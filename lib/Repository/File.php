<?php

namespace Hc\Houseceeper\Repository;

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

	public const ACCEPTED_AVATAR_TYPES = [
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

	public static function deleteAllPostFiles($postId)
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

	public static function deletePostFiles($postId, $fileIds)
	{
		$query = PostFileTable::getList([
			'select' => ['*'],
			'filter' => [
				'POST_ID' => $postId,
				'@FILE_ID' => $fileIds
			]
		])->fetchCollection();

		foreach ($query as $obj)
		{
			\CFile::Delete($obj->getFileId());
			$filePath = \CFile::GetPath($obj->getFileId());
			unlink($_SERVER["DOCUMENT_ROOT"] . $filePath);
			$obj->delete();
		}
	}

	public static function saveAvatar($userId, $file)
	{
		return \CFile::SaveFile(
			$file,
			"user-avatars/{$userId}",
			'',
			'',
			'',
			false
		);
	}

	public static function deleteFile($id)
	{
		$file = \CFile::GetByID($id);
		if ($file)
		{
			\Bitrix\Main\IO\Directory::deleteDirectory(\Bitrix\Main\Application::getDocumentRoot() . '/upload/' . $file->arResult[0]['SUBDIR']);
		}
	}
}