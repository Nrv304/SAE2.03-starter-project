let HOST_URL = "https://mmi.unilim.fr/~trelat2/SAE2.03-starter-project";

let DataMovie = {};

DataMovie.getAll = async function () {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=getAllMovies");
  let movies = await answer.json();
  return movies;
};


DataMovie.addMovie = async function (movie) {
    let config = {
      method: "POST",
      body: movie,
    };
    let answer = await fetch(
        HOST_URL + "/server/script.php?todo=addMovies",
        config
    );
    let data = await answer.json();
    return data;
  };


export { DataMovie };