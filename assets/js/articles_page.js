const articles = [
  {
    id: 1,
    title: 'Lorem Ipsum Dolor Sit Amet Consectetur Adipiscing',
    excerpt: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
    category: 'Science & Research',
    author: 'Juan Dela Cruz',
    gradYear: "'11",
    date: 'Apr 25, 2026',
    gradient: 'linear-gradient(135deg, #005210 0%, #00a61f 60%, #66cc7a 100%)',
    image: 'assets/image/1x1pic/Gonzaga, Sam Aidan.jfif', 
  },
  {
    id: 2,
    title: 'Sed Do Eiusmod Tempor Incididunt Ut Labore Et Dolore',
    excerpt: 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
    category: 'Community Impact',
    author: 'Juan Dela Cruz',
    gradYear: "'08",
    date: 'Apr 20, 2026',
    gradient: 'linear-gradient(135deg, #003a0a 0%, #006e14 55%, #b3e2bb 100%)',
    image: 'assets/image/1x1pic/Gonzaga, Sam Aidan.jfif',
  },
  {
    id: 3,
    title: 'Ut Enim Ad Minim Veniam Quis Nostrud Exercitation',
    excerpt: 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
    category: 'Arts & Culture',
    author: 'Juan Dela Cruz',
    gradYear: "'04",
    date: 'Apr 13, 2026',
    gradient: 'linear-gradient(135deg, #006e14 0%, #33bb4d 60%, #e6f5e9 100%)',
    image: 'assets/image/1x1pic/Gonzaga, Sam Aidan.jfif',
  },
  {
    id: 4,
    title: 'Duis Aute Irure Dolor In Reprehenderit Voluptate Velit',
    excerpt: 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
    category: 'Business',
    author: 'Juan Dela Cruz',
    gradYear: "'15",
    date: 'Apr 10, 2026',
    gradient: 'linear-gradient(135deg, #003a0a 0%, #008a1a 55%, #66cc7a 100%)',
    image: 'assets/image/1x1pic/Gonzaga, Sam Aidan.jfif',
  },
  {
    id: 5,
    title: 'Excepteur Sint Occaecat Cupidatat Non Proident Sunt',
    excerpt: 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium totam rem.',
    category: 'Sports',
    author: 'Juan Dela Cruz',
    gradYear: "'17",
    date: 'Apr 7, 2026',
    gradient: 'linear-gradient(135deg, #005210 0%, #00a61f 50%, #ccedcf 100%)',
    image: 'assets/image/1x1pic/Gonzaga, Sam Aidan.jfif',
  },
  {
    id: 6,
    title: 'Sunt In Culpa Qui Officia Deserunt Mollit Anim Id',
    excerpt: 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni.',
    category: 'Other',
    author: 'Juan Dela Cruz',
    gradYear: "'19",
    date: 'Apr 3, 2026',
    gradient: 'linear-gradient(135deg, #005210 0%, #33bb4d 60%, #e6f5e9 100%)',
    image: 'assets/image/1x1pic/Gonzaga, Sam Aidan.jfif',
  },
  {
    id: 7,
    title: 'Cillum Dolore Eu Fugiat Nulla Pariatur Excepteur Sint',
    excerpt: 'Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet consectetur adipisci velit sed quia.',
    category: 'Science & Research',
    author: 'Juan Dela Cruz',
    gradYear: "'13",
    date: 'Mar 28, 2026',
    gradient: 'linear-gradient(135deg, #003a0a 0%, #006e14 55%, #b3e2bb 100%)',
    image: 'assets/image/1x1pic/Gonzaga, Sam Aidan.jfif',
  },
  {
    id: 8,
    title: 'Nemo Enim Ipsam Voluptatem Quia Voluptas Sit Aspernatur',
    excerpt: 'Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur.',
    category: 'Community Impact',
    author: 'Juan Dela Cruz',
    gradYear: "'21",
    date: 'Mar 22, 2026',
    gradient: 'linear-gradient(135deg, #006e14 0%, #00a61f 50%, #ccedcf 100%)',
    image: 'assets/image/1x1pic/Gonzaga, Sam Aidan.jfif',
  },
  {
    id: 9,
    title: 'Neque Porro Quisquam Est Qui Dolorem Ipsum Quia',
    excerpt: 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti.',
    category: 'Arts & Culture',
    author: 'Juan Dela Cruz',
    gradYear: "'22",
    date: 'Mar 15, 2026',
    gradient: 'linear-gradient(135deg, #005210 0%, #33bb4d 60%, #e6f5e9 100%)',
    image: 'assets/image/1x1pic/Gonzaga, Sam Aidan.jfif',
  },
  {
    id: 10,
    title: 'Quis Autem Vel Eum Iure Reprehenderit Qui In Ea',
    excerpt: 'Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime.',
    category: 'Business',
    author: 'Juan Dela Cruz',
    gradYear: "'09",
    date: 'Mar 10, 2026',
    gradient: 'linear-gradient(135deg, #003a0a 0%, #008a1a 55%, #66cc7a 100%)',
    image: 'assets/image/1x1pic/Gonzaga, Sam Aidan.jfif',
  },
  {
    id: 11,
    title: 'At Vero Eos Et Accusamus Et Iusto Odio Dignissimos',
    excerpt: 'Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates.',
    category: 'Sports',
    author: 'Juan Dela Cruz',
    gradYear: "'16",
    date: 'Mar 5, 2026',
    gradient: 'linear-gradient(135deg, #005210 0%, #00a61f 60%, #66cc7a 100%)',
    image: 'assets/image/1x1pic/Gonzaga, Sam Aidan.jfif',
  },
  {
    id: 12,
    title: 'Nam Libero Tempore Cum Soluta Nobis Est Eligendi',
    excerpt: 'Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur.',
    category: 'Other',
    author: 'Juan Dela Cruz',
    gradYear: "'20",
    date: 'Feb 28, 2026',
    gradient: 'linear-gradient(135deg, #003a0a 0%, #006e14 55%, #b3e2bb 100%)',
    image: 'assets/image/1x1pic/Gonzaga, Sam Aidan.jfif',
  },
];

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
    window.location.href = 'article-reader.html';
  }
});

/* ── INIT ─────────────────────────────────────────────────────── */
renderCards();
//hamburegr
       (function () {
            const btn      = document.getElementById('hamburgerBtn');
            const dropdown = document.getElementById('hamburgerDropdown');
 
            if (!btn || !dropdown) return;
 
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                const isOpen = dropdown.classList.toggle('show');
                btn.classList.toggle('open', isOpen);
                btn.setAttribute('aria-expanded', isOpen);
            });
 
            // Close when clicking outside
            document.addEventListener('click', function (e) {
                if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.remove('show');
                    btn.classList.remove('open');
                    btn.setAttribute('aria-expanded', 'false');
                }
            });
 
            // Close on Escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    dropdown.classList.remove('show');
                    btn.classList.remove('open');
                    btn.setAttribute('aria-expanded', 'false');
                }
            });
        })();