function generateLink(event) {
	event.preventDefault();

	const houseId = document.querySelector("input[name='house-id']").value;
	const number = document.querySelector("input[name='number']").value;

	fetch(`/create-reg-link?house-id=${houseId}&number=${number}`)
		.then(response => response.text())
		.then(inviteKey => {
			const inviteKeyElement = document.getElementById("invite-key");
			inviteKeyElement.textContent = inviteKey;

			let inviteLink = 'bitrix.dev.bx/sign-up?key=' + inviteKey;
			const inviteLinkElement = document.getElementById("invite-link");
			inviteLinkElement.textContent = inviteLink;
		})
		.catch(error => console.error(error));
}