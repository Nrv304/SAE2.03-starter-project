let HOST_URL = "../server";

let DataMovie = {};

DataMovie.getAll = async function () {
  let answer = await fetch(`${HOST_URL}/script.php?todo=getAllMovies`);
  let movies = await answer.json();
  return movies;
};

DataMovie.requestMovieDetails = async function (movieId) {
  let answer = await fetch(`${HOST_URL}/script.php?todo=readMovieDetail&id=${movieId}`);
  let movieDetails = await answer.json();

  if (movieDetails.error) {
    throw new Error(movieDetails.error);
  }

  let averageRating = await fetch(`${HOST_URL}/script.php?todo=getAverageRating&id_movie=${movieId}`);
  movieDetails.average_rating = await averageRating.json();

  return movieDetails;
};

DataMovie.requestMovieCategory = async function (age) {
  const url = `${HOST_URL}/script.php?todo=getMovieCategory&age=${age}`;
  let answer = await fetch(url);
  let movieCategory = await answer.json();
  console.log("Données des catégories de films :", movieCategory); // Vérifiez ici
  return movieCategory;
};

DataMovie.addFavorite = async function (movieId, profileId) {
  const url = `${HOST_URL}/script.php?todo=addFavorites&id_profile=${profileId}&id_movie=${movieId}`;
  let answer = await fetch(url);
  if (!answer.ok) {
    throw new Error("Erreur lors de la requête au serveur.");
  }
  let favoriteResponse = await answer.json();
  return favoriteResponse;
};

DataMovie.getFavorite = async function (profileId) {
  const url = `${HOST_URL}/script.php?todo=getFavorites&id_profile=${profileId}`;
  let answer = await fetch(url);
  let favoriteResponse = await answer.json();
  return favoriteResponse;
};

DataMovie.removeFavorite = async function (profileId, movieId) {
  const url = `${HOST_URL}/script.php?todo=removeFavorites&id_profile=${profileId}&id_movie=${movieId}`;
  let answer = await fetch(url);
  let favoriteResponse = await answer.json();
  return favoriteResponse;
};

DataMovie.getFeaturedMovies = async function () {
  let answer = await fetch(`${HOST_URL}/script.php?todo=getFeaturedMovies`);
  let featuredMovies = await answer.json();
  return featuredMovies;
};

DataMovie.searchMovies = async function (keyword) {
  const url = `${HOST_URL}/script.php?todo=searchMovies&keyword=${encodeURIComponent(keyword)}`;
  let answer = await fetch(url);
  let movies = await answer.json();
  return movies;
};

DataMovie.addRating = async function (movieId, profileId, rating) {
  const url = `${HOST_URL}/script.php?todo=addRating&id_movie=${movieId}&rating=${rating}&id_profil=${profileId}`;
  let response = await fetch(url);
  let jsonResponse = await response.json();
  return jsonResponse;
};

DataMovie.addComment = async function (movieId, profileId, commentText) {
  const url = `${HOST_URL}/script.php?todo=addComment&id_movie=${movieId}&id_profile=${profileId}&comment_text=${encodeURIComponent(commentText)}`;
  let response = await fetch(url);
  let jsonResponse = await response.json();
  return jsonResponse;
};

DataMovie.getComments = async function (movieId) {
  const url = `${HOST_URL}/script.php?todo=getComments&id_movie=${movieId}`;
  let response = await fetch(url);
  let comments = await response.json();
  return comments;
};


export { DataMovie };
