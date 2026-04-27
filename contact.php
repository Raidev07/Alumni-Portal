<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="icon" href="assets/image/alumni-logo.png">
    <link rel="stylesheet" href="assets/css/contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap"
        rel="stylesheet">
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar" id="navbar">
        <div class="nav-left">
            <a href="#" class="logo-link1"><img src="assets/image/alumni-logo.png" alt="Alumni Logo"></a>
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
                <button class="btn" onclick="window.location.href = 'DPA.php'">
                    Signup
                </button>
            </div>
            <a href="#" class="logo-link2"><img src="assets/image/plplogo.png" alt="PLP Logo"></a>
        </div>
    </nav>

    <!-- MAP -->
    <section class="location">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.648293414424!2d121.0721697102915!3d14.56209408586095!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c87941df8e2b%3A0xc7cd5073d3d73742!2sPamantasan%20ng%20Lungsod%20ng%20Pasig!5e0!3m2!1sen!2sph!4v1772607934052!5m2!1sen!2sph"
            width="600" height="420" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>

    <!-- CONTACT SECTION -->
    <section class="contact-section">
        <div class="contact-wrapper">
            <div class="contact-header">
                <span class="section-tag">Contact Us</span>
                <p class="section-sub">Have questions or concerns? We're here to help. Fill out the form below or reach
                    us directly.</p>
            </div>
            <div class="contact-form-card">
                <h3 class="form-title">Send a Message</h3>
                <p class="form-sub">We'll respond within 24 hours on business days.</p>
                <div class="info-cards">
                    <div class="info-card">
                        <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="info-text">
                            <h5>Address</h5>
                            <p>12-B Alcalde Jose, Pasig<br>1600 Metro Manila</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
                        <div class="info-text">
                            <h5>Phone</h5>
                            <p>0287215846</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-icon"><i class="fas fa-clock"></i></div>
                        <div class="info-text">
                            <h5>Working Hours</h5>
                            <p>Mon – Fri, 9AM to 5PM</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-icon"><i class="fas fa-envelope"></i></div>
                        <div class="info-text">
                            <h5>Email</h5>
                            <p>rollamas_justinebryle<br>@plpasig.edu.ph</p>
                        </div>
                    </div>
                </div>
                <form action="form-handler.php" method="post" class="contact-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" placeholder="Juan dela Cruz" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" placeholder="juan@email.com" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" placeholder="How can we help you?" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="6" placeholder="Write your message here..."
                            required></textarea>
                    </div>
                    <button type="submit" class="submit-btn">
                        <span>Send Message</span>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
        </div>
    </section>

    <!-- ABOUT US SECTION -->
    <div class="about-section">
        <h1 class="about-heading">About Us</h1>
        <p class="about-subheading">Meet the team behind the PLP Alumni Portal — click any card to learn more.</p>

        <div class="team-grid">
            <!-- Card 1 -->
            <div class="card" onclick="openModal('jonjesse')">
                <div class="img-container">
                    <img src="assets/image/1x1pic/tao.png" alt="John Jesse Escalona"
                        onerror="this.style.display='none'; this.parentElement.textContent='JE'">
                </div>
                <h3>John Jesse Escalona</h3>
                <div class="card-role">Lead Developer</div>
                <div class="card-id">24-00972</div>
                <div class="card-click-hint">View Profile</div>
            </div>

            <!-- Card 2 -->
            <div class="card" onclick="openModal('sam')">
                <div class="img-container">
                    <img src="assets/image/1x1pic/Gonzaga, Sam Aidan.jfif" alt="Sam Aidan Gonzaga"
                        onerror="this.style.display='none'; this.parentElement.textContent='SA'">
                </div>
                <h3>Sam Aidan Gonzaga</h3>
                <div class="card-role">Project Lead</div>
                <div class="card-id">24-00662</div>
                <div class="card-click-hint">View Profile</div>
            </div>


            <!-- Card 3 -->
            <div class="card" onclick="openModal('bryle')">
                <div class="img-container">
                    <img src="assets/image/1x1pic/bryl.png" Justine Bryle Rollamas"
                        onerror="this.style.display='none'; this.parentElement.textContent='JB'">
                </div>
                <h3>Justine Bryle Rollamas</h3>
                <div class="card-role">Project Manager</div>
                <div class="card-id">24-00607</div>
                <div class="card-click-hint">View Profile</div>
            </div>

            <!-- Card 4 -->
            <div class="card" onclick="openModal('vehniah')">
                <div class="img-container">
                    <img src="assets/image/1x1pic/VehniahSamson 1x1pic.jpg" alt="Vehniah P. Samson"
                        onerror="this.style.display='none'; this.parentElement.textContent='VS'">
                </div>
                <h3>Vehniah P. Samson</h3>
                <div class="card-role">Senior Developer</div>
                <div class="card-id">24-00585</div>
                <div class="card-click-hint">View Profile</div>
            </div>
        </div>
    </div>

    <!-- MODAL -->
    <div class="modal-overlay" id="modalOverlay" onclick="handleOverlayClick(event)">
        <div class="modal" id="modal">
            <div class="modal-top-bar"></div>
            <button class="modal-close" onclick="closeModal()">&#x2715;</button>
            <div class="modal-header">
                <div class="modal-avatar" id="modalAvatar"></div>
                <div>
                    <div class="modal-name" id="modalName"></div>
                    <div id="modalRole"></div><br>
                    <div class="modal-id-label" id="modalId"></div>
                </div>
            </div>
            <div class="modal-divider"></div>
            <div class="modal-body">
                <div class="modal-section-label">Contributions to the Project</div>
                <div class="contributions" id="modalContributions"></div>
                <div class="modal-section-label">Connect</div>
                <div class="social-links" id="modalSocials"></div>
            </div>
        </div>
    </div>

    <script>
        const members = {
            jonjesse: {
                initials: 'JE',
                name: 'John Jesse Escalona',
                roles: ['Lead Developer', 'Full-stack'],
                id: '24-00972',
                photo: 'assets/image/1x1pic/tao.png',
                contributions: [
                    'Architected the full-stack structure of the Alumni portal',
                    'Built the core authentication system — login, signup, and session handling',
                    'Developed the Jobs and Events listing modules',
                    'Integrated the database schema and backend API routes',
                    'Led code reviews and maintained repository standards'
                ],
                fb: 'https://www.facebook.com/johnjesse.escalona.96',
                email: 'https://mail.google.com/mail/?view=cm&fs=1&to=jay.escalona.je@gmail.com'
            },
            sam: {
                initials: 'SA',
                name: 'Sam Aidan Gonzaga',
                roles: ['Project Lead', 'Database Administrator'],
                id: '24-00662',
                photo: 'assets/image/1x1pic/Gonzaga, Sam Aidan.jfif',
                contributions: [
                    'Assisted in gathering and documenting system requirements',
                    'Prepared test cases and performed functional testing',
                    'Supported content entry and data verification tasks',
                    'Coordinated with the project lead on scheduling and progress reports',
                    'Managed documentation for the About and Contact sections'
                ],
                fb: 'https://www.facebook.com/samaidan.gonzaga',
                email: 'https://mail.google.com/mail/?view=cm&fs=1&to=gonzaga_samaidan@plpasig.edu.ph'
            },
            bryle: {
                initials: 'JB',
                name: 'Justine Bryle Rollamas',
                roles: ['Project Manager', 'Frontend Developer'],
                id: '24-00607',
                photo: 'assets/image/1x1pic/bryl.png',
                contributions: [
                    'Defined the project scope, timeline, and key deliverables',
                    'Coordinated team meetings and tracked milestone progress',
                    'Handled stakeholder communication and official documentation',
                    'Designed the overall user flow and initial wireframes',
                    'Ensured all features aligned with the alumni office requirements'
                ],
                fb: 'https://www.facebook.com/jb.vasquezrollamas',
                email: 'https://mail.google.com/mail/?view=cm&fs=1&to=rollamas_justinebryle@plpasig.edu.ph'
            },
            vehniah: {
                initials: 'VS',
                name: 'Vehniah P. Samson',
                roles: ['Senior Developer', 'Full-stack'],
                id: '24-00585',
                photo: 'assets/image/1x1pic/VehniahSamson 1x1pic.jpg',
                contributions: [
                    'Developed all frontend UI components and responsive layouts',
                    'Implemented the sticky navbar and smooth scroll behaviors',
                    'Built the contact form with full client-side validation',
                    'Designed and styled the About and Contact pages end-to-end',
                    'Optimized CSS for cross-browser and mobile compatibility'
                ],
                fb: 'https://www.facebook.com/vehniah.samson',
                email: 'https://mail.google.com/mail/?view=cm&fs=1&to=samson_vehniah@plpasig.edu.ph'
            }
        };

        function openModal(key) {
            const m = members[key];

            // Avatar: try image, fallback to initials
            const avatarEl = document.getElementById('modalAvatar');
            avatarEl.innerHTML = '';
            const img = document.createElement('img');
            img.src = m.photo;
            img.alt = m.name;
            img.onerror = () => { avatarEl.innerHTML = ''; avatarEl.textContent = m.initials; };
            avatarEl.appendChild(img);

            document.getElementById('modalName').textContent = m.name;
            document.getElementById('modalRole').innerHTML = m.roles.map(r =>
                `<div class="modal-role-badge">${r}</div>`
            ).join('');
            document.getElementById('modalId').textContent = 'Student ID: ' + m.id;

            document.getElementById('modalContributions').innerHTML =
                m.contributions.map(t =>
                    `<div class="contrib-item">
                        <div class="contrib-dot"></div>
                        <div class="contrib-text">${t}</div>
                    </div>`
                ).join('');

            document.getElementById('modalSocials').innerHTML =
                `<a class="social-btn" href="${m.fb}" target="_blank">
                    <i class="fab fa-facebook"></i> Facebook
                </a>
                <a class="social-btn" href="${m.email}" target="_blank">
                    <i class="fas fa-envelope"></i> Email
                </a>`;

            document.getElementById('modalOverlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('modalOverlay').classList.remove('open');
            document.body.style.overflow = '';
        }

        function handleOverlayClick(e) {
            if (e.target === document.getElementById('modalOverlay')) closeModal();
        }

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeModal();
        });

        // Sticky navbar
        window.addEventListener('scroll', function () {
            const nav = document.getElementById('navbar');
            nav.classList.toggle('sticky', window.scrollY > 50);
        });
    </script>

</body>

</html>