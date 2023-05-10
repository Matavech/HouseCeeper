<?php

class ErrorsMessageComponent extends CBitrixComponent {
	public function executeComponent()
	{
		$this->fetchErrors();
		$this->includeComponentTemplate();
	}
	public function fetchErrors()
	{
		$errors = \Bitrix\Main\Application::getInstance()->getSession()->get('errors');
		if ($errors)
		{
			foreach ($errors as $error)
			{
				$this->arParams['ERRORS'][] = $error;
			}
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', []);
		}
	}
}