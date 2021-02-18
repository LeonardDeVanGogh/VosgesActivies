import './styles/show.css';

let comments = document.getElementsByClassName("openReportModal");
let i;
for (i = 0; i < comments.length; i++) {
    comments[i].addEventListener("click", setCommentId);
}

function setCommentId(){
    document.getElementById("comment_id").value = this.dataset.commentId;
}