<?php

namespace Hc\Houseceeper\Repository;

use Bitrix\Main\Type\DateTime;
use Hc\HouseCeeper\Constant\PostType;
use Hc\Houseceeper\Model\BUserTable;
use Hc\Houseceeper\Model\HouseTable;
use Hc\Houseceeper\Model\PostFileTable;
use Hc\Houseceeper\Model\PostTable;
use Hc\Houseceeper\Model\PostTypeTable;

class Post
{
	public static function getPage($navObject, string $houseId, ?string $postType, $search): array
	{
		global $USER;
		$seeUnconfirmed = $USER->IsAdmin() || User::isHeadman($USER->GetID(), $houseId);

		$query = PostTable::query()
			->setSelect(['*', 'TYPE.NAME'])
			->setFilter(['HOUSE.ID' => $houseId])
			->setOrder(['DATETIME_CREATED' => 'DESC']);

		if ($postType) {
			$query->addFilter('TYPE.NAME', $postType);
		}

		if (!$seeUnconfirmed) {
			$query->addFilter('!=TYPE.NAME', PostType::HC_HOUSECEEPER_POSTTYPE_UNCONFIRMED);
		}

		if ($search){
			$query->addFilter('%TITLE', $search);
		}

		$navObject->setRecordCount(count($query->fetchAll()));

		$query->setOffset($navObject->getOffset())
			->setLimit($navObject->getLimit());

		$result = $query->fetchAll();

		if($result)
			return $result;
		return [];
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
				'*', 'TYPE.NAME',
			])
			->setFilter([
				'ID' => $id,
			]);

		$result = $query->fetch();
		if (!$result) {
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

		if (empty($result)) {
			return [];
		}

		$fileId = [];
		foreach ($result as $file) {
			$fileId[] = $file['FILE_ID'];
		}

		$result = \CFile::GetList(
			['ID' => 'asc'],
			['@ID' => $fileId]
		);

		$fileList = ['FILES' => [], 'IMAGES' => []];
		while ($file = $result->Fetch()) {
			if (\CFile::IsImage($file['FILE_NAME'])) {
				$fileList['IMAGES'][] = $file;
			} else {
				$fileList['FILES'][] = \CFile::GetFileArray($file['ID']);
			}
		}

		return $fileList;
	}

	public static function acceptPost($postId)
	{
		$query = PostTable::getByPrimary($postId)
			->fetchObject();
		if($query){
			$query->set('DATETIME_CREATED', new DateTime())
				->set('TYPE_ID', 2)
				->save();
		}
	}

	public static function updateGeneral($postId, $postTitle, $postContent, $postTypeId)
	{
		$post = PostTable::getById($postId)->fetchObject();
		$post
			->setTitle($postTitle)
			->setContent($postContent)
			->setTypeId($postTypeId);
		return $post->save();
	}

	public static function getPostHouseId($postId)
	{
		return PostTable::getById($postId)->fetchObject()->getHouseId();
	}
}