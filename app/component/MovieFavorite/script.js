let templateFile = await fetch("./component/MovieFavorite/template.html");
let template = await templateFile.text();

let templateLiFile = await fetch("./component/MovieFavorite/template_li.html");
let templateLi = await templateLiFile.text();

let MovieFavorite = {};

MovieFavorite.format = function (favoriteData) {
    let html = template;

    html = html.replace("{{image}}", favoriteData.image || "default-image.png");
    html = html.replace("{{name}}", favoriteData.name ? favoriteData.name : "Nom inconnu");
    html = html.replace(/{{id}}/g, favoriteData.id); // Remplace toutes les occurrences de {{id}}
    html = html.replace("{{handler}}", `C.handlerDetail(${favoriteData.id})`); // Assurez-vous que C.handlerDetail est défini dans votre contexte
    return html;
};

MovieFavorite.formatLi = function (favoriteData) {
    let favoriteContent = MovieFavorite.format(favoriteData); // Génère le HTML pour tous les films
    let liHtml = templateLi;
    liHtml = liHtml.replace("{{favorite}}", favoriteContent); // Insère les films dans le conteneur
    return liHtml;
}

export { MovieFavorite };