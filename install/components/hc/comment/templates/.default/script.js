function replyToComment(comment_id, user_name) {
	document.getElementById("parentCommentId").value = comment_id;

	let input = document.getElementById("inputComment");

	input.value = user_name + ", ";
	input.focus();
}