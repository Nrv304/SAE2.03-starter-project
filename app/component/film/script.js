let templateFile = await fetch("./component/film/template.html");
let template = await templateFile.text();

let templateLiFile = await fetch("./component/film/template_li.html");
let templateLi = await templateLiFile.text();

let Films = {};

// Formate les films avec le template principal
Films.format = function (films, profileId, favorites, recentMovies = []) {
    if (!favorites || !Array.isArray(favorites)) {
        favorites = [];
    }

    let allFilmsHtml = "";

    for (let i = 0; i < films.length; i++) {
        let movie = films[i];
        let filmHtml = template;

        filmHtml = filmHtml.replace("{{titre}}", movie.name);
        filmHtml = filmHtml.replace("{{image}}", movie.image);
        filmHtml = filmHtml.replace("{{handler}}", `C.handlerDetail(${movie.id})`);

        // Vérifiez si le film est récent
        const newTag = movie.is_new ? `<span class="tag-new">New</span>` : "";
        filmHtml = filmHtml.replace("{{newTag}}", newTag);

        // Vérifiez si le film est un favori
        const isFavorite = favorites.some(fav => fav.id === movie.id);
        const favoriteButton = isFavorite
            ? `<button disabled>Favori</button>`
            : `<button class="add-to-favorites-button" onclick="C.addFavorites(${movie.id}, ${profileId})">Ajouter aux favoris</button>`;

        filmHtml = filmHtml.replace("{{button}}", favoriteButton);

        allFilmsHtml += filmHtml;
    }

    return allFilmsHtml;
};

// Insère les films formatés dans le conteneur défini par template_li
Films.formatLi = function (films) {
    let filmContent = Films.format(films); // Génère le HTML pour tous les films
    let liHtml = templateLi;
    liHtml = liHtml.replace("{{film}}", filmContent); // Insère les films dans le conteneur
    return liHtml;
};

export { Films };