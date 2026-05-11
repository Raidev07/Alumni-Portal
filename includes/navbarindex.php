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
            <div class="btns">
                <button class="btn" onclick="window.location.href = 'login.php'">Login</button>
                <button class="btn" onclick="window.location.href = 'DPA.php'">
                    Signup
                </button>
            </div>
            <a href="#" class="logo-link2"><img src="assets/image/plplogo.png" alt="PLP Logo"></a>
        </div>
    </nav>