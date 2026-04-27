<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms & Privacy - Alumni Portal</title>
    <link rel="icon" href="assets/image/alumni-logo.png">
    <link rel="stylesheet" href="assets/css/DPA.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
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
            <button class="btn" onclick="window.location.href='login.php'">Login</button>
            <button class="btn" onclick="window.location.href = 'DPA.php'">Signup</button>
        </div>
        <a href="#" class="logo-link2"><img src="assets/image/plplogo.png" alt="PLP Logo"></a>
    </div>
</nav>

<!-- MAIN PAGE -->
<div class="page-wrapper">
    <div class="consent-card">

        <!-- Header -->
        <div class="card-header">
            <div class="card-header-icon">
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15v-4H7l5-8v4h4l-5 8z"/></svg>
            </div>
            <div class="card-header-text">
                <h1>Data Privacy &amp; Terms of Use</h1>
                <p>Please read and accept both documents before continuing with registration.</p>
            </div>
        </div>

        <!-- Tab Nav -->
        <div class="tab-nav">
            <button class="tab-btn active" data-tab="dpa" onclick="switchTab('dpa', this)">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>
                Data Privacy Act
            </button>
            <button class="tab-btn" data-tab="tnc" onclick="switchTab('tnc', this)">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm-1 7V3.5L18.5 9H13z"/></svg>
                Terms &amp; Conditions
            </button>
        </div>

        <!-- Scroll panels wrapper -->
        <div class="panels-wrapper">

            <!-- DPA Panel -->
            <div class="scroll-panel active" id="panel-dpa">
                <p class="doc-meta">Republic Act No. 10173 · Data Privacy Act of 2012 · Alumni Information System Privacy Policy</p>

                <div class="doc-section">
                    <h2>Introduction</h2>
                    <p>The Pamantasan ng Lungsod ng Pasig (PLP) is committed to protecting the personal privacy of its stakeholders. It is the policy of the University that information collected from its stakeholders be stored, maintained, and used only for appropriate, necessary, and clearly defined purposes, and that such information be controlled and safeguarded in order to ensure the protection of personal privacy to the extent permitted by law.</p>
                    <p style="margin-top:0.6rem;">To be consistent with data protection laws, we ask you to take a moment to review the key points in this privacy policy. By availing of the University's services, you consent to the use of your data under this privacy policy.</p>
                </div>

                <div class="doc-section">
                    <h2>Information We Collect</h2>
                    <p>We collect relevant personal information online through the Alumni Information System (AIS) in addition to information already gathered from you when you applied and when you were admitted as a student.</p>
                    <p style="margin-top:0.6rem;">We collect information about your past and present employment, graduate degrees, recognitions, awards, and other information which may allow us to determine attainment of graduate outcomes after completion of degrees in our institution.</p>
                    <p style="margin-top:0.6rem;">Your personal information is connected to your academic performance within your years of study in the University. You may also be asked to provide feedback regarding your learning experience and render suggestions for the improvement of our programs. For these feedback mechanisms, you will not be individually identified.</p>
                </div>

                <div class="doc-section">
                    <h2>Why We Process Your Data</h2>
                    <p>We use your personal data, together with your academic performance, to determine successful attainment of graduate outcomes upon graduation from the University, as evidenced by employment, promotion, or recognition of our alumni. We also utilize your data for educational, research, and institutional quality assurance purposes, such as but not limited to:</p>
                    <ul>
                        <li>Monitoring graduate employability</li>
                        <li>Determining factors for successful employment</li>
                        <li>Identifying patterns and determinants of graduate employability</li>
                        <li>Identifying potential gaps in services to ensure programs remain relevant</li>
                    </ul>
                </div>

                <div class="doc-section">
                    <h2>How We Process Your Data</h2>
                    <p>We may use your personal information to contact you on matters pertaining to your connection with us as an alumnus of the University.</p>
                    <p style="margin-top:0.6rem;">We conduct data analytics of all alumni data for the purposes mentioned above and compare aggregate data with those of previous terms or academic years to analyze trends. We may conduct predictive and prescriptive analytics for future decision-making regarding our program offerings and teaching-learning strategies. <strong>These aggregate analyses do not identify you individually.</strong></p>
                    <p style="margin-top:0.6rem;">As an educational institution, we retain alumni information in perpetuity, in order to allow us to update existing academic data and make your academic records readily available when you request for them in the future.</p>
                    <p style="margin-top:0.6rem;">We may likewise utilize your personal information and contact details to provide you with information on continuing professional development (CPD) programs and graduate programs that may be of interest to you in the future. You may opt not to receive this information, and we will not use your data for these marketing purposes.</p>
                </div>

                <div class="doc-section">
                    <h2>How We Share Information</h2>
                    <p>The Office of Alumni Relations is the Personal Information Controller (PIC) of all alumni data. The respective academic unit that has jurisdiction over your program has access to your personal information as they directly monitor your graduate outcomes after graduation.</p>
                    <p style="margin-top:0.6rem;">With the permission of the University's Data Protection Officer (DPO) and subject to compliance with research ethics and data privacy, the PIC may share your <strong>depersonalized</strong> information to academic researchers who may request for such, instituting measures that will not allow you to be individually identified.</p>
                    <p style="margin-top:0.6rem;">Upon your request, we may need to share your personal and academic data with external agencies that require these for evaluation of your credentials for purposes of employment or further studies.</p>
                    <p style="margin-top:0.6rem;">We may need to share your data when required by law or to protect your rights and security, or when required by regulatory agencies such as CHED, LEB, DepEd, or local and international accrediting agencies (e.g., PACUCOA, PAASCU) as part of the monitoring and/or evaluation process.</p>
                </div>

                <div class="doc-section">
                    <h2>Your Choices and Obligations</h2>
                    <p>You have the option not to grant use of your personal information for institutional marketing purposes or for research done by individuals or groups outside of institutional research purposes.</p>
                    <p style="margin-top:0.6rem;">You have the obligation to ensure the completeness and accuracy of all information provided to the University. Provision of fraudulent information, if proven to be deliberate, may result in disciplinary action or prevention from availing University services.</p>
                </div>

                <div class="doc-section">
                    <h2>Other Important Information</h2>
                    <p>We implement security safeguards designed to protect your data and regularly monitor our systems for possible vulnerabilities and attacks.</p>
                    <p style="margin-top:0.6rem;">You may contact us through the <strong>Office of the University Data Protection Officer</strong> to communicate any concerns you may have regarding our privacy policy.</p>
                </div>
            </div>

            <!-- T&C Panel -->
            <div class="scroll-panel" id="panel-tnc">
                <p class="doc-meta">PLP Alumni Portal · Version 2.1 · Last updated: March 10, 2025</p>

                <div class="doc-section">
                    <h2>Acceptance of Terms</h2>
                    <p>By registering for and using the PLP Alumni Portal, you agree to be bound by these Terms and Conditions. If you do not agree to all the terms stated herein, you must not access or use the portal. These terms may be updated periodically; continued use of the portal after updates constitutes acceptance of the revised terms.</p>
                </div>

                <div class="doc-section">
                    <h2>Eligibility</h2>
                    <p>Access to the Alumni Portal is restricted to:</p>
                    <ul>
                        <li>Verified graduates of any academic program offered by PLP</li>
                        <li>Currently enrolled students of PLP (with limited access privileges)</li>
                        <li>Faculty and staff authorized by the Office of Alumni Affairs</li>
                    </ul>
                </div>

                <div class="doc-section">
                    <h2>Account Responsibilities</h2>
                    <p>You are solely responsible for maintaining the confidentiality of your login credentials and for all activities that occur under your account. You agree to immediately notify PLP of any unauthorized use of your account. PLP shall not be liable for any loss or damage arising from your failure to comply with this obligation.</p>
                </div>

                <div class="doc-section">
                    <h2>Prohibited Conduct</h2>
                    <p>Users of the portal must not engage in any of the following:</p>
                    <ul>
                        <li>Providing false or misleading registration information</li>
                        <li>Impersonating another person or entity</li>
                        <li>Posting defamatory, obscene, or offensive content</li>
                        <li>Using the portal for unauthorized commercial solicitation</li>
                        <li>Attempting to gain unauthorized access to other users' accounts</li>
                        <li>Introducing malicious code, viruses, or harmful software</li>
                    </ul>
                </div>

                <div class="doc-section">
                    <h2>Intellectual Property</h2>
                    <p>All content available on the PLP Alumni Portal, including but not limited to text, graphics, logos, icons, and software, is the property of Pamantasan ng Lungsod ng Pasig and is protected by applicable intellectual property laws. Unauthorized reproduction or distribution is strictly prohibited.</p>
                </div>

                <div class="doc-section">
                    <h2>Limitation of Liability</h2>
                    <p>PLP shall not be held liable for any indirect, incidental, special, or consequential damages arising from your use of or inability to access the portal, including but not limited to loss of data, loss of revenue, or damage to reputation, even if PLP has been advised of the possibility of such damages.</p>
                </div>

                <div class="doc-section">
                    <h2>Governing Law</h2>
                    <p>These Terms and Conditions shall be governed by and construed in accordance with the laws of the Republic of the Philippines. Any dispute arising from these terms shall be subject to the exclusive jurisdiction of the appropriate courts of Pasig City, Metro Manila.</p>
                </div>

                <div class="doc-section">
                    <h2>Termination</h2>
                    <p>PLP reserves the right to suspend or permanently terminate your account at its sole discretion, without prior notice, if you are found to have violated any provision of these Terms and Conditions or any applicable law.</p>
                </div>
            </div>

            <!-- Scroll fade overlay -->
            <div class="scroll-fade" id="scrollFade"></div>
        </div>

        <!-- Scroll indicator -->
        <div class="scroll-indicator" id="scrollIndicator">Scroll to read — <span id="scrollPct">0%</span> read</div>

        <!-- Agreement checkboxes -->
        <div class="agreements">
            <label class="check-label" id="label-dpa">
                <input type="checkbox" id="check-dpa" onchange="updateNext(); styleLabel(this)">
                <span class="check-text">
                    I have read and fully understood the <strong>Data Privacy Act (RA 10173)</strong> disclosure and I consent to the collection and processing of my personal data by PLP for the stated purposes.
                </span>
            </label>
            <label class="check-label" id="label-tnc">
                <input type="checkbox" id="check-tnc" onchange="updateNext(); styleLabel(this)">
                <span class="check-text">
                    I have read and agree to the <strong>Terms &amp; Conditions</strong> of the PLP Alumni Portal and I understand that violations may result in account suspension or termination.
                </span>
            </label>
        </div>

        <!-- Footer buttons -->
        <div class="card-footer">
            <button class="footer-btn btn-cancel" onclick="handleCancel()">Cancel</button>
            <button class="footer-btn btn-next" id="nextBtn" disabled onclick="handleNext()">
                Next
                <svg viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
            </button>
        </div>

    </div>
