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
				$fileId = \CFile::SaveFile($arrFile, "post-files/{$postId}");
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
}