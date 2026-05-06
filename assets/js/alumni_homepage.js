document.addEventListener("DOMContentLoaded", () => {

  const hamburgerBtn      = document.getElementById("hamburgerBtn");
  const hamburgerDropdown = document.getElementById("hamburgerDropdown");
  const logoutTrigger     = document.getElementById("logoutTrigger");
  const logoutOverlay     = document.getElementById("logoutOverlay");
  const logoutNo          = document.getElementById("logoutNo");
  const logoutYes         = document.getElementById("logoutYes");

  /* ── HAMBURGER TOGGLE ──────────────────────────────────────── */
  if (hamburgerBtn && hamburgerDropdown) {
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

    document.addEventListener("click", (e) => {
      if (!hamburgerBtn.contains(e.target) && !hamburgerDropdown.contains(e.target)) {
        closeMenu();
      }
    });

    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") closeMenu();
    });
  }

  /* ── LOGOUT MODAL ──────────────────────────────────────────── */
  if (logoutTrigger && logoutOverlay && logoutNo && logoutYes) {
    function openLogoutModal() {
      if (hamburgerDropdown) hamburgerDropdown.classList.remove("show");
      logoutOverlay.classList.add("show");
      logoutNo.focus();
    }

    function closeLogoutModal() {
      logoutOverlay.classList.remove("show");
    }

    logoutTrigger.addEventListener("click", (e) => {
      e.preventDefault();
      openLogoutModal();
    });

    logoutNo.addEventListener("click", closeLogoutModal);

    logoutOverlay.addEventListener("click", (e) => {
      if (e.target === logoutOverlay) closeLogoutModal();
    });

    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && logoutOverlay.classList.contains("show")) {
        closeLogoutModal();
      }
    });

    logoutYes.addEventListener("click", () => {
      window.location.href = "logout.php";
    });
  }

});