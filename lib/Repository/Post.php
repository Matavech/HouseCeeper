<?php

namespace Hc\Houseceeper\Repository;

use Hc\Houseceeper\Model\PostTable;

class Post
{
	public static function getPage(int $itemsPerPage, int $pageNumber): array
	{
		if ($pageNumber > 1)
		{
			$offset = $itemsPerPage * ($pageNumber - 1);
		}
		else
		{
			$offset = 0;
		}

		$postList = PostTable::getList()->fetchAll();

		return $postList;
	}
}