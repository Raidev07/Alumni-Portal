function render() {
    document.getElementById("displayName").textContent =
        (profile.firstName || "") +
        (profile.middleName ? " " + profile.middleName : "") +
        " " +
        (profile.lastName || "") +
        (profile.suffix ? ", " + profile.suffix : "");

    document.getElementById("displayHeadline").textContent =
        profile.headline || "";
    document.getElementById("displayLocation").textContent =
        profile.location || "";
    document.getElementById("displayEmail").textContent = profile.email || "";
    document.getElementById("displayBio").textContent =
        profile.about || "Tell us about yourself...";

    const avatarEl = document.getElementById("avatarDisplay");

    if (profile.profile_picture) {
        avatarEl.innerHTML =
            '<img src="uploads/profile/' +
            profile.profile_picture +
            '" class="avatar" alt="Avatar">';
    } else {
        avatarEl.innerHTML =
            '<span class="avatarInitials" id="avatarInitials">' +
            (profile.firstName?.[0] || "") +
            (profile.middleName?.[0] || "") +
            (profile.lastName?.[0] || "") +
            "</span>";
    }

    // EXPERIENCE
    const expEl = document.getElementById("experienceList");

    if (!profile.experiences || profile.experiences.length === 0) {
        expEl.innerHTML =
            '<span class="empty-text">No experience added yet.</span>';
    } else {
        expEl.innerHTML = profile.experiences
            .map(
                (exp) => `
        <div class="entryCard">
            <div class="entry-left">
                <div class="entry-icon"><i class="fas fa-briefcase"></i></div>
                <div>
                    <p class="entry-title">${esc(exp.title || "")}</p>
                    <p class="entry-sub">${esc(exp.company || "")} · ${esc(exp.location || "")}</p>
                    <p class="entry-date">
                        <i class="fas fa-calendar" style="width:12px;margin-right:4px"></i>
                        ${esc(exp.startDate || "")} — ${exp.endDate ? esc(exp.endDate) : "Present"}
                    </p>

                    ${exp.description ? `<p class="entryDesc">${esc(exp.description)}</p>` : ""}
                </div>
            </div>

            <div class="entry-actions">
                <button class="btnProf btnGhost" onclick="openEditExp(${exp.id})">
                    <i class="fas fa-pencil" style="width:12px"></i>
                </button>

                <button class="btnProf btn-destructive" onclick="deleteExp(${exp.id})">
                    <i class="fas fa-trash" style="width:12px"></i>
                </button>
            </div>
        </div>
    `,
            )
            .join("");
    }

    // EDUCATION
    const eduEl = document.getElementById("educationList");
    if (!profile.educations || profile.educations.length === 0) {
        eduEl.innerHTML =
            '<span class="empty-text">No education added yet.</span>';
    } else {
        eduEl.innerHTML = profile.educations
            .map(
                (edu) => `
<div class="entry">
    <div class="entry-left">
        <div class="entry-icon"><i class="fas fa-graduation-cap"></i></div>
        <div>
        <p class="entry-title">${esc(edu.school || "")}</p>
        <p class="entry-sub">${esc(edu.degree || "")} in ${esc(edu.awards || "")}</p>
        <p class="entry-date">
            <i class="fas fa-calendar" style="width:12px;margin-right:4px"></i>
            ${esc(edu.startYear)} — ${esc(edu.endYear || "Present")}
        </div>
    </div>
    <div class="entry-actions">
        <button class="btnProf btnGhost" onclick="openEditEdu('${edu.id}')">
            <i class="fas fa-pencil" style="width:12px"></i>
        </button>
        <button class="btnProf btn-destructive" onclick="deleteEdu('${edu.id}')">
            <i class="fas fa-trash" style="width:12px"></i>
        </button>
    </div>
</div>
        `,
            )
            .join("");
    }

    // SKILLS
    // SKILLS
    const skillsEl = document.getElementById("skillsList");

    if (!Array.isArray(profile.skills) || profile.skills.length === 0) {
        skillsEl.innerHTML =
            '<span class="empty-text">No skills added yet.</span>';
    } else {
        skillsEl.innerHTML = profile.skills
            .map(
                (s) => `
<span class="badge">
    ${esc(s.name)}

    <button 
        class="delete-skill"
        onclick="removeSkill(${s.id})">
        &times;
    </button>
</span>
`,
            )
            .join("");
    }
}

