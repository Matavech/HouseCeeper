function replyToComment(comment_id, user_name) {
	document.getElementById("parentCommentId").value = encodeURIComponent(comment_id);
//Todo Экранировать
	let input = document.getElementById("inputComment");

	input.value = user_name + ", ";
	input.focus();
}