<?php

use Bitrix\Main\Routing\Controllers\PublicPageController;
use Bitrix\Main\Routing\RoutingConfigurator;

return function (RoutingConfigurator $routes)
{

	$routes->get('/', new PublicPageController('/local/modules/hc.houseceeper/views/post-list.php'));

};