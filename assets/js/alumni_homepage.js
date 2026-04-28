document.addEventListener("DOMContentLoaded", () => {

  /* ── ELEMENTS ──────────────────────────────────────────────── */
  const hamburgerBtn      = document.getElementById("hamburgerBtn");
  const hamburgerDropdown = document.getElementById("hamburgerDropdown");
  const logoutTrigger     = document.getElementById("logoutTrigger");
  const logoutOverlay     = document.getElementById("logoutOverlay");
  const logoutNo          = document.getElementById("logoutNo");
  const logoutYes         = document.getElementById("logoutYes");

  /* ── HAMBURGER TOGGLE ──────────────────────────────────────── */
  function openMenu() {
    hamburgerDropdown.classList.add("show");
    hamburgerBtn.classList.add("open");
    hamburgerBtn.setAttribute("aria-expanded", "true");
  }

  function closeMenu() {
    hamburgerDropdown.classList.remove("show");
    hamburgerBtn.classList.remove("open");
    hamburgerBtn.setAttribute("aria-expanded", "false");
  }

  hamburgerBtn.addEventListener("click", (e) => {
    e.stopPropagation();
    hamburgerDropdown.classList.contains("show") ? closeMenu() : openMenu();
  });

  // Close dropdown when clicking anywhere outside
  document.addEventListener("click", (e) => {
    if (!hamburgerBtn.contains(e.target) && !hamburgerDropdown.contains(e.target)) {
      closeMenu();
    }
  });

  // Close dropdown on Escape key
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeMenu();
  });

  /* ── LOGOUT MODAL ──────────────────────────────────────────── */
  function openLogoutModal() {
    closeMenu();
    logoutOverlay.classList.add("show");
    logoutNo.focus();
  }

  function closeLogoutModal() {
    logoutOverlay.classList.remove("show");
  }

  // Open modal when Logout is clicked
  logoutTrigger.addEventListener("click", (e) => {
    e.preventDefault();
    openLogoutModal();
  });

  // Cancel — close the modal
  logoutNo.addEventListener("click", closeLogoutModal);

  // Close modal when clicking the dark backdrop
  logoutOverlay.addEventListener("click", (e) => {
    if (e.target === logoutOverlay) closeLogoutModal();
  });

  // Close modal on Escape key
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && logoutOverlay.classList.contains("show")) {
      closeLogoutModal();
    }
  });

  // Confirm logout — redirect to index.php (change href as needed)
  logoutYes.addEventListener("click", () => {
    window.location.href = "index.php";
  });

});