let templateFile = await fetch("./component/MovieFeatured/template.html");
let template = await templateFile.text();
let templateLiFile = await fetch("./component/MovieFeatured/template_li.html");
let templateLi = await templateLiFile.text();
let FeaturedMovies = {};


FeaturedMovies.formatOne = function (movie) {
    let movieHtml = template;

    movieHtml = movieHtml.replace("{{image}}", movie.image);
    movieHtml = movieHtml.replace("{{title}}", movie.name);
    movieHtml = movieHtml.replace("{{description}}", movie.description);
    movieHtml = movieHtml.replace("{{onclick}}", `C.handlerDetail(${movie.id})`);
    return movieHtml;
  };

  FeaturedMovies.formatLi = function (movies) {
    if (movies.length === 0) {
        return `<p class="no-movies">Aucun film trouvé</p>`; // Utilisez un <p> ou une autre balise
    }

    let formattedMovies = "";
    for (let movie of movies) {
        formattedMovies += FeaturedMovies.formatOne(movie);
    }

    let liHtml = templateLi;
    liHtml = liHtml.replace("{{movies}}", formattedMovies);
    return liHtml;
}

export { FeaturedMovies };