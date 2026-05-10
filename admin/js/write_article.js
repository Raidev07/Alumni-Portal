// =============================
// Toast Message (UI only)
// =============================
function showToast(msg) {
  const t = document.createElement("div");
  t.textContent = msg;

  t.style.cssText = `
    position: fixed;
    bottom: 1.5rem;
    right: 1.5rem;
    background: #006e14;
    color: #fff;
    padding: 0.65rem 1.25rem;
    border-radius: 8px;
    font-size: 0.9rem;
    z-index: 9999;
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
  `;

  document.body.appendChild(t);
  setTimeout(() => t.remove(), 3000);
}


// =============================
// Categories Auto Load
// =============================
const CATEGORIES = [
  "Science & Research",
  "Community Impact",
  "Arts & Culture",
  "Business",
  "Sports",
  "Technology",
  "Gaming",
  "Food and Hospitality",
  "Other"
];

function loadCategories() {
  const select = document.querySelector('[name="category"]');
  if (!select) return;

  // prevent duplicates
  if (select.dataset.loaded) return;
  select.dataset.loaded = "true";

  CATEGORIES.forEach(cat => {
    const option = document.createElement("option");
    option.value = cat;
    option.textContent = cat;
    select.appendChild(option);
  });
}


// =============================
// Alumni Search (AJAX PHP READY)
// =============================
function setupAlumniSearch() {
  const searchInput = document.getElementById("alumniSearch");
  const alumniId = document.getElementById("alumni_id");
  const alumniName = document.getElementById("alumniName");
  const gradYear = document.getElementById("gradYear");

  if (!searchInput) return;

  let timeout;

  searchInput.addEventListener("input", function () {
    clearTimeout(timeout);

    const query = this.value.trim();
    if (query.length < 2) return;

    timeout = setTimeout(() => {
      fetch(`search_alumni.php?q=${encodeURIComponent(query)}`)
        .then(res => res.json())
        .then(data => renderDropdown(data))
        .catch(err => console.error("Search error:", err));
    }, 300);
  });

  function renderDropdown(data) {
    let old = document.getElementById("alumniDropdown");
    if (old) old.remove();

    const box = document.createElement("div");
    box.id = "alumniDropdown";

    box.style.cssText = `
      position: absolute;
      background: #fff;
      border: 1px solid #ddd;
      width: 100%;
      z-index: 9999;
      max-height: 200px;
      overflow-y: auto;
    `;

    data.forEach(item => {
      const div = document.createElement("div");

      div.textContent = `${item.full_name} (${item.year_graduated})`;

      div.style.cssText = `
        padding: 8px;
        cursor: pointer;
      `;

      div.addEventListener("mouseenter", () => {
        div.style.background = "#f2f2f2";
      });

      div.addEventListener("mouseleave", () => {
        div.style.background = "#fff";
      });

      div.onclick = () => {
        alumniId.value = item.id;
        alumniName.value = item.full_name;
        gradYear.value = item.year_graduated;

        searchInput.value = item.full_name;

        box.remove();
      };

      box.appendChild(div);
    });

    searchInput.parentNode.style.position = "relative";
    searchInput.parentNode.appendChild(box);
  }
}


// =============================
// INIT
// =============================
document.addEventListener("DOMContentLoaded", () => {
  loadCategories();
  setupAlumniSearch();
});