// ─── STATE ────────────────────────────────────────────────────────────────────
let activeType = "all";
let jobsCache = [];
let deleteJobId = null;

// ─── FETCH & RENDER JOBS FROM DB ──────────────────────────────────────────────
async function renderJobs() {
    const list = document.getElementById("jobsList");
    const empty = document.getElementById("emptyState");
    const query = document.getElementById("searchInput").value.trim();

    const fetchType = activeType === "mine" ? "all" : activeType;

    const fetchParams = new URLSearchParams({
        type: fetchType,
    });

    if (query) {
        fetchParams.append("query", query);
    }

    try {

        const res = await fetch(
            `backend/jobs_process.php?${fetchParams.toString()}`
        );

        const jobs = await res.json();

        if (!res.ok) {
            list.innerHTML =
                `<p style="color:red;">Error: ${jobs.error ?? "Unknown error"}</p>`;
            return;
        }

        // FILTER CREATED BY ME
        const filtered =
            activeType === "mine"
                ? jobs.filter(
                    (j) => parseInt(j.user_id) === SESSION_USER_ID
                )
                : jobs;

        jobsCache = filtered;

        if (filtered.length === 0) {
            list.innerHTML = "";
            empty.classList.add("show");
            return;
        }

        empty.classList.remove("show");

        list.innerHTML = filtered.map((j) => {

            const isOwner =
                SESSION_LOGGED_IN &&
                parseInt(j.user_id) === SESSION_USER_ID;

            return `
            <div class="job-card ${isOwner ? "job-card--owned" : ""}">

                <div class="job-content">

                    <div class="job-title">
                        ${escHtml(j.title)}

                        ${isOwner
                            ? `<span class="owner-tag">Your Post</span>`
                            : ""
                        }
                    </div>

                    <div class="job-company">
                        ${escHtml(j.company)}
                    </div>

                    <p class="job-desc">
                        ${j.desc.length > 110
                            ? escHtml(j.desc.slice(0, 110)) + "…"
                            : escHtml(j.desc)
                        }
                    </p>

                    <div class="job-meta">

                        <span class="meta-item">
                            <span class="meta-icon">
                                <i class="fa-solid fa-briefcase"></i>
                            </span>

                            <span class="badge ${badgeClass(j.type)}">
                                ${escHtml(j.type)}
                            </span>
                        </span>

                        <span class="meta-item">
                            <span class="meta-icon">
                                <i class="fa-solid fa-location-dot"></i>
                            </span>

                            ${escHtml(j.location)}
                        </span>

                        <span class="meta-item">
                            <span class="meta-icon">
                                <i class="fa-solid fa-peso-sign"></i>
                            </span>

                            ${escHtml(j.salary)}
                        </span>

                        <span class="meta-item">
                            <span class="meta-icon">
                                <i class="fa-regular fa-clock"></i>
                            </span>

                            Posted ${escHtml(j.posted)}
                        </span>

                    </div>

                </div>

                <button
                    class="apply-btn"
                    onclick="openDetail(${j.id})"
                >
                    See More
                </button>

            </div>
            `;
        }).join("");

    } catch (err) {

        list.innerHTML =
            `<p style="color:red;">Failed to load jobs.</p>`;

        console.error(err);
    }
}

