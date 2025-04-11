let SearchMovie = {};

SearchMovie.init = function () {
    document.querySelector("#searchKeyword").addEventListener("keypress", (e) => {;
    if (e.key === "Enter") {
        C.handlerSearchMovie(e);
    } 
    });
};

SearchMovie.renderResults = function (movies, updateHandler) {
    if (movies.length === 0) {
      return  `<p>Aucun film ne correspond à votre recherche.</p>`;
    }

    let html ="";
    let i = 0;
    let moviesCount = movies.length;
  
    while (i < moviesCount) {
        let movie = movies[i];
        html += 
        `
        <div class="movie">
          <h3>${movie.name}</h3>
          <p>Catégorie : ${movie.category}</p>
          <p>Statut : ${movie.is_featured ? "Mis en avant" : "Non mis en avant"}</p>
          <button onclick="${updateHandler}(${movie.id}, ${!movie.is_featured})">
            ${movie.is_featured ? "Retirer des films mis en avant" : "Mettre en avant"}
          </button>
        </div>
      `;
        i++;
    }
    return html;
  };

  export { SearchMovie };