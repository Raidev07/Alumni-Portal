// |========================|
// |School ID Format        |
// |========================|
const studentId = document.querySelector('input[name="studentId"]');
if (studentId) {
    studentId.addEventListener("keydown", function (e) {
        if (e.key === "Backspace" && this.value.endsWith("-")) {
            e.preventDefault();
            this.value = this.value.slice(0, -2);
        }
    });

    studentId.addEventListener("input", function () {
        let value = this.value.replace(/\D/g, "");
        if (value.length >= 2) {
            value = value.slice(0, 2) + "-" + value.slice(2, 8);
        }
        this.value = value;
    });
}

document.addEventListener("DOMContentLoaded", function () {
    // |========================|
    // |Show/Hide Password      |
    // |========================|
    document.querySelectorAll(".toggle-password").forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            const targetId = this.getAttribute("data-target");
            const inputField = document.querySelector(targetId);

            if (inputField && inputField.type === "password") {
                inputField.type = "text";
                this.textContent = "Hide";
            } else if (inputField) {
                inputField.type = "password";
                this.textContent = "Show";
            }
        });
    });

    // |========================|
    // |Year Enrolled Dropdown  |
    // |========================|
    const select = document.querySelector('select[name="yearEnrolled"]');
    if (select) {
        for (let y = 2024; y >= 2000; y--) {
            const opt = document.createElement("option");
            opt.value = y;
            opt.textContent = y;
            select.appendChild(opt);
        }
    }

    // |========================|
    // |Form Submit Validation  |
    // |========================|
    document.querySelector("form").addEventListener("submit", function (e) {
        let hasError = false;

        // --- All text/email/date/select inputs ---
        const fields = this.querySelectorAll(
            'input[required]:not([type="radio"]), select[required]',
        );
        fields.forEach((field) => {
            if (!field.value.trim()) {
                field.classList.add("input-error");
                hasError = true;
            } else {
                field.classList.remove("input-error");
            }
        });

        // --- Sex ---
        const sexSelected = document.querySelector('input[name="sex"]:checked');
        const sexWarning = document.getElementById("sexWarning");
        if (!sexSelected) {
            sexWarning.style.display = "block";
            hasError = true;
        } else {
            sexWarning.style.display = "none";
        }

        // --- Password rules ---
        const password = document.getElementById("password").value;
        const confirm = document.getElementById("confirmPassword").value;

        const rules = {
            "req-length": password.length >= 8 && password.length <= 20,
            "req-upper": /[A-Z]/.test(password),
            "req-lower": /[a-z]/.test(password),
            "req-number": /[0-9]/.test(password),
            "req-special": /[!@#$%^&*(),.?":{}|<>]/.test(password),
            "req-space": password.length > 0 && !/\s/.test(password),
        };

        const allRulesMet = Object.values(rules).every(Boolean);
        const passwordsMatch = password === confirm && confirm.length > 0;

        for (const [id, met] of Object.entries(rules)) {
            const el = document.getElementById(id);
            el.classList.toggle("met", met);
            el.classList.toggle("error", !met);
        }

        const matchEl = document.getElementById("req-match");
        matchEl.classList.toggle("met", passwordsMatch);
        matchEl.classList.toggle("error", !passwordsMatch);

        if (!allRulesMet) {
            document.getElementById("password").classList.add("input-error");
            hasError = true;
        }

        if (!passwordsMatch) {
            document
                .getElementById("confirmPassword")
                .classList.add("input-error");
            hasError = true;
        }

        // --- Show toast if errors ---
        if (hasError) {
            e.preventDefault();
            showToast("Form incomplete. Please check the highlighted fields.");
        }
    });

    // --- Remove error highlight when user types ---
    document
        .querySelector("form")
        .querySelectorAll("input, select")
        .forEach((el) => {
            el.addEventListener("input", () =>
                el.classList.remove("input-error"),
            );
            el.addEventListener("change", () =>
                el.classList.remove("input-error"),
            );
        });

    // --- Hide sex warning when user selects ---
    document.querySelectorAll('input[name="sex"]').forEach((radio) => {
        radio.addEventListener("change", () => {
            document.getElementById("sexWarning").style.display = "none";
        });
    });

    // --- Remove error class on password input ---
    document.getElementById("password").addEventListener("input", () => {
        document.getElementById("password").classList.remove("input-error");
        document.querySelectorAll("#requirements li").forEach((li) => {
            li.classList.remove("error");
        });
    });

    document.getElementById("confirmPassword").addEventListener("input", () => {
        document
            .getElementById("confirmPassword")
            .classList.remove("input-error");
        document.getElementById("req-match").classList.remove("error");
    });
});

