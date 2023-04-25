<?php

class PostDetailsComponent extends CBitrixComponent {
	public function executeComponent()
	{
		\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);
		$this->fetchPost();
		$this->includeComponentTemplate();
	}

	protected function fetchPost()
	{
		$post = new \Hc\Houseceeper\Controller\Post();
		$this->arResult['POST'] =  $post->getPostById($this->arParams['id']);
		$this->arResult['POST']['DATETIME_CREATED'] = FormatDate('X', $this->arResult['POST']['DATETIME_CREATED']);
	}
}