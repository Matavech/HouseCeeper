<?php

namespace Hc\Houseceeper\Controller;

use Bitrix\Main\Context;
use Bitrix\Main\Engine\Controller;
use Hc\HouseCeeper\Constant\PostType;
use Hc\Houseceeper\Model\CommentTable;
class Comment extends Controller
{
	public function getComments(int $postId = 0, int $level = 0, int $maxLevel = 3, string $order = 'DESC', int $parentId = NULL)
	{
		$result = CommentTable::query()
			->setSelect(['*', 'user.NAME', 'user.LAST_NAME'])
			->setFilter([
				'POST_ID' => $postId,
				'PARENT_COMMENT_ID' => $parentId,
						])
			->setOrder([
				'DATETIME_CREATED' => 'DESC',
					   ])
			->fetchAll();
		if ($result)
		{
			foreach ($result as $comment)
			{
				$APPLICATION = new \CMain();
				$APPLICATION->IncludeComponent('hc:comment', '', [
					'COMMENT' => $comment,
					'LEVEL' => $level,
				], 'hc:post.details' );

				if ($level > $maxLevel)
				{
					--$level;
				}
				if ($level>=0)
				{
					$order = 'ASC';
				}
				$this->getComments($postId, $level + 1, $maxLevel, $order, $comment['ID']);
			}
		}

	}

	public function addComment(string $housePath,  int $postId)
	{
		$post = \Hc\Houseceeper\Repository\Post::getDetails($postId);
		if ($post['HC_HOUSECEEPER_MODEL_POST_TYPE_NAME'] === PostType::HC_HOUSECEEPER_POSTTYPE_ANNOUNCEMENT)
		{
			echo 'Каким-то образом вы смогли попытаться добавить комментарий к объявлению. Мы это предусмотрели, так нельзя';
		}

		$request = Context::getCurrent()->getRequest();
		global $USER;


		$content = trim($request->getPost('content'));

		$parentId = (int)$request->getPost('parentId');
		$parentId = $parentId === 0 ? NULL : $parentId;


		$userId = $USER->GetID();

		$result = \Hc\Houseceeper\Repository\Comment::addItem($postId, $userId, $content, $parentId);
		if ($result->isSuccess())
		{
			LocalRedirect('/house/'. $housePath .  '/post/'. $postId);
		}
		else
		{

			foreach ($result->getErrorMessages() as $message)
			{
				echo $message;
			}
		}
	}

	public function deleteComment(int $commentId = 0, bool $ignoreCheck = FALSE)
	{
		global $USER;
		if (!$commentId)
		{
			$commentId = (int)Context::getCurrent()->getRequest()->getPost('commentId');
		}
		$houseId = (int)Context::getCurrent()->getRequest()->getPost('houseId');

		$comment = CommentTable::getById($commentId)->fetch();
		if (!$comment) {
			LocalRedirect('/');
		}
		if (!$ignoreCheck)
		{
			if (!$USER->IsAdmin() && !\Hc\Houseceeper\Repository\User::isHeadman($USER->GetID(), $houseId) && $USER->GetID()!==$comment['USER_ID'])
			{
				echo ('Вы не являетесь автором этого комментария');
				return;
			}
		}

		$childComments = $this->findChildComments($commentId);

		if ($childComments)
		{
			foreach ($childComments as $childComment)
			{
				$this->deleteComment($childComment['ID'], TRUE);
			}
		}
		CommentTable::delete($commentId);
	}

	public function findChildComments(int $commentId)
	{
		return CommentTable::query()
					->setSelect(['ID'])
					->setFilter(['PARENT_COMMENT_ID' => $commentId])
					->fetchAll();
	}


	public function deletePostComments(int $postId)
	{
		foreach( CommentTable::query()
			->setSelect(['ID'])
			->setFilter([
				'POST_ID' => $postId,
				'PARENT_COMMENT_ID' => NULL,
						])
			->fetchAll()
		as $comment)
		{
			$this->deleteComment($comment['ID']);
		}
	}
}