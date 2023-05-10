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

	$routes->get('/logout', [\Hc\Houseceeper\Controller\Auth::class, 'logout']);
	$routes->post('/login', [\Hc\Houseceeper\Controller\Auth::class, 'signin']);
	$routes->post('/reg', [\Hc\Houseceeper\Controller\Auth::class, 'signupUser']);
	$routes->get('/get-into', new PublicPageController('/local/modules/hc.houseceeper/views/get-into.php'));
	$routes->post('/get-into', [\Hc\Houseceeper\Controller\Auth::class, 'addUserToHouse']);

	$routes->get('/profile', new PublicPageController('/local/modules/hc.houseceeper/views/user-profile.php'));
	$routes->post('/profile/changePassword', [\Hc\Houseceeper\Controller\Auth::class, 'changePassword']);
	$routes->post('/profile/changeGeneral', [\Hc\Houseceeper\Controller\User::class, 'changeUserGeneralInfo']);
	$routes->post('/profile/changeAvatar', [\Hc\Houseceeper\Controller\File::class, 'changeAvatar']);
	$routes->get('/profile/deleteAvatar', [\Hc\Houseceeper\Controller\File::class, 'deleteAvatar']);
	$routes->post('/profile/leaveApartment', [\Hc\Houseceeper\Controller\User::class, 'removeUserFromApartment']);
	$routes->post('/profile/leaveHouse', [\Hc\Houseceeper\Controller\User::class, 'removeuserFromHouse']);

	$routes->get('/house-list', new PublicPageController('/local/modules/hc.houseceeper/views/house-list.php'));
	$routes->get('/add-house', new PublicPageController('/local/modules/hc.houseceeper/views/house-add.php'));
	$routes->post('/add-house', [\Hc\Houseceeper\Controller\House::class, 'addNewHouse']);


	$routes->get('/house/{housePath}/about', new PublicPageController('/local/modules/hc.houseceeper/views/house-details.php'));
	$routes->get('/create-reg-link', function () {
		echo \Hc\Houseceeper\Repository\Apartment::generateRegKey($_REQUEST['house-id'], $_REQUEST['number']);
	});
	$routes->post('/house/{housePath}/edit-house', [\Hc\Houseceeper\Controller\House::class, 'editHouse']);
	$routes->get('/house/{housePath}/add-headman/{userId}', [\Hc\Houseceeper\Controller\User::class, 'addHeadman']);
	$routes->get('/house/{housePath}/delete-headman/{userId}', [\Hc\Houseceeper\Controller\User::class, 'deleteHeadman']);
	$routes->get('/house/{housePath}/remove-user/{userId}/{apartmentId}', [\Hc\Houseceeper\Controller\User::class, 'removeUserFromApartmentAdmin']);

	$routes->get('/house/{housePath}/add-post', new PublicPageController('/local/modules/hc.houseceeper/views/post-add.php'));
	$routes->post('/house/{housePath}/add-post', [\Hc\Houseceeper\Controller\Post::class, 'addNewPostForHouse']);

	$routes->get('/house/{housePath}', new PublicPageController('/local/modules/hc.houseceeper/views/post-list.php'));
	$routes->get('/house/{housePath}/discussions', new PublicPageController('/local/modules/hc.houseceeper/views/discussion-list.php'));
	$routes->get('/house/{housePath}/announcements', new PublicPageController('/local/modules/hc.houseceeper/views/announcement-list.php'));
	$routes->get('/sign-up', new PublicPageController('/local/modules/hc.houseceeper/views/sign-up.php'));
	$routes->get('/sign-in', new PublicPageController('/local/modules/hc.houseceeper/views/sign-in.php'));

	$routes->get('/house/{housePath}/post/{id}', new PublicPageController('/local/modules/hc.houseceeper/views/post-details.php'))->where('id', '[0-9]+');
	$routes->post('/house/{housePath}/post/{postId}', [\Hc\Houseceeper\Controller\Comment::class, 'addComment']);
	$routes->post('/house/{housePath}/post/{postId}/delete', [\Hc\Houseceeper\Controller\Post::class, 'deletePost']);
	$routes->post('/house/{housePath}/post/{postId}/confirm', [\Hc\Houseceeper\Controller\Post::class, 'confirmPost']);
	$routes->post('/house/{housePath}/post/{postId}/deleteComment', function() {
		\Hc\Houseceeper\Controller\User::checkAccessToHouse();
		$comment = new \Hc\Houseceeper\Controller\Comment();
		$comment->deleteComment();
		LocalRedirect('/house/' . $_REQUEST['housePath'] . '/post/' .$_REQUEST['id'] );
	});

	$routes->get('/house/{housePath}/post/{id}/edit', new PublicPageController('/local/modules/hc.houseceeper/views/post-edit.php'));
	$routes->post('/house/{housePath}/post/{id}/edit', function(){
		$request = \Bitrix\Main\Context::getCurrent()->getRequest();
		$postCaption = $request->getPost('post-caption');
		$postContent = $request->getPost('post-body');
		$postType = $request->getPost('post-type');
		$filesToAdd = $request->getPost('files');

		$fileIdsToDelete = [];
		foreach ($request->getPostList() as $paramName => $paramValue) {
			if (strpos($paramName, '_del') !== false && $paramValue === 'Y') {
				$fileId = str_replace('_del', '', $paramName);
				$fileIdsToDelete[] = $request->getPost($fileId);
			}
		}

		$result = \Hc\Houseceeper\Controller\Post::update($_REQUEST['id'], $postCaption, $postContent, $postType, $filesToAdd, $fileIdsToDelete);
		if ($result===true)
		{
			LocalRedirect('/house/'.$_REQUEST['housePath'].'/post/'.$_REQUEST['id']);
		}
		foreach ($result as $error)
		{
			echo $error;
		}
	});
};