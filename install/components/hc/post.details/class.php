<?php

class PostDetailsComponent extends CBitrixComponent {
	public function executeComponent()
	{
		$this->fetchPost();
		$this->fetchComments();
		$this->includeComponentTemplate();
	}

	protected function fetchPost()
	{
		$post = new \Hc\Houseceeper\Controller\Post();
		$this->arResult['POST'] =  $post->getPostById($this->arParams['id']);
	}

	protected function fetchComments()
	{
		$comment = new \Hc\Houseceeper\Controller\Comment();
		$comment->getComments($this->arParams['id']);
	}
}