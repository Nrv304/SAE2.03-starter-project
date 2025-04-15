import { DataMovie } from "../../data/dataMovie.js";

let templateFile = await fetch("./component/MovieComment/template.html");
let template = await templateFile.text();

let MovieComment = {};

MovieComment.format = function (movieId) {
    let html = template;
    html = html.replace("{{movieId}}", movieId);
    return html;
}

MovieComment.loadcomment = async function (movieId) {
    const comments = await DataMovie.getComments(movieId);
    console.log(comments);
    const commentsContainer = document.querySelector("#comments-list");

    if (comments.length === 0) {
        commentsContainer.innerHTML = "<p>Aucun commentaire pour se film, sois le premier.</p>";
        return;
    }

    let commentsHtml = "";
    comments.forEach(comment => {
        commentsHtml += `<div class="comment">
            <p><strong>${comment.profile_name}:</strong> ${comment.comment_text}</p>
            <p><em>${comment.created_at}</p>
        </div>`;
    });
    commentsContainer.innerHTML = commentsHtml;
}

MovieComment.addComment = async function (movieId) {
    const profileId = C.getSelectedProfileId();
    if (!profileId) {
        alert("Veuillez vous connecter pour ajouter un commentaire.");
        return;
    }

    const commentText = document.querySelector("#new-comment").value;
    if (!commentText) {
        alert("Veuillez entrer un commentaire.");
        return;
    }

    const response = await DataMovie.addComment(movieId, profileId, commentText);
    alert(response.message || "Commentaire ajouté avec succès.");
    MovieComment.loadcomment(movieId);
};

export { MovieComment };