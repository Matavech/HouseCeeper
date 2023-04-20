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
}