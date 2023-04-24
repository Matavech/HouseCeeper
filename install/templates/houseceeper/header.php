<?php
/**
 * @var CMain $APPLICATION
 */
global $USER;
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
		<a class="navbar-item has-text-primary" href="/">
			HouseCeeper
		</a>

		<a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
			<span aria-hidden="true"></span>
			<span aria-hidden="true"></span>
			<span aria-hidden="true"></span>
		</a>
	</div>


	<div id="navbarBasicExample" class="navbar-menu">
		<?php if ($USER->IsAuthorized() && !$USER->IsAdmin()) { ?>
		<div class="navbar-start">
			<a class="navbar-item" href="<?= \Hc\Houseceeper\Repository\House::getUserHousePath($USER->GetID())?>">
				Feed
			</a>

			<a class="navbar-item" href="<?= \Hc\Houseceeper\Repository\House::getUserHousePath($USER->GetID())?>/discussions">
				Discussions
			</a>

			<a class="navbar-item" href="<?= \Hc\Houseceeper\Repository\House::getUserHousePath($USER->GetID())?>/announcements">
				Announcements
			</a>

			<a class="navbar-item" href="<?= \Hc\Houseceeper\Repository\House::getUserHousePath($USER->GetID())?>/about">
				About house
			</a>


			<a class="navbar-item" href="<?= \Hc\Houseceeper\Repository\House::getUserHousePath($USER->GetID()) . '/add-post' ?>">
				New post
			</a>

		</div>

		<div class="navbar-end">

			<div class="navbar-item">
				<span class="tag has-background-grey-light is-large">
					<?= htmlspecialcharsbx($USER->GetFullName()) ?>
				</span>
			</div>
			<?php } ?>
			<?php if ($USER->IsAuthorized()) { ?>
			<div class="navbar-item">
				<div class="buttons">
					<a class="button is-link" href="/logout">
						<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_LOGOUT')?>
					</a>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>

</nav>