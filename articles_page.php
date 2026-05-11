<?php
session_start();
include("backend/db.php");

$isloggedIn = isset($_SESSION['user_id']);
$uid = $isloggedIn ? $_SESSION['user_id'] : null;

$articles = [];

$sql = "SELECT * FROM alumnifeatured ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {

    $articles[] = [
        "id" => $row['id'],
        "title" => $row['title'],
        "excerpt" => $row['excerpt'],
        "category" => $row['category'],
        "author" => $row['alumni_name'],
        "gradYear" => "'" . substr($row['year_graduated'], -2),
        "date" => date("M d, Y", strtotime($row['created_at'])),
        "image" => $row['cover_image']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PLP Alumni stories</title>
    <link rel="icon" href="assets/image/alumni_plp_newicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,400&family=Roboto+Slab:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/alumni_homepage.css">
    <link rel="stylesheet" href="assets/css/articles_page.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&family=Roboto+Slab:wght@600;700&display=swap" rel="stylesheet" />
</head>

<body>
    <?php
    if ($isloggedIn) {
        include('includes/navbarhome.php');
    } else {
        include('includes/navbarindex.php');
    } ?>

    <!-- PAGE BODY -->
    <div class="page-wrap">

        <!-- PAGE HEADER -->
        <div class="page-header">
            <div class="page-header-text">
                <p class="page-eyebrow">The Library</p>
                <h1 class="page-title">All Alumni Stories</h1>
                <p class="page-desc">Browse achievements, milestones, and moments from our community of graduates.
                </p>
            </div>
        </div>

        <!-- FILTER BAR -->
        <div class="filter-bar">
            <div class="search-wrap">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.35-4.35" />
                </svg>
                <input class="search-input" id="searchInput" type="text"
                    placeholder="Search by title or alumni name..." />
            </div>
            <div class="filter-pills" id="filterPills">
                <button class="pill active" data-cat="all">All</button>
                <button class="pill" data-cat="Science & Research">Science &amp; Research</button>
                <button class="pill" data-cat="Community Impact">Community Impact</button>
                <button class="pill" data-cat="Arts & Culture">Arts &amp; Culture</button>
                <button class="pill" data-cat="Business">Business</button>
                <button class="pill" data-cat="Sports">Sports</button>
                <button class="pill" data-cat="Other">Other</button>
            </div>
        </div>

        <!-- RESULTS META -->
        <p class="results-meta" id="resultsMeta">Showing <strong>9</strong> stories</p>

        <!-- CARD GRID -->
        <div class="card-grid" id="cardGrid"></div>

        <!-- PAGINATION -->
        <div class="pagination" id="pagination"></div>

    </div>


    <?php include('includes/logoutmodal.php'); ?>

    <script>
        const articles = <?php echo json_encode($articles); ?>;
    </script>
    <script src="assets/js/articles_page.js"></script>
    <script src="assets/js/alumni_homepage.js"></script>
</body>

</html>