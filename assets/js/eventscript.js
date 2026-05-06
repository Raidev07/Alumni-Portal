// eventscript.js — FULL UPDATED VERSION

let allEvents = [];
let activeType = "all";
let deleteEventId = null;

// ── Utility ───────────────────────────────────────────────────────────────────

function formatDate(dateStr) {
    if (!dateStr) return "TBD";

    const d = new Date(dateStr + "T00:00:00");

    return d.toLocaleDateString("en-PH", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
}

function formatTime(timeStr) {

    if (!timeStr) return "TBD";

    const [h, m] = timeStr.split(":");

    const hour = parseInt(h);

    const ampm = hour >= 12 ? "PM" : "AM";

    const display = hour % 12 === 0
        ? 12
        : hour % 12;

    return `${display}:${m} ${ampm}`;
}

function formatTimeRange(timeStart, timeEnd) {

    const start = formatTime(timeStart);
    const end = formatTime(timeEnd);

    if (start === "TBD" && end === "TBD") {
        return "TBD";
    }

    if (!timeEnd || end === "TBD") {
        return start;
    }

    return `${start} – ${end}`;
}

function typeBadgeClass(type) {

    switch (type) {

        case "Networking":
            return "text-networking";

        case "Workshop":
            return "text-workshop";

        case "Seminar":
            return "text-seminar";

        case "Reunion":
            return "text-reunion";

        default:
            return "text-ft";
    }
}

// ── FETCH EVENTS ──────────────────────────────────────────────────────────────

async function fetchEvents() {

    const query =
        document.getElementById("searchInput")
            .value
            .trim();

    const fetchType =
        activeType === "mine"
            ? "all"
            : activeType;

    const params = new URLSearchParams();

    if (fetchType !== "all") {
        params.set("type", fetchType);
    }

    if (query) {
        params.set("search", query);
    }

    showLoadingState(true);

    try {

        const res = await fetch(
            `backend/event_process.php?${params.toString()}`
        );

        const data = await res.json();

        if (!data.success) {
            throw new Error(data.message);
        }

        const filtered =
            activeType === "mine"
                ? data.events.filter(
                    (e) =>
                        parseInt(e.user_id) === SESSION_USER_ID
                )
                : data.events;

        allEvents = filtered;

        renderEvents(filtered);

    } catch (err) {

        showError(err.message);

    } finally {

        showLoadingState(false);
    }
}

// ── RENDER EVENTS ─────────────────────────────────────────────────────────────

function renderEvents(events) {

    const list = document.getElementById("jobsList");
    const empty = document.getElementById("emptyState");

    if (!events || events.length === 0) {

        list.innerHTML = "";

        empty.classList.add("show");

        return;
    }

    empty.classList.remove("show");

    list.innerHTML = events.map((e) => {

        const isOwner =
            SESSION_LOGGED_IN &&
            parseInt(e.user_id) === SESSION_USER_ID;

        return `
        <div class="job-card">

            <div class="job-content">

                <div class="job-title">

                    ${escHtml(e.title)}

                    ${isOwner
                        ? `<span class="owner-tag">Your Event</span>`
                        : ""
                    }

                </div>

                <div class="job-company">
                    ${escHtml(e.organizer || "PLP Alumni")}
                </div>

                <p class="job-desc">

                    ${e.desc && e.desc.length > 110
                        ? escHtml(e.desc.slice(0, 110)) + "…"
                        : escHtml(e.desc || "")
                    }

                </p>

                <div class="job-meta">

                    <span class="meta-item">
                        <span class="meta-icon">
                            <i class="fa-solid fa-tag"></i>
                        </span>

                        <span class="badge ${typeBadgeClass(e.type)}">
                            ${escHtml(e.type)}
                        </span>
                    </span>

                    <span class="meta-item">
                        <span class="meta-icon">
                            <i class="fa-solid fa-calendar-days"></i>
                        </span>

                        ${formatDate(e.date)}
                    </span>

                    <span class="meta-item">
                        <span class="meta-icon">
                            <i class="fa-regular fa-clock"></i>
                        </span>

                        ${formatTimeRange(e.timeStart, e.timeEnd)}
                    </span>

                    <span class="meta-item">
                        <span class="meta-icon">
                            <i class="fa-solid fa-location-dot"></i>
                        </span>

                        ${escHtml(e.location)}
                    </span>

                </div>

            </div>

            <button
                class="apply-btn"
                onclick="openDetail(${e.id})"
            >
                See More
            </button>

        </div>
        `;
    }).join("");
}

// ── OPEN DETAIL ───────────────────────────────────────────────────────────────

function openDetail(id) {

    const e = allEvents.find((x) => x.id == id);

    if (!e) return;

    const isOwner =
        SESSION_LOGGED_IN &&
        parseInt(e.user_id) === SESSION_USER_ID;

    document.getElementById("d-title").textContent = e.title;

    document.getElementById("d-organizer").textContent =
        e.organizer || "PLP Alumni";

    document.getElementById("d-type-badge").innerHTML = `
        <span class="detail-event-type-badge ${typeBadgeClass(e.type)}">
            ${escHtml(e.type)}
        </span>
    `;

    document.getElementById("d-meta").innerHTML = `
        <div class="detail-meta-card">
            <div class="dmc-label">Date</div>
            <div class="dmc-value">${formatDate(e.date)}</div>
        </div>

        <div class="detail-meta-card">
            <div class="dmc-label">Time Start</div>
            <div class="dmc-value">${formatTime(e.timeStart)}</div>
        </div>

        <div class="detail-meta-card">
            <div class="dmc-label">Time End</div>
            <div class="dmc-value">${formatTime(e.timeEnd)}</div>
        </div>

        <div class="detail-meta-card">
            <div class="dmc-label">Location</div>
            <div class="dmc-value">${escHtml(e.location)}</div>
        </div>

        <div class="detail-meta-card">
            <div class="dmc-label">Max Attendees</div>
            <div class="dmc-value">${e.maxAttendees}</div>
        </div>

        <div class="detail-meta-card">
            <div class="dmc-label">Deadline</div>
            <div class="dmc-value">${formatDate(e.deadline)}</div>
        </div>

        <div class="detail-meta-card">
            <div class="dmc-label">Contact</div>
            <div class="dmc-value">${escHtml(e.email || "")}</div>
        </div>
    `;

    document.getElementById("d-desc").textContent =
        e.desc || "";

    const registerBtn =
        document.getElementById("d-register");

    if (!SESSION_LOGGED_IN) {

        registerBtn.textContent = "Login to Register";

        registerBtn.onclick = () => {
            window.location.href = "login.php";
        };

    } else {

        registerBtn.textContent = "Register Now";
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
        editBtn.onclick = () => openEdit(e);
    }

    if (deleteBtn && isOwner) {
        deleteBtn.onclick = () => deleteEvent(e.id);
    }

    document
        .getElementById("detailOverlay")
        .classList.remove("hidden");

    document.body.classList.add("modal-open");
}

// ── OPEN EDIT ─────────────────────────────────────────────────────────────────

function openEdit(e) {

    document
        .getElementById("detailOverlay")
        .classList.add("hidden");

    document.getElementById("e-id").value = e.id;
    document.getElementById("e-title").value = e.title;
    document.getElementById("e-date").value = e.date;
    document.getElementById("e-type").value = e.type;
    document.getElementById("e-time-start").value = e.timeStart;
    document.getElementById("e-time-end").value = e.timeEnd;
    document.getElementById("e-location").value = e.location;
    document.getElementById("e-max").value = e.maxAttendees;
    document.getElementById("e-deadline").value = e.deadline;
    document.getElementById("e-email").value = e.email || "";
    document.getElementById("e-desc").value = e.desc || "";

    document
        .getElementById("editOverlay")
        .classList.remove("hidden");

    document.body.classList.add("modal-open");
}

// ── SAVE EDIT ─────────────────────────────────────────────────────────────────

document
    .getElementById("saveEditBtn")
    ?.addEventListener("click", async () => {

        const payload = {
            id: parseInt(document.getElementById("e-id").value),
            title: document.getElementById("e-title").value.trim(),
            date: document.getElementById("e-date").value,
            type: document.getElementById("e-type").value,
            timeStart: document.getElementById("e-time-start").value,
            timeEnd: document.getElementById("e-time-end").value,
            location: document.getElementById("e-location").value.trim(),
            maxAttendees: parseInt(document.getElementById("e-max").value) || 0,
            deadline: document.getElementById("e-deadline").value,
            email: document.getElementById("e-email").value.trim(),
            desc: document.getElementById("e-desc").value.trim(),
        };

        try {

            const res = await fetch(
                "backend/event_process.php",
                {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(payload),
                }
            );

            const data = await res.json();

            if (!data.success) {
                throw new Error("Failed to update event.");
            }

            document
                .getElementById("editOverlay")
                .classList.add("hidden");

            document.body.classList.remove("modal-open");

            fetchEvents();

        } catch (err) {

            alert(err.message);
        }
    });

// ── DELETE EVENT ──────────────────────────────────────────────────────────────

function deleteEvent(id) {

    deleteEventId = id;

    document
        .getElementById("detailOverlay")
        .classList.add("hidden");

    document
        .getElementById("deleteOverlay")
        .classList.remove("hidden");

    document.body.classList.add("modal-open");
}

// ── CONFIRM DELETE ────────────────────────────────────────────────────────────

document
    .getElementById("confirmDeleteBtn")
    ?.addEventListener("click", async () => {

        try {

            const res = await fetch(
                "backend/event_process.php",
                {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        id: deleteEventId,
                    }),
                }
            );

            const data = await res.json();

            if (!data.success) {
                throw new Error("Failed to delete event.");
            }

            document
                .getElementById("deleteOverlay")
                .classList.add("hidden");

            document.body.classList.remove("modal-open");

            fetchEvents();

        } catch (err) {

            alert(err.message);
        }
    });

