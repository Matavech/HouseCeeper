<?php

class PostListComponent extends CBitrixComponent {

	public function executeComponent()
	{
		\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);
		$this->fetchPostList();
		$this->includeComponentTemplate();
	}

	protected function fetchPostList()
	{
		$postList = new \Hc\Houseceeper\Controller\Post();
		$list = $postList->getListAction($this->arParams['housePath'], $this->arParams['postType']);
		$this->arResult['POSTS'] = $list['postList'];
		foreach ($this->arResult['POSTS'] as $key => $post)
		{
			$this->arResult['POSTS'][$key]['DATETIME_CREATED'] = FormatDate('X', $post['DATETIME_CREATED']);
		}
		$this->arResult['NAV_OBJECT'] = $list['navObject'];
	}
}