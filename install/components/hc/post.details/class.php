<?php

class PostDetailsComponent extends CBitrixComponent {
	public function executeComponent()
	{
		$this->fetchPost();
		$this->fetchError();
		$this->includeComponentTemplate();
	}

	protected function fetchPost()
	{
		$post = new \Hc\Houseceeper\Controller\Post();
		$this->arResult['POST'] =  $post->getPostById($this->arParams['id']);
		$this->arResult['POST']['DATETIME_CREATED'] = FormatDate('X', $this->arResult['POST']['DATETIME_CREATED']);
	}

	public function fetchError()
	{
//		$this->arResult['ERRORS'] = $this->arParams['errors'];
//		$this->arResult['ERRORS'] = \Hc\Houseceeper\Errors::fetchErrors();
	}
}