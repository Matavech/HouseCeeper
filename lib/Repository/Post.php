<?php

namespace Hc\Houseceeper\Repository;

use Hc\Houseceeper\Model\BUserTable;
use Hc\Houseceeper\Model\HouseTable;
use Hc\Houseceeper\Model\PostFileTable;
use Hc\Houseceeper\Model\PostTable;
use Hc\Houseceeper\Model\PostTypeTable;

class Post
{
	public static function getPage($navObject, string $housePath, ?string $postType): array
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
				'HOUSE_ID' => $houseId,
				$postType ? ['TYPE.NAME' => $postType] : ''
			]));

			if ($postType)
			{
				$postTypeId = PostTypeTable::query()
					->setSelect(['ID'])
					->setFilter(['NAME'=>$postType])
					->fetch()['ID'];
			}

			// $result = PostTable::getList([
			// 	'select' => ['*', 'TYPE.NAME'],
			// 	'filter' => ['HOUSE_ID' => $houseId, 'TYPE_ID' => $postTypeId],
			// 	'order' => ['DATETIME_CREATED' => 'DESC'],
			// 	'offset' => $navObject->getOffset(),
			// 	'limit' => $navObject->getLimit()
			// ]);
			//

			$query = PostTable::query()
				->setSelect(['*', 'TYPE.NAME'])
				->setFilter(['HOUSE_ID' => $houseId])
				->setOrder(['DATETIME_CREATED' => 'DESC'])
				->setOffset($navObject->getOffset())
				->setLimit($navObject->getLimit());
			if ($postType)
			{
				$query->addFilter('TYPE_ID' , $postTypeId);
			}
			return $query->fetchAll();
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

	public static function addPost($houseId, $userId, $postCaption, $postBody, $postTypeId)
	{
		return PostTable::add([
			'HOUSE_ID' => $houseId,
			'USER_ID' => $userId,
			'TITLE' => $postCaption,
			'CONTENT' => $postBody,
			'TYPE_ID' => $postTypeId,
		]);
	}

	public static function getPostFiles($postId)
	{
		$result = PostFileTable::getList([
			'select' => ['FILE_ID'],
			'filter' => ['=POST_ID' => $postId]
		])->fetchAll();

		if (empty($result))
		{
			return [];
		}

		$fileId = [];
		foreach ($result as $file)
		{
			$fileId[] = $file['FILE_ID'];
		}

		$result = \CFile::GetList(
			['ID' => 'asc'],
			['@ID' => $fileId]
		);

		$fileList = ['FILES' => [], 'IMAGES' => []];
		while ($file = $result->Fetch())
		{
			if(\CFile::IsImage($file['FILE_NAME']))
			{
				$fileList['IMAGES'][] = $file;
			}
			else
			{
				$fileList['FILES'][] = \CFile::GetFileArray($file['ID']);
			}
		}

		return $fileList;
	}
}