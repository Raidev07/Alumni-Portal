document.addEventListener("DOMContentLoaded", () => {

  const hamburgerBtn      = document.getElementById("hamburgerBtn");
  const hamburgerDropdown = document.getElementById("hamburgerDropdown");
  const logoutTrigger     = document.getElementById("logoutTrigger");
  const logoutOverlay     = document.getElementById("logoutOverlay");
  const logoutNo          = document.getElementById("logoutNo");
  const logoutYes         = document.getElementById("logoutYes");
  const securityTrigger   = document.getElementById("securityTrigger");
  const securityOverlay   = document.getElementById("securityOverlay");
  const securityClose     = document.getElementById("securityClose");
  const twoFactorBtn      = document.getElementById("twoFactorBtn");
  const changePasswordBtn = document.getElementById("changePasswordBtn");

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

  /* ── SECURITY MODAL ────────────────────────────────────────── */
  if (securityTrigger && securityOverlay && securityClose) {
    function openSecurityModal() {
      if (hamburgerDropdown) hamburgerDropdown.classList.remove("show");
      securityOverlay.classList.add("show");
      securityClose.focus();
    }

    function closeSecurityModal() {
      securityOverlay.classList.remove("show");
    }

    securityTrigger.addEventListener("click", (e) => {
      e.preventDefault();
      openSecurityModal();
    });

    securityClose.addEventListener("click", closeSecurityModal);

    securityOverlay.addEventListener("click", (e) => {
      if (e.target === securityOverlay) closeSecurityModal();
    });

    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && securityOverlay.classList.contains("show")) {
        closeSecurityModal();
      }
    });

    if (twoFactorBtn) {
      twoFactorBtn.addEventListener("click", () => {
        window.location.href = "two_factor_authentication.php";
      });
    }

    if (changePasswordBtn) {
      changePasswordBtn.addEventListener("click", () => {
        window.location.href = "change_password.php";
      });
    }
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