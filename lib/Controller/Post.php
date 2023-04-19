<?php
namespace Hc\Houseceeper\Controller;

use Bitrix\Main\Context;
use Bitrix\Main\Engine;
use Bitrix\Main\Error;
use Hc\Houseceeper\Model\PostTable;
use Hc\Houseceeper\Repository;

class Post extends Engine\Controller
{
	protected const PROJECT_PER_PAGE = 20;
//	protected function getDefaultPreFilters(): array
//	{
//		return [
//			new ActionFilter\ApiKeyAuthorization(),
//		];
//	}

	public function getListAction(string $housePath,int $pageNumber = 1): ?array
	{
		if ($pageNumber < 0)
		{
			$this->addError(new Error('pageNumber should be greater than 0', 'invalid_page_number'));

			return null;
		}

		$postList = Repository\Post::getPage(self::PROJECT_PER_PAGE, $pageNumber, $housePath);

		return [
			'pageNumber' => $pageNumber,
			'postList' => $postList,
		];
	}

	public function addNewPostForHouse(string $housePath)
	{
		$request = Context::getCurrent()->getRequest();
		$postCaption = trim($request->getPost('post-caption'));
		$postBody = trim($request->getPost('post-body'));
		$postType = trim($request->getPost('post-type'));

		global $USER;
		$userId = $USER->GetID();
		$houseId = Repository\House::getIdByPath($housePath);
		$postTypeId = Repository\Post::getPostTypeId($postType);

		if ($houseId && $postTypeId){
			$result = PostTable::add([
				'HOUSE_ID' => $houseId,
				'USER_ID' => $userId,
				'TITLE' => $postCaption,
				'CONTENT' => $postBody,
				'TYPE_ID' => $postTypeId,
			]);

			if ($result->isSuccess()) {
				//echo 'Post has been added successfully';
				LocalRedirect('/');
			}
		} else {
			echo 'Wrong post type or house path';
		}
	}
}