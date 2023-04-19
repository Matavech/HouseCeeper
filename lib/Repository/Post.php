<?php

namespace Hc\Houseceeper\Repository;

use Hc\Houseceeper\Model\BUserTable;
use Hc\Houseceeper\Model\HouseTable;
use Hc\Houseceeper\Model\PostTable;
use Hc\Houseceeper\Model\PostTypeTable;

class Post
{
	public static function getPage($navObject, string $housePath): array
	{
		$query = HouseTable::query()
			->setSelect(['ID'])
			->setFilter([
				'UNIQUE_PATH' => $housePath
			]);

		$result = $query->fetch();

		if($result) {
			$houseId = $result['ID'];
			$navObject->setRecordCount(PostTable::getCount([
				'HOUSE_ID' => $houseId
			]));

			$result = PostTable::getList([
				'select' => ['*', 'TYPE.NAME'],
				'filter' => ['HOUSE_ID' => $houseId],
				'offset' => $navObject->getOffset(),
				'limit' => $navObject->getLimit()
			]);
			return $result->fetchAll();

//			$query = PostTable::query()
//				->setSelect(['*', 'TYPE.NAME'])
//				->setFilter([
//					'HOUSE_ID' => $houseId
//				]);
//			return $query->fetchAll();
		}

		LocalRedirect('/');
	}

	public static function getPostTypeId(string $postType)
	{
		$query = PostTypeTable::query()
			->setSelect(['ID'])
			->setFilter([
				'NAME' => $postType
			]);

		$result = $query->fetch();

		if ($result) {
			return $result['ID'];
		}
		return false;
	}

	public static function getDetails(string $id)
	{
		$query = PostTable::query()
			->setSelect([
				'*', 'TYPE.NAME', 'USER.IMAGE_PATH',
							])
			->setFilter([
				'ID' => $id,
						]);

		$result = $query->fetch();
		if (!$result)
		{
			return false;
		}

		return $result;
	}
}