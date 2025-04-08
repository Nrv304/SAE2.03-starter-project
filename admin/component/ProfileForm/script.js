import { DataProfile } from "../../data/dataProfile.js";

let templateFile = await fetch('./component/ProfileForm/template.html');
let template = await templateFile.text();

let ProfileForm = {};

// Formate le template avec les profils et les gestionnaires
ProfileForm.format = function (profiles, handler) {
    let html = template;
    let options = "";
    for (let i = 0; i < profiles.length; i++) {
        const p = profiles[i];
        options += `<option value="${p.id}" data-name="${p.name}" data-avatar="${p.avatar}" data-age="${p.min_age}">${p.name}</option>`;
    }

    html = html.replace("{{options}}", options);
    html = html.replace("{{addHandler}}", handler);
    return html;
};

// Initialise les champs et les événements du formulaire
ProfileForm.init = function () {
    const select = document.getElementById("profile-select");
    const idField = document.getElementById("profile-id");
    const nameField = document.getElementById("profile-name");
    const avatarField = document.getElementById("profile-avatar");
    const minAgeField = document.getElementById("profile-min-age");

    // Remplit les champs en fonction du profil sélectionné
    select.addEventListener("change", (event) => {
        const selectedOption = event.target.selectedOptions[0];
        if (selectedOption) {
            idField.value = selectedOption.value || "";
            nameField.value = selectedOption.dataset.name || "";
            avatarField.value = selectedOption.dataset.avatar || "";
            minAgeField.value = selectedOption.dataset.age || "";
        }
    });
};


export { ProfileForm };