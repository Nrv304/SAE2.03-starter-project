import { MovieComment } from "../MovieComment/script";

let templateFile = await fetch("./component/MovieDetail/template.html");
let template = await templateFile.text();

let MovieDetail = {};

// Formate les détails d'un film avec le template
MovieDetail.format = function (film) {
  let html = template;
  html = html.replace("{{movieTitle}}", film.name);
  html = html.replace("{{movieDirector}}", film.director);
  html = html.replace("{{movieReleaseYear}}", film.year);
  html = html.replace("{{movieDescription}}", film.description);
  html = html.replace("{{movieCategory}}", film.category);
  html = html.replace("{{movieAgeRestriction}}", film.min_age);
  html = html.replace("{{movieTrailerUrl}}", film.trailer);
  html = html.replace("{{image}}", film.image);
  html = html.replace("{{onclick}}", `C.addRating(${film.id})`);

  const newTag = isRecent ? `<span class="new-tag">New</span>` : "";
  html = html.replace("{{newTag}}", newTag);

  let averageRating = film.average_rating ||  0;
  html = html.replace("{{averageRating}}", averageRating);
  html += MovieComment.format(film.id);

  return html;
};

export { MovieDetail };