
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
// DOM Ready
// ========================
document.addEventListener("DOMContentLoaded", function () {

    var form = document.querySelector("form");

    // ========================
    // Show / Hide Password
    // ========================
    var toggleButtons = document.querySelectorAll(".toggle-password");

    for (var i = 0; i < toggleButtons.length; i++) {
        toggleButtons[i].addEventListener("click", function (e) {
            e.preventDefault();

            var target = document.querySelector(this.getAttribute("data-target"));

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
    var yearSelect = document.querySelector('select[name="yearEnrolled"]');

    if (yearSelect) {
        var currentYear = new Date().getFullYear();

        for (var y = currentYear; y >= 2000; y--) {
            var opt = document.createElement("option");
            opt.value = y;
            opt.textContent = y;
            yearSelect.appendChild(opt);
        }
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
    if (confirmPassword) confirmPassword.addEventListener("input", validateConfirm);

    // ========================
    // Sex warning remove
    // ========================
    var sexRadios = document.querySelectorAll('input[name="sex"]');

    for (var s = 0; s < sexRadios.length; s++) {
        sexRadios[s].addEventListener("change", function () {
            document.getElementById("sexWarning").style.display = "none";
        });
    }

    // ========================
    // FORM SUBMIT (ONLY ONE)
    // ========================
    form.addEventListener("submit", function (e) {

        var hasError = false;

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
            document.getElementById("sexWarning").style.display = "block";
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
            !/\s/.test(pass)
        ];

        var allPass = true;

        for (var r = 0; r < rules.length; r++) {
            if (!rules[r]) {
                allPass = false;
                break;
            }
        }

        var match = pass === confirm && confirm.length > 0;

        if (!allPass || !match) {
            document.getElementById("password").classList.add("input-error");
            document.getElementById("confirmPassword").classList.add("input-error");
            hasError = true;
        }

        if (hasError) {
            e.preventDefault();
            showToast("Please fix all errors before submitting.");
        }
    });
});

// ========================
// VALIDATION FUNCTIONS
// ========================
function validateEmail() {
    var email = document.getElementById("email");
    var valid = /^[^\s@]+@[^\s@]+\.com$/i.test(email.value);

    var req = document.getElementById("req-email");
    if (req) req.classList.toggle("met", valid);

    if (valid) {
        email.classList.remove("input-error");
    }
}

function validatePhone() {
    var phone = document.getElementById("contactNum");
    var valid = /^09\d{9}$/.test(phone.value);

    var req = document.getElementById("req-phone");
    if (req) req.classList.toggle("met", valid);

    if (valid) {
        phone.classList.remove("input-error");
    }
}

function validatePassword() {
    var pass = document.getElementById("password").value;

    var rules = {
        "req-length": pass.length >= 8 && pass.length <= 20,
        "req-upper": /[A-Z]/.test(pass),
        "req-lower": /[a-z]/.test(pass),
        "req-number": /[0-9]/.test(pass),
        "req-special": /[!@#$%^&*(),.?":{}|<>]/.test(pass),
        "req-space": !/\s/.test(pass)
    };

    for (var key in rules) {
        var el = document.getElementById(key);
        if (el) el.classList.toggle("met", rules[key]);
    }

    var allMet = true;

    for (var k in rules) {
        if (!rules[k]) {
            allMet = false;
            break;
        }
    }

    if (allMet) {
        document.getElementById("password").classList.remove("input-error");
    }

    validateConfirm();
}

function validateConfirm() {
    var pass = document.getElementById("password").value;
    var confirm = document.getElementById("confirmPassword").value;

    var match = confirm.length > 0 && pass === confirm;

    var el = document.getElementById("req-match");
    if (el) el.classList.toggle("met", match);

    if (match) {
        document.getElementById("confirmPassword").classList.remove("input-error");
    }
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