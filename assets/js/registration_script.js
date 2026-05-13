// ========================
// School ID Format
// ========================
const studentId = document.querySelector('input[name="studentId"]');

if (studentId) {
    studentId.addEventListener("keydown", function (e) {
        if (e.key === "Backspace" && this.value.endsWith("-")) {
            e.preventDefault();
            this.value = this.value.slice(0, -1);
        }
    });

    studentId.addEventListener("input", function () {
        let value = this.value.replace(/\D/g, "");

        if (value.length > 2) {
            value = value.slice(0, 2) + "-" + value.slice(2, 7);
        }

        this.value = value;
    });
}

// ========================
// Auto Fetch Graduate Info
// ========================

if (studentId) {
    studentId.addEventListener("input", function () {
        const studentNumber = this.value.trim();

        if (!/^\d{2}-\d{5}$/.test(studentNumber)) {
            return;
        }

        fetch(
            `backend/get_graduate.php?student_number=${encodeURIComponent(studentNumber)}`,
        )
            .then((res) => res.json())
            .then((data) => {
                if (!data.success) {
                    showRegModal(
                        "⚠️",
                        "Graduate Not Found",
                        data.message,
                        null,
                    );

                    return;
                }

                const g = data.data;

                // Fill Inputs
                document.getElementById("firstName").value = g.first_name || "";
                document.getElementById("middleName").value =
                    g.middle_name || "";
                document.getElementById("lastName").value = g.last_name || "";
                document.getElementById("suffix").value = g.suffix || "";
                document.getElementById("birthdate").value = g.birthdate || "";

                // Course
                document.getElementById("course").value = g.course_id;

                // Year Graduated
                document.getElementById("yearGraduated").value =
                    g.year_graduated;

                // Gender
                if (g.gender === "Male") {
                    document.getElementById("dot-1").checked = true;
                } else if (g.gender === "Female") {
                    document.getElementById("dot-2").checked = true;
                }

                // Remove red error state after auto-fill
                const filledFields = [
                    "firstName",
                    "middleName",
                    "lastName",
                    "suffix",
                    "birthdate",
                    "course",
                    "yearGraduated",
                ];

                filledFields.forEach((id) => {
                    const el = document.getElementById(id);

                    if (el) {
                        el.classList.remove("input-error");
                    }
                });

                // Remove sex error state
                document
                    .querySelector(".sex__details .category")
                    .classList.remove("sex-error");

                document.getElementById("sexWarning").style.display = "none";

                // Refresh validation UI after autofill
                const autoFilledFields = [
                    "firstName",
                    "middleName",
                    "lastName",
                    "birthdate",
                ];

                autoFilledFields.forEach((id) => {
                    const field = document.getElementById(id);

                    if (field) {
                        field.classList.remove("input-error");
                        field.classList.add("readonly-valid");
                        // trigger browser validation refresh
                        field.dispatchEvent(
                            new Event("input", { bubbles: true }),
                        );
                        field.dispatchEvent(
                            new Event("change", { bubbles: true }),
                        );
                    }
                });
                // Lock fields
                const lockFields = [
                    "firstName",
                    "middleName",
                    "lastName",
                    "birthdate",
                ];

                lockFields.forEach((id) => {
                    document.getElementById(id).readOnly = true;
                });

                document.getElementById("course").style.pointerEvents = "none";
                document.getElementById("suffix").style.pointerEvents = "none";
                document.getElementById("yearGraduated").style.pointerEvents =
                    "none";

                document.querySelector(".sex__details").style.pointerEvents =
                    "none";

                document
                    .getElementById("firstName")
                    .classList.add("locked-field");
                document
                    .getElementById("middleName")
                    .classList.add("locked-field");
                document
                    .getElementById("lastName")
                    .classList.add("locked-field");
                document.getElementById("suffix").classList.add("locked-field");
                document
                    .getElementById("birthdate")
                    .classList.add("locked-field");
                document
                    .querySelector(".sex__details")
                    .classList.add("sex-locked");

                document.getElementById("course").classList.add("locked-field");
                document
                    .getElementById("yearGraduated")
                    .classList.add("locked-field");
            })
            .catch(() => {
                showRegModal(
                    "❌",
                    "Server Error",
                    "Unable to verify graduate information.",
                    null,
                );
            });
    });
}

