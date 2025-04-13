let HOST_URL = "../server";

let DataMovie = {};

DataMovie.getAll = async function () {
  let answer = await fetch(`${HOST_URL}/script.php?todo=getAllMovies`);
  let movies = await answer.json();
  return movies;
};


DataMovie.addMovie = async function (movie) {
    let config = {method: "POST", body: movie,};
    let answer = await fetch(`${HOST_URL}/script.php?todo=addMovies`,config);
    let data = await answer.json();
    return data;
  };

  DataMovie.searchMovies = async function (keyword) {
    const url = `${HOST_URL}/script.php?todo=searchMovies&keyword=${encodeURIComponent(keyword)}`;
    let answer = await fetch(url);
    let movies = await answer.json();
    return movies;
  };
  
  DataMovie.updateFeaturedStatus = async function (id_movie, is_featured) {
    const url = `${HOST_URL}/script.php?todo=updateFeaturedStatus&movie_id=${id_movie}&is_featured=${is_featured}`;
    let answer = await fetch(url);

    if (!answer.ok) {
        console.error(`Erreur HTTP : ${answer.status}`);
        return { success: false, error: `Erreur HTTP : ${answer.status}` };
    }

    return answer.json().catch((error) => {
        console.error("Erreur lors du traitement de la réponse JSON :", error);
        return { success: false, error: "Réponse invalide du serveur." };
    });
};

DataMovie.getPendingComments = async function () {
  const url = `${HOST_URL}/script.php?todo=getPendingComments`;
  const response = await fetch(url);
  return await response.json();
};

DataMovie.approveComment = async function (commentId) {
  const url = `${HOST_URL}/script.php?todo=approveComment&id=${commentId}`;
  const response = await fetch(url);
  return await response.json();
};

DataMovie.deleteComment = async function (commentId) {
  const url = `${HOST_URL}/script.php?todo=deleteComment&id=${commentId}`;
  const response = await fetch(url);
  return await response.json();
};

export { DataMovie };