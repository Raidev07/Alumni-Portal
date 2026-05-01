const studentId = document.querySelector('input[name="student_number"]');

if (studentId) {
    studentId.addEventListener("keydown", function (e) {
        if (e.key === "Backspace" && this.value.endsWith("-")) {
            e.preventDefault();
            this.value = this.value.slice(0, -1);
        }
    });

    studentId.addEventListener("input", function () {
        // remove non-numbers
        let value = this.value.replace(/\D/g, "");

        // limit to 7 digits total (2 + 5)
        value = value.slice(0, 7);

        // format as XX-XXXXX
        if (value.length > 2) {
            value = value.slice(0, 2) + "-" + value.slice(2);
        }

        this.value = value;
    });
}

// ========================
// Year Dropdown
// ========================
var yearSelect = document.querySelector('select[name="year_graduated"]');

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
// Sex warning remove
// ========================
var sexRadios = document.querySelectorAll('input[name="gender"]');

for (var s = 0; s < sexRadios.length; s++) {
    sexRadios[s].addEventListener("change", function () {
        var warning = document.getElementById("sexWarning");
        if (warning) {
            warning.style.display = "none";
        }
        var category = document.querySelector(".sex__details .category");
        if (category) {
            category.classList.remove("sex-error");
        }
    });
}

