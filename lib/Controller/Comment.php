<?php

namespace Hc\Houseceeper\Controller;

use Bitrix\Main\Context;
use Bitrix\Main\Engine\Controller;
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

	public function deleteComment(string $housePath, int $postId)
	{
		global $USER;
		$commentId = (int)Context::getCurrent()->getRequest()->getPost('commentId');

		$comment = CommentTable::getById($commentId)->fetch();
		if (!$comment) {
			LocalRedirect('/');
		}

		if (!$USER->IsAdmin() && $USER->GetID()!==$comment['USER_ID'])
		{
			LocalRedirect('/');
		}

		CommentTable::delete($commentId);

		LocalRedirect('/house/'. $housePath .  '/post/'. $postId);
	}
}