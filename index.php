<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Portal</title>
    <link rel="icon" href="assets/image/alumni-logo.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/signUpDialog_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body>
    <nav class="navbar" id="navbar">
        <div class="nav-left">
            <a href="#" class="logo-link1"><img src="assets/image/alumni-logo.png" alt="alumni Logo"></a>
            <div class="title">
                <div>Pamantasan ng Lungsod ng Pasig</div>
                <div>ALUMNI</div>
            </div>
        </div>

        <ul class="nav-links">
            <li><a href="index.php" class="active">Home</a></li>
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

    <!-- Sign Up Dialog Start -->
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
    <!-- Sign Up Dialog End -->

    <section class="header">
        <!-- Swiper Slider -->
        <div class="swipers">
            <div class="swiper-container">
                <div class="swiper-wrapper">

                    <!-- Slide 1 -->
                    <div class="swiper-slide">
                        <div class="slide-content1">
                            <h1>Welcome to PLP’s Alumni Page</h1>
                            <p>
                                Join our vibrant alumni community. Connect, share experiences,
                                and build lasting relationships with graduates from around the world.
                            </p>
                            <!-- <a href="#" class="btn">Join now</a> -->
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="swiper-slide">
                        <div class="slide-content2">
                            <h1>Register Your Alumni Profile</h1>
                            <p>
                                Access exclusive features, update your profile, and stay informed about alumni events.
                            </p>
                            <ul>
                                <li><i class="fas fa-check-circle"></i> Alumni Card Application</li>
                                <li><i class="fas fa-check-circle"></i> Yearbook Claiming Application</li>
                                <li><i class="fas fa-check-circle"></i> 2-in-1 Package</li>
                            </ul>
                            <a href="#" class="btn">Sign Up</a>
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
            <div onclick="window.location.href='https://github.com/Raidev07' " class="project-box">
                <i class="uil uil-briefcase-alt"></i>
                <h3>10,000+ Members</h3>
                <label>Alumni</label>
            </div>
            </a>
            <div onclick="window.location.href='https://www.facebook.com/jb.vasquezrollamas'" class="project-box">
                <i class="uil uil-users-alt"></i>
                <h3>100+ Events</h3>
                <label>Events per year</label>
            </div>
            <div class="project-box">
                <i class="uil uil-award"></i>
                <h3>Lorem ipsum</h3>
                <label>dolor sit amet</label>
            </div>
            <div class="project-box">
                <i class="uil uil-award"></i>
                <h3>95% Overall</h3>
                <label>Satisfaction Rate</label>
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
                    <!-- Single Card -->
                    <div class="card swiper-slide">
                        <div class="card-image">
                            <img src="assets/image/design.jpg" alt="Design Trends" />
                            <div class="card-tag">Design</div>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Modern UI Trends for 2025</h3>
                            <p class="card-text">Explore the latest user interface design trends that are shaping the
                                digital landscape this year. From neumorphism to glassmorphism and beyond.</p>
                            <div class="card-footer">
                                <div class="card-profile">
                                    <img src="assets/image/user-1.jpg" alt="Alex Smith" />
                                    <div class="card-profile-info">
                                        <span class="card-profile-name">Alex Smith</span>
                                        <span class="card-profile-role">UI Designer</span>
                                    </div>
                                </div>
                                <a href="#" class="card-button">Read More</a>
                            </div>
                        </div>
                    </div>

                    <!-- Single Card -->
                    <div class="card swiper-slide">
                        <div class="card-image">
                            <img src="assets/image/development.jpg" alt="Development" />
                            <div class="card-tag">Development</div>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Best Frontend Frameworks</h3>
                            <p class="card-text">A comprehensive comparison of the most popular frontend frameworks and
                                libraries that developers are using to build modern web applications.</p>
                            <div class="card-footer">
                                <div class="card-profile">
                                    <img src="assets/image/user-2.jpg" alt="Jessica Chen" />
                                    <div class="card-profile-info">
                                        <span class="card-profile-name">Jessica Chen</span>
                                        <span class="card-profile-role">Developer</span>
                                    </div>
                                </div>
                                <a href="#" class="card-button">Read More</a>
                            </div>
                        </div>
                    </div>

                    <!-- Single Card -->
                    <div class="card swiper-slide">
                        <div class="card-image">
                            <img src="assets/image/ai.jpg" alt="AI" />
                            <div class="card-tag">AI</div>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">AI User Experience Design</h3>
                            <p class="card-text">How artificial intelligence is revolutionizing user experience design
                                and enabling more personalized, intuitive interfaces for digital products.</p>
                            <div class="card-footer">
                                <div class="card-profile">
                                    <img src="assets/image/user-3.jpg" alt="Marcus Johnson" />
                                    <div class="card-profile-info">
                                        <span class="card-profile-name">Marcus Johnson</span>
                                        <span class="card-profile-role">UX Researcher</span>
                                    </div>
                                </div>
                                <a href="#" class="card-button">Read More</a>
                            </div>
                        </div>
                    </div>

                    <!-- Single Card -->
                    <div class="card swiper-slide">
                        <div class="card-image">
                            <img src="assets/image/productivity.jpg" alt="Productivity" />
                            <div class="card-tag">Productivity</div>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Workspace Design for Focus</h3>
                            <p class="card-text">Designing workspaces that maximize productivity and minimize
                                distractions for creative professionals in the hybrid work environment.</p>
                            <div class="card-footer">
                                <div class="card-profile">
                                    <img src="assets/image/user-4.jpg" alt="Sarah Miller" />
                                    <div class="card-profile-info">
                                        <span class="card-profile-name">Sarah Miller</span>
                                        <span class="card-profile-role">Interior Designer</span>
                                    </div>
                                </div>
                                <a href="#" class="card-button">Read More</a>
                            </div>
                        </div>
                    </div>

                    <!-- Single Card -->
                    <div class="card swiper-slide">
                        <div class="card-image">
                            <img src="assets/image/animation.jpg" alt="Animation" />
                            <div class="card-tag">Animation</div>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Micro Animation Designs</h3>
                            <p class="card-text">The small animations and interactions that make a big difference in
                                user experience and how to implement them effectively in your designs.</p>
                            <div class="card-footer">
                                <div class="card-profile">
                                    <img src="assets/image/user-5.jpg" alt="David Park" />
                                    <div class="card-profile-info">
                                        <span class="card-profile-name">David Park</span>
                                        <span class="card-profile-role">Motion Designer</span>
                                    </div>
                                </div>
                                <a href="#" class="card-button">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="swiper-pagination"></div>

                <!-- Navigation Buttons -->
                <div class="swiper-slide-button swiper-button-prev"></div>
                <div class="swiper-slide-button swiper-button-next"></div>
            </div>
        </div>
    </section>

    <!-- footer -->

    <footer class="footer">
        <div class="footer-container">

            <!-- Left: Logo + About -->
            <div class="footer-section">
                <img src="assets/image/alumni-logo.png" alt="Alumni Logo" class="footer-logo">
                <h3>PLP Alumni Portal</h3>
                <p>
                    Connecting graduates of Pamantasan ng Lungsod ng Pasig.
                    Stay updated with events, jobs, and alumni activities.
                </p>
            </div>

            <!-- Middle: Links -->
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="jobs.php">Jobs</a></li>
                    <li><a href="events.php">Events</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>

            <!-- Right: Contact -->
            <div class="footer-section">
                <h4>Contact</h4>
                <p>Email: alumni@plpasig.edu.ph</p>
                <p>Phone: +63 912 345 6789</p>

                <div class="socials">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

        </div>

        <!-- Bottom -->
        <div class="footer-bottom">
            <p>© 2026 PLP Alumni Portal | All Rights Reserved</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>