</div>

<!-- Sign Up Dialog -->
<dialog id="signUpDialog">
    <div class="title">Sign Up As...</div>
    <div class="registerButtons">
        <button onclick="window.location.href='student_form.php'">Register As Student</button>
        <button onclick="window.location.href='alumni_form.php'">Register As Alumni</button>
    </div>
    <button id="closeButton" onclick="document.getElementById('signUpDialog').close()">Close</button>
</dialog>

<script>
    /* ── STICKY NAV ─────────────────────────────────────────── */
    window.addEventListener('scroll', () => {
        document.getElementById('navbar').classList.toggle('sticky', window.scrollY > 10);
    });

    /* ── TAB SWITCHING ──────────────────────────────────────── */
    let activeTab = 'dpa';

    function switchTab(tab, btn) {
        activeTab = tab;

        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        document.querySelectorAll('.scroll-panel').forEach(p => p.classList.remove('active'));
        document.getElementById('panel-' + tab).classList.add('active');

        updateScrollState();
    }

    /* ── SCROLL TRACKING ────────────────────────────────────── */
    function updateScrollState() {
        const panel = document.querySelector('.scroll-panel.active');
        const fade  = document.getElementById('scrollFade');
        const pct   = document.getElementById('scrollPct');

        const scrollable = panel.scrollHeight - panel.clientHeight;
        const progress   = scrollable > 0 ? panel.scrollTop / scrollable : 1;
        const percent    = Math.round(progress * 100);

        pct.textContent = percent + '%';
        fade.classList.toggle('hidden', progress >= 0.98);
    }

    document.querySelectorAll('.scroll-panel').forEach(panel => {
        panel.addEventListener('scroll', updateScrollState);
    });

    // init
    updateScrollState();

    /* ── CHECKBOX LOGIC ─────────────────────────────────────── */
    function styleLabel(checkbox) {
        const label = checkbox.closest('.check-label');
        label.classList.toggle('checked', checkbox.checked);
    }

    function updateNext() {
        const allChecked =
            document.getElementById('check-dpa').checked &&
            document.getElementById('check-tnc').checked;
        document.getElementById('nextBtn').disabled = !allChecked;
    }

    /* ── BUTTON ACTIONS ─────────────────────────────────────── */
    function handleCancel() {
        if (confirm('Are you sure you want to cancel? Your progress will be lost.')) {
            window.location.href = 'index.php';
        }
    }

    function handleNext() {
        // Replace with your actual next step URL or action
        window.location.href = 'alumni_form.php';
    }
</script>
</body>
</html>