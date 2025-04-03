let templateFile = await fetch("./component/film/template.html");
let template = await templateFile.text();
let Films = {}; 
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
export {Films}