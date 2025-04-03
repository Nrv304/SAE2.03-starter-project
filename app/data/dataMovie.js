let HOST_URL = "https://mmi.unilim.fr/~trelat2/SAE2.03-starter-project"

let DataMovie = {}

DataMovie.getAll = async function() {
    let answer = await fetch(HOST_URL + "/server/script.php?todo=getAllMovies");
    let movies = await answer.json();
    return movies;
}

export {DataMovie};