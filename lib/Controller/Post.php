<?php
namespace Hc\Houseceeper\Controller;

use Bitrix\Main\Engine;
use Bitrix\Main\Error;
use Hc\Houseceeper\Repository;

class Post extends Engine\Controller
{
	protected const PROJECT_PER_PAGE = 20;
//	protected function getDefaultPreFilters(): array
//	{
//		return [
//			new ActionFilter\ApiKeyAuthorization(),
//		];
//	}

	public function getListAction(string $housePath,int $pageNumber = 1): ?array
	{
		if ($pageNumber < 0)
		{
			$this->addError(new Error('pageNumber should be greater than 0', 'invalid_page_number'));

			return null;
		}

		$postList = Repository\Post::getPage(self::PROJECT_PER_PAGE, $pageNumber, $housePath);

		return [
			'pageNumber' => $pageNumber,
			'postList' => $postList,
		];
	}

	public function configureActions(): array
	{
		return [
			'getList' => [
				// '+prefilters' => [
				// 	new ActionFilter\ApiKeyAuthorization(),
				// ],
				'-prefilters' => [
					Engine\ActionFilter\Authentication::class,
				],
			],
		];
	}
}