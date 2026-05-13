<?php
// backend/event_process.php
// GET  → fetch events list (public)
// POST → create a new event (requires login)

header('Content-Type: application/json');
header('Cache-Control: no-cache');

require_once __DIR__ . '/db.php';
session_start();

// ── Route by HTTP method ──────────────────────────────────────────────────────

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    handleGetEvents();
} elseif ($method === 'POST') {
    handlePostEvent();
} elseif ($method === 'PUT') {
    handleUpdateEvent();
} elseif ($method === 'DELETE') {
    handleDeleteEvent();
} elseif ($method === 'PATCH') {
    handleRestoreEvent();
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
}

// AUTO STATUS UPDATE
// ONGOING
$conn->query("
    UPDATE events
    SET status = 'ongoing'
    WHERE status = 'upcoming'
    AND event_date = CURDATE()
    AND CURTIME() BETWEEN start_time AND end_time
");

// COMPLETED
$conn->query("
    UPDATE events
    SET status = 'completed'
    WHERE status IN ('upcoming', 'ongoing')
    AND (
        event_date < CURDATE()
        OR (
            event_date = CURDATE()
            AND end_time < CURTIME()
        )
    )
");

// Fetch events from DB
function handleGetEvents()
{

    global $conn;

    try {
        $type = isset($_GET['type']) ? trim($_GET['type']) : '';
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $status = $_GET['status'] ?? 'upcoming';
        $mine = $_GET['mine'] ?? '0';

        $sql = "
            SELECT
                e.event_id              AS id,
                e.user_id               AS user_id,
                e.event_title           AS title,
                CONCAT(up.first_name, ' ', up.last_name) AS organizer,
                e.event_type            AS type,
                e.event_date            AS date,
                e.start_time            AS timeStart,
                e.end_time              AS timeEnd,
                e.location              AS location,
                e.max_attendees         AS maxAttendees,
                e.registration_deadline AS deadline,
                e.contact_email         AS email,
                e.event_description     AS eventDesc,
                e.status,
                e.created_at
            FROM events e
            LEFT JOIN USERPROFILE up ON up.user_id = e.user_id
            WHERE 1=1
        ";

        $params = [];
        $types = '';

        if ($status === 'archived') {
            $sql .= "AND e.status IN ('completed', 'cancelled')";
        } elseif ($status === 'all') {
            $sql .= "AND e.status IN ('upcoming', 'ongoing')";
        } else {
            $sql .= " AND e.status = ?";
            $params[] = $status;
            $types .= 's';
        }

        if (
            $mine === '1' &&
            !empty($_SESSION['user_id'])
        ) {
            $sql .= " AND e.user_id = ?";
            $params[] = (int) $_SESSION['user_id'];
            $types .= 'i';
        }

        // Filter by event type
        if ($type && $type !== 'all') {
            $sql .= " AND e.event_type = ?";
            $params[] = $type;
            $types .= 's';
        }

        // Search by title, location, or organizer name
        if ($search !== '') {
            $like = '%' . $search . '%';
            $sql .= " AND (
                                e.event_title LIKE ?
                            OR e.location    LIKE ?
                            OR CONCAT(up.first_name, ' ', up.last_name) LIKE ?
                            )";
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
            $types .= 'sss';
        }

        $sql .= " ORDER BY e.event_date ASC, e.start_time ASC";

        $stmt = $conn->prepare($sql);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $events = [];
        while ($row = $result->fetch_assoc()) {
            $row['posted'] = timeAgo($row['created_at']);

            // Trim seconds off TIME columns (HH:MM:SS -> HH:MM)
            if ($row['timeStart'])
                $row['timeStart'] = substr($row['timeStart'], 0, 5);
            if ($row['timeEnd'])
                $row['timeEnd'] = substr($row['timeEnd'], 0, 5);

            // Rename eventDesc -> desc for the frontend
            $row['desc'] = $row['eventDesc'] ?? '';
            unset($row['eventDesc'], $row['created_at']);

            $events[] = $row;
        }

        $stmt->close();

        echo json_encode(['success' => true, 'events' => $events]);
    } catch (Exception $ex) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $ex->getMessage()]);
    }
}

// Insert a new event (must be logged in)

