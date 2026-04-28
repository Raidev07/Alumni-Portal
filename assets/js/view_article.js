const fill = document.getElementById('progressFill');
window.addEventListener('scroll', () => {
  const scrollTop = window.scrollY;
  const docHeight = document.documentElement.scrollHeight - window.innerHeight;
  fill.style.width = (docHeight > 0 ? Math.min((scrollTop / docHeight) * 100, 100) : 0) + '%';
});

function handleCopy() {
  const btn = document.getElementById('copyBtn');
  if (navigator.clipboard) {
    navigator.clipboard.writeText(window.location.href).catch(() => {});
  }
  const orig = btn.innerHTML;
  btn.innerHTML = '&#10003; Copied!';
  btn.style.color = 'var(--green-700)';
  setTimeout(() => { btn.innerHTML = orig; btn.style.color = ''; }, 2000);
}

function handleEmail() {
  const title = encodeURIComponent(document.querySelector('.article-title').textContent.trim());
  const url = encodeURIComponent(window.location.href);
  window.location.href = `mailto:?subject=${title}&body=I thought you might enjoy this alumni story: ${url}`;
}

// HAMBURGER MENU

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