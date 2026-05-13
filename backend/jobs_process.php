<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/db.php';

//  fetch jobs
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $type = $_GET['type'] ?? 'all';
    $query = trim($_GET['query'] ?? '');
    $mine = $_GET['mine'] ?? '0';
    $status = $_GET['status'] ?? 'active';

    $sql = "SELECT * FROM JOBPOSTINGS WHERE status = '$status'";

    // ONLY MY JOBS
    if ($mine === '1' && !empty($_SESSION['user_id'])) {
        $user_id = (int) $_SESSION['user_id'];
        $sql .= " AND user_id = $user_id";
    }

    // FILTER BY JOB TYPE
    if ($type !== 'all') {
        $type_safe = $conn->real_escape_string($type);
        $sql .= " AND job_type = '$type_safe'";
    }

    // SEARCH
    if ($query !== '') {

        $stmt = $conn->prepare("CALL sp_SearchJobs(?)");

        $stmt->bind_param("s", $query);

        $stmt->execute();

        $result = $stmt->get_result();

        $jobs = [];

        while ($row = $result->fetch_assoc()) {

            $postedAt = new DateTime($row['posted_at']);
            $now = new DateTime();

            $diff = $now->diff($postedAt);

            if ($diff->days === 0)
                $posted = 'Today';
            elseif ($diff->days === 1)
                $posted = '1 day ago';
            elseif ($diff->days < 7)
                $posted = $diff->days . ' days ago';
            elseif ($diff->days < 14)
                $posted = '1 week ago';
            else
                $posted = floor($diff->days / 7) . ' weeks ago';

            $jobs[] = [

                'id' => (int) $row['job_id'],
                'user_id' => (int) $row['user_id'],
                'status' => $row['status'],

                'title' => $row['job_title'],
                'company' => $row['company_name'],
                'type' => $row['job_type'],
                'location' => $row['location'],
                'salary' => $row['salary_range'] ?? '',
                'posted' => $posted,
                'desc' => $row['job_description'] ?? '',
                'modality' => $row['modality'],
                'category' => $row['category'],
                'req' => $row['requirements_qualifications'] ?? '',
                'benefits' => $row['benefits'] ?? '',
                'link' => $row['application_link'] ?? '#',
                'email' => $row['contact_email'] ?? '',
            ];
        }

        echo json_encode($jobs);

        exit;
    }

    $sql .= " ORDER BY posted_at DESC";

    $result = $conn->query($sql);

    if (!$result) {
        http_response_code(500);
        echo json_encode([
            'error' => 'Query failed: ' . $conn->error
        ]);
        exit;
    }

    $jobs = [];

    while ($row = $result->fetch_assoc()) {

        $postedAt = new DateTime($row['posted_at']);
        $now = new DateTime();
        $diff = $now->diff($postedAt);

        if ($diff->days === 0)
            $posted = 'Today';
        elseif ($diff->days === 1)
            $posted = '1 day ago';
        elseif ($diff->days < 7)
            $posted = $diff->days . ' days ago';
        elseif ($diff->days < 14)
            $posted = '1 week ago';
        else
            $posted = floor($diff->days / 7) . ' weeks ago';

        $jobs[] = [
            'id' => (int) $row['job_id'],
            'user_id' => (int) $row['user_id'],
            'status' => $row['status'],

            'title' => $row['job_title'],
            'company' => $row['company_name'],
            'type' => $row['job_type'],
            'location' => $row['location'],
            'salary' => $row['salary_range'] ?? '',
            'posted' => $posted,
            'desc' => $row['job_description'] ?? '',
            'modality' => $row['modality'],
            'category' => $row['category'],
            'req' => $row['requirements_qualifications'] ?? '',
            'benefits' => $row['benefits'] ?? '',
            'link' => $row['application_link'] ?? '#',
            'email' => $row['contact_email'] ?? '',
        ];
    }

    echo json_encode($jobs);
    exit;
}
// insert a new job posting
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'You must be logged in to post a job.']);
        exit;
    }

    $data = json_decode(file_get_contents('php://input'), true);

    $title = trim($data['title'] ?? '');
    $company = trim($data['company'] ?? '');

    if (!$title || !$company) {
        http_response_code(400);
        echo json_encode(['error' => 'Job title and company name are required.']);
        exit;
    }

    $user_id = (int) $_SESSION['user_id'];
    $title_s = $conn->real_escape_string($title);
    $company_s = $conn->real_escape_string($company);
    $location = $conn->real_escape_string(trim($data['location'] ?? 'TBD'));
    $job_type = $conn->real_escape_string($data['type'] ?? 'Full-time');
    $modality = $conn->real_escape_string($data['modality'] ?? 'Onsite');
    $category = $conn->real_escape_string($data['category'] ?? 'Other');
    $salary = $conn->real_escape_string(trim($data['salary'] ?? 'Negotiable'));
    $email = $conn->real_escape_string(trim($data['email'] ?? ''));
    $desc = $conn->real_escape_string(trim($data['desc'] ?? ''));
    $req = $conn->real_escape_string(trim($data['req'] ?? ''));
    $benefits = $conn->real_escape_string(trim($data['benefits'] ?? ''));

    $sql = "INSERT INTO JOBPOSTINGS (user_id, job_title, company_name, location, job_type, modality,
                category, salary_range, contact_email, job_description, requirements_qualifications, benefits,
                status, posted_at) VALUES
                ($user_id, '$title_s', '$company_s', '$location', '$job_type', '$modality', '$category', '$salary', '$email',
                '$desc', '$req', '$benefits', 'active', NOW())";

    if ($conn->query($sql)) {
        echo json_encode(['success' => true, 'job_id' => $conn->insert_id]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Insert failed: ' . $conn->error]);
    }
    exit;
}

