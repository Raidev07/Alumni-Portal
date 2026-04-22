<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLP Alumni – Events Board</title>
    <link rel="icon" href="assets/image/alumni-logo.png">
    <link rel="stylesheet" href="assets/css/events.css">
    <link rel="stylesheet" href="assets/css/signUpDialog_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
</head>

<body>

    <nav class="navbar" id="navbar">
        <div class="nav-left">
            <a href="https://plpasig.edu.ph/" class="logo-link1"><img src="assets/image/alumni-logo.png"
                    alt="Alumni Logo"></a>
            <div class="title">
                <div>Pamantasan ng Lungsod ng Pasig</div>
                <div>ALUMNI</div>
            </div>
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="jobs.php">Jobs</a></li>
            <li><a href="events.php">Events</a></li>
        </ul>
        <div class="nav-right">
            <div class="btns">
                <button class="btn" onclick="window.location.href = 'login.php'">Login</button>
                <button class="btn" onclick="document.getElementById('signUpDialog').showModal()">
                    Signup
                </button>
            </div>
            <a href="#" class="logo-link2"><img src="assets/image/plplogo.png" alt="PLP Logo"></a>
        </div>
    </nav>

    <!-- POST EVENT MODAL OVERLAY -->
    <div class="overlay hidden" id="postOverlay">
        <div class="modal">
            <div class="modal-header">
                <h2>Alumni Event Details</h2>
                <p>Fill in the information below</p>
            </div>
            <div class="form-grid">
                <div class="form-group form-full">
                    <label for="f-title">Event Title</label>
                    <input id="f-title" type="text" placeholder="e.g. PLP Alumni Networking Night 2025">
                </div>
                <div class="form-group">
                    <label for="f-date">Event Date</label>
                    <input id="f-date" type="date">
                </div>
                <div class="form-group">
                    <label for="f-time">Time</label>
                    <input id="f-time" type="time">
                </div>
                <div class="form-group">
                    <label for="f-type">Event Type</label>
                    <select id="f-type">
                        <option>Networking</option>
                        <option>Workshop</option>
                        <option>Seminar</option>
                        <option>Reunion</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="f-location">Location</label>
                    <input id="f-location" type="text" placeholder="e.g. PLP Main Campus, Pasig">
                </div>
                <div class="form-group">
                    <label for="f-max">Max Attendees</label>
                    <input id="f-max" type="number" placeholder="e.g. 100" min="1">
                </div>
                <div class="form-group">
                    <label for="f-deadline">Registration Deadline</label>
                    <input id="f-deadline" type="date">
                </div>
                <div class="form-group">
                    <label for="f-email">Contact Email</label>
                    <input id="f-email" type="email" placeholder="events@plpalumni.ph">
                </div>
                <div class="form-group form-full">
                    <label for="f-desc">Event Description</label>
                    <textarea id="f-desc" rows="4"
                        placeholder="Describe the event, what attendees can expect, speakers, activities..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-cancel" id="cancelBtn">Cancel</button>
                <button class="btn-post" id="postBtn">Post Event</button>
            </div>
        </div>
    </div>

    <!-- EVENT DETAIL MODAL OVERLAY -->
    <div class="detail-overlay hidden" id="detailOverlay">
        <div class="detail-modal">
            <div class="detail-header">
                <div class="detail-event-type" id="d-type-badge"></div>
                <h2 id="d-title"></h2>
                <div class="dh-company" id="d-organizer"></div>
            </div>
            <div class="detail-body">
                <div class="detail-meta-row" id="d-meta"></div>
                <div class="detail-section">
                    <h3><i class="fa-solid fa-align-left"></i> About This Event</h3>
                    <p id="d-desc"></p>
                </div>
                <div class="detail-actions">
                    <button class="btn-apply" id="d-register">Register Now</button>
                    <button class="btn-back" id="closeDetail">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN PAGE -->
    <div class="page">
        <div class="top-row">
            <div>
                <h1>Alumni Events Board</h1>
                <p class="subtitle">Explore events held by our alumni network</p>
            </div>
            <button class="create-btn" id="openPostBtn">
                <i class="fa-solid fa-plus"></i> Post an Event
            </button>
        </div>

        <div class="layout">
            <aside class="sidebar">
                <h3>Filter Events</h3>
                <p class="sidebar-label">Event Type</p>
                <div class="filter-item active" data-filter="all">All</div>
                <div class="filter-item" data-filter="Networking">Networking</div>
                <div class="filter-item" data-filter="Workshop">Workshop</div>
                <div class="filter-item" data-filter="Seminar">Seminar</div>
                <div class="filter-item" data-filter="Reunion">Reunion</div>
            </aside>
            <main class="main">
                <div class="search-row">
                    <input type="text" id="searchInput" placeholder="Search by title or location...">
                    <button onclick="renderEvents()">Search</button>
                </div>
                <div id="jobsList"></div>
                <div class="empty-state" id="emptyState">
                    <p>No events found. Try a different search.</p>
                </div>
            </main>
        </div>
    </div>

    <dialog id="signUpDialog">
        <div class="title">Sign Up As...</div>
        <div class="registerButtons">
            <button onclick="window.location.href = 'student_form.php'">
                Register As Student
            </button>
            <button onclick="window.location.href = 'alumni_form.php'">
                Register As Alumni
            </button>
        </div>
        <button id="closeButton" onclick="document.getElementById('signUpDialog').close()">
            Close
        </button>
    </dialog>

    <script src="assets/js/eventscript.js"></script>
</body>
</html>