let templateFile = await fetch("./component/film/template.html");
let template = await templateFile.text();

let templateLiFile = await fetch("./component/film/template_li.html");
let templateLi = await templateLiFile.text();

let Films = {};

// Formate les films avec le template principal
Films.format = function (films) {
    let html = "";
    films.forEach((film) => {
        let filmHtml = template;
        filmHtml = filmHtml.replace("{{titre}}", film.name);
        filmHtml = filmHtml.replace("{{image}}", film.image);
        html += filmHtml;
    });
    return html;
};

// Insère les films formatés dans le conteneur défini par template_li
Films.formatLi = function (films) {
    let filmContent = Films.format(films); // Génère le HTML des films
    let liHtml = templateLi;
    liHtml = liHtml.replace("{{film}}", filmContent); // Insère les films dans le conteneur
    return liHtml;
};

export { Films };