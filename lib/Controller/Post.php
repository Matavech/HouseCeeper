<?php

namespace Hc\Houseceeper\Controller;

use Bitrix\Main\Context;
use Bitrix\Main\DB\Exception;
use Bitrix\Main\Engine;
use Bitrix\Main\Error;
use Bitrix\Main\Type\Date;
use Bitrix\Main\Type\DateTime;
use Hc\HouseCeeper\Constant\PostType;
use Hc\Houseceeper\Model\PostTable;
use Hc\Houseceeper\Repository;

class Post extends Engine\Controller
{
	protected const POST_PER_PAGE = 5;
	protected const MAX_FILE_COUNT = 10;

	public function getListAction(string $houseId, ?string $postType, ?string $search): ?array
	{
		$navObject = new \Bitrix\Main\UI\PageNavigation('nav');
		$navObject->allowAllRecords(false)
			->setPageSize(self::POST_PER_PAGE)
			->initFromUri();

		$postList = Repository\Post::getPage($navObject, $houseId, $postType, trim($search));

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
			$postType = PostType::HC_HOUSECEEPER_POSTTYPE_UNCONFIRMED;
		}
		else
		{
			$postType = trim($request->getPost('post-type'));
		}
		$postCaption = trim($request->getPost('post-caption'));
		$postBody = trim($request->getPost('post-body'));
		$files = $request->getPost('files');

		global $USER;
		$userId = $USER->GetID();
		$postTypeId = Repository\Post::getPostTypeId($postType);

		if (count($files) > self::MAX_FILE_COUNT)
		{
			$errors[] =  'Вы не можете загрузить более ' . self::MAX_FILE_COUNT . ' файлов';
		}

		if ($houseId && $postTypeId) {
			$result = Repository\Post::addPost($houseId, $userId, $postCaption, $postBody, $postTypeId);

			if ($result->isSuccess()) {
				if(!is_null($files)) // Если хотя бы есть 1 файл
				{
					$postId = $result->getId();
					Repository\File::addPostFiles($postId, $files);
				}
				//echo 'Post has been added successfully';
				LocalRedirect('/house/'.$housePath);
			} else {
				foreach ($result->getErrors() as $error) {
					$errors[] = $error->getMessage();
				}
			}
		}
		else
		{
			$errors[] = 'Неверный тип поста или путь к дому';
		}
		if ($errors)
		{
//			$APPLICATION = new \CMain();
//			$APPLICATION->IncludeComponent('hc:post.add', '', [
//				'errors' => $errors,
//				'housePath' => $housePath,
//			]);
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect('/house/'.$housePath.'/add-post');
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
		Repository\File::deleteAllPostFiles($id);
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
		Repository\Post::acceptPost($id);
		LocalRedirect('/house/' . $housePath . '/post/' . $id);
	}

	public function update($postId, $postTitle, $postContent, $postType, $filesToAdd, $fileIdsToDelete)
	{
		$postId = (int)$postId;
		$postTitle = trim($postTitle);
		$postContent = trim($postContent);
		$postType = trim($postType);

		$post = Repository\Post::getDetails($postId);
		if (!$post)
		{
			$errors[] = 'Пост не найден';
		}
		global $USER;
		if (!$USER->IsAdmin() && !Repository\User::isHeadman($USER->GetId(), Repository\Post::getPostHouseId($postId)))
		{
			$errors[] = 'Вам нельзя';
		}

		$postTypeId = Repository\Post::getPostTypeId($postType);
		if (!$postTypeId)
		{
			$errors[] = 'Недопустимый тип поста';
		}

		$result = Repository\Post::updateGeneral($postId, $postTitle, $postContent, $postTypeId);
		if ($result->isSuccess())
		{
			Repository\File::deletePostFiles($postId, $fileIdsToDelete);
			Repository\File::addPostFiles($postId, $filesToAdd);
			return True;
		}

		foreach ($result->getErrors() as $error) {
			$errors[] = $error->getMessage();
		}

		\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
		LocalRedirect('edit');
		return $result->getErrorMessages();
	}
}