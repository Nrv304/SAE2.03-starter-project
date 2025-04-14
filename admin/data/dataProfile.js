let HOST_URL = "../server";

let DataProfile = {};

DataProfile.addProfile = async function (fdata) {
  let config = {
      method: "POST",
      body: fdata,
  };

  let answer = await fetch(`${HOST_URL}/script.php?todo=addProfile`, config);

  if (!answer.ok) {
      console.error("Erreur HTTP:", answer.status);
      let text = await answer.text();
      console.error("Réponse brute :", text);
      return { success: false, error: `Erreur serveur (${answer.status})` };
  }

  let data = await answer.json(); // Essayer de parser le JSON
  return data;
};

  
  DataProfile.updateProfile = async function (fdata) {
    let config = {method: "POST", body: fdata};
    let answer = await fetch(`${HOST_URL}/script.php?todo=updateProfiles`, config);
    let data = await answer.json();
    return data;
};

DataProfile.readProfile = async function () {
    let answer = await fetch(`${HOST_URL}/script.php?todo=readProfiles`);
    let profile = await answer.json();
    return profile;
};

export { DataProfile };