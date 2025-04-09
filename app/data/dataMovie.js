let HOST_URL = "https://mmi.unilim.fr/~trelat2/SAE2.03-starter-project";

let DataMovie = {};

DataMovie.getAll = async function () {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=getAllMovies");
  let movies = await answer.json();
  return movies;
};

DataMovie.requestMovieDetails = async function (movieId) {
  let answer = await fetch(
    HOST_URL + `/server/script.php?todo=readMovieDetail&id=${movieId}`
  );
  let movieDetails = await answer.json();
  return movieDetails;
};

DataMovie.requestMovieCategory = async function (age) {
  const url = HOST_URL + "/server/script.php?todo=getMovieCategory&age=" + age;
  console.log("URL générée :", url);
  let answer = await fetch(url);
  let movieCategory = await answer.json();
  return movieCategory;
};

DataMovie.addFavorite = async function (movieId, profileId) {
  const url = `${HOST_URL}/server/script.php?todo=addFavorites&id_profile=${profileId}&id_movie=${movieId}`;
  console.log("URL générée pour ajouter aux favoris :", url);
  let answer = await fetch(url);
  if (!answer.ok) {
    throw new Error("Erreur lors de la requête au serveur.");
  }
  let favoriteResponse = await answer.json();
  return favoriteResponse;
};

DataMovie.getFavorite = async function (profileId) {
  const url = `${HOST_URL}/server/script.php?todo=getFavorites&id_profile=${profileId}`;
  console.log("URL générée pour récupérer les favoris :", url); // Ajoutez cette ligne pour déboguer
  let answer = await fetch(url);
  let favoriteResponse = await answer.json();
  return favoriteResponse;
};

DataMovie.removeFavorite = async function (profileId, movieId) {
  const url = `${HOST_URL}/server/script.php?todo=removeFavorites&id_profile=${profileId}&id_movie=${movieId}`;
  console.log("URL générée pour supprimer des favoris :", url);
  let answer = await fetch(url);
  let favoriteResponse = await answer.json();
  return favoriteResponse;
};

export { DataMovie };
