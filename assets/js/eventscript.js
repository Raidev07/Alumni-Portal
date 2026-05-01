// v MAPAPALITAN RIN ITO PAG MAY DB NA, TEMPLATE LANG MUNA FOR UI
// v FAKE DATA MUNA (NAKA ARRAY, FIXED)
const events = [
    {
        id: 1,
        title: "PLP Alumni Grand Reunion 2025",
        organizer: "PLP Alumni Association",
        type: "Reunion",
        date: "2025-06-14",
        timeStart: "17:00",
        timeEnd: "21:00",
        location: "PLP Main Campus, Pasig",
        maxAttendees: 300,
        deadline: "2025-06-07",
        email: "https://mail.google.com/mail/?view=cm&fs=1&to=rollamas_justinebryle@plpasig.edu.ph",
        desc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        posted: "2 days ago",
    },
    {
        id: 2,
        title: "Tech Career Networking Night",
        organizer: "PLP CS & IT Alumni Chapter",
        type: "Networking",
        date: "2025-05-23",
        timeStart: "18:00",
        timeEnd: "20:30",
        location: "The Axon, Pasig",
        maxAttendees: 80,
        deadline: "2025-05-20",
        email: "https://mail.google.com/mail/?view=cm&fs=1&to=rollamas_justinebryle@plpasig.edu.ph",
        desc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        posted: "1 day ago",
    },
    {
        id: 3,
        title: "Professional Resume & Interview Workshop",
        organizer: "PLP Business Alumni",
        type: "Workshop",
        date: "2025-05-31",
        timeStart: "09:00",
        timeEnd: "12:00",
        location: "PLP AVR, Pasig",
        maxAttendees: 50,
        deadline: "2025-05-28",
        email: "https://mail.google.com/mail/?view=cm&fs=1&to=rollamas_justinebryle@plpasig.edu.ph",
        desc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        posted: "3 days ago",
    },
    {
        id: 4,
        title: "Entrepreneurship & Startups Seminar",
        organizer: "PLP Entrepreneurs Guild",
        type: "Seminar",
        date: "2025-06-07",
        timeStart: "13:00",
        timeEnd: "16:00",
        location: "Online (Zoom)",
        maxAttendees: 200,
        deadline: "2025-06-05",
        email: "https://mail.google.com/mail/?view=cm&fs=1&to=rollamas_justinebryle@plpasig.edu.ph",
        desc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        posted: "5 days ago",
    },
    {
        id: 5,
        title: "Healthcare Professionals Networking",
        organizer: "PLP Medical & Nursing Alumni",
        type: "Networking",
        date: "2025-06-21",
        timeStart: "16:00",
        timeEnd: "19:00",
        location: "The Medical City, Pasig",
        maxAttendees: 60,
        deadline: "2025-06-18",
        email: "https://mail.google.com/mail/?view=cm&fs=1&to=rollamas_justinebryle@plpasig.edu.ph",
        desc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        posted: "1 week ago",
    },
    {
        id: 6,
        title: "Digital Marketing Masterclass",
        organizer: "PLP Marketing Alumni",
        type: "Workshop",
        date: "2025-07-05",
        timeStart: "10:00",
        timeEnd: "13:00",
        location: "PLP Function Hall, Pasig",
        maxAttendees: 40,
        deadline: "2025-07-01",
        email: "https://mail.google.com/mail/?view=cm&fs=1&to=rollamas_justinebryle@plpasig.edu.ph",
        desc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        posted: "4 days ago",
    },
];

let activeType = "all"; // CURRENT FILTER STATE (ALL / NETWORKING / WORKSHOP / ETC)

