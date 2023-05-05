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
		$errors = \Bitrix\Main\Application::getInstance()->getSession()->get('errors');
		if ($errors)
		{
			foreach ($errors as $error)
			{
				$this->arResult['ERRORS'][] = '<div class="error">' . htmlspecialcharsbx($error) . '</div>';
			}
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', []);
		}
	}
}