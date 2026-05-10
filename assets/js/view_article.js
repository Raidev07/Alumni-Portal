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