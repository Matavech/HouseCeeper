document.addEventListener("DOMContentLoaded", function() {
	let posts = document.querySelectorAll(".post");

	BX.ready(function(){
		hc.houseceeper.HcConstantManager.getPostConstants().then(result=>{
			hc.houseceeper.HcConstantManager.getPostConstantsRu().then(resultRu=>{
				let types = result.data;
				let typesRu = resultRu.data;
				console.log(typesRu);
				posts.forEach(function(post) {
					let typeElement = post.querySelector("#type");
					let typeText = typeElement.textContent.trim();

					if (typeText.trim() === types.HC_HOUSECEEPER_POSTTYPE_ANNOUNCEMENT) {
						typeElement.textContent = typesRu.HC_HOUSECEEPER_POSTTYPE_ANNOUNCEMENT_RU;
						typeElement.classList.add('is-warning');
					} else if (typeText.trim() === types.HC_HOUSECEEPER_POSTTYPE_DISCUSSION) {
						typeElement.textContent = typesRu.HC_HOUSECEEPER_POSTTYPE_DISCUSSION_RU;
						typeElement.classList.add('is-primary');
					} else if (typeText.trim() === types.HC_HOUSECEEPER_POSTTYPE_UNCONFIRMED) {
						typeElement.textContent = typesRu.HC_HOUSECEEPER_POSTTYPE_UNCONFIRMED_RU;
						typeElement.classList.add('is-danger');
					}
				});
			})
		});
	})
});
