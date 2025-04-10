let templateFile = await fetch("./component/film/template.html");
let template = await templateFile.text();

let templateLiFile = await fetch("./component/film/template_li.html");
let templateLi = await templateLiFile.text();

let Films = {};

// Formate les films avec le template principal
Films.format = function (films, profileId, favorites) {
    if (!favorites || !Array.isArray(favorites)) {
        favorites = [];
    }

    let allFilmsHtml = ""; // Contiendra le HTML de tous les films

    for (let i = 0; i < films.length; i++) {
        let movie = films[i];
        let filmHtml = template;

        filmHtml = filmHtml.replace("{{titre}}", movie.name);
        filmHtml = filmHtml.replace("{{image}}", movie.image);
        filmHtml = filmHtml.replace("{{handler}}", `C.handlerDetail(${movie.id})`);

        let isFavorite = false;
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

        allFilmsHtml += filmHtml; // Ajoute le HTML du film courant au résultat
    }

    return allFilmsHtml; // Retourne le HTML combiné de tous les films
};

// Insère les films formatés dans le conteneur défini par template_li
Films.formatLi = function (films) {
    let filmContent = Films.format(films); // Génère le HTML pour tous les films
    let liHtml = templateLi;
    liHtml = liHtml.replace("{{film}}", filmContent); // Insère les films dans le conteneur
    return liHtml;
};

export { Films };