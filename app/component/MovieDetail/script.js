import { MovieComment } from "../MovieComment/script.js";

let templateFile = await fetch("./component/MovieDetail/template.html");
let template = await templateFile.text();

let MovieDetail = {};

// Formate les détails d'un film avec le template
MovieDetail.format = function (film, favorites, profileId) {
  if (!favorites || !Array.isArray(favorites)) {
    favorites = [];
}

  let html = template;
  html = html.replace(/{{movieTitle}}/g, film.name);
  html = html.replace("{{movieDirector}}", film.director);
  html = html.replace("{{movieReleaseYear}}", film.year);
  html = html.replace("{{movieDescription}}", film.description);
  html = html.replace("{{movieCategory}}", film.category);
  html = html.replace("{{movieAgeRestriction}}", film.min_age);
  html = html.replace("{{movieTrailerUrl}}", film.trailer);
  html = html.replace("{{image}}", film.image);
  html = html.replace("{{onclick}}", `C.addRating(${film.id})`);

  const newTag = film.is_new ? `<span class="new-detail">New</span>` : "";
  html = html.replace("{{newTag}}", newTag);

  let averageRating = film.average_rating ||  0;
  html = html.replace("{{averageRating}}", averageRating);
  html += MovieComment.format(film.id);

  const isFavorite = favorites.some(fav => fav.id === film.id);
  const favoriteButton = isFavorite
      ? `<button disabled>Favori</button>`
      : `<button class="add-to-favorites-button" onclick="C.addFavorites(${film.id}, ${profileId})">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M4.24 12.25C3.84461 11.8572 3.53134 11.3897 3.31845 10.8747C3.10556 10.3596 2.99731 9.80733 3 9.25002C3 8.12285 3.44777 7.04184 4.2448 6.24481C5.04183 5.44778 6.12283 5.00002 7.25 5.00002C8.83 5.00002 10.21 5.86002 10.94 7.14002H12.06C12.4311 6.48908 12.9681 5.94811 13.6163 5.57219C14.2645 5.19628 15.0007 4.99886 15.75 5.00002C16.8772 5.00002 17.9582 5.44778 18.7552 6.24481C19.5522 7.04184 20 8.12285 20 9.25002C20 10.42 19.5 11.5 18.76 12.25L11.5 19.5L4.24 12.25ZM19.46 12.96C20.41 12 21 10.7 21 9.25002C21 7.85763 20.4469 6.52227 19.4623 5.53771C18.4777 4.55314 17.1424 4.00002 15.75 4.00002C14 4.00002 12.45 4.85002 11.5 6.17002C11.0151 5.49652 10.3766 4.94834 9.63748 4.57095C8.89835 4.19356 8.0799 3.99784 7.25 4.00002C5.85761 4.00002 4.52226 4.55314 3.53769 5.53771C2.55312 6.52227 2 7.85763 2 9.25002C2 10.7 2.59 12 3.54 12.96L11.5 20.92L19.46 12.96Z" fill="black"/>
          </svg>

          <h4 class="featured-movie__button-text">Ajouter</h4>
      </button>`;
  html = html.replace("{{button}}", favoriteButton);

  return html;
};

export { MovieDetail };