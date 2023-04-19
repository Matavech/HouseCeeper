document.addEventListener("DOMContentLoaded", function() {
	let typeElement = document.querySelector("#type");
	let typeText = typeElement.textContent;

	if (typeText.trim() === 'announcement') {
		typeElement.textContent = 'Объявление';
		typeElement.classList.add('is-warning');
	} else if (typeText.trim() === 'discussion') {
		typeElement.textContent = 'Обсуждение';
		typeElement.classList.add('is-primary');
	} else if (typeText.trim() === 'unconfirmed') {
		typeElement.textContent = 'Неподтвержден';
		typeElement.classList.add('is-danger');
	}
});