// ── CLOSE / CANCEL ────────────────────────────────────────────────────────────

document
    .getElementById("closeDetail")
    ?.addEventListener("click", () => {

        document
            .getElementById("detailOverlay")
            .classList.add("hidden");

        document.body.classList.remove("modal-open");
    });

document
    .getElementById("cancelEditBtn")
    ?.addEventListener("click", () => {

        document
            .getElementById("editOverlay")
            .classList.add("hidden");

        document.body.classList.remove("modal-open");
    });

document
    .getElementById("cancelDeleteBtn")
    ?.addEventListener("click", () => {

        document
            .getElementById("deleteOverlay")
            .classList.add("hidden");

        document
            .getElementById("detailOverlay")
            .classList.remove("hidden");
    });

// ── POST MODAL ────────────────────────────────────────────────────────────────

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

// ── FILTERS ───────────────────────────────────────────────────────────────────

document.querySelectorAll(".filter-item").forEach((el) => {

    el.addEventListener("click", () => {

        document
            .querySelectorAll(".filter-item")
            .forEach((e) => e.classList.remove("active"));

        el.classList.add("active");

        activeType = el.dataset.filter;

        fetchEvents();
    });
});

// ── SEARCH ────────────────────────────────────────────────────────────────────

let searchTimer = null;

document
    .getElementById("searchInput")
    ?.addEventListener("input", () => {

        clearTimeout(searchTimer);

        searchTimer = setTimeout(fetchEvents, 350);
    });

// ── HELPERS ───────────────────────────────────────────────────────────────────

function showLoadingState(on) {

    const list = document.getElementById("jobsList");

    if (on) {
        list.innerHTML =
            `<p style="padding:1rem;">Loading events…</p>`;
    }
}

function showError(msg) {

    const list = document.getElementById("jobsList");

    list.innerHTML =
        `<p style="color:red;padding:1rem;">${escHtml(msg)}</p>`;
}

function escHtml(str) {

    if (!str) return "";

    return String(str)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;");
}

// ── INIT ──────────────────────────────────────────────────────────────────────

fetchEvents();