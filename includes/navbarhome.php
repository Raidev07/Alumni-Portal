<?php $current_page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)); ?>
<nav class="navbar" id="navbar">
    <div class="nav-left">
        <a href="#" class="logo-link1"><img src="assets/image/alumni_plp_newicon.png" alt="alumni Logo"></a>    
        <div class="title">
            <div>Pamantasan ng Lungsod ng Pasig</div>
            <div>ALUMNI</div>
        </div>
    </div>

    <ul class="nav-links">
        <li><a href="index.php" class="<?= ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a></li>
        <li><a href="jobs.php" class="<?= ($current_page == 'jobs.php') ? 'active' : ''; ?>">Jobs</a></li>
        <li><a href="events.php" class="<?= ($current_page == 'events.php') ? 'active' : ''; ?>">Events</a></li>
        <li><a href="articles_page.php" class="<?= ($current_page == 'articles_page.php') ? 'active' : ''; ?>">Highlights</a></li>
    </ul>

    <div class="nav-right">

        <!-- Profile Icon -->
        <a href="profile-page.php" class="profile-icon <?= ($current_page == 'profile-page.php') ? 'active' : ''; ?>" title="My Profile">
            <i class="fas fa-user" ></i>
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
                    <li>
                        <a href="security.php" id="securityTrigger">
                            <i class="fas fa-shield-alt"></i> Security Settings
                        </a>
                    </li>
                    <li>
                        <a href="my_tickets.php" id="securityTrigger">
                            <i class="fas fa-ticket-alt"></i> My Tickets
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