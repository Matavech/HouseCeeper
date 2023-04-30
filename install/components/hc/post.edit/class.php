<?php

class PostEditComponent extends CBitrixComponent {
	public function executeComponent()
	{
		$this->fetchPost();
		$this->arResult['POST']['ADDFILE'] = $this->prepareFileInput();
		$this->includeComponentTemplate();
	}

	protected function fetchPost()
	{
		$post = new \Hc\Houseceeper\Controller\Post();
		$this->arResult['POST'] =  $post->getPostById($this->arParams['id']);
		$this->arResult['POST']['DATETIME_CREATED'] = FormatDate('X', $this->arResult['POST']['DATETIME_CREATED']);
	}
	protected function prepareFileInput()
	{
		return \Bitrix\Main\UI\FileInput::createInstance(
			[
				"name" => "files[#IND#]",
				"description" => true,
				"upload" => true,
				"allowUpload" => "A",
				"medialib" => true,
				"fileDialog" => true,
				"delete" => true,
				"maxCount" => 10,
				"maxSize" => 50*1024*1024
			]);
	}
}