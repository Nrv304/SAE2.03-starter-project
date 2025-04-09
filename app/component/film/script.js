let templateFile = await fetch("./component/film/template.html");
let template = await templateFile.text();

let templateLiFile = await fetch("./component/film/template_li.html");
let templateLi = await templateLiFile.text();

let Films = {};

// Formate les films avec le template principal
Films.format = function (films, profileId, favorites) {
    let i = 0;


        let filmHtml = template;
        let movie = films[i];
        filmHtml = filmHtml.replace("{{titre}}", movie.name);
        filmHtml = filmHtml.replace("{{image}}", movie.image);
        filmHtml = filmHtml.replace("{{handler}}", `C.handlerDetail(${movie.id})`);

        if (!favorites || !Array.isArray(favorites)) {
            favorites = [];
          }

        let isFavorite = false
        for (let fav of favorites) {
            if (fav.id === movie.id) {
                isFavorite = true;
                break;
            }
        }
        const favoritebutton = isFavorite
            ? `<button disabled> Favoris</button>`
            : `<button class="add-to-favorites-button" onclick="C.addFavorites(${movie.id}, ${profileId})">Ajouter aux favoris</button>`;
            
            filmHtml = filmHtml.replace("{{button}}", favoritebutton);
            i++;
    return filmHtml;
};

// Insère les films formatés dans le conteneur défini par template_li
Films.formatLi = function (films) {
    let filmContent = Films.format(films); // Génère le HTML des films
    let liHtml = templateLi;
    liHtml = liHtml.replace("{{film}}", filmContent); // Insère les films dans le conteneur
    return liHtml;
};

export { Films };