// ========================
// Reset Form
// ========================
function resetRegistrationForm() {
    const form = document.querySelector("form");

    form.reset();

    // Unlock readonly fields
    const lockFields = ["firstName", "middleName", "lastName", "birthdate"];

    lockFields.forEach((id) => {
        const field = document.getElementById(id);

        if (field) {
            field.readOnly = false;
            field.value = "";

            field.classList.remove(
                "readonly-valid",
                "input-error",
                "locked-field",
            );

            field.style.borderColor = "";
            field.style.boxShadow = "";
            field.style.backgroundColor = "";
        }
    });

    // Unlock select fields
    ["course", "suffix", "yearGraduated"].forEach((id) => {
        const field = document.getElementById(id);

        if (field) {
            field.style.pointerEvents = "";
            field.value = "";

            field.classList.remove(
                "locked-field",
                "readonly-valid",
                "input-error",
            );

            field.style.borderColor = "";
            field.style.boxShadow = "";
            field.style.backgroundColor = "";
        }
    });

    // Unlock sex section
    const sexDetails = document.querySelector(".sex__details");

    if (sexDetails) {
        sexDetails.style.pointerEvents = "";
        sexDetails.classList.remove("sex-locked");

        const category = sexDetails.querySelector(".category");

        if (category) {
            category.classList.remove("sex-error");
            category.style.borderColor = "";
            category.style.boxShadow = "";
            category.style.backgroundColor = "";
        }
    }

    // Hide sex warning
    const sexWarning = document.getElementById("sexWarning");

    if (sexWarning) {
        sexWarning.style.display = "none";
    }

    // Reset ALL inputs/selects CSS
    const allFields = form.querySelectorAll("input, select");

    allFields.forEach((field) => {
        field.classList.remove("input-error", "readonly-valid", "locked-field");

        field.style.borderColor = "";
        field.style.boxShadow = "";
        field.style.backgroundColor = "";

        // Force browser validation refresh
        field.dispatchEvent(new Event("input", { bubbles: true }));
        field.dispatchEvent(new Event("change", { bubbles: true }));
    });

    // Reset password requirement indicators
    const requirements = document.querySelectorAll(".requirement");

    requirements.forEach((req) => {
        req.classList.remove("met");
    });
}
// ========================
// DOM Ready
// ========================
document.addEventListener("DOMContentLoaded", function () {
    var form = document.querySelector("form");

    const resetBtn = document.getElementById("resetBtn");

    if (resetBtn) {
        resetBtn.addEventListener("click", resetRegistrationForm);
    }
    // ========================
    // Show / Hide Password
    // ========================
    var toggleButtons = document.querySelectorAll(".toggle-password");

    for (var i = 0; i < toggleButtons.length; i++) {
        toggleButtons[i].addEventListener("click", function (e) {
            e.preventDefault();

            var target = document.querySelector(
                this.getAttribute("data-target"),
            );

            if (!target) return;

            if (target.type === "password") {
                target.type = "text";
                this.textContent = "Hide";
            } else {
                target.type = "password";
                this.textContent = "Show";
            }
        });
    }

    // ========================
    // Year Dropdown
    // ========================
    var yearSelect = document.querySelector('select[name="yearGraduated"]');

    if (yearSelect) {
        var currentYear = new Date().getFullYear();

        for (var y = currentYear; y >= 2000; y--) {
            // ← back to 2000
            var opt = document.createElement("option");
            opt.value = y;
            opt.textContent = y;
            yearSelect.appendChild(opt);
        }
    }

    // ========================
    // Birthdate restriction (last 10 years)
    // ========================
    var birthdateInput = document.querySelector('input[name="birthdate"]');

    if (birthdateInput) {
        var today = new Date();

        var maxDate = new Date(today);
        maxDate.setFullYear(today.getFullYear() - 10); // ← must be at least 10 yrs old

        var format = function (d) {
            return d.toISOString().split("T")[0];
        };

        birthdateInput.max = format(maxDate); // latest selectable date = 10 years ago
        // no min set — allows any older birthdate
    }
    // ========================
    // Live Validation Events
    // ========================
    var email = document.getElementById("email");
    var phone = document.getElementById("contactNum");
    var password = document.getElementById("password");
    var confirmPassword = document.getElementById("confirmPassword");

    if (email) email.addEventListener("input", validateEmail);
    if (phone) phone.addEventListener("input", validatePhone);
    if (password) password.addEventListener("input", validatePassword);
    if (confirmPassword)
        confirmPassword.addEventListener("input", validateConfirm);

    // ========================
    // Name Validation (No Numbers)
    // ========================
    function allowLettersOnly(input) {
        input.addEventListener("input", function () {
            this.value = this.value.replace(/[^a-zA-Z\s]/g, "");
        });
    }

    allowLettersOnly(document.getElementById("firstName"));
    allowLettersOnly(document.getElementById("middleName"));
    allowLettersOnly(document.getElementById("lastName"));
    // ========================
    // Remove error on focus
    // ========================
    var allInputs = form.querySelectorAll("input, select");

    for (var i = 0; i < allInputs.length; i++) {
        allInputs[i].addEventListener("focus", function () {
            this.classList.remove("input-error");
        });
    }

    // ========================
    // Sex warning remove
    // ========================
    var sexRadios = document.querySelectorAll('input[name="sex"]');

    for (var s = 0; s < sexRadios.length; s++) {
        sexRadios[s].addEventListener("change", function () {
            document.getElementById("sexWarning").style.display = "none";
            document
                .querySelector(".sex__details .category")
                .classList.remove("sex-error");
        });
    }

    // ========================
    // FORM SUBMIT (AJAX)
    // ========================

    form.addEventListener("submit", function (e) {
        e.preventDefault(); // Always stop default — we use fetch instead

        var hasError = false;

        // Required field check
        var fields = form.querySelectorAll("input[required], select[required]");

        for (var i = 0; i < fields.length; i++) {
            if (!fields[i].value.trim()) {
                fields[i].classList.add("input-error");
                hasError = true;
            } else {
                fields[i].classList.remove("input-error");
            }
        }

        // Sex validation
        var sex = document.querySelector('input[name="sex"]:checked');

        if (!sex) {
            document.getElementById("sexWarning").style.display = "flex";
            document
                .querySelector(".sex__details .category")
                .classList.add("sex-error");
            hasError = true;
        }

        // Password validation
        var pass = document.getElementById("password").value;
        var confirm = document.getElementById("confirmPassword").value;

        var rules = [
            pass.length >= 8 && pass.length <= 20,
            /[A-Z]/.test(pass),
            /[a-z]/.test(pass),
            /[0-9]/.test(pass),
            /[!@#$%^&*(),.?":{}|<>]/.test(pass),
            !/\s/.test(pass),
        ];

        var allPass = rules.every(Boolean);
        var match = pass === confirm && confirm.length > 0;

        if (!allPass || !match) {
            document.getElementById("password").classList.add("input-error");
            document
                .getElementById("confirmPassword")
                .classList.add("input-error");
            hasError = true;
        }

        if (hasError) {
            showToast("Please fix all errors before submitting.");
            return;
        }

        // ── AJAX Submit ──────────────────────────────────────────────────────
        var submitBtn = form.querySelector('input[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.value = "Registering...";

        var formData = new FormData(form);

        fetch(form.action, { method: "POST", body: formData })
            .then(function (res) {
                return res.json();
            })
            .then(function (data) {
                submitBtn.disabled = false;
                submitBtn.value = "Register";

                if (data.success) {
                    showRegModal(
                        "✅",
                        "Success!",
                        "Your account has been created.<br><br>Your registration is being processed. Access will be granted within 2-3 business days.",
                        function () {
                            window.location.href = "login.php?registered=1";
                        },
                    );
                } else {
                    var msg = data.errors.join("<br>");
                    showRegModal("⚠️", "Registration Failed", msg, null);
                }
            })
            .catch(function () {
                submitBtn.disabled = false;
                submitBtn.value = "Register";
                showRegModal(
                    "❌",
                    "Network Error",
                    "Could not reach the server. Please check your connection and try again.",
                    null,
                );
            });
    });
});

// ========================
// MODAL HELPERS
// ========================
var regModalCallback = null;

function showRegModal(icon, title, body, callback) {
    document.getElementById("regModalIcon").textContent = icon;
    document.getElementById("regModalTitle").textContent = title;
    document.getElementById("regModalBody").innerHTML = body;
    document.getElementById("regModal").style.display = "flex";
    regModalCallback = callback || null;
}

function closeRegModal() {
    document.getElementById("regModal").style.display = "none";
    if (regModalCallback) regModalCallback();
}

// ========================
// VALIDATION FUNCTIONS
// ========================
function validateEmail() {
    var email = document.getElementById("email");
    var valid = /^[^\s@]+@[^\s@]+\.com$/i.test(email.value);

    var req = document.getElementById("req-email");
    if (req) req.classList.toggle("met", valid);

    email.classList.toggle("input-error", !valid && email.value.length > 0);
}

function validatePhone() {
    var phone = document.getElementById("contactNum");
    var valid = /^09\d{9}$/.test(phone.value);

    var req = document.getElementById("req-phone");
    if (req) req.classList.toggle("met", valid);

    phone.classList.toggle("input-error", !valid && phone.value.length > 0);
}

function validatePassword() {
    var pass = document.getElementById("password").value;

    var rules = {
        "req-length": pass.length >= 8 && pass.length <= 20,
        "req-upper": /[A-Z]/.test(pass),
        "req-lower": /[a-z]/.test(pass),
        "req-number": /[0-9]/.test(pass),
        "req-special": /[!@#$%^&*(),.?":{}|<>]/.test(pass),
        "req-space": !/\s/.test(pass),
    };

    for (var key in rules) {
        var el = document.getElementById(key);
        if (el) el.classList.toggle("met", rules[key]);
    }

    var allMet = Object.values(rules).every(Boolean);

    document
        .getElementById("password")
        .classList.toggle("input-error", !allMet && pass.length > 0);

    validateConfirm();
}

function validateConfirm() {
    var pass = document.getElementById("password").value;
    var confirm = document.getElementById("confirmPassword").value;

    var match = confirm.length > 0 && pass === confirm;

    var el = document.getElementById("req-match");
    if (el) el.classList.toggle("met", match);

    document
        .getElementById("confirmPassword")
        .classList.toggle("input-error", !match && confirm.length > 0);
}

// ========================
// TOAST
// ========================
function showToast(message) {
    var old = document.getElementById("toast");
    if (old) old.remove();

    var toast = document.createElement("div");
    toast.id = "toast";
    toast.textContent = message;

    document.body.appendChild(toast);

    setTimeout(function () {
        toast.remove();
    }, 3000);
}
