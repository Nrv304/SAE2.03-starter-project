let loadTemplate = async function(filename) {
    // fetch est une fonction JS qui permet de lire un fichier
    // il faut attendre (await) que la lecture soit terminée avant de poursuivre
    // et d'être certain d'avoir le résultat de l'appel à fetch dans response
    let response = await fetch(filename);
    // response est un objet JS qui contient le résultat de la lecture du fichier
    // response.text() est une fonction qui permet de récupérer le contenu du fichier sous forme de chaîne de caractères
    // c'est aussi une opération qui n'est pas instantanée, il faut donc attendre (await) que l'extraction soit terminée
    let html = await response.text();
    // on retourne le contenu du fichier HTML sous forme de chaîne de caractères
    return html;
}


// on exporte la fonction pour pouvoir les utiliser dans d'autres modules JS
export { loadTemplate};