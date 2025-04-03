let HOST_URL = "https://mmi.unilim.fr/~trelat2/SAE2.03-TrelatOwen"

let DataMovie = {}

DataMovie.getAll = async function() {

    let answer = await fetch(HOST_URL + "/serveur/script.php?todo=readmovies")

    let data = await answer.json()

    return data
}

export {DataMovie};