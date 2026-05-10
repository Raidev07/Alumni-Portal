/* ── STATE ────────────────────────────────────────────────────── */
const PER_PAGE = 9;
let activeCategory = 'all';
let searchQuery = '';
let currentPage = 1;

/* ── RENDER ───────────────────────────────────────────────────── */
function filteredArticles() {
  return articles.filter(a => {
    const matchCat = activeCategory === 'all' || a.category === activeCategory;
    const q = searchQuery.toLowerCase();
    const matchSearch = !q || a.title.toLowerCase().includes(q) || a.author.toLowerCase().includes(q);
    return matchCat && matchSearch;
  });
}

function renderCards() {
  const grid = document.getElementById('cardGrid');
  const meta = document.getElementById('resultsMeta');
  const filtered = filteredArticles();
  const total = filtered.length;
  const totalPages = Math.max(1, Math.ceil(total / PER_PAGE));
  if (currentPage > totalPages) currentPage = 1;
  const start = (currentPage - 1) * PER_PAGE;
  const paged = filtered.slice(start, start + PER_PAGE);

  meta.innerHTML = `Showing <strong>${total}</strong> stor${total === 1 ? 'y' : 'ies'}`;

  if (paged.length === 0) {
    grid.innerHTML = `<div class="empty-state">
      <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#5a7a5f" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      <p>No stories found. Try a different search or filter.</p>
    </div>`;
    renderPagination(0, 0);
    return;
  }

  grid.innerHTML = paged.map(a => {
    const cat = a.category.toUpperCase();
    const imgContent = a.image
      ? `<img src="${a.image}" alt="${a.title}" loading="lazy" />`
      : `<div class="card-img-placeholder" style="background:${a.gradient}">IMAGE PLACEHOLDER</div>`;
    return `
    <a class="article-card" href="#" data-id="${a.id}">
      <div class="card-img-wrap">
        ${imgContent}
        <span class="card-category-chip">${cat}</span>
      </div>
      <div class="card-body">
        <h2 class="card-title">${a.title}</h2>
        <p class="card-excerpt">${a.excerpt}</p>
        <div class="card-footer">
          <span class="card-author">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            ${a.author} &middot; ${a.gradYear}
          </span>
          <span class="card-date">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            ${a.date}
          </span>
        </div>
      </div>
    </a>`;
  }).join('');

  renderPagination(currentPage, totalPages);
}

function renderPagination(current, total) {
  const el = document.getElementById('pagination');
  if (total <= 1) { el.innerHTML = ''; return; }

  let html = `<button class="page-btn" onclick="goPage(${current - 1})" ${current === 1 ? 'disabled' : ''}>&#8592;</button>`;
  for (let p = 1; p <= total; p++) {
    if (p === 1 || p === total || Math.abs(p - current) <= 1) {
      html += `<button class="page-btn ${p === current ? 'active' : ''}" onclick="goPage(${p})">${p}</button>`;
    } else if (Math.abs(p - current) === 2) {
      html += `<span style="color:var(--ink-faint);padding:0 4px;">…</span>`;
    }
  }
  html += `<button class="page-btn" onclick="goPage(${current + 1})" ${current === total ? 'disabled' : ''}>&#8594;</button>`;
  el.innerHTML = html;
}

function goPage(p) {
  const total = Math.ceil(filteredArticles().length / PER_PAGE);
  if (p < 1 || p > total) return;
  currentPage = p;
  renderCards();
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

/* ── EVENTS ───────────────────────────────────────────────────── */
document.getElementById('filterPills').addEventListener('click', e => {
  const btn = e.target.closest('.pill');
  if (!btn) return;
  document.querySelectorAll('.pill').forEach(p => p.classList.remove('active'));
  btn.classList.add('active');
  activeCategory = btn.dataset.cat;
  currentPage = 1;
  renderCards();
});

let searchTimer;
document.getElementById('searchInput').addEventListener('input', e => {
  clearTimeout(searchTimer);
  searchTimer = setTimeout(() => {
    searchQuery = e.target.value.trim();
    currentPage = 1;
    renderCards();
  }, 220);
});

/* Card click → navigate to article reader */
document.getElementById('cardGrid').addEventListener('click', e => {
  const card = e.target.closest('.article-card');
  if (card) {
    /* Replace with your actual navigation logic */
    window.location.href = `view_article.php?id=${card.dataset.id}`;
  }
});

/* ── INIT ─────────────────────────────────────────────────────── */
renderCards();
