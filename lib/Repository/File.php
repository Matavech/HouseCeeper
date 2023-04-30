<?php

namespace Hc\Houseceeper\Repository;

use Hc\Houseceeper\Model\BUserTable;
use Hc\Houseceeper\Model\PostFileTable;

class File
{
	protected const ACCEPTED_MIME_TYPES = [
		'image/',
		'application/pdf',
		'application/msword',
		'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
		'application/vnd.ms-excel',
		'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
		'application/vnd.ms-powerpoint',
		'application/vnd.openxmlformats-officedocument.presentationml.presentation',
	];

	protected const ACCEPTED_AVATAR_TYPES = [
		'image/',
	];

	public static function addPostFiles($postId, $files)
	{
		foreach ($files as $file) {
			$arrFile = [
				"name" => $file["name"],
				"size" => $file["size"],
				"type" => $file["type"],
				"tmp_name" => \Bitrix\Main\Application::getDocumentRoot() . '/upload/tmp' . $file["tmp_name"],
				"MODULE_ID" => "hc.houseceeper",
				"del" => "N"
			];

			var_dump($arrFile);

			$res = \CFile::CheckFile($arrFile,
				50*1024*1024,
				self::ACCEPTED_MIME_TYPES
			);

			if (strlen($res) > 0) {
				var_dump($res);
			} else {
				$fileId = \CFile::SaveFile(
					$arrFile,
					"post-files/{$postId}",
					'',
					'',
					'',
					false
				);
				if ($fileId){
					$result = PostFileTable::add([
						'POST_ID' => $postId,
						'FILE_ID' => $fileId
					]);
					if (!$result) {
						var_dump($result->getErrors());
					}
				}
			}
		}
	}

	public static function deletePostFiles($postId)
	{
		$query = PostFileTable::getList([
			'select' => ['*'],
			'filter' => ['POST_ID' => $postId]
		])->fetchCollection();

		foreach ($query as $obj)
		{
			\CFile::Delete($obj->getFileId());
			$obj->delete();
		}

		\Bitrix\Main\IO\Directory::deleteDirectory(\Bitrix\Main\Application::getDocumentRoot() . '/upload/post-files/' . $postId);
	}

	public static function changeAvatar($userId, $file)
	{
		$arrFile = [
			"name" => $file["name"],
			"size" => $file["size"],
			"type" => $file["type"],
			"tmp_name" => \Bitrix\Main\Application::getDocumentRoot() . '/upload/tmp' . $file["tmp_name"],
			"MODULE_ID" => "hc.houseceeper",
			"del" => "N"
		];


		$error = \CFile::CheckFile($arrFile,
								 10*1024*1024,
								 self::ACCEPTED_AVATAR_TYPES
		);
		if ($error)
		{
			return $error;
		}
		\CFile::ResizeImage(
			$arrFile,
			[
				'width' => 300,
				'height' => 300
			],
			'BX_RESIZE_IMAGE_EXACT'
				  );

		$fileId = self::saveAvatar($userId, $arrFile);
		if ($fileId)
		{
			self::deleteAvatar($userId);
		}
		if (!User::setAvatar($userId, $fileId))
		{
			return false;
		}
	}

	public static function saveAvatar($userId, $file)
	{
		$fileId = \CFile::SaveFile(
			$file,
			"user-avatars/{$userId}",
			'',
			'',
			'',
			false
		);
		return $fileId;
	}

	public static function deleteAvatar($userId)
	{
		$oldAvatarId = User::getUserAvatarId($userId);

		if ($oldAvatarId) {
			$oldAvatar = \CFile::GetByID($oldAvatarId);
			\Bitrix\Main\IO\Directory::deleteDirectory(\Bitrix\Main\Application::getDocumentRoot() . '/upload/' . $oldAvatar->arResult[0]['SUBDIR']);
		}
	}
}