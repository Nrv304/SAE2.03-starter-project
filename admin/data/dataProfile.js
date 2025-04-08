let HOST_URL = "https://mmi.unilim.fr/~trelat2/SAE2.03-starter-project";

let DataProfile = {};

// Fonction pour ajouter un profil utilisateur
DataProfile.addProfile = async function (fdata) {
    // fetch possède un deuxième paramètre (optionnel) qui est un objet de configuration de la requête HTTP:
    //  - method : la méthode HTTP à utiliser (GET, POST...)
    //  - body : les données à envoyer au serveur (sous forme d'objet FormData ou bien d'une chaîne de caractères, par exempe JSON)
  
    let config = {
      method: "POST", // méthode HTTP à utiliser
      body: fdata, // données à envoyer sous forme d'objet FormData
    };
    let answer = await fetch(HOST_URL + "/server/script.php?todo=addProfile", config);
    let data = await answer.json();
    return data;
  };
  
  DataProfile.updateProfile = async function (fdata) {
    // fetch possède un deuxième paramètre (optionnel) qui est un objet de configuration de la requête HTTP:
    //  - method : la méthode HTTP à utiliser (GET, POST...)
    //  - body : les données à envoyer au serveur (sous forme d'objet FormData ou bien d'une chaîne de caractères, par exemple JSON)
    let config = {
        method: "POST", // méthode HTTP à utiliser
        body: fdata // données à envoyer sous forme d'objet FormData
    };
    let answer = await fetch(HOST_URL + "/server/script.php?todo=updateProfiles", config);
    let data = await answer.json();
    return data;
};

DataProfile.readProfile = async function () {
    let answer = await fetch(HOST_URL + `/server/script.php?todo=readProfiles`);
    let profile = await answer.json();
    return profile;
};

export { DataProfile };