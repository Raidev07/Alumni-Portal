<<<<<<< HEAD
// ─── STATE ────────────────────────────────────────────────────────────────────
let activeType = "all";   // current sidebar filter
let jobsCache  = [];      // local cache so openDetail() still works
=======
// v MAPAPALITAN RIN ITO PAG MAY DB NA, TEMPLATE LANG MUNA FOR UI
// v FAKE DATA MUNA (NAKA ARRAY, FIXED)
// In terms of the "posted" variable, unsure pako kung mas madali ba kung date nalang (ie. 4/11/2026) or ung days counted itself (ie. 2 days ago)
const jobs = [
    {
        id: 1,
        title: "Senior Software Engineer",
        company: "TechCorp Inc.",
        type: "Full-time",
        location: "Pasig",
        salary: "30,000 – 40,000",
        posted: "1 week ago",
        desc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        modality: "Onsite",
        category: "Engineering",
        req: "5+ years of experience in Node.js or Java. Strong understanding of REST APIs and microservices architecture.",
        benefits:
            "HMO coverage, performance bonus, paid leaves, hybrid options after probation.",
        link: "https://mail.google.com/mail/?view=cm&fs=1&to=rollamas_justinebryle@plpasig.edu.ph",
        email: "hr@techcorp.com",
    },
    {
        id: 2,
        title: "Product Manager",
        company: "Innovation Labs",
        type: "Full-time",
        location: "Remote",
        salary: "40,000 – 60,000",
        posted: "1 week ago",
        desc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        modality: "Remote",
        category: "Product",
        req: "3+ years in product management. Experience with Agile and data-driven decision making.",
        benefits: "Full remote setup, HMO, equipment allowance.",
        link: "https://mail.google.com/mail/?view=cm&fs=1&to=rollamas_justinebryle@plpasig.edu.ph",
        email: "careers@innovationlabs.ph",
    },
    {
        id: 3,
        title: "Marketing Director",
        company: "Global Solutions",
        type: "Full-time",
        location: "Pasig",
        salary: "35,000 – 50,000",
        posted: "3 days ago",
        desc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        modality: "Hybrid",
        category: "Marketing",
        req: "7+ years of marketing experience. Proven track record in brand management and team leadership.",
        benefits: "Car allowance, HMO, executive benefits package.",
        link: "https://mail.google.com/mail/?view=cm&fs=1&to=rollamas_justinebryle@plpasig.edu.ph",
        email: "hr@globalsolutions.com",
    },
    {
        id: 4,
        title: "Data Scientist",
        company: "DataVision Corp",
        type: "Full-time",
        location: "Remote",
        salary: "50,000 – 70,000",
        posted: "5 days ago",
        desc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        modality: "Remote",
        category: "Engineering",
        req: "Proficiency in Python, SQL, and ML frameworks (TensorFlow/PyTorch). Experience with data pipelines and visualization tools.",
        benefits: "Remote-first culture, learning budget, stock options.",
        link: "https://mail.google.com/mail/?view=cm&fs=1&to=rollamas_justinebryle@plpasig.edu.ph",
        email: "jobs@datavision.com",
    },
    {
        id: 5,
        title: "UX/UI Designer",
        company: "Creative Studio",
        type: "Contract",
        location: "Remote",
        salary: "30,000 – 45,000",
        posted: "1 day ago",
        desc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        modality: "Remote",
        category: "Design",
        req: "Portfolio required. Proficiency in Figma and experience working with design systems.",
        benefits: "Flexible hours, project-based completion bonuses.",
        link: "https://mail.google.com/mail/?view=cm&fs=1&to=rollamas_justinebryle@plpasig.edu.ph",
        email: "studio@creative.ph",
    },
    {
        id: 6,
        title: "Financial Analyst",
        company: "Capital Partners",
        type: "Full-time",
        location: "Pasig",
        salary: "28,000 – 40,000",
        posted: "4 days ago",
        desc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        modality: "Onsite",
        category: "Finance",
        req: "CPA preferred. 2+ years in financial analysis or audit. Proficiency in Excel and financial modeling.",
        benefits: "Rice allowance, HMO, 13th month pay.",
        link: "https://mail.google.com/mail/?view=cm&fs=1&to=rollamas_justinebryle@plpasig.edu.ph",
        email: "hr@capitalpartners.ph",
    },
    {
        id: 7,
        title: "Front Desk Officer",
        company: "Defy Media",
        type: "Full-time",
        location: "Pasig",
        salary: "20,000 – 28,000",
        posted: "2 days ago",
        desc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        modality: "Onsite",
        category: "Operations",
        req: "Excellent communication skills. Experience in customer-facing or administrative roles preferred.",
        benefits: "HMO, uniform allowance, paid leaves.",
        link: "https://mail.google.com/mail/?view=cm&fs=1&to=rollamas_justinebryle@plpasig.edu.ph",
        email: "hr@defymedia.ph",
    },
    {
        id: 8,
        title: "Content Strategist",
        company: "MediaHouse",
        type: "Internship",
        location: "Onsite",
        salary: "",
        posted: "3 days ago",
        desc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        modality: "Onsite",
        category: "Marketing",
        req: "Strong writing and SEO skills. Experience with CMS tools such as WordPress or Contentful.",
        benefits: "Flexible schedule, project completion bonuses.",
        link: "https://mail.google.com/mail/?view=cm&fs=1&to=rollamas_justinebryle@plpasig.edu.ph",
        email: "content@mediahouse.ph",
    },
    {
        id: 9,
        title: "ML Engineer",
        company: "AI Ventures",
        type: "Full-time",
        location: "Pasig",
        salary: "55,000 – 80,000",
        posted: "6 days ago",
        desc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        modality: "Hybrid",
        category: "Engineering",
        req: "Experience with MLOps, Kubernetes, and model serving frameworks. Strong Python expertise required.",
        benefits: "Stock options, comprehensive HMO, remote flexibility.",
        link: "https://mail.google.com/mail/?view=cm&fs=1&to=rollamas_justinebryle@plpasig.edu.ph",
        email: "ml@aiventures.ph",
    },
    {
        id: 10,
        title: "Product Designer",
        company: "DesignFirst",
        type: "Full-time",
        location: "Remote",
        salary: "30,000 – 50,000",
        posted: "1 week ago",
        desc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        modality: "Remote",
        category: "Design",
        req: "3+ years in product design. Strong portfolio demonstrating both UX thinking and visual design skills.",
        benefits:
            "100% remote, equipment stipend, learning and development budget.",
        link: "https://mail.google.com/mail/?view=cm&fs=1&to=rollamas_justinebryle@plpasig.edu.ph",
        email: "design@designfirst.ph",
    },
    {
        id: 11,
        title: "Desk Assistant",
        company: "Venn Aiah",
        type: "Internship",
        location: "Onsite",
        salary: "3,000 – 5,000",
        posted: "2 week ago",
        desc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        modality: "Onsite",
        category: "Assistant",
        req: "Individuals who are confident with their skills in speaking to clients via email, scheduling tasks, finishing deadlings are encouraged to apply.",
        benefits:
            "Free food and coffee within building premises, paid internship",
        link: "https://mail.google.com/mail/?view=cm&fs=1&to=rollamas_justinebryle@plpasig.edu.ph",
        email: "Venn_aiah@gmail.com.ph",
    },
];
>>>>>>> 3aba082 (Update alumni portal UI, login flow, and database schema; remove deprecated alumni_homepage.php)

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

