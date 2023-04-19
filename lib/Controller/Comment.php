<?php
namespace Hc\Houseceeper\Controller;

use Bitrix\Main\Engine\Controller;
use Hc\Houseceeper\Model\CommentTable;

class Comment extends Controller
{
	public function getComments(int $postId = 0, int $level = 0, int $maxLevel = 3, int $parentId = NULL)
	{
		$result = CommentTable::query()
			->setSelect(['*', 'user.NAME', 'user.LAST_NAME'])
			->setFilter([
				'POST_ID' => $postId,
				'PARENT_COMMENT_ID' => $parentId,
						])
			->fetchAll();
		if ($result)
		{
			foreach ($result as $comment)
			{
				echo '<div class="comment" style="padding-left: ' . ($level * 20) . 'px;">';
				echo '<div class="comment-author">' . $comment['HC_HOUSECEEPER_MODEL_COMMENT_USER_NAME']. ' '. $comment['HC_HOUSECEEPER_MODEL_COMMENT_USER_LAST_NAME'] . ':</div>';
				echo '<div class="comment-text">' . $comment['CONTENT'] . '</div>';

				if ($level > $maxLevel)
				{
					echo '<button class="show-more" data-parent="' . $parentId . '">Показать больше</button>';
					--$level;
				}
				echo '</div>';

				$this->getComments($postId, $level + 1, $maxLevel, $comment['ID']);
			}
		}
	}
}