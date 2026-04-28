<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Alumni Article Reader</title>
    <link rel="icon" href="assets/image/alumni-logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,400&family=Roboto+Slab:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/view_article.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>
<body>

  <div class="reading-progress-bar"><div class="reading-progress-fill" id="progressFill"></div></div>

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
        <!-- Swap <span> for <img src="..." alt="..."> when you have a real image -->
        <span class="cover-placeholder-text">FEATURE STORY</span>
      </div>

      <header class="article-header">
        <span class="category-badge">
          <span class="category-badge-dot"></span>
          Technology &amp; Innovation
        </span>
        <h1 class="article-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit</h1>
        <div class="article-meta">
          <div class="alumni-avatar" aria-hidden="true">MR</div>
          <div class="meta-info">
            <div class="alumni-name">Juan Dela Cruz</div>
            <div class="grad-year">B.S. Computer Science &middot; Class of 2016</div>
          </div>
        </div>
      </header>

      <blockquote class="article-excerpt">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit
      </blockquote>

      <article class="article-body">
        <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

        <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit</h2>
        <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
      </article>

      <div style="height: 2rem;"></div>
    </main>

    <!-- SIDEBAR -->
    <aside class="sidebar">

      <div class="sidebar-card">
        <p class="sidebar-card-title">About the Alumna</p>
        <div class="author-inner">
          <div class="author-avatar-lg" aria-hidden="true">MR</div>
          <div class="author-name-lg">Juan Dela Cruz</div>
          <div class="author-degree">B.S. Computer Science<br>Stanford M.S. (part-time, 2019)</div>
          <span class="year-chip">Class of 2016</span>
          <p class="author-bio">Co-founder &amp; CEO of GreenMind Technologies. Former research engineer and angel-backed founder. Passionate about sustainable AI infrastructure and university mentorship.</p>
        </div>
      </div>

      <div class="sidebar-card">
        <p class="sidebar-card-title">Article Details</p>
        <div class="detail-list">
          <div class="detail-row">
            <span class="detail-label">Category</span>
            <span class="category-badge" style="font-size:0.66rem; padding:3px 9px;">
              <span class="category-badge-dot"></span>Technology
            </span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Alumni Name</span>
            <span class="detail-value">Juan Dela Cruz</span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Graduation Year</span>
            <span class="detail-value">2016</span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Published</span>
            <span class="detail-value">April 2025</span>
          </div>
        </div>
      </div>

      <div class="sidebar-card">
        <p class="sidebar-card-title">Share this Article</p>
        <div class="share-buttons">
          <button class="share-btn" id="copyBtn" onclick="handleCopy()">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
            Copy Link
          </button>
          <button class="share-btn" onclick="handleEmail()">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
            Email
          </button>
        </div>
      </div>

    </aside>
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

<script src="assets/js/view_article.js"></script>
</body>
</html>