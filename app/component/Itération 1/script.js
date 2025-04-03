let templateFile = await fetch("./component/Itération 1/template.html");
let template = await templateFile.text();
let Films = {}; 
Films.format =  function(obj) {
    let html = template;
    html = html.replace('{{image}}', obj.urlImage);
    html = html.replaceAll('{{titre}}', obj.titre);
    return html;
}
Films.render = async function(selector, data){
    let html = '';
    for(let obj of data){
        html += Films.format(obj);  
    }
    let where = document.querySelector(selector);
    where.innerHTML =  html;
}
export {Films}