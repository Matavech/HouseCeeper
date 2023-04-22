<?php

class CommentComponent extends CBitrixComponent {
	public function executeComponent()
	{
		$this->prepareComponentParams();
		$this->includeComponentTemplate();
	}

	protected function prepareComponentParams()
	{
		$this->arParams['COMMENT']['DATETIME_CREATED'] = FormatDate('X', $this->arParams['COMMENT']['DATETIME_CREATED']);
	}
}