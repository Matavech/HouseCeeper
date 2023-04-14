<?php

class PostListComponent extends CBitrixComponent {
	public function executeComponent()
	{
		$this->fetchPostList();
		$this->includeComponentTemplate();
	}

	protected function fetchPostList()
	{
		$this->arResult['POST'] = Hc\Houseceeper\Repository\Post::getPage(20, 1);
	}
}