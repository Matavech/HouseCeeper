document.addEventListener("DOMContentLoaded", function() {
	// Generate input files preview
	const inputElement = document.querySelector('input[type="file"]');
	const fileListElement = document.querySelector('.input-file-list');

	inputElement.addEventListener('change', handleFiles, false);

	function handleFiles() {
		const fileList = this.files;
		fileListElement.innerHTML = '';

		for (let i = 0; i < fileList.length; i++) {
			const file = fileList[i];

			const reader = new FileReader();

			reader.onload = function(event) {
				const fileElement = document.createElement('div');
				const fileThumbnail = document.createElement('img');
				const fileName = document.createElement('div');
				const fileFooter = document.createElement('div');
				const fileRemoveButton = document.createElement('button');

				fileElement.classList.add('card', 'column', 'is-3', 'm-1');
				fileThumbnail.classList.add('card-image');
				fileThumbnail.setAttribute('alt', '');
				fileName.classList.add('card-content');
				fileFooter.classList.add('card-footer');
				fileRemoveButton.classList.add('button', 'is-danger', 'card-footer-item');

				fileThumbnail.src = event.target.result;
				fileName.textContent = file.name;
				//fileRemoveButton.textContent = 'Не прикреплять';

				// Delete file from form

				fileElement.appendChild(fileThumbnail);
				fileElement.appendChild(fileName);
				//fileElement.appendChild(fileFooter);
				//fileFooter.appendChild(fileRemoveButton);
				fileListElement.appendChild(fileElement);
			};
			reader.readAsDataURL(file);
		}
	}

	// const form = document.querySelector('form');
	// form.addEventListener('submit', function(event) {
	// 	event.preventDefault();
	// 	const formData = new FormData(form);
	// 	const sizeInBytes = new Blob(Array.from(formData.values())).size;
	// 	const maxSizeInBytes = 50 * 1024 * 1024; // 50 МБ
	// 	if (sizeInBytes > maxSizeInBytes) {
	// 		event.preventDefault();
	// 		alert('Суммарный размер всех файлов не должен превышать 50 МБ');
	// 	}
	// 	const maxFilesCount = 10;
	// 	const files = inputElement.files;
	// 	if (files.length > maxFilesCount) {
	// 		event.preventDefault();
	// 		alert(`Выбрано слишком много файлов. Выберите не более ${maxFilesCount} файлов.`);
	// 	}
	// });
});