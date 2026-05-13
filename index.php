<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

session_start();
require_once "backend/db.php";

$isLoggedIn = isset($_SESSION['user_id']);
$uid = $isLoggedIn ? $_SESSION['user_id'] : null;

// total alumni
$query = "
    SELECT COUNT(*) AS total_alumni
    FROM users
    WHERE role = 'alumni'
";

$result = mysqli_query($conn, $query);

$total_alumni = 0;

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $total_alumni = $row['total_alumni'] ?? 0;
}


// total event
$events_query = "
    SELECT COUNT(*) AS total_events
    FROM events
";

$events_result = mysqli_query($conn, $events_query);

$total_events = 0;

if ($events_result) {
    $row = mysqli_fetch_assoc($events_result);
    $total_events = $row['total_events'] ?? 0;
}


// total job
$query_jobs = "SELECT COUNT(*) AS total_jobs FROM jobpostings";
$result_jobs = mysqli_query($conn, $query_jobs);

$total_jobs = 0;

if ($result_jobs) {
    $row_jobs = mysqli_fetch_assoc($result_jobs);
    $total_jobs = $row_jobs['total_jobs'] ?? 0;
}

$featuredQuery = $conn->query("
    SELECT 
        af.id,
        af.title,
        af.excerpt,
        af.category,
        af.cover_image,
        af.alumni_name,
        up.profile_picture,
        ad.course_id,
        c.course_name
    FROM alumnifeatured af
    LEFT JOIN userprofile up ON af.user_id = up.user_id
    LEFT JOIN alumnidetails ad ON af.user_id = ad.user_id
    LEFT JOIN courses c ON ad.course_id = c.course_id
    ORDER BY af.created_at DESC
    LIMIT 5
");

$full_name = 'Guest';

if ($isLoggedIn) {
    $profile_stmt = $conn->prepare("
        SELECT first_name, last_name 
        FROM userprofile 
        WHERE user_id = ?
    ");

    if ($profile_stmt) {
        $profile_stmt->bind_param("i", $uid);
        $profile_stmt->execute();
        $profile_result = $profile_stmt->get_result();
        $profile = $profile_result->fetch_assoc();

        if ($profile) {
            $full_name = ucfirst($profile['first_name']) . ' ' . ucfirst($profile['last_name']);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Portal</title>
    <link rel="icon" href="assets/image/alumni_plp_newicon.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/alumni_homepage.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body>
    <?php
    if ($isLoggedIn) {
        include('includes/navbarhome.php');
    } else {
        include('includes/navbarindex.php');
    } ?>

    <section class="header">
        <!-- Swiper Slider -->
        <div class="swipers">
            <div class="swiper-container">
                <div class="swiper-wrapper">

                    <!-- Slide 1 -->
                    <div class="swiper-slide">
                        <div class="slide-content1">
                            <h1><?= $isLoggedIn
                                    ? "Welcome Back, " . htmlspecialchars($full_name)
                                    : "Welcome to PLP’s Alumni Page"
                                ?>
                            </h1>
                            <p>
                                <?= $isLoggedIn
                                    ? "Explore jobs, events, and updates from the PLP community."
                                    : "Join our vibrant alumni community. Connect, share experiences, and build lasting relationships with graduates from around the world."
                                ?>
                            </p>
                            <?php if (!$isLoggedIn): ?>
                                <div class="login-prmpt">
                                    <p>Already have an account? <a href="login.php" class="btn">Join now</a></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="swiper-slide">
                        <div class="slide-content2">
                            <h1>
                                <?= $isLoggedIn ? "Your Alumni Hub" : "Register Your Alumni Profile" ?>
                            </h1>
                            <p>
                                <?= $isLoggedIn
                                    ? "Manage your profile, explore opportunities, and stay connected."
                                    : "Access exclusive features, update your profile, and stay informed about alumni events."
                                ?>
                            </p>
                            <ul>
                                <?php if ($isLoggedIn): ?>
                                    <li><i class="fas fa-check-circle"></i> Update Your Profile Information</li>
                                    <li><i class="fas fa-check-circle"></i> Browse Job Opportunities</li>
                                    <li><i class="fas fa-check-circle"></i> Check Upcoming Events</li>
                                <?php else: ?>
                                    <li><i class="fas fa-check-circle"></i> Alumni Card Application</li>
                                    <li><i class="fas fa-check-circle"></i> Yearbook Claiming Application</li>
                                    <li><i class="fas fa-check-circle"></i> 2-in-1 Package</li>
                                <?php endif; ?>
                            </ul>
                            <a href="<?= $isLoggedIn ? 'jobs.php' : 'DPA.php' ?>" class="btn">
                                <?= $isLoggedIn ? "View Latest Jobs" : "Sign Up" ?>
                            </a>
                        </div>
                    </div>

                </div>

                <!-- Swiper Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <section class="section" id="projects">
        <div class="top-header">
            <h1>Community</h1>
        </div>
        <div class="project-container">
            <div onclick="window.location.href='articles_page.php' " class="project-box">
                <i class="uil uil-briefcase-alt"></i>
                <h3> <?= number_format($total_alumni) ?>+ Members</h3>
                <label>Alumni</label>
            </div>
            <div onclick="window.location.href='events.php'" class="project-box">
                <i class="uil uil-users-alt"></i>
                <h3><?= number_format($total_events) ?>+ Events</h3>
                <label>Events per year</label>
            </div>
            <div onclick="window.location.href='jobs.php'" class="project-box">
                <i class="uil uil-award"></i>
                <h3><?= number_format($total_jobs) ?>+ Jobs</h3>
                <label>jobs per year</label>
            </div>
        </div>
    </section>


    <section class="card-section">
        <div class="section-header">
            <span class="subtitle">Alumni Spotlight</span>
            <h2>Featured Alumni</h2>
            <div class="line"></div>
            <p>Meet our outstanding graduates and their achievements</p>
        </div>

        <div class="container swiper">
            <div class="wrapper">
                <div class="card-list swiper-wrapper">

                    <?php while ($featured = $featuredQuery->fetch_assoc()): ?>

                        <?php
                        $profilePic = !empty($featured['profile_picture'])
                            ? "uploads/profile/" . htmlspecialchars($featured['profile_picture'])
                            : "assets/image/default-profile.png";

                        $coverImage = !empty($featured['cover_image'])
                            ? htmlspecialchars($featured['cover_image'])
                            : "assets/image/default-cover.jpg";

                        $parts = explode(" ", trim($featured['alumni_name']));
                        $initials = strtoupper(
                            substr($parts[0] ?? '', 0, 1) .
                                (isset($parts[1]) ? substr($parts[1], 0, 1) : '')
                        );
                        ?>

                        <div class="card swiper-slide">

                            <div class="card-image">
                                <img src="<?= $coverImage ?>" alt="Article Cover">
                                <div class="card-tag"><?= htmlspecialchars($featured['category']) ?></div>
                            </div>

                            <div class="card-content">
                                <h3 class="card-title"><?= htmlspecialchars($featured['title']) ?></h3>
                                <p class="card-text"><?= htmlspecialchars(mb_strimwidth($featured['excerpt'], 0, 100, '...')) ?></p>
                                <div class="card-footer">
                                    <div class="card-profile">
                                        <?php if (!empty($featured['profile_picture'])): ?>
                                            <img src="<?= $profilePic ?>" alt="Profile Picture">
                                        <?php else: ?>
                                            <div class="profile-placeholder"><?= $initials ?></div>
                                        <?php endif; ?>

                                        <div class="card-profile-info">
                                            <span class="card-profile-name"><?= htmlspecialchars($featured['alumni_name']) ?></span>

                                            <span class="card-profile-role">
                                                <?= !empty($featured['course_name'])
                                                    ? htmlspecialchars($featured['course_name'])
                                                    : 'Alumni' ?>
                                            </span>
                                        </div>
                                    </div>
                                    <a href="<?= $isLoggedIn ? 'view_article.php?id=' . $featured['id'] : 'DPA.php' ?>" class="card-button">Read More</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <div class="swiper-pagination"></div>

                <!-- Navigation Buttons -->
                <div class="swiper-slide-button swiper-button-prev"></div>
                <div class="swiper-slide-button swiper-button-next"></div>
            </div>
        </div>
    </section>

    <?php include('includes/footer.php'); ?>
    <?php include('includes/logoutmodal.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/alumni_homepage.js"></script>
</body>
</html>