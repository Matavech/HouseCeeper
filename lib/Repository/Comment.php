<?php

namespace Hc\Houseceeper\Repository;

use Hc\Houseceeper\Model\CommentTable;

class Comment
{
	public static function addItem(int $postId, int $userId, string $content, int $parentId = NULL)
	{
		$result = CommentTable::add([
			'POST_ID' => $postId,
			'USER_ID' => $userId,
			'PARENT_COMMENT_ID' => $parentId,
			'CONTENT' => $content,
						  ]);
		return $result;
	}

	public static function getCommentList($postId, $parentId)
	{
		$result = CommentTable::query()
			->setSelect(['*', 'user.NAME', 'user.LAST_NAME'])
			->setFilter([
				'POST_ID' => $postId,
				'PARENT_COMMENT_ID' => $parentId,
			])
			->setOrder([
				'DATETIME_CREATED' => 'DESC',
			]);
		return $result->fetchAll();
	}

	public static function getChildComments(int $commentId)
	{
		return CommentTable::query()
			->setSelect(['ID'])
			->setFilter(['PARENT_COMMENT_ID' => $commentId])
			->fetchAll();
	}

	public static function getMainComments(int $postId)
	{
		return CommentTable::query()
			->setSelect(['ID'])
			->setFilter([
				'POST_ID' => $postId,
				'PARENT_COMMENT_ID' => NULL,
			])
			->fetchAll();
	}
}