function esc(s) {
    const d = document.createElement("div");
    d.textContent = s ?? "";
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
            /firstName|lastName|mHeadline|mLocation|mEmail|jobTitle|company|workLocation|school|degree|fieldOfStudy|skillName/.test(
                input.id,
            )
        ) {
            if (!input.value.trim()) return false;
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
    document.getElementById("mFirstName").value = profile.firstName ?? "";
    document.getElementById("mMiddleName").value = profile.middleName ?? "";
    document.getElementById("mLastName").value = profile.lastName ?? "";
    document.getElementById("mSuffix").value = profile.suffix ?? "";

    document.getElementById("mHeadline").value = profile.headline ?? "";
    document.getElementById("mLocation").value = profile.location ?? "";
    document.getElementById("mEmail").value = profile.email ?? "";

    openModal(
        "Edit Profile",
        "Update your basic information.",
        "formEditProfile",
        () => {
            profile.firstName = g("mFirstName");
            profile.middleName = g("mMiddleName");
            profile.lastName = g("mLastName");
            profile.suffix = g("mSuffix");

            profile.headline = g("mHeadline");
            profile.location = g("mLocation");
            profile.email = g("mEmail");
        },
    );
}

// Bio Edit
function renderBio() {
    const bioEl = document.getElementById("displayBio");

    const bio = profile.about?.trim();

    if (!bio) {
        bioEl.textContent = "Tell us about yourself...";
        bioEl.classList.add("empty");
    } else {
        bioEl.textContent = bio;
        bioEl.classList.remove("empty");
    }
}

window.openEditBio = function () {
    const bioText = document.getElementById("displayBio").textContent.trim();

    document.getElementById("about").value =
        bioText === "Tell us about yourself..." ? "" : bioText;

    openModal(
        "Edit About",
        "Write a short summary about yourself.",
        "formEditBio",
        () => {
            const value = g("about").trim();

            fetch("assets/profile/update_bio.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: "about=" + encodeURIComponent(value),
            })
                .then((res) => res.text())
                .then((res) => {
                    console.log(res);

                    if (res.trim() === "success") {
                        document.getElementById("displayBio").textContent =
                            value || "Tell us about yourself...";
                    } else {
                        alert("Save failed: " + res);
                    }
                });
        },
    );
};

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
    const e = profile.experiences.find((x) => String(x.id) === String(id));
    if (!e) return;

    expModal(e, true);
}

function expModal(exp, editing) {
    document.getElementById("mExpTitle").value = exp.title || "";
    document.getElementById("mExpCompany").value = exp.company || "";
    document.getElementById("mExpLocation").value = exp.location || "";
    document.getElementById("mExpStart").value = exp.startDate || "";
    document.getElementById("mExpEnd").value = exp.endDate || "";
    document.getElementById("mExpDesc").value = exp.description || "";

    openModal(
        editing ? "Edit Experience" : "Add Experience",
        "",
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

            if (!updated.title || !updated.company) {
                alert("Title and Company are required");
                return;
            }

            let url = editing
                ? "assets/profile/update_experience.php"
                : "assets/profile/add_experience.php";

            fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: new URLSearchParams({
                    id: updated.id,
                    title: updated.title,
                    company: updated.company,
                    location: updated.location,
                    start_date: updated.startDate,
                    end_date: updated.endDate,
                    description: updated.description,
                }),
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.status === "success") {
                        if (!editing) {
                            updated.id = data.id || updated.id;

                            profile.experiences.unshift(updated);
                        } else {
                            const i = profile.experiences.findIndex(
                                (x) => String(x.id) === String(exp.id),
                            );

                            if (i !== -1) {
                                profile.experiences[i] = {
                                    ...profile.experiences[i],
                                    ...updated,
                                };
                            }
                        }

                        render();
                        closeModal();
                    } else {
                        alert(data.message || "Error");
                    }
                });
        },
    );
}

function deleteExp(id) {
    openDeleteDialog(
        "Delete Experience",
        "Are you sure you want to delete this experience?",
        () => {
            fetch("assets/profile/delete_experience.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: new URLSearchParams({ id }),
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    profile.experiences = profile.experiences.filter(
                        x => String(x.id) !== String(id)
                    );
                    render();
                } else {
                    alert("Delete failed");
                }
            });
        }
    );
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
    if (!e) return;
    eduModal({ ...e }, true);
}

