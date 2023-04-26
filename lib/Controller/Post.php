<?php

namespace Hc\Houseceeper\Controller;

use Bitrix\Main\Context;
use Bitrix\Main\DB\Exception;
use Bitrix\Main\Engine;
use Bitrix\Main\Error;
use Bitrix\Main\Type\Date;
use Bitrix\Main\Type\DateTime;
use Hc\Houseceeper\Model\PostTable;
use Hc\Houseceeper\Repository;

class Post extends Engine\Controller
{
	protected const POST_PER_PAGE = 5;
	protected const MAX_FILE_COUNT = 10;

	public function getListAction(string $houseId, ?string $postType): ?array
	{
		$navObject = new \Bitrix\Main\UI\PageNavigation('nav');
		$navObject->allowAllRecords(false)
			->setPageSize(self::POST_PER_PAGE)
			->initFromUri();

		$postList = Repository\Post::getPage($navObject, $houseId, $postType);

		return [
			'postList' => $postList,
			'navObject' => $navObject,
		];
	}

	public function addNewPostForHouse(string $housePath)
	{
		global $USER;
		$houseId = Repository\House::getIdByPath($housePath);
		$request = Context::getCurrent()->getRequest();
		if (!$USER->IsAdmin() && !Repository\User::isHeadman($USER->GetID(), $houseId))
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
		$postTypeId = Repository\Post::getPostTypeId($postType);

		if (count($files['name']) > self::MAX_FILE_COUNT)
		{
			echo 'Вы не можете загрузить более ' . self::MAX_FILE_COUNT . ' файлов';
			return;
		}

		if ($houseId && $postTypeId) {
			$result = Repository\Post::addPost($houseId, $userId, $postCaption, $postBody, $postTypeId);

			if ($result->isSuccess()) {
				if($files['error'][0] === 0) // Если хотя бы есть 1 файл
				{
					$postId = $result->getId();
					Repository\File::addPostFiles($postId,$files, $result->getId());
				}
				//echo 'Post has been added successfully';
				LocalRedirect('/house/'.$housePath);
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
		if (!$USER->IsAdmin() && !Repository\User::isHeadman($USER->GetID(), Repository\House::getIdByPath($housePath)))
		{
			echo ('Вам нельзя такое');
			return;
		}
		$comment = new Comment();
		$comment->deletePostComments($id);
		PostTable::delete($id);
		LocalRedirect('/house/' . $housePath);
	}

	public function confirmPost(string $housePath, int $id)
	{
		global $USER;
		if (!$USER->IsAdmin() && !Repository\User::isHeadman($USER->GetID(), Repository\House::getIdByPath($housePath)))
		{
			echo ('Вам нельзя такое');
			return;
		}

		$query = PostTable::getByPrimary($id)->fetchObject();
		$query->set('DATETIME_CREATED', new DateTime());
		$query->set('TYPE_ID', 2);
		$query->save();
		LocalRedirect('/house/' . $housePath . '/post/' . $id);
	}
}