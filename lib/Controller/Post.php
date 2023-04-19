<?php
namespace Hc\Houseceeper\Controller;

use Bitrix\Main\Context;
use Bitrix\Main\Engine;
use Bitrix\Main\Error;
use Hc\Houseceeper\Model\PostTable;
use Hc\Houseceeper\Repository;

class Post extends Engine\Controller
{
	protected const PROJECT_PER_PAGE = 3;

	public function getListAction(string $housePath): ?array
	{
		$navObject = new \Bitrix\Main\UI\PageNavigation('nav');
		$navObject->allowAllRecords(false)
			->setPageSize(self::PROJECT_PER_PAGE)
			->initFromUri();

		$postList = Repository\Post::getPage($navObject, $housePath);

		return [
			'postList' => $postList,
			'navObject' => $navObject,
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

	public function getPostById($id)
	{
		$post = Repository\Post::getDetails((int)$id);

		$user = new User();
		$post['USER'] = $user->getUserName((int)$post['USER_ID']);

		return $post;
	}
}