// ─── OPEN DETAIL MODAL ────────────────────────────────────────────────────────
function openDetail(id) {

    const j = jobsCache.find((x) => x.id === id);

    if (!j) return;

    const isOwner =
        SESSION_LOGGED_IN &&
        parseInt(j.user_id) === SESSION_USER_ID;

    document.getElementById("d-title").textContent = j.title;
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
            <div class="dmc-value dmc-email">
                ${escHtml(j.email)}
            </div>
        </div>
    `;

    document.getElementById("d-desc").textContent = j.desc;
    document.getElementById("d-req").textContent = j.req;
    document.getElementById("d-ben").textContent = j.benefits;

    const applyLink = document.getElementById("d-link");

    if (applyLink) {
        applyLink.href = j.link || "#";
    }

    const editBtn = document.getElementById("d-edit");
    const deleteBtn = document.getElementById("d-delete");

    if (editBtn) {
        editBtn.classList.toggle("hidden", !isOwner);
    }

    if (deleteBtn) {
        deleteBtn.classList.toggle("hidden", !isOwner);
    }

    if (editBtn && isOwner) {
        editBtn.onclick = () => openEdit(j);
    }

    if (deleteBtn && isOwner) {
        deleteBtn.onclick = () => deleteJob(j.id);
    }

    document
        .getElementById("detailOverlay")
        .classList.remove("hidden");

    document.body.classList.add("modal-open");
}

// ─── OPEN EDIT MODAL ──────────────────────────────────────────────────────────
function openEdit(j) {

    document
        .getElementById("detailOverlay")
        .classList.add("hidden");

    document.getElementById("e-id").value = j.id;
    document.getElementById("e-title").value = j.title;
    document.getElementById("e-company").value = j.company;
    document.getElementById("e-location").value = j.location;
    document.getElementById("e-salary").value = j.salary;
    document.getElementById("e-desc").value = j.desc;
    document.getElementById("e-req").value = j.req;
    document.getElementById("e-benefits").value = j.benefits;
    document.getElementById("e-link").value = j.link || "";
    document.getElementById("e-email").value = j.email || "";

    setSelectValue("e-type", j.type);
    setSelectValue("e-modality", j.modality);
    setSelectValue("e-category", j.category);

    document
        .getElementById("editOverlay")
        .classList.remove("hidden");

    document.body.classList.add("modal-open");
}

function setSelectValue(id, value) {

    const el = document.getElementById(id);

    if (!el) return;

    [...el.options].forEach((opt) => {
        opt.selected = opt.value === value;
    });
}

// ─── SAVE EDIT ────────────────────────────────────────────────────────────────
document
    .getElementById("saveEditBtn")
    ?.addEventListener("click", async () => {

        const id = document.getElementById("e-id").value;

        const payload = {
            id: parseInt(id),
            title: document.getElementById("e-title").value.trim(),
            company: document.getElementById("e-company").value.trim(),
            type: document.getElementById("e-type").value,
            location: document.getElementById("e-location").value.trim(),
            salary: document.getElementById("e-salary").value.trim(),
            desc: document.getElementById("e-desc").value.trim(),
            modality: document.getElementById("e-modality").value,
            category: document.getElementById("e-category").value,
            req: document.getElementById("e-req").value.trim(),
            benefits: document.getElementById("e-benefits").value.trim(),
            link: document.getElementById("e-link").value.trim(),
            email: document.getElementById("e-email").value.trim(),
        };

        try {

            const res = await fetch(
                "backend/jobs_process.php",
                {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(payload),
                }
            );

            const data = await res.json();

            if (!res.ok) {
                alert(data.error ?? "Failed to update.");
                return;
            }

            document
                .getElementById("editOverlay")
                .classList.add("hidden");

            document.body.classList.remove("modal-open");

            renderJobs();

        } catch (err) {

            console.error(err);
        }
    });

// ─── CANCEL EDIT ──────────────────────────────────────────────────────────────
document
    .getElementById("cancelEditBtn")
    ?.addEventListener("click", () => {

        document
            .getElementById("editOverlay")
            .classList.add("hidden");

        document.body.classList.remove("modal-open");
    });

// ─── DELETE JOB ───────────────────────────────────────────────────────────────
function deleteJob(id) {

    deleteJobId = id;

    document
        .getElementById("detailOverlay")
        .classList.add("hidden");

    document
        .getElementById("deleteOverlay")
        .classList.remove("hidden");

    document.body.classList.add("modal-open");
}

// ─── CONFIRM DELETE ───────────────────────────────────────────────────────────
document
    .getElementById("confirmDeleteBtn")
    ?.addEventListener("click", async () => {

        if (!deleteJobId) return;

        try {

            const res = await fetch(
                "backend/jobs_process.php",
                {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        id: deleteJobId,
                    }),
                }
            );

            const data = await res.json();

            if (!res.ok) {
                alert(data.error ?? "Failed to delete.");
                return;
            }

            document
                .getElementById("deleteOverlay")
                .classList.add("hidden");

            document.body.classList.remove("modal-open");

            deleteJobId = null;

            renderJobs();

        } catch (err) {

            console.error(err);
        }
    });

// ─── CANCEL DELETE ────────────────────────────────────────────────────────────
document
    .getElementById("cancelDeleteBtn")
    ?.addEventListener("click", () => {

        deleteJobId = null;

        document
            .getElementById("deleteOverlay")
            .classList.add("hidden");

        document
            .getElementById("detailOverlay")
            .classList.remove("hidden");

        document.body.classList.add("modal-open");
    });

// ─── POST JOB ─────────────────────────────────────────────────────────────────
document
    .getElementById("postBtn")
    ?.addEventListener("click", async () => {

        const payload = {
            title: document.getElementById("f-title").value.trim(),
            company: document.getElementById("f-company").value.trim(),
            type: document.getElementById("f-type").value,
            location: document.getElementById("f-location").value.trim(),
            salary: document.getElementById("f-salary").value.trim(),
            desc: document.getElementById("f-desc").value.trim(),
            modality: document.getElementById("f-modality").value,
            category: document.getElementById("f-category").value,
            req: document.getElementById("f-req").value.trim(),
            benefits: document.getElementById("f-benefits").value.trim(),
            link: document.getElementById("f-link").value.trim(),
            email: document.getElementById("f-email").value.trim(),
        };

        try {

            const res = await fetch(
                "backend/jobs_process.php",
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(payload),
                }
            );

            const data = await res.json();

            if (!res.ok) {
                alert(data.error ?? "Failed to post.");
                return;
            }

            document
                .getElementById("postOverlay")
                .classList.add("hidden");

            document.body.classList.remove("modal-open");

            renderJobs();

        } catch (err) {

            console.error(err);
        }
    });

// ─── HELPERS ──────────────────────────────────────────────────────────────────
function badgeClass(type) {

    if (type === "Full-time") return "badge-ft";
    if (type === "Part-time") return "badge-pt";
    if (type === "Internship") return "badge-in";

    return "badge-ct";
}

function escHtml(str = "") {

    return String(str)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;");
}

// ─── EVENT LISTENERS ──────────────────────────────────────────────────────────
document
    .getElementById("closeDetail")
    ?.addEventListener("click", () => {

        document
            .getElementById("detailOverlay")
            .classList.add("hidden");

        document.body.classList.remove("modal-open");
    });

document
    .getElementById("openPostBtn")
    ?.addEventListener("click", () => {

        if (!SESSION_LOGGED_IN) {
            window.location.href = "login.php";
            return;
        }

        document
            .getElementById("postOverlay")
            .classList.remove("hidden");

        document.body.classList.add("modal-open");
    });

document
    .getElementById("cancelBtn")
    ?.addEventListener("click", () => {

        document
            .getElementById("postOverlay")
            .classList.add("hidden");

        document.body.classList.remove("modal-open");
    });

document.querySelectorAll(".filter-item").forEach((el) => {

    el.addEventListener("click", () => {

        document
            .querySelectorAll(".filter-item")
            .forEach((e) => e.classList.remove("active"));

        el.classList.add("active");

        activeType = el.dataset.filter;

        renderJobs();
    });
});

document
    .getElementById("searchInput")
    ?.addEventListener("input", renderJobs);

// ─── INIT ─────────────────────────────────────────────────────────────────────
renderJobs();