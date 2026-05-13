// ─── STATE ────────────────────────────────────────────────────────────────────
let activeType = "all";
let jobsCache = [];
let deleteJobId = null;

// ─── ERROR MODAL ──────────────────────────────────────────────────────────────
function showErrorModal(message) {
    document.getElementById("errorMessage").textContent =
        message || "Something went wrong.";

    document.getElementById("errorOverlay").classList.remove("hidden");

    document.body.classList.add("modal-open");
}

function closeErrorModal() {
    document.getElementById("errorOverlay").classList.add("hidden");

    document.body.classList.remove("modal-open");
}

// ─── VALIDATION HELPERS ─────────────────────────────────────

function setFieldError(inputId, errorId, message) {
    const input = document.getElementById(inputId);
    const error = document.getElementById(errorId);

    if (input) {
        input.classList.add("input-error");
    }

    if (error) {
        error.textContent = message;
    }
}

function clearFieldError(inputId, errorId) {
    const input = document.getElementById(inputId);
    const error = document.getElementById(errorId);

    if (input) {
        input.classList.remove("input-error");
    }

    if (error) {
        error.textContent = "";
    }
}

function formatSalaryInput(input) {
    if (!input) return;

    input.addEventListener("input", () => {
        let value = input.value.replace(/[^\d]/g, "");

        if (value === "") {
            input.value = "";
            return;
        }

        input.value = Number(value).toLocaleString("en-US");
    });
}

// ─── LIVE ERROR RESET ─────────────────────────

[
    ["f-salary-min", "f-salary-min-error"],
    ["f-salary-max", "f-salary-max-error"],
    ["e-salary-min", "e-salary-min-error"],
    ["e-salary-max", "e-salary-max-error"],
].forEach(([inputId, errorId]) => {
    const input = document.getElementById(inputId);

    if (!input) return;

    input.addEventListener("input", () => {
        clearFieldError(inputId, errorId);

        const minInput = inputId.startsWith("f")
            ? "f-salary-min"
            : "e-salary-min";

        const maxInput = inputId.startsWith("f")
            ? "f-salary-max"
            : "e-salary-max";

        const min = parseInt(
            document.getElementById(minInput).value.replace(/,/g, ""),
            10,
        );

        const max = parseInt(
            document.getElementById(maxInput).value.replace(/,/g, ""),
            10,
        );

        if (!isNaN(min) && !isNaN(max) && max <= min) {
            clearFieldError(maxInput, `${maxInput}-error`);

            setFieldError(
                maxInput,
                `${maxInput}-error`,
                "Maximum salary must be greater than minimum.",
            );
        }
    });
});

function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.com$/.test(email);
}

["f-salary-min", "f-salary-max", "e-salary-min", "e-salary-max"].forEach(
    (id) => {
        const el = document.getElementById(id);

        if (el) {
            formatSalaryInput(el);
        }
    },
);

document
    .getElementById("closeErrorBtn")
    ?.addEventListener("click", closeErrorModal);

document.getElementById("errorOverlay")?.addEventListener("click", (e) => {
    if (e.target.id === "errorOverlay") {
        closeErrorModal();
    }
});

