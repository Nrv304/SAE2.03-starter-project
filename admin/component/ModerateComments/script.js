import { DataMovie } from "../../data/dataMovie.js";

export const ModerateComments = {};

ModerateComments.loadComments = async function () {
    const comments = await DataMovie.getPendingComments();
    const commentsContainer = document.querySelector("#comments-list");

    if (!comments || comments.length === 0) {
        commentsContainer.innerHTML = "<p>Aucun commentaire à modérer pour le moment.</p>";
        return;
    }

    let commentsHtml = comments.map(comment => `
        <div class="comment">
            <p><strong>${comment.profile_name}:</strong> ${comment.comment_text}</p>
            <p><em>${new Date(comment.created_at).toLocaleString()}</em></p>
            <p>Statut : ${comment.status}</p>
            <button onclick="ModerateComments.approveComment(${comment.id})">Approuver</button>
            <button onclick="ModerateComments.deleteComment(${comment.id})">Supprimer</button>
        </div>
    `).join("");

    commentsContainer.innerHTML = commentsHtml;
};

ModerateComments.approveComment = async function (commentId) {
    const response = await DataMovie.approveComment(commentId);
    alert(response.message || response.error);
    ModerateComments.loadComments();
};

ModerateComments.deleteComment = async function (commentId) {
    const response = await DataMovie.deleteComment(commentId);
    alert(response.message || response.error);
    ModerateComments.loadComments();
};