let templateFile = await fetch("./component/MovieDetail/template.html");
let template = await templateFile.text();

let MovieDetail = {};

// Formate les détails d'un film avec le template
MovieDetail.format = function (film) {
  let html = template;
  html = html.replace("{{movietTitle}}", film.name);
  html = html.replace("{{movieDirector}}", film.director);
  html = html.replace("{{movieReleaseYear}}", film.year);
  html = html.replace("{{movieDescription}}", film.description);
  html = html.replace("{{movieCategory}}", film.category);
  html = html.replace("{{movieAgeRestriction}}", film.min_age);
  html = html.replace("{{movieTrailerUrl}}", film.trailer);
  html = html.replace("{{image}}", film.image);
  return html;
};

export { MovieDetail };