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
		LocalRedirect(\Hc\Houseceeper\Repository\House::getUserHousePath($USER->GetID()));
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

	$routes->get('/house/{housePath}/about', new PublicPageController('/local/modules/hc.houseceeper/views/house-details.php'));
	$routes->get('/create-reg-link', function () {
		echo \Hc\Houseceeper\Controller\Apartment::generateRegKey($_REQUEST['house-id'], $_REQUEST['number']);
	});

	$routes->get('/house/{housePath}/add-post', new PublicPageController('/local/modules/hc.houseceeper/views/post-add.php'));
	$routes->post('/house/{housePath}/add-post', function() {
		$post = new \Hc\Houseceeper\Controller\Post();
		$post->addNewPostForHouse($_REQUEST['housePath']);
	});

	$routes->get('/house/{housePath}', new PublicPageController('/local/modules/hc.houseceeper/views/post-list.php'));
	$routes->get('/sign-up', new PublicPageController('/local/modules/hc.houseceeper/views/sign-up.php'));
	$routes->get('/sign-in', new PublicPageController('/local/modules/hc.houseceeper/views/sign-in.php'));

	$routes->get('/house/{housePath}/post/{id}', new PublicPageController('/local/modules/hc.houseceeper/views/post-details.php'))->where('id', '[0-9]+');
	$routes->post('/house/{housePath}/post/{id}', function() {

		$comment = new \Hc\Houseceeper\Controller\Comment();
		$comment->addComment($_REQUEST['housePath'],$_REQUEST['id']);
	});

	$routes->post('/house/{housePath}/post/{id}/deleteComment', function() {

		$comment = new \Hc\Houseceeper\Controller\Comment();
		$comment->deleteComment($_REQUEST['housePath'],$_REQUEST['id']);
	});
};