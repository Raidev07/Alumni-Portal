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
        link: "https://jobstreet.com",
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
        link: "https://jobstreet.com",
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
        link: "https://jobstreet.com",
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
        link: "https://jobstreet.com",
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
        link: "https://jobstreet.com",
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
        link: "https://jobstreet.com",
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
        link: "https://jobstreet.com",
        email: "hr@defymedia.ph",
    },
    {
        id: 8,
        title: "Content Strategist",
        company: "MediaHouse",
        type: "Part-time",
        location: "Remote",
        salary: "15,000 – 25,000",
        posted: "3 days ago",
        desc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        modality: "Remote",
        category: "Marketing",
        req: "Strong writing and SEO skills. Experience with CMS tools such as WordPress or Contentful.",
        benefits: "Flexible schedule, project completion bonuses.",
        link: "https://jobstreet.com",
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
        link: "https://jobstreet.com",
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
        link: "https://jobstreet.com",
        email: "design@designfirst.ph",
    },
];

let activeType = "all"; // CURRENT FILTER STATE (ALL / FULL-TIME / PART-TIME / CONTRACT)

// RENDER JOBSSS FUNCTIONNN
// RESPONSIBLE FOR DISPLAYING JOB CARDS BASED ON FILTER + SEARCH
function renderJobs() {
    const list = document.getElementById("jobsList"); // CONTAINER WHERE JOB CARDS ARE INSERTED
    const empty = document.getElementById("emptyState"); // EMPTY STATE MESSAGEEE (PAG WALANG JOBS)
    const query = document.getElementById("searchInput").value.toLowerCase(); // SEARCH INPUT VALUEEE

    // FILTER LOGICCC (TYPE + SEARCH QUERY)
    const filtered = jobs.filter((j) => {
        const typeMatch = activeType === "all" || j.type === activeType; // CHECK JOB TYPE FILTER
        const queryMatch =
            !query ||
            j.title.toLowerCase().includes(query) ||
            j.company.toLowerCase().includes(query) ||
            j.location.toLowerCase().includes(query); // SEARCH MATCHH

        return typeMatch && queryMatch;
    });

    // IF NO RESULTS FOUND > SHOW EMPTY MESSAGE
    if (filtered.length === 0) {
        list.innerHTML = "";
        empty.classList.add("show");
        return;
    }

    // OTHERWISE HIDE EMPTY MESSAGE AND DISPLAY JOBSSS
    empty.classList.remove("show");

    // FOR JOB CARD
    list.innerHTML = filtered
        .map(
            (j) => `
    <div class="job-card">
      <div class="job-content">
        <div class="job-title">${j.title}</div>
        <div class="job-company">${j.company}</div>

        <!-- SHORT DESCRIPTION (TRUNCATEDDD) -->
        <p class="job-desc">
          ${j.desc.length > 110 ? j.desc.slice(0, 110) + "…" : j.desc}
        </p>

        <!-- JOB META INFO (TYPE, LOCATION, SALARY, TIMEEE) -->
        <div class="job-meta">
          <span class="meta-item">
            <span class="meta-icon"><i class="fa-solid fa-briefcase"></i></span>
            <span class="badge ${badgeClass(j.type)}">${j.type}</span>
          </span>

          <span class="meta-item">
            <span class="meta-icon"><i class="fa-solid fa-location-dot"></i></span>
            ${j.location}
          </span>

          <span class="meta-item">
            <span class="meta-icon"><i class="fa-solid fa-peso-sign"></i></span>
            ${j.salary}
          </span>

          <span class="meta-item">
            <span class="meta-icon"><i class="fa-regular fa-clock"></i></span>
            Posted ${j.posted}
          </span>
        </div>
      </div>

      <!-- SEE MORE BUTTONNN (OPENS DETAIL MODALLL) -->
      <button class="apply-btn" onclick="openDetail(${j.id})">See More</button>
    </div>
  `,
        )
        .join("");
}

// FOR CSS BADGE CLASS (ibang kulay kung part-time or full-time ba)
function badgeClass(type) {
    if (type === "Full-time") return "badge-ft";
    if (type === "Part-time") return "badge-pt";
    return "badge-ct"; // DEFAULT = CONTRACTTT
}