function handlePostEvent()
{
    global $conn;

    // Auth check
    if (empty($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'You must be logged in to post an event.']);
        return;
    }

    // Parse JSON body
    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid request body.']);
        return;
    }

    // Sanitize inputs
    $user_id = (int) $_SESSION['user_id'];
    $title = trim($input['title'] ?? '');
    $event_date = trim($input['date'] ?? '');
    $event_type = trim($input['type'] ?? 'Networking');
    $time_start = trim($input['timeStart'] ?? '');
    $time_end = trim($input['timeEnd'] ?? '');
    $location = trim($input['location'] ?? 'TBD');
    $max_att = (int) ($input['maxAttendees'] ?? 0);
    $deadline = trim($input['deadline'] ?? '');
    $email = trim($input['email'] ?? '');
    $description = trim($input['desc'] ?? 'No description provided.');

    // Required fields (event_date, start_time, end_time are NOT NULL in the table)
    if ($title === '') {
        http_response_code(422);
        echo json_encode(['success' => false, 'message' => 'Event title is required.']);
        return;
    }
    if ($event_date === '') {
        http_response_code(422);
        echo json_encode(['success' => false, 'message' => 'Event date is required.']);
        return;
    }
    if ($time_start === '') {
        http_response_code(422);
        echo json_encode(['success' => false, 'message' => 'Start time is required.']);
        return;
    }
    if ($time_end === '') {
        http_response_code(422);
        echo json_encode(['success' => false, 'message' => 'End time is required.']);
        return;
    }

    // Whitelist event type against the enum
    $allowed_types = ['Networking', 'Workshop', 'Seminar', 'Reunion'];
    if (!in_array($event_type, $allowed_types, true)) {
        $event_type = 'Networking';
    }

    // Null-safe optional fields
    $max_att_val = $max_att > 0 ? $max_att : null;
    $deadline_val = $deadline !== '' ? $deadline : null;
    $email_val = $email !== '' ? $email : null;

    try {
        $stmt = $conn->prepare("
            INSERT INTO events (
                user_id,
                event_title,
                event_date,
                start_time,
                end_time,
                location,
                event_type,
                max_attendees,
                registration_deadline,
                contact_email,
                event_description,
                status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'upcoming')
        ");

        $stmt->bind_param(
            'issssssisss',
            $user_id,      
            $title,        
            $event_date,   
            $time_start,   
            $time_end,     
            $location,     
            $event_type,   
            $max_att_val,  
            $deadline_val, 
            $email_val,    
            $description   
        );

        $stmt->execute();
        $new_id = $stmt->insert_id;
        $stmt->close();

        echo json_encode([
            'success' => true,
            'message' => 'Event posted successfully.',
            'event_id' => $new_id,
        ]);
    } catch (Exception $ex) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $ex->getMessage()]);
    }
}

// Helper

function handleUpdateEvent() {
    global $conn;

    if (empty($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['success' => false]);
        return;
    }

    $data = json_decode(file_get_contents("php://input"), true);

    $id = (int) $data['id'];
    $user_id = (int) $_SESSION['user_id'];

    $stmt = $conn->prepare("
        UPDATE events
        SET
            event_title=?,
            event_date=?,
            event_type=?,
            start_time=?,
            end_time=?,
            location=?,
            max_attendees=?,
            registration_deadline=?,
            contact_email=?,
            event_description=?
        WHERE event_id=?
        AND user_id=?
    ");

    $stmt->bind_param(
        "ssssssisssii",
        $data['title'],
        $data['date'],
        $data['type'],
        $data['timeStart'],
        $data['timeEnd'],
        $data['location'],
        $data['maxAttendees'],
        $data['deadline'],
        $data['email'],
        $data['desc'],
        $id,
        $user_id
    );

    $stmt->execute();

    echo json_encode([
        'success' => true
    ]);
}

function handleDeleteEvent() {
    global $conn;
    if (empty($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['success' => false]);
        return;
    }

    $data = json_decode(file_get_contents("php://input"), true);

    $id = (int) $data['id'];
    $user_id = (int) $_SESSION['user_id'];

    $stmt = $conn->prepare("
        UPDATE events
        SET status = 'cancelled'
        WHERE event_id=?
        AND user_id=?
    ");

    $stmt->bind_param("ii", $id, $user_id);

    $stmt->execute();

    echo json_encode([
        'success' => true
    ]);
}



function handleRestoreEvent() {
    global $conn;

    if (empty($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['success' => false]);
        return;
    }

    $data = json_decode(file_get_contents("php://input"), true);

    $id = (int) $data['id'];
    $user_id = (int) $_SESSION['user_id'];

    $stmt = $conn->prepare("
        UPDATE events
        SET
        status='upcoming'
        WHERE event_id=?
        AND user_id=?
    ");

    $stmt->bind_param("ii", $id, $user_id);

    $stmt->execute();

    echo json_encode([
        'success' => true
    ]);
}

function timeAgo($datetime) {
    if (!$datetime)
        return '';
    $diff = time() - strtotime($datetime);
    if ($diff < 60)
        return 'Just now';
    if ($diff < 3600)
        return floor($diff / 60) . ' minutes ago';
    if ($diff < 86400)
        return floor($diff / 3600) . ' hours ago';
    if ($diff < 604800)
        return floor($diff / 86400) . ' days ago';
    return floor($diff / 604800) . ' weeks ago';
}
