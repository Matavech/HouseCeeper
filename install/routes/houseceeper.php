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

		LocalRedirect('/house-list');
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
	$routes->get('/get-into', new PublicPageController('/local/modules/hc.houseceeper/views/get-into.php'));
	$routes->post('/get-into', function() {
		\Hc\Houseceeper\Controller\Auth::addUserToHouse();
	});

	$routes->get('/profile', new PublicPageController('/local/modules/hc.houseceeper/views/user-profile.php'));
	 $routes->post('/profile/changePassword', function() {
	 	$request = \Bitrix\Main\Context::getCurrent()->getRequest();
	 	$oldPassword = trim($request->getPost('oldPassword'));
	 	$newPassword = trim($request->getPost('newPassword'));
	 	$confirmPassword = trim($request->getPost('confirmPassword'));
	 	\Hc\Houseceeper\Controller\Auth::changePassword($oldPassword, $newPassword, $confirmPassword);
	 });
	// $routes->post('/profile/changeGeneral', function(){
	// 	$request = \Bitrix\Main\Context::getCurrent()->getRequest();
	// 	$userName = trim($request->getPost('userName'));
	// 	$userLastName = trim($request->getPost('userLastName'));
	// 	$userLogin = trim($request->getPost('userLogin'));
	// 	if (\Hc\Houseceeper\Controller\User::changeUserGeneralInfo($userName, $userLastName, $userLogin))
	// 	{
	// 		LocalRedirect('/profile');
	// 	}
	// });

	$routes->post('/profile/changeGeneral', [\Hc\Houseceeper\Controller\User::class, 'changeUserGeneralInfo']); // todo

	$routes->post('/profile/changeAvatar', function(){
		$request = \Bitrix\Main\Context::getCurrent()->getRequest();
		$file = $request->getPost('files');
		if (!$file)
		{
			LocalRedirect('/profile');
		}

		global $USER;
		$error = \Hc\Houseceeper\Controller\File::changeAvatar($USER->GetId(), $file[0]);
		if ($error)
		{
			echo $error;
			return;
		}
		LocalRedirect('/profile');
	});
	$routes->get('/profile/deleteAvatar', function () {
		global $USER;
		\Hc\Houseceeper\Controller\File::deleteAvatar($USER->GetId());
		LocalRedirect('/profile');
	});


	$routes->post('/profile/leaveApartment', function(){
		global $USER;
		$request = \Bitrix\Main\Context::getCurrent()->getRequest();
		$userId = $USER->GetId();
		$apartmentId = trim($request->getPost('apartmentId'));
		$houseId = trim($request->getPost('houseId'));
		\Hc\Houseceeper\Controller\User::removeUserFromApartment($userId, $apartmentId, $houseId);
	});
	$routes->post('/profile/leaveHouse', function(){
		global $USER;
		$request = \Bitrix\Main\Context::getCurrent()->getRequest();
		$userId = $USER->GetId();
		$houseId = trim($request->getPost('houseId'));
		\Hc\Houseceeper\Controller\User::removeuserFromHouse($userId, $houseId);
	});

	$routes->get('/house-list', new PublicPageController('/local/modules/hc.houseceeper/views/house-list.php'));
	$routes->get('/add-house', new PublicPageController('/local/modules/hc.houseceeper/views/house-add.php'));
	$routes->post('/add-house', function () {
		$house = new \Hc\Houseceeper\Controller\House();
		$house->addNewHouse();
	});

	$routes->get('/house/{housePath}/about', new PublicPageController('/local/modules/hc.houseceeper/views/house-details.php'));
	$routes->get('/create-reg-link', function () {
		echo \Hc\Houseceeper\Repository\Apartment::generateRegKey($_REQUEST['house-id'], $_REQUEST['number']);
	});
	$routes->post('/house/{housePath}/edit-house', function () {
		global $USER;
		if(!$USER->IsAdmin())
		{
			LocalRedirect('/house/{housePath}/about');
		}
		$house = new \Hc\Houseceeper\Controller\House();
		$house->editHouse();
	});
	$routes->post('/house/{housePath}/add-headman', function () {
		global $USER;
		if(!$USER->IsAdmin())
		{
			LocalRedirect('/house/{housePath}/about');
		}
		$user = new \Hc\Houseceeper\Controller\User();
		$user->addHeadman();
	});
	$routes->post('/house/{housePath}/delete-headman', function () {
		global $USER;
		if(!$USER->IsAdmin())
		{
			LocalRedirect('/house/{housePath}/about');
		}
		$user = new \Hc\Houseceeper\Controller\User();
		$user->deleteHeadman();
	});
	$routes->post('/house/{housePath}/remove-user', function () {
		$user = new \Hc\Houseceeper\Controller\User();
		$user->removeUserFromApartmentAdmin();
	});

	$routes->get('/house/{housePath}/add-post', new PublicPageController('/local/modules/hc.houseceeper/views/post-add.php'));
	$routes->post('/house/{housePath}/add-post', function() {
		$post = new \Hc\Houseceeper\Controller\Post();
		$post->addNewPostForHouse($_REQUEST['housePath']);
	});

	$routes->get('/house/{housePath}', new PublicPageController('/local/modules/hc.houseceeper/views/post-list.php'));
	$routes->get('/house/{housePath}/discussions', new PublicPageController('/local/modules/hc.houseceeper/views/discussion-list.php'));
	$routes->get('/house/{housePath}/announcements', new PublicPageController('/local/modules/hc.houseceeper/views/announcement-list.php'));
	$routes->get('/sign-up', new PublicPageController('/local/modules/hc.houseceeper/views/sign-up.php'));
	$routes->get('/sign-in', new PublicPageController('/local/modules/hc.houseceeper/views/sign-in.php'));

	$routes->get('/house/{housePath}/post/{id}', new PublicPageController('/local/modules/hc.houseceeper/views/post-details.php'))->where('id', '[0-9]+');
	$routes->post('/house/{housePath}/post/{id}', function() {
		\Hc\Houseceeper\Controller\User::checkAccessToHouse();
		$comment = new \Hc\Houseceeper\Controller\Comment();
		$comment->addComment($_REQUEST['housePath'],$_REQUEST['id']);
	});
	$routes->get('/house/{housePath}/post/{id}/delete', function() {
		\Hc\Houseceeper\Controller\User::checkAccessToHouse();
		$post = new \Hc\Houseceeper\Controller\Post();
		$post->deletePost($_REQUEST['housePath'], $_REQUEST['id']);
	});
	$routes->get('/house/{housePath}/post/{id}/confirm', function() {
		\Hc\Houseceeper\Controller\User::checkAccessToHouse();
		$post = new \Hc\Houseceeper\Controller\Post();
		$post->confirmPost($_REQUEST['housePath'], $_REQUEST['id']);
	});
	$routes->post('/house/{housePath}/post/{id}/deleteComment', function() {
		\Hc\Houseceeper\Controller\User::checkAccessToHouse();
		$comment = new \Hc\Houseceeper\Controller\Comment();
		$comment->deleteComment();
		LocalRedirect('/house/' . $_REQUEST['housePath'] . '/post/' .$_REQUEST['id'] );
	});
};