// |========================|
// |Password Validation     |
// |========================|
function validatePassword() {
    const password = document.getElementById("password").value;

    const rules = {
        "req-length": password.length >= 8 && password.length <= 20,
        "req-upper": /[A-Z]/.test(password),
        "req-lower": /[a-z]/.test(password),
        "req-number": /[0-9]/.test(password),
        "req-special": /[!@#$%^&*(),.?":{}|<>]/.test(password),
        "req-space": password.length > 0 && !/\s/.test(password),
    };

    const allMet = Object.values(rules).every(Boolean);

    for (const [id, met] of Object.entries(rules)) {
        const el = document.getElementById(id);
        el.classList.toggle("met", met);
    }

    // remove red border on password if all rules met
    if (allMet) {
        document.getElementById("password").classList.remove("input-error");
    }

    validateConfirm();
}

//Form Submit Validation

document.querySelector("form").addEventListener("submit", function (e) {
    let hasError = false;

    // --- All text/email/date/select inputs ---
    const fields = this.querySelectorAll(
        'input[required]:not([type="radio"]), select[required]',
    );

    fields.forEach((field) => {
        let isInvalid = false;
        const val = field.value.trim();

        if (!val) {
            // Error if empty
            isInvalid = true;
        } else if (field.type === "email") {
            // Email Validation: Must have an '@' and end with '.com'
            const emailRegex = /^[^\s@]+@[^\s@]+\.com$/i;
            if (!emailRegex.test(val)) {
                isInvalid = true;
            }
        } else if (field.name === "contactNum") {
            // Contact Number Validation: Must be exactly 11 digits and start with 09
            const phoneRegex = /^09\d{9}$/;
            if (!phoneRegex.test(val)) {
                isInvalid = true;
            }
        }

        // Apply or remove the error class based on validation
        if (isInvalid) {
            field.classList.add("input-error");
            hasError = true;
        } else {
            field.classList.remove("input-error");
        }
    });

    // --- Sex ---
    const sexSelected = document.querySelector('input[name="sex"]:checked');
    const sexWarning = document.getElementById("sexWarning");
    if (!sexSelected) {
        sexWarning.style.display = "block";
        hasError = true;
    } else {
        sexWarning.style.display = "none";
    }

    // --- Password rules ---
    const password = document.getElementById("password").value;
    const confirm = document.getElementById("confirmPassword").value;

    const rules = {
        "req-length": password.length >= 8 && password.length <= 20,
        "req-upper": /[A-Z]/.test(password),
        "req-lower": /[a-z]/.test(password),
        "req-number": /[0-9]/.test(password),
        "req-special": /[!@#$%^&*(),.?":{}|<>]/.test(password),
        "req-space": password.length > 0 && !/\s/.test(password),
    };

    const allRulesMet = Object.values(rules).every(Boolean);
    const passwordsMatch = password === confirm && confirm.length > 0;

    for (const [id, met] of Object.entries(rules)) {
        const el = document.getElementById(id);
        el.classList.toggle("met", met);
        el.classList.toggle("error", !met);
    }

    const matchEl = document.getElementById("req-match");
    matchEl.classList.toggle("met", passwordsMatch);
    matchEl.classList.toggle("error", !passwordsMatch);

    if (!allRulesMet) {
        document.getElementById("password").classList.add("input-error");
        hasError = true;
    }

    if (!passwordsMatch) {
        document.getElementById("confirmPassword").classList.add("input-error");
        hasError = true;
    }

    // --- Show toast if errors ---
    if (hasError) {
        e.preventDefault(); // Stop form from submitting
        showToast(
            "Form incomplete or invalid. Please check the highlighted fields.",
        );
    }
});

// |========================|
// |Email & Phone Validation|
// |========================|
function validateEmail() {
    const email = document.getElementById("email").value;
    // Checks for @ and ends with .com
    const isValid = /^[^\s@]+@[^\s@]+\.com$/i.test(email);

    const reqEl = document.getElementById("req-email");
    reqEl.classList.toggle("met", isValid);

    // Remove red error box if user fixes it
    if (isValid) {
        document.getElementById("email").classList.remove("input-error");
    }
}

function validatePhone() {
    const phone = document.getElementById("contactNum").value;
    // Checks for exactly 11 digits starting with 09
    const isValid = /^09\d{9}$/.test(phone);

    const reqEl = document.getElementById("req-phone");
    reqEl.classList.toggle("met", isValid);

    // Remove red error box if user fixes it
    if (isValid) {
        document.getElementById("contactNum").classList.remove("input-error");
    }
}
function validateConfirm() {
    const password = document.getElementById("password").value;
    const confirm = document.getElementById("confirmPassword").value;

    const match = confirm.length > 0 && password === confirm;
    document.getElementById("req-match").classList.toggle("met", match);

    // add this — remove red border when passwords match
    const confirmField = document.getElementById("confirmPassword");
    if (match) {
        confirmField.classList.remove("input-error");
    }
}

function showToast(message) {
    const existing = document.getElementById("toast");
    if (existing) existing.remove();

    const toast = document.createElement("div");
    toast.id = "toast";
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => toast.remove(), 3000);
}