// OPEN DETAIL FUNCTION (SHOW WHEN SEE MORE BTN IS CLICKED)
function openDetail(id) {
    const j = jobs.find((x) => x.id === id); // FIND JOB BY IDDD
    if (!j) return;

    //BASIC INFO
    document.getElementById("d-title").textContent = j.title;
    document.getElementById("d-company").textContent = j.company;

    // BADGES (TYPE / MODALITY / CATEGORYYY)
    document.getElementById("d-badges").innerHTML = `
    <span class="detail-badge">${j.type}</span>
    <span class="detail-badge">${j.modality}</span>
    <span class="detail-badge">${j.category}</span>
  `;

    // META CARDS (LOCATION, SALARY, ETC)
    document.getElementById("d-meta").innerHTML = `
    <div class="detail-meta-card">
      <div class="dmc-label">Location</div>
      <div class="dmc-value">${j.location}</div>
    </div>
    <div class="detail-meta-card">
      <div class="dmc-label">Salary Range</div>
      <div class="dmc-value">&#x20B1;${j.salary}</div>
    </div>
    <div class="detail-meta-card">
      <div class="dmc-label">Modality</div>
      <div class="dmc-value">${j.modality}</div>
    </div>
    <div class="detail-meta-card">
      <div class="dmc-label">Posted</div>
      <div class="dmc-value">${j.posted}</div>
    </div>
    <div class="detail-meta-card">
      <div class="dmc-label">Contact</div>
      <div class="dmc-value dmc-email">${j.email}</div>
    </div>
  `;

    // TEXT SECTIONS
    document.getElementById("d-desc").textContent = j.desc;
    document.getElementById("d-req").textContent = j.req;
    document.getElementById("d-ben").textContent = j.benefits;

    // LINK FOR APPLICATION (SIMULATED)
    const applyLink = document.getElementById("d-link");
    applyLink.href = j.link || "#";

    // SHOW MODALLL
    document.getElementById("detailOverlay").classList.remove("hidden");
}

// CLOSE DETAIL MODALLL
document.getElementById("closeDetail").addEventListener("click", () => {
    document.getElementById("detailOverlay").classList.add("hidden");
});

// OPEN POST JOB MODALLL (SHOW WHEN POST A JOB BTN IS CLICKED)
document.getElementById("openPostBtn").addEventListener("click", () => {
    document.getElementById("postOverlay").classList.remove("hidden");
});

// CLOSEE POST MODALLLLL (CANCEL BTN)
document.getElementById("cancelBtn").addEventListener("click", () => {
    document.getElementById("postOverlay").classList.add("hidden");
});

// POST JOB FUNCTIONNN
// CREATES NEW JOB OBJECT AND ADDS TO ARRAYYY
document.getElementById("postBtn").addEventListener("click", () => {
    const title = document.getElementById("f-title").value.trim();
    const company = document.getElementById("f-company").value.trim();

    // VALIDATION (REQUIRED FIELDSSS)
    if (!title || !company) {
        alert("Job title and company name are required.");
        return;
    }

    // CREATE NEW JOB OBJECT
    const newJob = {
        id: Date.now(), // UNIQUE ID BASED ON TIMEEE
        title,
        company,
        type: document.getElementById("f-type").value,
        location: document.getElementById("f-location").value.trim() || "TBD",
        salary:
            document.getElementById("f-salary").value.trim() || "Negotiable",
        posted: "Just now",
        desc:
            document.getElementById("f-desc").value.trim() ||
            "No description provided.",
        modality: document.getElementById("f-modality").value,
        category: document.getElementById("f-category").value,
        req:
            document.getElementById("f-req").value.trim() ||
            "See job description.",
        benefits:
            document.getElementById("f-benefits").value.trim() ||
            "To be discussed.",
        link: document.getElementById("f-link").value.trim() || "#",
        email: document.getElementById("f-email").value.trim() || "",
    };

    // ADD NEW JOB TO TOP OF ARRAY
    jobs.unshift(newJob);

    // RESETS THE FORM AFTER POSTING
    [
        "f-title",
        "f-company",
        "f-location",
        "f-salary",
        "f-desc",
        "f-req",
        "f-benefits",
        "f-link",
        "f-email",
    ].forEach((id) => {
        document.getElementById(id).value = "";
    });

    // CLOSE CONTAINER + REFRESH LISTTT
    document.getElementById("postOverlay").classList.add("hidden");
    renderJobs();
});

// FILTER SIDEBARRR (CLICK EVENT)
document.querySelectorAll(".filter-item").forEach((el) => {
    el.addEventListener("click", () => {
        document
            .querySelectorAll(".filter-item")
            .forEach((e) => e.classList.remove("active"));
        el.classList.add("active");
        activeType = el.dataset.filter; // UPDATE FILTER
        renderJobs(); // RE-RENDER LIST
    });
});

// LIVE SEARCH (PARA REAL-TIME UNG PAG SEARCH)
document.getElementById("searchInput").addEventListener("input", renderJobs);

renderJobs();