<<<<<<< HEAD
// ─── OPEN JOB DETAIL MODAL ────────────────────────────────────────────────────
=======
// FOR CSS BADGE CLASS (ibang kulay kung part-time or full-time ba)
function badgeClass(type) {
    if (type === "Full-time") return "badge-ft";
    if (type === "Part-time") return "badge-pt";
    if (type === "Internship") return "badge-in";
    return "badge-ct";
}

// OPEN DETAIL FUNCTION (SHOW WHEN SEE MORE BTN IS CLICKED)
>>>>>>> 3aba082 (Update alumni portal UI, login flow, and database schema; remove deprecated alumni_homepage.php)
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
<<<<<<< HEAD
    applyLink.href  = j.link || "#";
=======

    if (!isLoggedIn) {
        applyLink.href = "login.php";
        applyLink.textContent = "Login to Apply";
        applyLink.target = "_self";
    } else {
        applyLink.href = j.link || "#";
        applyLink.textContent = "Apply Now";
        applyLink.target = "_blank";
    }
>>>>>>> 3aba082 (Update alumni portal UI, login flow, and database schema; remove deprecated alumni_homepage.php)

    document.getElementById("detailOverlay").classList.remove("hidden");
}

<<<<<<< HEAD
// ─── POST JOB (SENDS TO API) ──────────────────────────────────────────────────
document.getElementById("postBtn")?.addEventListener("click", async () => {
    const title   = document.getElementById("f-title").value.trim();
=======
// CLOSE DETAIL MODALLL
document.getElementById("closeDetail").addEventListener("click", () => {
    document.getElementById("detailOverlay").classList.add("hidden");
});

// OPEN POST JOB MODALLL (SHOW WHEN POST A JOB BTN IS CLICKED)
const openBtn = document.getElementById("openPostBtn");

if (openBtn) {
    openBtn.addEventListener("click", () => {
        document.getElementById("postOverlay").classList.remove("hidden");
    });
}
// CLOSEE POST MODALLLLL (CANCEL BTN)
document.getElementById("cancelBtn").addEventListener("click", () => {
    document.getElementById("postOverlay").classList.add("hidden");
});

// POST JOB FUNCTIONNN
// CREATES NEW JOB OBJECT AND ADDS TO ARRAYYY
document.getElementById("postBtn").addEventListener("click", () => {
    const title = document.getElementById("f-title").value.trim();
>>>>>>> 3aba082 (Update alumni portal UI, login flow, and database schema; remove deprecated alumni_homepage.php)
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