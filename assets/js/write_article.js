const KEY = "alumni_articles";

function getArticles() {
  return JSON.parse(localStorage.getItem(KEY) || "[]");
}

function addArticle(a) {
  const all = getArticles();
  const next = { ...a, id: crypto.randomUUID(), createdAt: new Date().toISOString() };
  localStorage.setItem(KEY, JSON.stringify([next, ...all]));
  return next;
}

function showToast(msg) {
  const t = document.createElement("div");
  t.textContent = msg;
  t.style.cssText = "position:fixed;bottom:1.5rem;right:1.5rem;background:#006e14;color:#fff;padding:0.65rem 1.25rem;border-radius:8px;font-size:0.9rem;z-index:9999;box-shadow:0 4px 16px rgba(0,0,0,0.15);";
  document.body.appendChild(t);
  setTimeout(() => t.remove(), 3000);
}

const CATEGORIES = ["Science & Research", "Community Impact", "Arts & Culture", "Business", "Sports", "Other"];

function setupForm() {
  const form = document.getElementById("new-article-form");
  if (!form) return;

  const sel = form.querySelector('[name="category"]');
  CATEGORIES.forEach(c => {
    const o = document.createElement("option");
    o.value = c;
    o.textContent = c;
    sel.appendChild(o);
  });

  form.addEventListener("submit", e => {
    e.preventDefault();
    const fd = new FormData(form);
    const data = Object.fromEntries(fd.entries());

    if (!data.title || !data.alumniName || !data.content) {
      showToast("Title, alumni name, and content are required.");
      return;
    }

    if (!data.coverImage) {
      data.coverImage = "https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1200&q=80";
    }

    const created = addArticle(data);
    showToast("Story published!");
    setTimeout(() => { location.href = `article.html?id=${created.id}`; }, 600);
  });
}

document.addEventListener("DOMContentLoaded", setupForm);