<?php

namespace Hc\Houseceeper\Controller;

use Bitrix\Main\Context;
use Bitrix\Main\Engine;
use Bitrix\Main\Error;
use Bitrix\Main\Type\Date;
use Bitrix\Main\Type\DateTime;
use Hc\Houseceeper\Model\PostTable;
use Hc\Houseceeper\Repository;

class Post extends Engine\Controller
{
	protected const PROJECT_PER_PAGE = 3;

	public function getListAction(string $housePath, ?string $postType): ?array
	{
		$navObject = new \Bitrix\Main\UI\PageNavigation('nav');
		$navObject->allowAllRecords(false)
			->setPageSize(self::PROJECT_PER_PAGE)
			->initFromUri();

		$postList = Repository\Post::getPage($navObject, $housePath, $postType);

		return [
			'postList' => $postList,
			'navObject' => $navObject,
		];
	}

	public function addNewPostForHouse(string $housePath)
	{
		global $USER;
		$request = Context::getCurrent()->getRequest();
		if (!$USER->IsAdmin() && !Repository\User::isHeadman($USER->GetID()))
		{
			$postType = 'unconfirmed';
		}
		else
		{
			$postType = trim($request->getPost('post-type'));
		}
		$postCaption = trim($request->getPost('post-caption'));
		$postBody = trim($request->getPost('post-body'));
		$files = $request->getFileList()['files'];

		global $USER;
		$userId = $USER->GetID();
		$houseId = Repository\House::getIdByPath($housePath);
		$postTypeId = Repository\Post::getPostTypeId($postType);

		if ($houseId && $postTypeId) {
			$result = Repository\Post::addPost($houseId, $userId, $postCaption, $postBody, $postTypeId);

			if ($result->isSuccess()) {
				if($files['error'][0] === 0)
				{
					$postId = $result->getId();
					Repository\File::addPostFiles($postId,$files, $result->getId());
				}
				//echo 'Post has been added successfully';
				LocalRedirect('/');
			} else {
				$errors = $result->getErrors();
				foreach ($errors as $error) {
					echo $error->getMessage();
				}
			}
		} else {
			echo 'Wrong post type or house path';
		}
	}

	public function getPostById($id)
	{
		$post = Repository\Post::getDetails((int)$id);
		$allFiles = Repository\Post::getPostFiles($id);
		$post['IMAGES'] = $allFiles['IMAGES'];
		$post['FILES'] = $allFiles['FILES'];

		$user = new User();
		$post['USER'] = $user->getUserName((int)$post['USER_ID']);

		return $post;
	}

	public function deletePost(string $housePath, int $id)
	{
		global $USER;
		if (!$USER->IsAdmin() && !Repository\User::isHeadman($USER->GetID()))
		{
			echo ('Вам нельзя такое');
			return;
		}

		PostTable::delete($id);
		LocalRedirect('/house/' . $housePath);
	}

	public function confirmPost(string $housePath, int $id)
	{
		global $USER;
		if (!$USER->IsAdmin() && !Repository\User::isHeadman($USER->GetID()))
		{
			echo ('Вам нельзя такое');
			return;
		}

		$query = PostTable::getByPrimary($id)->fetchObject();
		$query->set('TYPE_ID', 2);
		$query->save();
		LocalRedirect('/house/' . $housePath . '/post/' . $id);
	}
}