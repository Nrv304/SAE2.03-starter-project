let loadTemplate = async function(filename) {
    let response = await fetch(filename);
    let html = await response.text();
    return html;
}


export { loadTemplate};