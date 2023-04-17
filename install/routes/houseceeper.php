<?php

use Bitrix\Main\Routing\Controllers\PublicPageController;
use Bitrix\Main\Routing\RoutingConfigurator;

return function (RoutingConfigurator $routes)
{
	//$routes->get('/', new PublicPageController('/local/modules/hc.houseceeper/views/house-list.php'));
	$routes->get('/', function () {
		global $USER;
		if(!$USER->IsAuthorized()) {
			LocalRedirect('/sign-in');
		}
		if($USER->IsAdmin()) {
			LocalRedirect('/house-list');
		}
		\Hc\Houseceeper\Repository\House::redirectToHisHouse($USER->GetID());
	});

	$routes->get('/logout', function() {
		Hc\Houseceeper\Controller\Auth::logout();
	});
	$routes->post('/login', function () {
		Hc\Houseceeper\Controller\Auth::signin();
	});
	$routes->post('/reg', function()  {
		Hc\Houseceeper\Controller\Auth::signupUser();
	});

	$routes->get('/house-list', new PublicPageController('/local/modules/hc.houseceeper/views/house-list.php'));
	$routes->get('/add-house', new PublicPageController('/local/modules/hc.houseceeper/views/house-add.php'));
	$routes->post('/add-house', function () {
		$house = new \Hc\Houseceeper\Controller\House();
		$house->addNewHouse();
	});
	$routes->get('/house-about/{housePath}', new PublicPageController('/local/modules/hc.houseceeper/views/house-details.php'));

	$routes->get('/house/{housePath}', new PublicPageController('/local/modules/hc.houseceeper/views/post-list.php'));
	$routes->get('/house/{housePath}/post', new PublicPageController('/local/modules/hc.houseceeper/views/post-details.php'));
	$routes->get('/sign-up', new PublicPageController('/local/modules/hc.houseceeper/views/sign-up.php'));
	$routes->get('/sign-in', new PublicPageController('/local/modules/hc.houseceeper/views/sign-in.php'));
};