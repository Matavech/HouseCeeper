function generateLink(event) {
	event.preventDefault();

	const houseId = document.querySelector("input[name='house-id']").value;
	const number = document.querySelector("input[name='number']").value;

	fetch(`/create-reg-link?house-id=${houseId}&number=${number}`)
		.then(response => response.text())
		.then(inviteLink => {

			const inviteLinkElement = document.getElementById("invite-link");
			inviteLinkElement.textContent = inviteLink;
		})
		.catch(error => console.error(error));
}