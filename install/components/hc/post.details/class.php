<?php

class PostDetailsComponent extends CBitrixComponent {
	public function executeComponent()
	{
		$this->fetchPost();
		$this->includeComponentTemplate();
	}

	protected function fetchPost() {
		$post = new \Hc\Houseceeper\Controller\Post();
		$this->arResult['POST'] =  $post->getPostById($this->arParams['id']);
	}
}