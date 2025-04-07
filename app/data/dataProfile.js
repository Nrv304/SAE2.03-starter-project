let HOST_URL = "https://mmi.unilim.fr/~trelat2/SAE2.03-starter-project";

let DataProfile = {};

DataProfile.readProfile = async function () {
    let answer = await fetch(HOST_URL + `/server/script.php?todo=readProfiles`);
    let profile = await answer.json();
    return profile;
};

export { DataProfile };