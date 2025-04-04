let templateFile = await fetch("./component/MovieDetail/template.html");
let template = await templateFile.text();

let MovieDetail = {};

// Formate les détails d'un film avec le template
MovieDetail.format = function (movie) {
  let html = template;
  html = html.replace("{{movietTitle}}", movie.name);
  html = html.replace("{{movieDirector}}", movie.director);
  html = html.replace("{{movieReleaseYear}}", movie.year);
  html = html.replace("{{movieDescription}}", movie.description);
  html = html.replace("{{movieCategory}}", movie.category);
  html = html.replace("{{movieAgeRestriction}}", movie.min_age);
  html = html.replace("{{movieTrailerUrl}}", movie.trailer);
  html = html.replace("{{image}}", movie.image);
  return html;
};

export { MovieDetail };