function eduModal(edu, editing) {
    document.getElementById("mEduSchool").value = edu.school || "";
    document.getElementById("mEduDegree").value = edu.degree || "";
    document.getElementById("mAwards").value = edu.awards || "";
    document.getElementById("mEduStart").value = edu.startYear || "";
    document.getElementById("mEduEnd").value = edu.endYear || "";

    openModal(
        editing ? "Edit Education" : "Add Education",
        "Add your educational background.",
        "formEdu",
        () => {
            const updated = {
                id: edu.id,
                school: g("mEduSchool"),
                degree: g("mEduDegree"),
                awards: g("mAwards"),
                startYear: g("mEduStart"),
                endYear: g("mEduEnd"),
            };

            let url = editing
                ? "assets/profile/update_education.php"
                : "assets/profile/add_education.php";

            fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: new URLSearchParams({
                    id: updated.id,
                    school: updated.school,
                    degree: updated.degree,
                    awards: updated.awards,
                    start_year: updated.startYear,
                    end_year: updated.endYear,
                }),
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.status === "success") {
                        if (!editing) {
                            updated.id = data.id || updated.id;

                            profile.educations.unshift(updated);
                        } else {
                            const i = profile.educations.findIndex(
                                (x) => String(x.id) === String(edu.id),
                            );

                            if (i !== -1) {
                                profile.educations[i] = {
                                    ...profile.educations[i],
                                    ...updated,
                                };
                            }
                        }

                        render();
                        closeModal();
                    } else {
                        alert(data.message || "Error");
                    }
                });
        },
    );
}

function deleteEdu(id) {
    openDeleteDialog(
        "Delete Education",
        "Are you sure you want to delete this education record?",
        () => {
            fetch("assets/profile/delete_education.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: new URLSearchParams({ id }),
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    profile.educations = profile.educations.filter(
                        x => String(x.id) !== String(id)
                    );
                    render();
                } else {
                    alert("Delete failed");
                }
            });
        }
    );
}

// Skills functions
function openAddSkill() {
    document.getElementById("skillName").value = "";

    openModal(
        "Add Skill",
        "Add a new skill to your profile.",
        "formSkill",
        () => {
            const skill = g("skillName").trim();

            if (!skill) return;

            fetch("assets/profile/add_skill.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: new URLSearchParams({
                    skill: skill,
                }),
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.status === "success") {
                        profile.skills.push({
                            id: data.id,
                            name: skill,
                        });

                        render();
                        closeModal();
                    } else {
                        alert(data.message || "Add failed");
                    }
                });
        },
    );
}

function removeSkill(id) {
    openDeleteDialog(
        "Delete Skill",
        "Remove this skill from your profile?",
        () => {
            fetch("assets/profile/delete_skill.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: new URLSearchParams({ id }),
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    profile.skills = profile.skills.filter(
                        x => String(x.id) !== String(id)
                    );
                    render();
                } else {
                    alert("Delete failed");
                }
            });
        }
    );
}

// Avatar upload
let selectedAvatarFile = null;

function handleAvatarChange(e) {
    const file = e.target.files[0];

    if (!file) return;

    selectedAvatarFile = file;

    document.getElementById("avatarDialog").classList.add("active");
}

document.getElementById("cancelAvatarBtn").addEventListener("click", () => {
    selectedAvatarFile = null;

    document.getElementById("avatarDialog").classList.remove("active");

    document.querySelector('input[type="file"]').value = "";
});

document.getElementById("confirmAvatarBtn").addEventListener("click", () => {
    if (!selectedAvatarFile) return;

    const formData = new FormData();
    formData.append("avatar", selectedAvatarFile);

    fetch("assets/profile/update_avatar.php", {
        method: "POST",
        body: formData,
    })
    .then(res => res.text())
    .then(res => {
        if (res.trim() === "success") {
            location.reload();
        } else {
            alert("Upload failed: " + res);
        }
    });

    document.getElementById("avatarDialog").classList.remove("active");
});

// document.getElementById("removeAvatarBtn").addEventListener("click", () => {
//     if (!confirm("Remove profile picture?")) return;

//     fetch("assets/profile/remove_avatar.php", {
//         method: "POST",
//     })
//     .then(res => res.text())
//     .then(res => {
//         console.log(res);

//         if (res.trim() === "success") {
//             location.reload();
//         } else {
//             alert("Failed to remove photo");
//         }
//     });
// });

let deleteCallback = null;

function openDeleteDialog(title, message, onConfirm) {
    document.getElementById("deleteTitle").textContent = title;
    document.getElementById("deleteMessage").textContent = message;

    deleteCallback = onConfirm;

    document.getElementById("deleteDialog").classList.add("active");
}

document.getElementById("cancelDeleteBtn").addEventListener("click", () => {
    deleteCallback = null;
    document.getElementById("deleteDialog").classList.remove("active");
});

document.getElementById("confirmDeleteBtn").addEventListener("click", () => {
    if (typeof deleteCallback === "function") {
        deleteCallback();
    }

    deleteCallback = null;
    document.getElementById("deleteDialog").classList.remove("active");
});
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
