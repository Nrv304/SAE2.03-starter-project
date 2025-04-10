let HOST_URL = "../server";

let DataProfile = {};

DataProfile.addProfile = async function (fdata) {
    let config = {method: "POST", body: fdata,};
    let answer = await fetch(`${HOST_URL}/script.php?todo=addProfile`, config);
    let data = await answer.json();
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