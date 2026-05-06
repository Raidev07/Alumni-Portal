// eventscript.js — Connected to database via event_process.php

let allEvents = [];
let activeType = "all";

// ── Utility: date/time formatters ─────────────────────────────────────────────

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
    const display = hour % 12 === 0 ? 12 : hour % 12;
    return `${display}:${m} ${ampm}`;
}

function formatTimeRange(timeStart, timeEnd) {
    const start = formatTime(timeStart);
    const end = formatTime(timeEnd);
    if (start === "TBD" && end === "TBD") return "TBD";
    if (!timeEnd || end === "TBD") return start;
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

// ── Fetch events from server ──────────────────────────────────────────────────

async function fetchEvents() {
    const query = document.getElementById("searchInput").value.trim();
    const params = new URLSearchParams();

    if (activeType !== "all") params.set("type", activeType);
    if (query) params.set("search", query);

    showLoadingState(true);

    try {
        const res = await fetch(
            `backend/event_process.php?${params.toString()}`,
        );
        const data = await res.json();

        if (!data.success)
            throw new Error(data.message || "Failed to load events.");

        allEvents = data.events;
        renderEvents(allEvents);
    } catch (err) {
        showError(err.message);
    } finally {
        showLoadingState(false);
    }
}

// ── Render event cards ────────────────────────────────────────────────────────

function renderEvents(events) {
    const list = document.getElementById("jobsList");
    const empty = document.getElementById("emptyState");

    if (!events || events.length === 0) {
        list.innerHTML = "";
        empty.classList.add("show");
        return;
    }

    empty.classList.remove("show");

    list.innerHTML = events
        .map(
            (e) => `
        <div class="job-card">
            <div class="job-content">
                <div class="job-title">${escHtml(e.title)}</div>
                <div class="job-company">${escHtml(e.organizer || "PLP Alumni")}</div>
                <p class="job-desc">
                    ${e.desc && e.desc.length > 110 ? escHtml(e.desc.slice(0, 110)) + "…" : escHtml(e.desc || "")}
                </p>
                <div class="job-meta">
                    <span class="meta-item">
                        <span class="meta-icon"><i class="fa-solid fa-tag"></i></span>
                        <span class="badge ${typeBadgeClass(e.type)}">${escHtml(e.type)}</span>
                    </span>
                    <span class="meta-item">
                        <span class="meta-icon"><i class="fa-solid fa-calendar-days"></i></span>
                        ${formatDate(e.date)}
                    </span>
                    <span class="meta-item">
                        <span class="meta-icon"><i class="fa-regular fa-clock"></i></span>
                        ${formatTimeRange(e.timeStart, e.timeEnd)}
                    </span>
                    <span class="meta-item">
                        <span class="meta-icon"><i class="fa-solid fa-location-dot"></i></span>
                        ${escHtml(e.location)}
                    </span>
                    <span class="meta-item">
                        <span class="meta-icon"><i class="fa-solid fa-users"></i></span>
                        ${e.maxAttendees} slots
                    </span>
                </div>
            </div>
            <button class="apply-btn" onclick="openDetail(${e.id})">See More</button>
        </div>
    `,
        )
        .join("");
}

// ── Detail modal ──────────────────────────────────────────────────────────────

function openDetail(id) {
    const e = allEvents.find((x) => x.id == id);
    if (!e) return;

    document.getElementById("d-type-badge").innerHTML =
        `<span class="detail-event-type-badge ${typeBadgeClass(e.type)}">${escHtml(e.type)}</span>`;

    document.getElementById("d-title").textContent = e.title;
    document.getElementById("d-organizer").textContent =
        e.organizer || "PLP Alumni";

    document.getElementById("d-meta").innerHTML = `
        <div class="detail-meta-card">
            <div class="dmc-label"><i class="fa-solid fa-calendar-days"></i> Date</div>
            <div class="dmc-value">${formatDate(e.date)}</div>
        </div>
        <div class="detail-meta-card">
            <div class="dmc-label"><i class="fa-regular fa-clock"></i> Time Start</div>
            <div class="dmc-value">${formatTime(e.timeStart)}</div>
        </div>
        <div class="detail-meta-card">
            <div class="dmc-label"><i class="fa-regular fa-clock"></i> Time End</div>
            <div class="dmc-value">${formatTime(e.timeEnd)}</div>
        </div>
        <div class="detail-meta-card">
            <div class="dmc-label"><i class="fa-solid fa-location-dot"></i> Location</div>
            <div class="dmc-value">${escHtml(e.location)}</div>
        </div>
        <div class="detail-meta-card">
            <div class="dmc-label"><i class="fa-solid fa-users"></i> Max Attendees</div>
            <div class="dmc-value">${e.maxAttendees} slots</div>
        </div>
        <div class="detail-meta-card">
            <div class="dmc-label"><i class="fa-solid fa-hourglass-end"></i> Reg. Deadline</div>
            <div class="dmc-value">${formatDate(e.deadline)}</div>
        </div>
        <div class="detail-meta-card">
            <div class="dmc-label"><i class="fa-solid fa-envelope"></i> Contact</div>
            <div class="dmc-value dmc-email">${escHtml(e.email || "")}</div>
        </div>
    `;

    document.getElementById("d-desc").textContent = e.desc || "";

    const registerBtn = document.getElementById("d-register");

    if (!SESSION_LOGGED_IN) {
        registerBtn.textContent = "Login to Register";
        registerBtn.onclick = () => {
            window.location.href = "login.php";
        };
    } else {
        registerBtn.textContent = "Register Now";
        registerBtn.onclick = () => {
            if (e.email) {
                const subject = "Event Registration: " + e.title;
                const body =
                    "Hello,\n\n" +
                    "I would like to register for the following event:\n\n" +
                    "Event: " +
                    e.title +
                    "\n" +
                    "Date: " +
                    formatDate(e.date) +
                    "\n" +
                    "Location: " +
                    e.location +
                    "\n\n" +
                    "Please confirm my registration.\n\n" +
                    "Thank you!";

                window.open(
                    "https://mail.google.com/mail/?view=cm" +
                        "&to=" +
                        encodeURIComponent(e.email) +
                        "&su=" +
                        encodeURIComponent(subject) +
                        "&body=" +
                        encodeURIComponent(body),
                    "_blank",
                );
            } else {
                alert("No contact email provided for this event.");
            }
        };
    }

    document.getElementById("detailOverlay").classList.remove("hidden");
}

document.getElementById("closeDetail")?.addEventListener("click", () => {
    document.getElementById("detailOverlay").classList.add("hidden");
});

// ── Post Event modal ──────────────────────────────────────────────────────────

// openPostBtn only exists in the DOM when logged in (PHP renders it conditionally)
document.getElementById("openPostBtn")?.addEventListener("click", () => {
    if (!SESSION_LOGGED_IN) {
        window.location.href = "login.php";
        return;
    }
    document.getElementById("postOverlay").classList.remove("hidden");
});

document.getElementById("cancelBtn")?.addEventListener("click", () => {
    document.getElementById("postOverlay").classList.add("hidden");
});

document.getElementById("postBtn")?.addEventListener("click", async () => {
    const title = document.getElementById("f-title").value.trim();

    if (!title) {
        showFormError("Event title is required.");
        return;
    }

    const payload = {
        title,
        date: document.getElementById("f-date").value || "",
        type: document.getElementById("f-type").value,
        timeStart: document.getElementById("f-time-start").value || "",
        timeEnd: document.getElementById("f-time-end").value || "",
        location: document.getElementById("f-location").value.trim() || "TBD",
        maxAttendees: parseInt(document.getElementById("f-max").value) || 0,
        deadline: document.getElementById("f-deadline").value || "",
        email: document.getElementById("f-email").value.trim() || "",
        desc:
            document.getElementById("f-desc").value.trim() ||
            "No description provided.",
    };

    const postBtn = document.getElementById("postBtn");
    postBtn.disabled = true;
    postBtn.textContent = "Posting…";

    try {
        const res = await fetch("backend/event_process.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(payload),
        });
        const data = await res.json();

        if (!data.success) {
            if (res.status === 401) {
                window.location.href = "login.php";
                return;
            }
            throw new Error(data.message || "Failed to post event.");
        }

        // Reset form
        [
            "f-title",
            "f-date",
            "f-time-start",
            "f-time-end",
            "f-location",
            "f-max",
            "f-deadline",
            "f-email",
            "f-desc",
        ].forEach((id) => {
            document.getElementById(id).value = "";
        });

        document.getElementById("postOverlay").classList.add("hidden");
        await fetchEvents();
    } catch (err) {
        showFormError(err.message);
    } finally {
        postBtn.disabled = false;
        postBtn.textContent = "Post Event";
    }
});

// ── Sidebar filters ───────────────────────────────────────────────────────────

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

// ── Live search (debounced) ───────────────────────────────────────────────────

let searchTimer = null;
document.getElementById("searchInput")?.addEventListener("input", () => {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(fetchEvents, 350);
});

// ── UI helpers ────────────────────────────────────────────────────────────────

function showLoadingState(on) {
    const list = document.getElementById("jobsList");
    if (on) {
        list.innerHTML = `<p style="color:var(--gray);padding:1rem;">Loading events…</p>`;
    }
}

function showError(msg) {
    const list = document.getElementById("jobsList");
    list.innerHTML = `<p style="color:#e53e3e;padding:1rem;">${escHtml(msg)}</p>`;
}

function showFormError(msg) {
    let err = document.getElementById("formError");
    if (!err) {
        err = document.createElement("p");
        err.id = "formError";
        err.style.cssText =
            "color:#e53e3e;font-size:.875rem;margin-top:.5rem;text-align:center;";
        document.querySelector(".modal-footer").prepend(err);
    }
    err.textContent = msg;
}

function escHtml(str) {
    if (!str) return "";
    return String(str)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#39;");
}

// ── Init ──────────────────────────────────────────────────────────────────────
fetchEvents();
