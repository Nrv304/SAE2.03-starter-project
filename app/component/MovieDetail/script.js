let templateFile = await fetch("./component/MovieDetail/template.html");
let template = await templateFile.text();

let MovieDetail = {};

// Formate les détails d'un film avec le template
MovieDetail.format = function (movie) {
  let html = template;
  html = html.replace("{{movietTitle}}", movie.name);
  html = html.replace("{{director}}", movie.director);
  html = html.replace("{{year}}", movie.year);
  html = html.replace("{{description}}", movie.description);
  html = html.replace("{{category}}", movie.category);
  html = html.replace("{{min_age}}", movie.min_age);
  html = html.replace("{{trailer}}", movie.trailer);
  html = html.replace("{{image}}", movie.image);
  return html;
};

export { MovieDetail };