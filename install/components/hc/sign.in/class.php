<?php

class SignInComponent extends CBitrixComponent {
	public function executeComponent()
	{
		$this->fetchError();
		$this->includeComponentTemplate();
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