// ─── FETCH & RENDER JOBS FROM DB ──────────────────────────────────────────────
async function renderJobs() {
    const list = document.getElementById("jobsList");
    const empty = document.getElementById("emptyState");
    const query = document.getElementById("searchInput").value.trim();

    const isMine =
        activeType === "mine-active" || activeType === "mine-archived";

    const fetchType = isMine ? "all" : activeType;

    const status = activeType === "mine-archived" ? "archived" : "active";

    const fetchParams = new URLSearchParams({
        type: fetchType,
        status: status,
    });

    if (isMine) {
        fetchParams.append("mine", "1");
    }

    if (query) {
        fetchParams.append("query", query);
    }

    try {
        const res = await fetch(
            `backend/jobs_process.php?${fetchParams.toString()}`,
        );

        const jobs = await res.json();

        if (!res.ok) {
            list.innerHTML = `<p style="color:red;">Error: ${jobs.error ?? "Unknown error"}</p>`;
            return;
        }

        // FILTER CREATED BY ME
        const filtered = jobs;

        jobsCache = filtered;

        if (filtered.length === 0) {
            list.innerHTML = "";
            empty.classList.add("show");
            return;
        }

        empty.classList.remove("show");

        list.innerHTML = filtered
            .map((j) => {
                const isOwner =
                    SESSION_LOGGED_IN &&
                    parseInt(j.user_id) === SESSION_USER_ID;

                return `
            <div class="job-card ${isOwner ? "job-card--owned" : ""}">

                <div class="job-content">

                    <div class="job-title">
                        ${escHtml(j.title)}

                        ${
                            isOwner
                                ? `<span class="owner-tag">Your Post</span>`
                                : ""
                        }
                    </div>

                    <div class="job-company">
                        ${escHtml(j.company)}
                    </div>

                    <p class="job-desc">
                        ${
                            j.desc.length > 110
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
            })
            .join("");
    } catch (err) {
        list.innerHTML = `<p style="color:red;">Failed to load jobs.</p>`;

        console.error(err);
    }
}

// ─── OPEN DETAIL MODAL ────────────────────────────────────────────────────────
function openDetail(id) {
    const j = jobsCache.find((x) => x.id === id);

    if (!j) return;

    const isOwner =
        SESSION_LOGGED_IN && Number(j.user_id) === Number(SESSION_USER_ID);

    const isArchived = j.status === "archived";

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

    // ─── DYNAMIC ACTION BUTTONS ─────────────────────────────────

    const actions = document.querySelector(".detail-actions");

    if (isArchived) {
        actions.innerHTML = `
            <button class="btn-post restore-btn" id="d-restore">
                Restore
            </button>

            <button class="btn-edit" id="d-edit">
                Edit
            </button>

            <button class="btn-back" id="closeDetail">
                Close
            </button>
        `;
    } else {
        actions.innerHTML = `

            ${
                SESSION_LOGGED_IN
                    ? `
                    <a class="btn-apply" id="d-link" href="#" target="_blank">
                        Apply Now
                    </a>
                    `
                    : `
                    <a class="btn-apply" href="login.php">
                        Login to Apply
                    </a>
                    `
            }

            ${
                isOwner
                    ? `
                    <button class="btn-edit" id="d-edit">
                        Edit
                    </button>

                    <button class="btn-delete archive-btn" id="d-delete">
                        Archive
                    </button>
                    `
                    : ""
            }

            <button class="btn-back" id="closeDetail">
                Close
            </button>
        `;
    }

    // ─── GET NEW BUTTON REFERENCES ─────────────────────────────

    const restoreBtn = document.getElementById("d-restore");
    const editBtn = document.getElementById("d-edit");
    const deleteBtn = document.getElementById("d-delete");
    const closeBtn = document.getElementById("closeDetail");
    const applyLink = document.getElementById("d-link");

    // ─── APPLY LINK ─────────────────────────────────────────────

    if (applyLink) {
        if (isOwner) {
            applyLink.classList.add("hidden");
        } else {
            applyLink.textContent = "Apply Now";

            applyLink.onclick = (event) => {
                event.preventDefault();

                if (j.email) {
                    const subject = "Application for " + j.title;

                    const body =
                        "Good day,\n\n" +
                            "I am interested in applying for the following position:\n\n" +
                            "Position: " +
                            j.title +
                            "\n" +
                            "Company: " +
                            j.company +
                            "\n" +
                            "Location: " +
                            j.location +
                            "\n\n" +
                            "Please find my application attached.\n\n" +
                            "Thank you and I look forward to hearing from you.\n\n" +
                            "Best regards,\n" +
                            SESSION_USER_NAME || "[Your Name]";

                    window.open(
                        "https://mail.google.com/mail/?view=cm" +
                            "&to=" +
                            encodeURIComponent(j.email) +
                            "&su=" +
                            encodeURIComponent(subject) +
                            "&body=" +
                            encodeURIComponent(body),
                        "_blank",
                    );
                } else {
                    showErrorModal("No contact email provided.");
                }
            };
        }
    }
    // ─── BUTTON EVENTS ──────────────────────────────────────────

    if (restoreBtn && isArchived) {
        restoreBtn.onclick = () => restoreJob(j.id);
    }

    if (editBtn && isOwner) {
        editBtn.onclick = () => openEdit(j);
    }

    if (deleteBtn && isOwner) {
        deleteBtn.onclick = () => deleteJob(j.id);
    }

    if (closeBtn) {
        closeBtn.onclick = () => {
            document.getElementById("detailOverlay").classList.add("hidden");

            document.body.classList.remove("modal-open");
        };
    }

    document.getElementById("detailOverlay").classList.remove("hidden");

    document.body.classList.add("modal-open");
}

// ─── OPEN EDIT MODAL ──────────────────────────────────────────────────────────
function openEdit(j) {
    document.getElementById("detailOverlay").classList.add("hidden");

    document.getElementById("e-id").value = j.id;
    document.getElementById("e-title").value = j.title;
    document.getElementById("e-company").value = j.company;
    document.getElementById("e-location").value = j.location;
    const salaryParts = j.salary.split("-");

    document.getElementById("e-salary-min").value = salaryParts[0]
        ?.replace(/[^\d]/g, "")
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    document.getElementById("e-salary-max").value = salaryParts[1]
        ?.replace(/[^\d]/g, "")
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    document.getElementById("e-desc").value = j.desc;
    document.getElementById("e-req").value = j.req;
    document.getElementById("e-benefits").value = j.benefits;
    document.getElementById("e-email").value = j.email || "";

    setSelectValue("e-type", j.type);
    setSelectValue("e-modality", j.modality);
    setSelectValue("e-category", j.category);

    document.getElementById("editOverlay").classList.remove("hidden");

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
document.getElementById("saveEditBtn")?.addEventListener("click", async () => {
    const id = document.getElementById("e-id").value;

    let hasError = false;

    const title = document.getElementById("e-title").value.trim();
    const company = document.getElementById("e-company").value.trim();
    const location = document.getElementById("e-location").value.trim();
    const email = document.getElementById("e-email").value.trim();
    const desc = document.getElementById("e-desc").value.trim();
    const req = document.getElementById("e-req").value.trim();
    const benefits = document.getElementById("e-benefits").value.trim();

    const minSalaryRaw = document
        .getElementById("e-salary-min")
        .value.replace(/,/g, "");

    const maxSalaryRaw = document
        .getElementById("e-salary-max")
        .value.replace(/,/g, "");

    const minSalary = parseInt(minSalaryRaw, 10);
    const maxSalary = parseInt(maxSalaryRaw, 10);

    clearFieldError("e-salary-min", "e-salary-min-error");
    clearFieldError("e-salary-max", "e-salary-max-error");

    // ─── REQUIRED FIELD CHECK ─────────────────────────

    if (!title) {
        showErrorModal("Job title is required.");
        return;
    }

    if (!company) {
        showErrorModal("Company name is required.");
        return;
    }

    if (!location) {
        showErrorModal("Location is required.");
        return;
    }

    if (!email) {
        showErrorModal("Contact email is required.");
        return;
    }

    if (!desc) {
        showErrorModal("Job description is required.");
        return;
    }

    if (!req) {
        showErrorModal("Requirements and qualifications are required.");
        return;
    }

    if (!benefits) {
        showErrorModal("Benefits field is required.");
        return;
    }

    // ─── EMAIL VALIDATION ─────────────────────────────

    if (!isValidEmail(email)) {
        showErrorModal("Please enter a valid email address.");

        return;
    }

    // ─── SALARY VALIDATION ────────────────────────────

    if (!minSalaryRaw || isNaN(minSalary) || minSalary <= 0) {
        setFieldError(
            "e-salary-min",
            "e-salary-min-error",
            "Minimum salary must be greater than 0.",
        );

        hasError = true;
    }

    if (!maxSalaryRaw || isNaN(maxSalary)) {
        setFieldError(
            "e-salary-max",
            "e-salary-max-error",
            "Maximum salary is required.",
        );

        hasError = true;
    }

    if (!isNaN(minSalary) && !isNaN(maxSalary) && maxSalary <= minSalary) {
        setFieldError(
            "e-salary-max",
            "e-salary-max-error",
            "Maximum salary must be greater than minimum.",
        );

        hasError = true;
    }

    if (hasError) {
        showErrorModal("Please fix the salary errors.");

        return;
    }

    const payload = {
        id: parseInt(id),

        title: title,

        company: company,

        type: document.getElementById("e-type").value,

        location: location,

        salary: `${minSalary.toLocaleString()} - ${maxSalary.toLocaleString()}`,

        desc: desc,

        modality: document.getElementById("e-modality").value,

        category: document.getElementById("e-category").value,

        req: req,

        benefits: benefits,

        email: email,
    };

    try {
        const res = await fetch("backend/jobs_process.php", {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(payload),
        });

        const data = await res.json();

        if (!res.ok) {
            showErrorModal(data.error ?? "Failed to update.");

            return;
        }

        document.getElementById("editOverlay").classList.add("hidden");

        document.body.classList.remove("modal-open");

        renderJobs();
    } catch (err) {
        console.error(err);

        showErrorModal("Something went wrong while updating the job.");
    }
});
// ─── CANCEL EDIT ──────────────────────────────────────────────────────────────
document.getElementById("cancelBtn")?.addEventListener("click", () => {
    document.getElementById("postOverlay").classList.add("hidden");

    document.body.classList.remove("modal-open");

    [
        "f-title",
        "f-company",
        "f-location",
        "f-salary-min",
        "f-salary-max",
        "f-email",
        "f-desc",
        "f-req",
        "f-benefits",
    ].forEach((id) => {
        const el = document.getElementById(id);

        if (el) {
            el.value = "";
            el.classList.remove("input-error");
        }
    });

    [
        "f-title-error",
        "f-company-error",
        "f-location-error",
        "f-salary-min-error",
        "f-salary-max-error",
        "f-email-error",
        "f-desc-error",
        "f-req-error",
        "f-benefits-error",
    ].forEach((id) => {
        const el = document.getElementById(id);

        if (el) {
            el.textContent = "";
        }
    });
});

// ─── CANCEL EDIT MODAL ─────────────────────────────────────
document.getElementById("cancelEditBtn")?.addEventListener("click", () => {
    document.getElementById("editOverlay").classList.add("hidden");

    document.body.classList.remove("modal-open");

    [
        "e-title",
        "e-company",
        "e-location",
        "e-salary-min",
        "e-salary-max",
        "e-email",
        "e-desc",
        "e-req",
        "e-benefits",
    ].forEach((id) => {
        const el = document.getElementById(id);

        if (el) {
            el.classList.remove("input-error");
        }
    });

    ["e-salary-min-error", "e-salary-max-error"].forEach((id) => {
        const el = document.getElementById(id);

        if (el) {
            el.textContent = "";
        }
    });
});

// ─── DELETE JOB ───────────────────────────────────────────────────────────────
function deleteJob(id) {
    deleteJobId = id;

    document.getElementById("detailOverlay").classList.add("hidden");

    document.getElementById("deleteOverlay").classList.remove("hidden");

    document.body.classList.add("modal-open");
}

// ─── RESTORE JOB ───────────────────────────────────────────────────────────────
async function restoreJob(id) {
    try {
        const res = await fetch("backend/jobs_process.php", {
            method: "PATCH",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                id: id,
            }),
        });

        const data = await res.json();

        if (!res.ok) {
            showErrorModal(data.error ?? "Failed to update.");
            return;
        }

        document.getElementById("detailOverlay").classList.add("hidden");

        document.body.classList.remove("modal-open");

        renderJobs();
    } catch (err) {
        console.error(err);
    }
}

// ─── CONFIRM DELETE ───────────────────────────────────────────────────────────
document
    .getElementById("confirmDeleteBtn")
    ?.addEventListener("click", async () => {
        if (!deleteJobId) return;

        try {
            const res = await fetch("backend/jobs_process.php", {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    id: deleteJobId,
                }),
            });

            const data = await res.json();

            if (!res.ok) {
                showErrorModal(data.error ?? "Failed to delete.");
                return;
            }

            document.getElementById("deleteOverlay").classList.add("hidden");

            document.body.classList.remove("modal-open");

            deleteJobId = null;

            renderJobs();
        } catch (err) {
            console.error(err);
        }
    });

// ─── CANCEL DELETE ────────────────────────────────────────────────────────────
document.getElementById("cancelDeleteBtn")?.addEventListener("click", () => {
    deleteJobId = null;

    document.getElementById("deleteOverlay").classList.add("hidden");

    document.getElementById("detailOverlay").classList.remove("hidden");

    document.body.classList.add("modal-open");
});

// ─── POST JOB ─────────────────────────────────────────────────────────────────
document.getElementById("postBtn")?.addEventListener("click", async () => {
    let hasError = false;

    const title = document.getElementById("f-title").value.trim();
    const company = document.getElementById("f-company").value.trim();
    const location = document.getElementById("f-location").value.trim();
    const email = document.getElementById("f-email").value.trim();
    const desc = document.getElementById("f-desc").value.trim();
    const req = document.getElementById("f-req").value.trim();
    const benefits = document.getElementById("f-benefits").value.trim();

    const minSalaryRaw = document
        .getElementById("f-salary-min")
        .value.replace(/,/g, "");

    const maxSalaryRaw = document
        .getElementById("f-salary-max")
        .value.replace(/,/g, "");

    const minSalary = parseInt(minSalaryRaw, 10);
    const maxSalary = parseInt(maxSalaryRaw, 10);

    clearFieldError("f-salary-min", "f-salary-min-error");
    clearFieldError("f-salary-max", "f-salary-max-error");

    // ─── REQUIRED FIELD CHECK ─────────────────────────

    if (!title) {
        showErrorModal("Job title is required.");
        return;
    }

    if (!company) {
        showErrorModal("Company name is required.");
        return;
    }

    if (!location) {
        showErrorModal("Location is required.");
        return;
    }

    if (!email) {
        showErrorModal("Contact email is required.");
        return;
    }

    if (!desc) {
        showErrorModal("Job description is required.");
        return;
    }

    if (!req) {
        showErrorModal("Requirements and qualifications are required.");
        return;
    }

    if (!benefits) {
        showErrorModal("Benefits field is required.");
        return;
    }

    // ─── EMAIL VALIDATION ─────────────────────────────

    if (!isValidEmail(email)) {
        showErrorModal("Please enter a valid email address.");

        return;
    }

    // ─── SALARY VALIDATION ────────────────────────────

    if (!minSalaryRaw || isNaN(minSalary) || minSalary <= 0) {
        setFieldError(
            "f-salary-min",
            "f-salary-min-error",
            "Minimum salary must be greater than 0.",
        );

        hasError = true;
    }

    if (!maxSalaryRaw || isNaN(maxSalary)) {
        setFieldError(
            "f-salary-max",
            "f-salary-max-error",
            "Maximum salary is required.",
        );

        hasError = true;
    }

    if (!isNaN(minSalary) && !isNaN(maxSalary) && maxSalary <= minSalary) {
        setFieldError(
            "f-salary-max",
            "f-salary-max-error",
            "Maximum salary must be greater than minimum.",
        );

        hasError = true;
    }

    if (hasError) {
        showErrorModal("Please fix the salary errors.");

        return;
    }

    const payload = {
        title: title,

        company: company,

        type: document.getElementById("f-type").value,

        location: location,

        salary: `${minSalary.toLocaleString()} - ${maxSalary.toLocaleString()}`,

        desc: desc,

        modality: document.getElementById("f-modality").value,

        category: document.getElementById("f-category").value,

        req: req,

        benefits: benefits,

        email: email,
    };

    try {
        const res = await fetch("backend/jobs_process.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(payload),
        });

        const data = await res.json();

        if (!res.ok) {
            showErrorModal(data.error ?? "Failed to post.");

            return;
        }

        document.getElementById("postOverlay").classList.add("hidden");

        document.body.classList.remove("modal-open");

        renderJobs();
    } catch (err) {
        console.error(err);

        showErrorModal("Something went wrong while posting the job.");
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
document.getElementById("closeDetail")?.addEventListener("click", () => {
    document.getElementById("detailOverlay").classList.add("hidden");

    document.body.classList.remove("modal-open");
});

document.getElementById("openPostBtn")?.addEventListener("click", () => {
    if (!SESSION_LOGGED_IN) {
        window.location.href = "login.php";
        return;
    }

    document.getElementById("postOverlay").classList.remove("hidden");

    document.body.classList.add("modal-open");
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

document.getElementById("searchInput")?.addEventListener("input", renderJobs);

// ─── INIT ─────────────────────────────────────────────────────────────────────
renderJobs();
