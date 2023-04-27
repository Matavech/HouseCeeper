document.addEventListener("DOMContentLoaded", function() {
	let posts = document.querySelectorAll(".post");

	BX.ready(function(){
		hc.houseceeper.HcConstantManager.getPostConstants().then(result=>{
			let types = result.data;
			posts.forEach(function(post) {
				let typeElement = post.querySelector("#type");
				let typeText = typeElement.textContent.trim();

				if (typeText.trim() === types.HC_HOUSECEEPER_POSTTYPE_ANNOUNCEMENT) {
					typeElement.textContent = 'Объявление';
					typeElement.classList.add('is-success');
				} else if (typeText.trim() === types.HC_HOUSECEEPER_POSTTYPE_DISCUSSION) {
					typeElement.textContent = 'Обсуждение';
					typeElement.classList.add('is-success');
				} else if (typeText.trim() === types.HC_HOUSECEEPER_POSTTYPE_UNCONFIRMED) {
					typeElement.textContent = 'Неподтвержден';
					typeElement.classList.add('is-success');
				}
			});
		});
	})
});
