// ─── STATE ────────────────────────────────────────────────────────────────────
let activeType = "all";   // current sidebar filter
let jobsCache  = [];      // local cache so openDetail() still works

// ─── FETCH & RENDER JOBS FROM DB ──────────────────────────────────────────────
async function renderJobs() {
    const list  = document.getElementById("jobsList");
    const empty = document.getElementById("emptyState");
    const query = document.getElementById("searchInput").value.trim();

    // Build query string
    const params = new URLSearchParams({ type: activeType });
    if (query) params.append("query", query);

    try {
        const res  = await fetch(`backend/jobs_process.php?${params.toString()}`);
        const jobs = await res.json();

        if (!res.ok) {
            list.innerHTML = `<p style="color:red;">Error: ${jobs.error ?? "Unknown error"}</p>`;
            return;
        }

        jobsCache = jobs; // cache for openDetail()

        if (jobs.length === 0) {
            list.innerHTML = "";
            empty.classList.add("show");
            return;
        }

        empty.classList.remove("show");

        list.innerHTML = jobs.map(j => `
            <div class="job-card">
                <div class="job-content">
                    <div class="job-title">${escHtml(j.title)}</div>
                    <div class="job-company">${escHtml(j.company)}</div>
                    <p class="job-desc">
                        ${j.desc.length > 110 ? escHtml(j.desc.slice(0, 110)) + "…" : escHtml(j.desc)}
                    </p>
                    <div class="job-meta">
                        <span class="meta-item">
                            <span class="meta-icon"><i class="fa-solid fa-briefcase"></i></span>
                            <span class="badge ${badgeClass(j.type)}">${escHtml(j.type)}</span>
                        </span>
                        <span class="meta-item">
                            <span class="meta-icon"><i class="fa-solid fa-location-dot"></i></span>
                            ${escHtml(j.location)}
                        </span>
                        <span class="meta-item">
                            <span class="meta-icon"><i class="fa-solid fa-peso-sign"></i></span>
                            ${escHtml(j.salary)}
                        </span>
                        <span class="meta-item">
                            <span class="meta-icon"><i class="fa-regular fa-clock"></i></span>
                            Posted ${escHtml(j.posted)}
                        </span>
                    </div>
                </div>
                <button class="apply-btn" onclick="openDetail(${j.id})">See More</button>
            </div>
        `).join("");

    } catch (err) {
        list.innerHTML = `<p style="color:red;">Failed to load jobs. Please try again.</p>`;
        console.error(err);
    }
}

// ─── OPEN JOB DETAIL MODAL ────────────────────────────────────────────────────
function openDetail(id) {
    const j = jobsCache.find(x => x.id === id);
    if (!j) return;

    document.getElementById("d-title").textContent   = j.title;
    document.getElementById("d-company").textContent = j.company;

    document.getElementById("d-badges").innerHTML = `
        <span class="detail-badge">${escHtml(j.type)}</span>
        <span class="detail-badge">${escHtml(j.modality)}</span>
        <span class="detail-badge">${escHtml(j.category)}</span>
    `;

    document.getElementById("d-meta").innerHTML = `
        <div class="detail-meta-card">
            <div class="dmc-label">Location</div>
            <div class="dmc-value">${escHtml(j.location)}</div>
        </div>
        <div class="detail-meta-card">
            <div class="dmc-label">Salary Range</div>
            <div class="dmc-value">&#x20B1;${escHtml(j.salary)}</div>
        </div>
        <div class="detail-meta-card">
            <div class="dmc-label">Modality</div>
            <div class="dmc-value">${escHtml(j.modality)}</div>
        </div>
        <div class="detail-meta-card">
            <div class="dmc-label">Posted</div>
            <div class="dmc-value">${escHtml(j.posted)}</div>
        </div>
        <div class="detail-meta-card">
            <div class="dmc-label">Contact</div>
            <div class="dmc-value dmc-email">${escHtml(j.email)}</div>
        </div>
    `;

    document.getElementById("d-desc").textContent = j.desc;
    document.getElementById("d-req").textContent  = j.req;
    document.getElementById("d-ben").textContent  = j.benefits;

    const applyLink = document.getElementById("d-link");
    applyLink.href  = j.link || "#";

    document.getElementById("detailOverlay").classList.remove("hidden");
}

// ─── POST JOB (SENDS TO API) ──────────────────────────────────────────────────
document.getElementById("postBtn")?.addEventListener("click", async () => {
    const title   = document.getElementById("f-title").value.trim();
    const company = document.getElementById("f-company").value.trim();

    if (!title || !company) {
        alert("Job title and company name are required.");
        return;
    }

    const payload = {
        title,
        company,
        type:     document.getElementById("f-type").value,
        location: document.getElementById("f-location").value.trim() || "TBD",
        salary:   document.getElementById("f-salary").value.trim()   || "Negotiable",
        desc:     document.getElementById("f-desc").value.trim()     || "",
        modality: document.getElementById("f-modality").value,
        category: document.getElementById("f-category").value,
        req:      document.getElementById("f-req").value.trim()      || "",
        benefits: document.getElementById("f-benefits").value.trim() || "",
        link:     document.getElementById("f-link").value.trim()     || "",
        email:    document.getElementById("f-email").value.trim()    || "",
    };

    try {
        const res  = await fetch("backend/jobs_process.php", {
            method:  "POST",
            headers: { "Content-Type": "application/json" },
            body:    JSON.stringify(payload),
        });
        const data = await res.json();

        if (!res.ok) {
            alert(data.error ?? "Failed to post job.");
            return;
        }

        // Reset form fields
        ["f-title","f-company","f-location","f-salary","f-desc","f-req","f-benefits","f-link","f-email"]
            .forEach(id => { document.getElementById(id).value = ""; });

        document.getElementById("postOverlay").classList.add("hidden");
        renderJobs(); // refresh list from DB

    } catch (err) {
        alert("Network error. Please try again.");
        console.error(err);
    }
});

// ─── HELPERS ──────────────────────────────────────────────────────────────────
function badgeClass(type) {
    if (type === "Full-time")  return "badge-ft";
    if (type === "Part-time")  return "badge-pt";
    if (type === "Internship") return "badge-in";
    return "badge-ct";
}

// Prevent XSS when inserting user-provided text into innerHTML
function escHtml(str = "") {
    return String(str)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;");
}

// ─── EVENT LISTENERS ──────────────────────────────────────────────────────────
document.getElementById("closeDetail")?.addEventListener("click", () => {
    document.getElementById("detailOverlay").classList.add("hidden");
});

document.getElementById("openPostBtn")?.addEventListener("click", () => {
    document.getElementById("postOverlay").classList.remove("hidden");
});

document.getElementById("cancelBtn")?.addEventListener("click", () => {
    document.getElementById("postOverlay").classList.add("hidden");
});

document.querySelectorAll(".filter-item").forEach(el => {
    el.addEventListener("click", () => {
        document.querySelectorAll(".filter-item").forEach(e => e.classList.remove("active"));
        el.classList.add("active");
        activeType = el.dataset.filter;
        renderJobs();
    });
});

document.getElementById("searchInput")?.addEventListener("input", renderJobs);

// ─── INIT ─────────────────────────────────────────────────────────────────────
renderJobs();