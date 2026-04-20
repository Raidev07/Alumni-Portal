const profile = {
    firstName: "Juan",
    lastName: "Dela Cruz",
    headline: "BS Information Technology — Batch 2020",
    about: "Passionate IT professional and proud alumnus of Pamantasan ng Lungsod ng Pasig. Currently working as a Software Engineer with 4+ years of experience in web and mobile development.",
    location: "Pasig City, Metro Manila",
    email: "juan.delacruz@email.com",
    profilepicURL: "",
    skills: [],
    experiences: [],
    educations: [],
};

function render() {
    document.getElementById("displayName").textContent =
        profile.firstName + " " + profile.lastName;
    document.getElementById("displayHeadline").textContent = profile.headline;
    document.getElementById("displayLocation").textContent = profile.location;
    document.getElementById("displayEmail").textContent = profile.email;
    document.getElementById("displayBio").textContent =
        profile.about || "Tell us about yourself...";

    const avatarEl = document.getElementById("avatarDisplay");
    if (profile.profilepicURL) {
        avatarEl.innerHTML =
            '<img src="' + profile.profilepicURL + '" alt="Avatar">';
    } else {
        avatarEl.innerHTML =
            '<span class="avatarInitials" id="avatarInitials">' +
            (profile.firstName[0] || "") +
            (profile.lastName ? profile.lastName[0] : "") +
            "</span>";
    }

    const expEl = document.getElementById("experienceList");
    if (profile.experiences.length === 0) {
        expEl.innerHTML = '<p class="empty-text">No experience added yet.</p>';
    } else {
        expEl.innerHTML = profile.experiences
            .map(
                (exp, i) =>
                    `<div class="entry">
        <div class="entry-left">
          <div class="entry-icon"><i class="fas fa-briefcase"></i></div>
          <div>
            <p class="entry-title">${esc(exp.title)}</p>
            <p class="entry-sub">${esc(exp.company)} · ${esc(exp.location)}</p>
            <p class="entry-date"><i class="fas fa-calendar" style="width:12px;margin-right:4px"></i>${esc(exp.startDate)} — ${esc(exp.endDate)}</p>
            ${exp.description ? `<p class="entryDesc">${esc(exp.description)}</p>` : ""}
          </div>
        </div>
        <div class="entry-actions">
          <button class="btnProf btnGhost" onclick="openEditExp('${exp.id}')"><i class="fas fa-pencil" style="width:12px"></i></button>
          <button class="btnProf btn-destructive" onclick="deleteExp('${exp.id}')"><i class="fas fa-trash" style="width:12px"></i></button>
        </div>
      </div>`,
            )
            .join("");
    }

    const eduEl = document.getElementById("educationList");
    if (profile.educations.length === 0) {
        eduEl.innerHTML = '<p class="empty-text">No education added yet.</p>';
    } else {
        eduEl.innerHTML = profile.educations
            .map(
                (edu, i) =>
                    `<div class="entry">
        <div class="entry-left">
          <div class="entry-icon"><i class="fas fa-graduation-cap"></i></div>
          <div>
            <p class="entry-title">${esc(edu.school)}</p>
            <p class="entry-sub">${esc(edu.degree)} in ${esc(edu.field)}</p>
            <p class="entry-date"><i class="fas fa-calendar" style="width:12px;margin-right:4px"></i>${esc(edu.startYear)} — ${esc(edu.endYear)}</p>
          </div>
        </div>
        <div class="entry-actions">
          <button class="btnProf btnGhost" onclick="openEditEdu('${edu.id}')"><i class="fas fa-pencil" style="width:12px"></i></button>
          <button class="btnProf btn-destructive" onclick="deleteEdu('${edu.id}')"><i class="fas fa-trash" style="width:12px"></i></button>
        </div>
      </div>`,
            )
            .join("");
    }

    // Skills list
    const skillsEl = document.getElementById("skillsList");
    if (profile.skills.length === 0) {
        skillsEl.innerHTML = '<p class="empty-text">No skills added yet.</p>';
    } else {
        skillsEl.innerHTML = profile.skills
            .map(
                (s) =>
                    `<span class="badge">${esc(s)}<button class="delete-skill" onclick="removeSkill('${esc(s)}')">&times;</button></span>`,
            )
            .join("");
    }
}

function esc(s) {
    const d = document.createElement("div");
    d.textContent = s;
    return d.innerHTML;
}

function hideAllForms() {
    document
        .querySelectorAll(".modalForm")
        .forEach((el) => (el.style.display = "none"));
}

function showForm(id) {
    hideAllForms();
    document.getElementById(id).style.display = "block";
}

function validateFormFields(formId) {
    const form = document.getElementById(formId);
    if (!form) return true;

    const inputs = form.querySelectorAll("input, textarea");
    for (let input of inputs) {
        if (
            input.hasAttribute("required") ||
            input.id.match(
                /firstName|lastName|mHeadline|mLocation|mEmail|jobTitle|company|workLocation|school|degree|fieldOfStudy|skillName/,
            )
        ) {
            if (!input.value.trim()) {
                return false;
            }
        }
    }
    return true;
}

function showValidationWarning(message) {
    const warning = document.getElementById("validationWarning");
    const warningMsg = document.getElementById("warningMessage");
    warningMsg.textContent = message;
    warning.style.display = "flex";
}

function hideValidationWarning() {
    document.getElementById("validationWarning").style.display = "none";
}

