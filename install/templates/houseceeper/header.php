<?php
/**
 * @var CMain $APPLICATION
 */
?><!doctype html>
<html lang="<?= LANGUAGE_ID; ?>">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?php $APPLICATION->ShowTitle(); ?></title>

	<?php
	$APPLICATION->ShowHead();
	?>
</head>
<body>
<?php $APPLICATION->ShowPanel(); ?>

<nav class="navbar is-dark" role="navigation" aria-label="main navigation">
	<div class="navbar-brand">
		<a class="navbar-item has-text-primary" href="https://bulma.io">
			!Project name!
		</a>

		<a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
			<span aria-hidden="true"></span>
			<span aria-hidden="true"></span>
			<span aria-hidden="true"></span>
		</a>
	</div>

	<div id="navbarBasicExample" class="navbar-menu">
		<div class="navbar-start">
			<a class="navbar-item">
				Feed
			</a>

			<a class="navbar-item">
				Discussions
			</a>

			<a class="navbar-item">
				Announcements
			</a>

			<div class="navbar-item has-dropdown is-hoverable">
				<a class="navbar-link">
					Information
				</a>

				<div class="navbar-dropdown">
					<a class="navbar-item">
						About house
					</a>
					<a class="navbar-item">
						Useful links
					</a>
				</div>
			</div>


			<a class="navbar-item">
				New post
			</a>


			<div class="navbar-item">
				<span class="tag has-background-grey-light is-large">Калининград, Ленинский проспект, 13</span>
			</div>
		</div>

		<div class="navbar-end">

			<div class="navbar-item">
				<span class="tag has-background-grey-light is-large">
					Антон Иванов, квартира 13
				</span>
			</div>

			<div class="navbar-item">
				<div class="buttons">
					<a class="button is-link">
						Logout
					</a>
				</div>
			</div>
		</div>
	</div>
</nav>