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
		$result = \Hc\Houseceeper\Repository\Comment::getCommentList($postId, $parentId);
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

	public function addCommentAction(string $housePath, int $postId, $content, $parentId = 0)
	{
		\Hc\Houseceeper\Controller\User::checkAccessToHouse();
		$post = \Hc\Houseceeper\Repository\Post::getDetails($postId);
		if ($post['HC_HOUSECEEPER_MODEL_POST_TYPE_NAME'] === PostType::HC_HOUSECEEPER_POSTTYPE_ANNOUNCEMENT)
		{
			$errors[] =  'Каким-то образом вы смогли попытаться добавить комментарий к объявлению. Мы это предусмотрели, так нельзя';
		} else {
			global $USER;
			$userId = $USER->GetID();
			$content = trim($content);
			$parentId = (int)$parentId;

			$result = \Hc\Houseceeper\Repository\Comment::addItem($postId, $userId, $content, $parentId);

			if ($result->isSuccess())
			{
				LocalRedirect('/house/'. $housePath .  '/post/'. $postId);
			}
			else
			{
				foreach ($result->getErrorMessages() as $message)
				{
					$errors[] = $message;
				}
			}
		}

		if ($errors)
		{
//			$APPLICATION = new \CMain();
//			$APPLICATION->IncludeComponent('hc:post.details', '', [
//				'errors' => $errors,
//				'id' => $postId,
//				'housePath' => $housePath,
//			]);
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect('/house/'. $housePath .  '/post/'. $postId);
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

		$childComments = \Hc\Houseceeper\Repository\Comment::getChildComments($commentId);

		if ($childComments)
		{
			foreach ($childComments as $childComment)
			{
				$this->deleteComment($childComment['ID'], TRUE);
			}
		}
		CommentTable::delete($commentId);
	}

	public function deletePostComments(int $postId)
	{
		$commentList = \Hc\Houseceeper\Repository\Comment::getMainComments($postId);
		foreach($commentList as $comment)
		{
			$this->deleteComment($comment['ID']);
		}
	}
}