// |========================|
// |Generate Random Password|
// |========================|
let chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

document.addEventListener("DOMContentLoaded", function() {
  const generateBtn = document.querySelector(".generatePassword");
  if (generateBtn) {
    generateBtn.addEventListener("click", generatePassword);
  }

  // |========================|
  // |Show/Hide Password|
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
});

function generatePassword() {
  let length = Number(document.getElementById("NumberInput").value);
  let password = "";
  for (let i = 0; i < length; i++) {
    password += chars[Math.floor(Math.random() * chars.length)];
  }
  document.getElementById("PasswordOutput").value = password;
}

  // |========================|
  // |Year Enrolled Dropdown  |
  // |========================|
const select = document.querySelector('select[name="yearEnrolled"]');
  for (let y = 2024; y >= 2000; y--) {
    const opt = document.createElement('option');
    opt.value = y;
    opt.textContent = y;
    select.appendChild(opt);

    
  }

  