// UPDATE JOB
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    if (empty($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }

    $data = json_decode(file_get_contents("php://input"), true);

    $id = (int) ($data['id'] ?? 0);
    $user_id = (int) $_SESSION['user_id'];

    $check = $conn->query("
        SELECT * FROM JOBPOSTINGS
        WHERE job_id = $id
        AND user_id = $user_id
    ");

    if (!$check || $check->num_rows === 0) {
        http_response_code(403);
        echo json_encode(['error' => 'Not allowed']);
        exit;
    }

    $title = $conn->real_escape_string($data['title']);
    $company = $conn->real_escape_string($data['company']);
    $type = $conn->real_escape_string($data['type']);
    $location = $conn->real_escape_string($data['location']);
    $salary = $conn->real_escape_string($data['salary']);
    $desc = $conn->real_escape_string($data['desc']);
    $modality = $conn->real_escape_string($data['modality']);
    $category = $conn->real_escape_string($data['category']);
    $req = $conn->real_escape_string($data['req']);
    $benefits = $conn->real_escape_string($data['benefits']);
    $email = $conn->real_escape_string($data['email']);

    $sql = "
        UPDATE JOBPOSTINGS
        SET
            job_title = '$title',
            company_name = '$company',
            job_type = '$type',
            location = '$location',
            salary_range = '$salary',
            job_description = '$desc',
            modality = '$modality',
            category = '$category',
            requirements_qualifications = '$req',
            benefits = '$benefits',
            contact_email = '$email'
        WHERE job_id = $id
    ";

    if ($conn->query($sql)) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => $conn->error]);
    }

    exit;
}


// RESTORE JOB
if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {

    if (empty($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }

    $data = json_decode(file_get_contents("php://input"), true);

    $id = (int) ($data['id'] ?? 0);
    $user_id = (int) $_SESSION['user_id'];

    $sql = "
        UPDATE JOBPOSTINGS
        SET
            status = 'active',
            posted_at = NOW()
        WHERE job_id = $id
        AND user_id = $user_id
    ";

    if ($conn->query($sql)) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode([
            'error' => $conn->error
        ]);
    }

    exit;
}
// DELETE JOB
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

    if (empty($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }

    $data = json_decode(file_get_contents("php://input"), true);

    $id = (int) ($data['id'] ?? 0);
    $user_id = (int) $_SESSION['user_id'];

    $sql = "
        UPDATE JOBPOSTINGS
        SET status = 'archived'
        WHERE job_id = $id
        AND user_id = $user_id
    ";

    if ($conn->query($sql)) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => $conn->error]);
    }
    exit;
}
http_response_code(405);
echo json_encode(['error' => 'Method not allowed.']);
