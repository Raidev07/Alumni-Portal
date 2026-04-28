<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>PLP Alumni stories</title>
    <link rel="icon" href="assets/image/alumni-logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,400&family=Roboto+Slab:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/articles_page.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&family=Roboto+Slab:wght@600;700&display=swap" rel="stylesheet" />
</head>
<body>

<!-- NAVBAR -->
   <nav class="navbar" id="navbar">
        <div class="nav-left">
            <a href="#" class="logo-link1"><img src="assets/image/alumni-logo.png" alt="alumni Logo"></a>
            <div class="title">
                <div>Pamantasan ng Lungsod ng Pasig</div>
                <div>ALUMNI</div>
            </div>
        </div>

        <ul class="nav-links">
            <li><a href="alumni_homepage.php">Home</a></li>
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

<!-- PAGE BODY -->
<div class="page-wrap">

  <!-- PAGE HEADER -->
  <div class="page-header">
    <div class="page-header-text">
      <p class="page-eyebrow">The Library</p>
      <h1 class="page-title">All Alumni Stories</h1>
      <p class="page-desc">Browse achievements, milestones, and moments from our community of graduates.</p>
    </div>
    <a href="view_article.php" class="new-article-btn">
      <span class="plus">+</span> New article
    </a>
  </div>

  <!-- FILTER BAR -->
  <div class="filter-bar">
    <div class="search-wrap">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      <input class="search-input" id="searchInput" type="text" placeholder="Search by title or alumni name..." />
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

<div class="logout-overlay" id="logoutOverlay" role="dialog" aria-modal="true" aria-labelledby="logoutTitle">
  <div class="logout-modal">
    <div class="logout-modal-icon">
      <i class="fas fa-sign-out-alt"></i>
    </div>
    <h3 id="logoutTitle">Logging out?</h3>
    <p>Are you sure you want to log out of your account?</p>
    <div class="logout-modal-btns">
      <button class="logout-btn-no" id="logoutNo">Cancel</button>
      <button class="logout-btn-yes" id="logoutYes">Yes, log out</button>
    </div>
  </div>
</div>


<script src="assets/js/articles_page.js">
</script>
</body>
</html>