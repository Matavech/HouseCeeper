<?php

namespace Hc\Houseceeper\Repository;

use Hc\Houseceeper\Model\BFileTable;
use Hc\Houseceeper\Model\PostFileTable;
use Hc\Houseceeper\Model\PostTable;

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

	public static function addPostFiles($postId, $files, $savePath)
	{
		$count = count($files["name"]);
		for ($i = 0; $i < $count; $i++) {
			$arrFile = [
				"name" => $files["name"][$i],
				"size" => $files["size"][$i],
				"type" => $files["type"][$i],
				"tmp_name" => $files["tmp_name"][$i],
				"MODULE_ID" => "hc.houseceeper",
				"del" => "N"
			];

			$res = \CFile::CheckFile($arrFile,
				50*1024*1024,
				self::ACCEPTED_MIME_TYPES
			);

			if (strlen($res) > 0) {
				var_dump($res);
			} else {
				$fileId = \CFile::SaveFile($arrFile, "post-files/{$savePath}");
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