// DATE FORMAT TO HUMAN READABLE (i.e June 14, 2025)
function formatDate(dateStr) {
    if (!dateStr) return "TBD";
    const d = new Date(dateStr + "T00:00:00");
    return d.toLocaleDateString("en-PH", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
}

// TIME FORMAT 12 HOUR FORMAT
function formatTime(timeStr) {
    if (!timeStr) return "TBD";
    const [h, m] = timeStr.split(":");
    const hour = parseInt(h);
    const ampm = hour >= 12 ? "PM" : "AM";
    const display = hour % 12 === 0 ? 12 : hour % 12;
    return `${display}:${m} ${ampm}`;
}

// FORMAT TIME RANGE (e.g. 9:00 AM – 12:00 PM)
function formatTimeRange(timeStart, timeEnd) {
    const start = formatTime(timeStart);
    const end = formatTime(timeEnd);
    if (start === "TBD" && end === "TBD") return "TBD";
    if (end === "TBD") return start;
    return `${start} – ${end}`;
}

// FOR CSS TEXT BADGE CATEGORY
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

function renderEvents() {
    const list = document.getElementById("jobsList");
    const empty = document.getElementById("emptyState");
    const query = document.getElementById("searchInput").value.toLowerCase();

    // FILTER LOGIC
    const filtered = events.filter((e) => {
        const typeMatch = activeType === "all" || e.type === activeType;
        const queryMatch =
            !query ||
            e.title.toLowerCase().includes(query) ||
            e.location.toLowerCase().includes(query) ||
            e.organizer.toLowerCase().includes(query);

        return typeMatch && queryMatch;
    });

    // IF NO EVENTS FOUND > SHOW EMPTY STATE
    if (filtered.length === 0) {
        list.innerHTML = "";
        empty.classList.add("show");
        return;
    }

    empty.classList.remove("show");

    // GENERATE EVENT CARDS
    list.innerHTML = filtered
        .map(
            (e) => `
    <div class="job-card">
      <div class="job-content">
        <div class="job-title">${e.title}</div>
        <div class="job-company">${e.organizer}</div>

        <!-- SHORT DESCRIPTION (TRUNCATED) -->
        <p class="job-desc">
          ${e.desc.length > 110 ? e.desc.slice(0, 110) + "…" : e.desc}
        </p>

        <!-- EVENT META INFO -->
        <div class="job-meta">
          <span class="meta-item">
            <span class="meta-icon"><i class="fa-solid fa-tag"></i></span>
            <span class="badge ${typeBadgeClass(e.type)}">${e.type}</span>
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
            ${e.location}
          </span>

          <span class="meta-item">
            <span class="meta-icon"><i class="fa-solid fa-users"></i></span>
            ${e.maxAttendees} slots
          </span>
        </div>
      </div>

      <!-- SEE MORE BUTTON (OPENS DETAIL MODAL) -->
      <button class="apply-btn" onclick="openDetail(${e.id})">See More</button>
    </div>
  `,
        )
        .join("");
}

// OPEN EVENT DETAILS (SHOW WHEN SEE MORE BTN IS CLICKED)
function openDetail(id) {
    const e = events.find((x) => x.id === id);
    if (!e) return;

    document.getElementById("d-type-badge").innerHTML =
        `<span class="detail-event-type-badge ${typeBadgeClass(e.type)}">${e.type}</span>`;

    document.getElementById("d-title").textContent = e.title;
    document.getElementById("d-organizer").textContent = e.organizer;

    // META INFO CARDS — now split into Time Start and Time End
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
      <div class="dmc-value">${e.location}</div>
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
      <div class="dmc-value dmc-email">${e.email}</div>
    </div>
  `;

    document.getElementById("d-desc").textContent = e.desc;

    // REGISTER BUTTON (OPENS EMAIL CLIENT)
    document.getElementById("d-register").onclick = () => {
        window.open(
            "mailto:" +
                e.email +
                "?subject=Event Registration: " +
                encodeURIComponent(e.title),
        );
    };

    document.getElementById("detailOverlay").classList.remove("hidden");
}

// CLOSE DETAIL MODAL
document.getElementById("closeDetail").addEventListener("click", () => {
    document.getElementById("detailOverlay").classList.add("hidden");
});

// OPEN POST EVENT MODAL
document.getElementById("openPostBtn").addEventListener("click", () => {
    document.getElementById("postOverlay").classList.remove("hidden");
});

// CLOSE MODAL (CANCEL BUTTON)
document.getElementById("cancelBtn").addEventListener("click", () => {
    document.getElementById("postOverlay").classList.add("hidden");
});

// POST AN EVENT FUNCTION
document.getElementById("postBtn").addEventListener("click", () => {
    const title = document.getElementById("f-title").value.trim();

    if (!title) {
        alert("Event title is required.");
        return;
    }

    const newEvent = {
        id: Date.now(),
        title,
        organizer: "PLP Alumni",
        type: document.getElementById("f-type").value,
        date: document.getElementById("f-date").value || "",
        timeStart: document.getElementById("f-time-start").value || "",
        timeEnd: document.getElementById("f-time-end").value || "",
        location: document.getElementById("f-location").value.trim() || "TBD",
        maxAttendees: parseInt(document.getElementById("f-max").value) || 0,
        deadline: document.getElementById("f-deadline").value || "",
        email: document.getElementById("f-email").value.trim() || "",
        desc:
            document.getElementById("f-desc").value.trim() ||
            "No description provided.",
        posted: "Just now",
    };

    events.unshift(newEvent);

    // RESET FORM
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
    renderEvents();
});

// SIDEBAR FILTERS
document.querySelectorAll(".filter-item").forEach((el) => {
    el.addEventListener("click", () => {
        document
            .querySelectorAll(".filter-item")
            .forEach((e) => e.classList.remove("active"));
        el.classList.add("active");
        activeType = el.dataset.filter;
        renderEvents();
    });
});

// LIVE SEARCH
document.getElementById("searchInput").addEventListener("input", renderEvents);

renderEvents();