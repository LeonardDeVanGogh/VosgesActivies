import './styles/show.css';




let tests = document.getElementsByClassName("openReportModal");
let i;
for (i = 0; i < tests.length; i++) {
    tests[i].addEventListener("click", setCommentId);
}

function setCommentId(){
    document.getElementById("comment_id").value = this.dataset.commentId;
}