function openModal(title, desc, formId, onSave) {
    document.getElementById("modalTitle").textContent = title;
    document.getElementById("modalDesc").textContent = desc;
    showForm(formId);
    hideValidationWarning();

    document.getElementById("modalAdd").onclick = () => {
        if (!validateFormFields(formId)) {
            showValidationWarning("Please fill in all required fields");
            return;
        }
        hideValidationWarning();
        onSave();
        closeModal();
        render();
    };
    document.getElementById("modalOverlay").classList.add("open");
}

function closeModal() {
    document.getElementById("modalOverlay").classList.remove("open");
    hideAllForms();
}

// Profile Edit
function openEditProfile() {
    document.getElementById("mFirstName").value = profile.firstName;
    document.getElementById("mLastName").value = profile.lastName;
    document.getElementById("mHeadline").value = profile.headline;
    document.getElementById("mLocation").value = profile.location;
    document.getElementById("mEmail").value = profile.email;

    openModal(
        "Edit Profile",
        "Update your basic information.",
        "formEditProfile",
        () => {
            profile.firstName = g("mFirstName");
            profile.lastName = g("mLastName");
            profile.headline = g("mHeadline");
            profile.location = g("mLocation");
            profile.email = g("mEmail");
        },
    );
}

// Bio Edit
function openEditBio() {
    document.getElementById("about").value = profile.about;

    openModal(
        "Edit About",
        "Write a short summary about yourself.",
        "formEditBio",
        () => {
            profile.about = g("about");
        },
    );
}

// Experience functions
function openAddExp() {
    clearForm("formExp");
    expModal(
        {
            id: uid(),
            title: "",
            company: "",
            location: "",
            startDate: "",
            endDate: "",
            description: "",
        },
        false,
    );
}

function openEditExp(id) {
    const e = profile.experiences.find((x) => x.id === id);
    if (e) expModal({ ...e }, true);
}

function expModal(exp, editing) {
    document.getElementById("mExpTitle").value = exp.title;
    document.getElementById("mExpCompany").value = exp.company;
    document.getElementById("mExpLocation").value = exp.location;
    document.getElementById("mExpStart").value = exp.startDate;
    document.getElementById("mExpEnd").value = exp.endDate;
    document.getElementById("mExpDesc").value = exp.description;

    openModal(
        editing ? "Edit Experience" : "Add Experience",
        "Add your work experience details.",
        "formExp",
        () => {
            const updated = {
                id: exp.id,
                title: g("mExpTitle"),
                company: g("mExpCompany"),
                location: g("mExpLocation"),
                startDate: g("mExpStart"),
                endDate: g("mExpEnd"),
                description: g("mExpDesc"),
            };
            if (editing) {
                const i = profile.experiences.findIndex((x) => x.id === exp.id);
                if (i >= 0) profile.experiences[i] = updated;
            } else {
                profile.experiences.unshift(updated);
            }
        },
    );
}

function deleteExp(id) {
    profile.experiences = profile.experiences.filter((x) => x.id !== id);
    render();
}

// Education functions
function openAddEdu() {
    clearForm("formEdu");
    eduModal(
        {
            id: uid(),
            school: "",
            degree: "",
            field: "",
            startYear: "",
            endYear: "",
        },
        false,
    );
}

function openEditEdu(id) {
    const e = profile.educations.find((x) => x.id === id);
    if (e) eduModal({ ...e }, true);
}

function eduModal(edu, editing) {
    document.getElementById("mEduSchool").value = edu.school;
    document.getElementById("mEduDegree").value = edu.degree;
    document.getElementById("mAwards").value = edu.field;
    document.getElementById("mEduStart").value = edu.startYear;
    document.getElementById("mEduEnd").value = edu.endYear;

    openModal(
        editing ? "Edit Education" : "Add Education",
        "Add your educational background.",
        "formEdu",
        () => {
            const updated = {
                id: edu.id,
                school: g("mEduSchool"),
                degree: g("mEduDegree"),
                field: g("mAwards"),
                startYear: g("mEduStart"),
                endYear: g("mEduEnd"),
            };
            if (editing) {
                const i = profile.educations.findIndex((x) => x.id === edu.id);
                if (i >= 0) profile.educations[i] = updated;
            } else {
                profile.educations.unshift(updated);
            }
        },
    );
}

function deleteEdu(id) {
    profile.educations = profile.educations.filter((x) => x.id !== id);
    render();
}

// Skills functions
function openAddSkill() {
    document.getElementById("skillName").value = "";

    openModal(
        "Add Skill",
        "Add a new skill to your profile.",
        "formSkill",
        () => {
            const s = g("skillName").trim();
            if (s && !profile.skills.includes(s)) {
                profile.skills.push(s);
            }
        },
    );

    setTimeout(() => {
        const el = document.getElementById("skillName");
        if (el) {
            el.onkeydown = (e) => {
                if (e.key === "Enter")
                    document.getElementById("modalAdd").click();
            };
        }
    }, 50);
}

function removeSkill(s) {
    profile.skills = profile.skills.filter((x) => x !== s);
    render();
}

// Avatar upload
function handleAvatarChange(e) {
    const file = e.target.files[0];
    if (file) {
        if (confirm("Are you sure you want to update your profile picture?")) {
            profile.profilepicURL = URL.createObjectURL(file);
            render();
        }
    }
}

// Utility functions
function clearForm(formId) {
    const form = document.getElementById(formId);
    if (form) {
        form.querySelectorAll("input, textarea").forEach(
            (el) => (el.value = ""),
        );
    }
}

function g(id) {
    return document.getElementById(id).value;
}

function uid() {
    return Math.random().toString(36).substr(2, 9);
}

// Initialize
render();
