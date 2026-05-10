<?php
session_start();
include("backend/db.php");

// get article ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id == 0) {
    die("Invalid article ID");
}

// fetch single article
$stmt = $conn->prepare("
    SELECT af.*, 
            up.about,
            up.first_name,
            up.last_name,
            up.middle_name,
            up.suffix,
            up.profile_picture
    FROM alumnifeatured af
    LEFT JOIN users u ON af.user_id = u.id
    LEFT JOIN userprofile up ON u.id = up.user_id
    WHERE af.id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$article = $result->fetch_assoc();

if (!$article) {
    die("Article not found");
}

$eduStmt = $conn->prepare("
    SELECT degree, school, start_year, end_year
    FROM education
    WHERE user_id = (
        SELECT user_id FROM alumnifeatured WHERE id = ?
    )
    ORDER BY end_year DESC
");

$eduStmt->bind_param("i", $id);
$eduStmt->execute();
$eduResult = $eduStmt->get_result();

$educationText = "";

while ($edu = $eduResult->fetch_assoc()) {
    $school = $edu['school'];
    $degree = $edu['degree'];
    $start = $edu['start_year'];
    $end = $edu['end_year'];

    $educationText .= htmlspecialchars($degree . " - " . $school . " (" . $start . "–" . $end . ")") . "<br>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Alumni Article Reader</title>
    <link rel="icon" href="assets/image/alumni-logo.png">
    <link rel="stylesheet" href="assets/css/view_article.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,400&family=Roboto+Slab:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>

    <div class="reading-progress-bar">
        <div class="reading-progress-fill" id="progressFill"></div>
    </div>

    <nav class="navbar" id="navbar">
        <div class="nav-left">
            <a href="#" class="logo-link1"><img src="assets/image/alumni-logo.png" alt="alumni Logo"></a>
            <div class="title">
                <div>Pamantasan ng Lungsod ng Pasig</div>
                <div>ALUMNI</div>
            </div>
        </div>

        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="jobs.php">Jobs</a></li>
            <li><a href="events.php">Events</a></li>
            <li><a href="articles_page.php" class="active">Highlights</a></li>
        </ul>

        <div class="nav-right">

            <!-- Profile Icon -->
            <a href="profile-page.php" class="profile-icon" title="My Profile">
                <i class="fas fa-user"></i>
            </a>

            <div class="hamburger-wrapper">
                <button class="hamburger-btn" id="hamburgerBtn" aria-label="Open menu" aria-expanded="false">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <div class="hamburger-dropdown" id="hamburgerDropdown">
                    <ul>
                        <li>
                            <a href="contact.php">
                                <i class="fas fa-envelope"></i> Contact Us
                            </a>
                        </li>
                        <li class="dropdown-divider-top">
                            <a href="#" id="logoutTrigger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>


            <a href="#" class="logo-link2">
                <img src="assets/image/plplogo.png" alt="PLP Logo">
            </a>
        </div>
    </nav>
    <div class="page-wrap">

        <!-- MAIN ARTICLE -->
        <main class="article-main">

            <div class="cover-image-wrap">
                <?php if (!empty($article['cover_image'])): ?>
                    <img src="<?php echo htmlspecialchars($article['cover_image']); ?>" alt="Cover Image">
                <?php else: ?>
                    <span class="cover-placeholder-text">FEATURE STORY</span>
                <?php endif; ?>
            </div>

            <header class="article-header">
                <span class="category-badge">
                    <span class="category-badge-dot"></span>
                    <?php echo htmlspecialchars($article['category']); ?>
                </span>
                <h1 class="article-title"><?php echo htmlspecialchars($article['title']); ?></h1>
                <div class="article-meta">
                    <div class="alumni-avatar" aria-hidden="true">MR</div>
                    <div class="meta-info">
                        <div class="alumni-name"><?php echo htmlspecialchars($article['alumni_name']); ?></div>
                        <div class="grad-year">B.S. Computer Science &middot; Class of <?php echo htmlspecialchars($article['year_graduated']); ?>
                        </div>
                    </div>
                </div>
            </header>

            <blockquote class="article-excerpt">
                <?php echo htmlspecialchars($article['excerpt']); ?>
            </blockquote>

            <article class="article-body">
                <?php echo nl2br(htmlspecialchars($article['content'])); ?>
            </article>

            <div style="height: 2rem;"></div>
        </main>

        <!-- SIDEBAR -->
        <aside class="sidebar">

            <div class="sidebar-card">
                <p class="sidebar-card-title">About the Alumni</p>

                <div class="author-inner">

                    <?php
                    $image = $article['profile_picture'] ?? null;
                    $parts = explode(" ", trim($article['alumni_name']));
                    $initials = strtoupper($parts[0][0] . ($parts[1][0] ?? ""));
                    ?>

                    <div class="author-avatar-lg" aria-hidden="true">
                        <?php if (!empty($image)): ?>
                            <img src="uploads/profile/<?= htmlspecialchars($image) ?>">
                        <?php else: ?>
                            <div class="avatar-initials">
                                <?= $initials ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="author-name-lg"><?= htmlspecialchars($article['alumni_name']); ?></div>
                    <div class="author-degree"><?= $educationText ?: "No education record available."; ?></div>
                    <span class="year-chip">Class of <?= htmlspecialchars($article['year_graduated']); ?></span>
                    <p class="author-bio">
                        <?= htmlspecialchars($article['about'] ?? 'No bio available.'); ?></p>
                </div>
            </div>
            <div class="sidebar-card">
                <p class="sidebar-card-title">Article Details</p>
                <div class="detail-list">
                    <div class="detail-row">
                        <span class="detail-label">Category</span>
                        <span class="category-badge" style="font-size:0.66rem; padding:3px 9px;">
                            <span class="category-badge-dot"></span><?php echo htmlspecialchars($article['category']); ?>
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Alumni Name</span>
                        <span class="detail-value"><?php echo htmlspecialchars($article['alumni_name']); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Graduation Year</span>
                        <span class="detail-value"><?php echo htmlspecialchars($article['year_graduated']); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Published</span>
                        <span class="detail-value"><?php echo date("F Y", strtotime($article['created_at'])); ?></span>
                    </div>
                </div>
            </div>

            <div class="sidebar-card">
                <p class="sidebar-card-title">Share this Article</p>
                <div class="share-buttons">
                    <button class="share-btn" id="copyBtn" onclick="handleCopy()">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
                        </svg>
                        Copy Link
                    </button>
                    <button class="share-btn" onclick="handleEmail()">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="4" width="20" height="16" rx="2" />
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                        </svg>
                        Email
                    </button>
                </div>
            </div>

        </aside>
    </div>

    <?php include('includes/logoutmodal.php'); ?>

    <script src="assets/js/view_article.js"></script>
    <script src="assets/js/alumni_homepage.js"></script>
</body>

</html>