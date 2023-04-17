<?php

namespace Hc\Houseceeper\Repository;

use Hc\Houseceeper\Model\HouseTable;
use Hc\Houseceeper\Model\PostTable;

class Post
{
	public static function getPage(int $itemsPerPage, int $pageNumber, string $housePath): array
	{
		if ($pageNumber > 1)
		{
			$offset = $itemsPerPage * ($pageNumber - 1);
		}
		else
		{
			$offset = 0;
		}

		$query = HouseTable::query()
			->setSelect(['ID'])
			->setFilter([
				'UNIQUE_PATH' => $housePath
			]);

		$result = $query->fetch();

		if($result) {
			$houseId = $result['ID'];
			$query = PostTable::query()
				->setSelect(['*'])
				->setFilter([
					'HOUSE_ID' => $houseId
				]);
			return $query->fetchAll();
		}

		LocalRedirect('/');
	}
}