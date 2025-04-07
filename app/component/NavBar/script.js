import { DataProfile } from "../../data/dataProfile.js";

let templateFile = await fetch("./component/NavBar/template.html");
let template = await templateFile.text();

let NavBar = {};
NavBar.format = async function (hAbout, hHome, onProfileSelect) {

  let html = template;

  // Récupération des profils via DataProfile
  const profiles = await DataProfile.readProfile();
  let profileOptions = profiles
    .map(profile => `<option value="${profile.id}" data-img="${profile.avatar}">${profile.name}</option>`)
    .join("");

  html = html.replace("{{hAbout}}", hAbout);
  html = html.replace("{{hHome}}", hHome);
  html = html.replace("{{onProfileSelect}}", onProfileSelect);
  html = html.replace("{{profileOptions}}", profileOptions);
  let image = profiles[0]?.avatar|| "";
  html = html.replace("{{image}}", image);

  return html;
};

export { NavBar };