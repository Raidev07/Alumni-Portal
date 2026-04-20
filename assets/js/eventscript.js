// v MAPAPALITAN RIN ITO PAG MAY DB NA, TEMPLATE LANG MUNA FOR UI
// v FAKE DATA MUNA (NAKA ARRAY, FIXED)
// In terms of the "posted" variable, unsure pako kung mas madali ba kung date nalang (ie. 4/11/2026) or ung days counted itself (ie. 2 days ago)
const events = [
    {
        id: 1,
        title: "PLP Alumni Grand Reunion 2025",
        organizer: "PLP Alumni Association",
        type: "Reunion",
        date: "2025-06-14",
        time: "17:00",
        location: "PLP Main Campus, Pasig",
        maxAttendees: 300,
        deadline: "2025-06-07",
        email: "reunion@plpalumni.ph",
        desc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        posted: "2 days ago",
    },
    {
        id: 2,
        title: "Tech Career Networking Night",
        organizer: "PLP CS & IT Alumni Chapter",
        type: "Networking",
        date: "2025-05-23",
        time: "18:00",
        location: "The Axon, Pasig",
        maxAttendees: 80,
        deadline: "2025-05-20",
        email: "csit@plpalumni.ph",
        desc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        posted: "1 day ago",
    },
    {
        id: 3,
        title: "Professional Resume & Interview Workshop",
        organizer: "PLP Business Alumni",
        type: "Workshop",
        date: "2025-05-31",
        time: "09:00",
        location: "PLP AVR, Pasig",
        maxAttendees: 50,
        deadline: "2025-05-28",
        email: "workshop@plpalumni.ph",
        desc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        posted: "3 days ago",
    },
    {
        id: 4,
        title: "Entrepreneurship & Startups Seminar",
        organizer: "PLP Entrepreneurs Guild",
        type: "Seminar",
        date: "2025-06-07",
        time: "13:00",
        location: "Online (Zoom)",
        maxAttendees: 200,
        deadline: "2025-06-05",
        email: "biz@plpalumni.ph",
        desc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        posted: "5 days ago",
    },
    {
        id: 5,
        title: "Healthcare Professionals Networking",
        organizer: "PLP Medical & Nursing Alumni",
        type: "Networking",
        date: "2025-06-21",
        time: "16:00",
        location: "The Medical City, Pasig",
        maxAttendees: 60,
        deadline: "2025-06-18",
        email: "health@plpalumni.ph",
        desc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        posted: "1 week ago",
    },
    {
        id: 6,
        title: "Digital Marketing Masterclass",
        organizer: "PLP Marketing Alumni",
        type: "Workshop",
        date: "2025-07-05",
        time: "10:00",
        location: "PLP Function Hall, Pasig",
        maxAttendees: 40,
        deadline: "2025-07-01",
        email: "marketing@plpalumni.ph",
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
    const list = document.getElementById("jobsList"); // MAIN CONTAINER (REUSED FROM JOBSSS)
    const empty = document.getElementById("emptyState"); // EMPTY STATE MESSAGEEE
    const query = document.getElementById("searchInput").value.toLowerCase(); // SEARCH INPUTTT

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

    // GENERATEE EVENT CARDSS
    list.innerHTML = filtered
        .map(
            (e) => `
    <div class="job-card">
      <div class="job-content">
        <div class="job-title">${e.title}</div>
        <div class="job-company">${e.organizer}</div>

        <!-- SHORT DESCRIPTIONNN (TRUNCATEDDD) -->
        <p class="job-desc">
          ${e.desc.length > 110 ? e.desc.slice(0, 110) + "…" : e.desc}
        </p>

        <!-- EVENT META INFO (TYPE, DATE, TIME, LOCATION, SLOTS) -->
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
            ${formatTime(e.time)}
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

      <!-- SEE MORE BUTTONNN (OPENS DETAIL MODALLL) -->
      <button class="apply-btn" onclick="openDetail(${e.id})">See More</button>
    </div>
  `,
        )
        .join("");
}

// OPEN EVENT DETAILS (SHOW WHEN SEE MORE BTN IS CLICKED)
function openDetail(id) {
    const e = events.find((x) => x.id === id); // FIND EVENT BY IDDD
    if (!e) return;

    //
    document.getElementById("d-type-badge").innerHTML =
        `<span class="detail-event-type-badge ${typeBadgeClass(e.type)}">${e.type}</span>`;

    // BASIC INFOOO STUFF
    document.getElementById("d-title").textContent = e.title;
    document.getElementById("d-organizer").textContent = e.organizer;

    // META INFO CARDS
    document.getElementById("d-meta").innerHTML = `
    <div class="detail-meta-card">
      <div class="dmc-label"><i class="fa-solid fa-calendar-days"></i> Date</div>
      <div class="dmc-value">${formatDate(e.date)}</div>
    </div>
    <div class="detail-meta-card">
      <div class="dmc-label"><i class="fa-regular fa-clock"></i> Time</div>
      <div class="dmc-value">${formatTime(e.time)}</div>
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

    // EVENT DESC
    document.getElementById("d-desc").textContent = e.desc;

    // REGISTER BUTTONNN (OPENS EMAIL CLIENTTT)
    document.getElementById("d-register").onclick = () => {
        window.open(
            "mailto:" +
                e.email +
                "?subject=Event Registration: " +
                encodeURIComponent(e.title),
        );
    };

    // SHOW CONTAINER
    document.getElementById("detailOverlay").classList.remove("hidden");
}

// CLOSE DETAIL MODALLL
document.getElementById("closeDetail").addEventListener("click", () => {
    document.getElementById("detailOverlay").classList.add("hidden");
});

// OPEN POSTTT EVENT MODALL

document.getElementById("openPostBtn").addEventListener("click", () => {
    document.getElementById("postOverlay").classList.remove("hidden");
});

// CLOSE CONTAINER (CANCEL BUTTONNN)
document.getElementById("cancelBtn").addEventListener("click", () => {
    document.getElementById("postOverlay").classList.add("hidden");
});

// POST AN EVENT FUNCTION
// CREATES NEW JOB OBJECT AND ADDS TO ARRAYYY
document.getElementById("postBtn").addEventListener("click", () => {
    const title = document.getElementById("f-title").value.trim();

    // VALIDATIONNNS
    if (!title) {
        alert("Event title is required.");
        return;
    }

    // CREATE NEW EVENT OBJECTTT
    const newEvent = {
        id: Date.now(),
        title,
        organizer: "PLP Alumni",
        type: document.getElementById("f-type").value,
        date: document.getElementById("f-date").value || "",
        time: document.getElementById("f-time").value || "",
        location: document.getElementById("f-location").value.trim() || "TBD",
        maxAttendees: parseInt(document.getElementById("f-max").value) || 0,
        deadline: document.getElementById("f-deadline").value || "",
        email: document.getElementById("f-email").value.trim() || "",
        desc:
            document.getElementById("f-desc").value.trim() ||
            "No description provided.",
        posted: "Just now",
    };

    // ADD NEW EVENTS TO TOP OF ARRAY
    events.unshift(newEvent);

    // RESETS THE FORM AFTER POSTING
    [
        "f-title",
        "f-date",
        "f-time",
        "f-location",
        "f-max",
        "f-deadline",
        "f-email",
        "f-desc",
    ].forEach((id) => {
        document.getElementById(id).value = "";
    });

    // CLOSE MODAL + REFRESH LISTTT
    document.getElementById("postOverlay").classList.add("hidden");
    renderEvents();
});

// SIDEBAR FILTERSSS
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

// LIVE SEARCH (PARA REAL-TIME UNG PAG SEARCH)
document.getElementById("searchInput").addEventListener("input", renderEvents);

renderEvents();
