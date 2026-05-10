<?php
session_start();
require_once "backend/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$uid = $_SESSION['user_id'];

$profile = null;
$experience = [];
$education = [];
$skills = [];

/* ================= PROFILE ================= */
$stmt = $conn->prepare("
    SELECT 
        u.email,
        p.first_name,
        p.middle_name,
        p.last_name,
        p.suffix,
        p.address,
        p.profile_picture,
        p.about,
        a.year_graduated,
        c.course_name
    FROM users u
    LEFT JOIN userprofile p ON p.user_id = u.id
    LEFT JOIN alumnidetails a ON a.user_id = u.id
    LEFT JOIN courses c ON c.course_id = a.course_id
    WHERE u.id = ?
");

$stmt->bind_param("i", $uid);
$stmt->execute();
$profile = $stmt->get_result()->fetch_assoc();

/* ================= EXPERIENCE ================= */
$stmt = $conn->prepare("
    SELECT * FROM experience
    WHERE user_id = ?
    ORDER BY start_date DESC
");

$stmt->bind_param("i", $uid);
$stmt->execute();
$experience = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

/* ================= EDUCATION ================= */
$stmt = $conn->prepare("
    SELECT * FROM education
    WHERE user_id = ?
    ORDER BY start_year DESC
");

$stmt->bind_param("i", $uid);
$stmt->execute();
$education = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

/* ================= SKILLS ================= */
$stmt = $conn->prepare("
    SELECT * FROM skills
    WHERE user_id = ?
    ORDER BY skill_name ASC
");

$stmt->bind_param("i", $uid);
$stmt->execute();
$skills = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$full_name = trim(
    ucwords(strtolower($profile['first_name'] ?? '')) . " " .
        (!empty($profile['middle_name']) ? ucwords(strtolower($profile['middle_name'])) . " " : "") .
        ucwords(strtolower($profile['last_name'] ?? '')) .
        (!empty($profile['suffix']) ? ", " . strtoupper($profile['suffix']) : "")
);

$email = $profile['email'] ?? '';
$course = $profile['course_name'] ?? 'No Course';
$batch = $profile['year_graduated'] ?? 'N/A';

$initials = '';

if (!empty($profile['first_name'])) {
    $initials .= strtoupper($profile['first_name'][0]);
}

if (!empty($profile['last_name'])) {
    $initials .= strtoupper($profile['last_name'][0]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Profile Page</title>
    <link rel="icon" href="assets/image/alumni-logo.png">
    <link rel="stylesheet" href="assets/css/profile.css">
    <link rel="stylesheet" href="assets/css/alumni_homepage.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <?php include('includes/navbarhome.php'); ?>

    <div class="container" id="app">

        <!-- Profile Header Card -->
        <div class="card">
            <div class="cardContent">
                <div class="profileHeader">

                    <div class="avatarWrap">
                        <?php if (!empty($profile['profile_picture'])): ?>
                            <img src="uploads/profile/<?= htmlspecialchars($profile['profile_picture']) ?>" class="avatar" id="avatarDisplay">
                        <?php else: ?>
                            <div class="avatar" id="avatarDisplay">
                                <span class="avatarInitials" id="avatarInitials"><?= $initials ?: 'U' ?></span>
                            </div>
                        <?php endif; ?>
                        <label class="avatarUpload">
                            <i class="fas fa-camera"></i>
                            <input type="file" accept="image/*" onchange="handleAvatarChange(event)">
                        </label>
                    </div>

                    <div class="profileInfo">
                        <div class="profileInfoTop">
                            <div>
                                <h1 class="profileName" id="displayName"><?= htmlspecialchars($full_name ?: "No Name") ?></h1>
                                <p class="profileHeadline" id="displayHeadline">
                                    <?= htmlspecialchars($course) ?> — Batch <?= htmlspecialchars($batch) ?>
                                </p>
                            </div>
                            <button class="btnProf btnGhost" onclick="openEditProfile()">
                                <i class="fas fa-pencil"></i>
                            </button>
                        </div>
                        <div class="profileMeta">
                            <span>
                                <i class="fa-solid fa-location-dot"></i>
                                <span id="displayLocation">
                                    <?= htmlspecialchars($profile['address'] ?? "No location") ?>
                                </span>
                            </span>
                            <span><i class="fa-regular fa-envelope"></i>
                                <span id="displayEmail">
                                    <?= htmlspecialchars($email ?: "No email") ?>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- About Card -->
        <div class="card">
            <div class="cardContent">
                <div class="sectionHeader">
                    <h2 class="sectionTitle">About</h2>
                    <button class="btnProf btnGhost" onclick="openEditBio()">
                        <i class="fas fa-pencil"></i>
                    </button>
                </div>
                <p class="entryDesc" id="displayBio"><?= htmlspecialchars($profile['about'] ?? '') ?></p>
            </div>
        </div>

        <div class="card">
            <div class="cardContent">
                <div class="sectionHeader">
                    <h2 class="sectionTitle">Experience</h2>
                    <button class="btnProf btnGhost" onclick="openAddExp()">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div id="experienceList">
                    <?php if (!empty($experience)): ?>
                        <?php foreach ($experience as $exp): ?>
                            <div class="entryCard">
                                <h3><?= htmlspecialchars($exp['title']) ?></h3>
                                <p>
                                    <?= htmlspecialchars($exp['company']) ?> |
                                    <?= $exp['start_date'] ?> -
                                    <?= $exp['end_date'] ?? 'Present' ?>
                                </p>
                                <p><?= htmlspecialchars($exp['description']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="entryCard empty">
                            <p>No experience added yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="cardContent">
                <div class="sectionHeader">
                    <h2 class="sectionTitle">Education</h2>
                    <button class="btnProf btnGhost" onclick="openAddEdu()">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div id="educationList">
                    <?php if (!empty($education)): ?>
                        <?php foreach ($education as $edu): ?>
                            <div class="entryCard">
                                <h3><?= htmlspecialchars($edu['school']) ?></h3>
                                <p>
                                    <?= htmlspecialchars($edu['degree']) ?>
                                    <?= htmlspecialchars($edu['field']) ?>
                                </p>
                                <p>
                                    <?= $edu['start_year'] ?> -
                                    <?= $edu['end_year'] ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No education added yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Skills Card -->
        <div class="card">
            <div class="cardContent">
                <div class="sectionHeader">
                    <h2 class="sectionTitle">Skills</h2>
                    <button class="btnProf btnGhost" onclick="openAddSkill()">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="skillsWrap" id="skillsList">
                    <?php if (!empty($skills)): ?>
                        <?php foreach ($skills as $skill): ?>
                            <span class="badge">
                                <?= htmlspecialchars($skill['skill_name']) ?>
                            </span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span class="badge empty">No skills added yet</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>


    <div class="modalOverlay" id="modalOverlay" onclick="if(event.target===this)closeModal()">
        <div class="modal">
            <button class="modalClose" onclick="closeModal()">&times;</button>
            <h3 class="modalTitle" id="modalTitle"></h3>
            <p class="modalDesc" id="modalDesc"></p>

            <div id="validationWarning" class="validationWarning" style="display:none;">
                <i class="fas fa-exclamation-circle"></i>
                <span id="warningMessage"></span>
            </div>

            <div id="modalBody">

                <div id="formEditProfile" class="modalForm" style="display:none">
                    <div class="formRow">
                        <div class="formGroup">
                            <label for="mFirstName">First Name</label>
                            <input type="text" id="mFirstName">
                        </div>
                        <div class="formGroup">
                            <label for="mMiddleName">Middle Name</label>
                            <input type="text" id="mMiddleName">
                        </div>
                        <div class="formGroup">
                            <label for="mLastName">Last Name</label>
                            <input type="text" id="mLastName">
                        </div>
                        <div class="formGroup">
                            <label for="mSuffix">Suffix</label>
                            <input type="text" id="mSuffix" placeholder="Jr, Sr, III (optional)">
                        </div>
                    </div>
                    <div class="formGroup">
                        <label for="mHeadline">Headline</label>
                        <input type="text" id="mHeadline">
                    </div>
                    <div class="formGroup">
                        <label for="mLocation">Location</label>
                        <input type="text" id="mLocation">
                    </div>
                    <div class="formGroup">
                        <label for="mEmail">Email</label>
                        <input type="email" id="mEmail">
                    </div>
                </div>

                <div id="formEditBio" class="modalForm" style="display:none">
                    <div class="formGroup">
                        <textarea id="about" rows="4" placeholder="Tell us about yourself..."></textarea>
                    </div>
                </div>

                <div id="formExp" class="modalForm" style="display:none">
                    <div class="formGroup">
                        <label for="mExpTitle">Job Title</label>
                        <input type="text" id="mExpTitle" placeholder="e.g. Software Engineer">
                    </div>
                    <div class="formGroup">
                        <label for="mExpCompany">Company</label>
                        <input type="text" id="mExpCompany" placeholder="e.g. White Cloak">
                    </div>
                    <div class="formGroup">
                        <label for="mExpLocation">Location</label>
                        <input type="text" id="mExpLocation" placeholder="e.g. Pasig City">
                    </div>
                    <div class="formGroup">
                        <label for="mExpType">Employment Type</label>
                        <select id="mExpType">
                            <option value="">Select Type</option>
                            <option value="Full-time">Full-time</option>
                            <option value="Part-time">Part-time</option>
                            <option value="Contract">Contract</option>
                        </select>
                    </div>
                    <div class="formRow">
                        <div class="formGroup">
                            <label for="mExpStart">Start Date</label>
                            <input type="date" id="mExpStart">
                        </div>
                        <div class="formGroup">
                            <label for="mExpEnd">End Date</label>
                            <input type="date" id="mExpEnd">
                        </div>
                    </div>
                    <div class="formGroup">
                        <label for="mExpDesc">Description</label>
                        <textarea id="mExpDesc" rows="3"
                            placeholder="Describe your role and responsibilities..."></textarea>
                    </div>
                </div>


                <div id="formEdu" class="modalForm" style="display:none">
                    <div class="formGroup">
                        <label for="mEduSchool">School</label>
                        <input type="text" id="mEduSchool" placeholder="e.g. Pamantasan ng Lungsod ng Pasig">
                    </div>
                    <div class="formGroup">
                        <label for="mEduDegree">Course</label>
                        <input type="text" id="mEduDegree"
                            placeholder="e.g. Bachelor of Science in Information Technology">
                    </div>
                    <div class="formGroup">
                        <label for="mAwards">Awards</label>
                        <input type="text" id="mAwards" placeholder="e.g. High Honors, Cum Laude. N/A if none">
                    </div>
                    <div class="formRow">
                        <div class="formGroup">
                            <label for="mEduStart">Start Year</label>
                            <input type="number" id="mEduStart" placeholder="e.g. 2016" min="1900" max="2099">
                        </div>
                        <div class="formGroup">
                            <label for="mEduEnd">End Year</label>
                            <input type="number" id="mEduEnd" placeholder="e.g. 2020" min="1900" max="2099">
                        </div>
                    </div>
                </div>

                <!-- ── Add Skillzzzz--->
                <div id="formSkill" class="modalForm" style="display:none">

                    <div class="formGroup">
                        <label for="skillName">Skill</label>
                        <input type="text" id="skillName" placeholder="e.g. JavaScript">
                    </div>

                    <div class="formGroup">
                        <label for="skillLevel">Skill Level</label>

                        <select id="skillLevel">
                            <option value="">Select Level</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert">Expert</option>
                        </select>
                    </div>

                </div>

            </div>

            <div class="modalFooter">
                <button class="btnProf btnOutline" onclick="closeModal()">Cancel</button>
                <button class="btnProf btnPrimary" id="modalAdd">Add</button>
            </div>
        </div>
    </div>

    <div class="dialogOverlay" id="avatarDialog">
        <div class="dialogBox">
            <h3>Update Profile Picture</h3>
            <p>What do you want to do?</p>
            <div class="dialogActions">
                <button class="btnCancel" id="cancelAvatarBtn">Cancel</button>
                <button class="btnConfirm" id="confirmAvatarBtn">Upload</button>
            </div>
        </div>
    </div>

    <!-- DELETE DIALOG -->
    <div class="dialogOverlay" id="deleteDialog">
        <div class="dialogBox">

            <h3 id="deleteTitle">Delete</h3>

            <p id="deleteMessage">
                Are you sure you want to delete this item?
            </p>

            <div class="dialogActions">

                <button class="btnCancel" id="cancelDeleteBtn">
                    Cancel
                </button>

                <button class="btnConfirm" id="confirmDeleteBtn">
                    Delete
                </button>

            </div>
        </div>
    </div>

    <?php include('includes/logoutmodal.php'); ?>

    <script src="assets/js/alumni_homepage.js"></script>

    <script>
        const profile = {
            firstName: <?= json_encode($profile['first_name'] ?? '') ?>,
            middleName: <?= json_encode($profile['middle_name'] ?? '') ?>,
            lastName: <?= json_encode($profile['last_name'] ?? '') ?>,
            suffix: <?= json_encode($profile['suffix'] ?? '') ?>,

            headline: <?= json_encode($profile['course_name'] ?? '') ?>,
            about: <?= json_encode($profile['about'] ?? '') ?>,
            location: <?= json_encode($profile['address'] ?? '') ?>,
            email: <?= json_encode($profile['email'] ?? '') ?>,

            profile_picture: <?= json_encode($profile['profile_picture'] ?? '') ?>,

            skills: <?= json_encode(array_values(array_map(function ($s) {
                        return [
                            "id" => $s['skill_id'] ?? null,
                            "name" => $s['skill_name'] ?? '',
                            "level" => $s['skill_level'] ?? ''
                        ];
                    }, $skills ?? []))) ?>,

            experiences: <?= json_encode(array_values(array_map(function ($e) {
                                return [
                                    "id" => $e['exp_id'] ?? null,
                                    "title" => $e['title'] ?? '',
                                    "company" => $e['company'] ?? '',
                                    "location" => $e['location'] ?? '',
                                    "startDate" => $e['start_date'] ?? '',
                                    "endDate" => $e['end_date'] ?? '',
                                    "description" => $e['description'] ?? ''
                                ];
                            }, $experience ?? []))) ?>,

            educations: <?= json_encode(array_values(array_map(function ($e) {
                            return [
                                "id" => $e['edu_id'] ?? null,
                                "school" => $e['school'] ?? '',
                                "degree" => $e['degree'] ?? '',
                                "awards" => $e['awards'] ?? '',
                                "startYear" => $e['start_year'] ?? '',
                                "endYear" => $e['end_year'] ?? ''
                            ];
                        }, $education ?? []))) ?>
        };
    </script>
    <script src="assets/js/profile.js"></script>
</body>

</html>