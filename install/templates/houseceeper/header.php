<?php
/**
 * @var CMain $APPLICATION
 */
global $USER;
$housePath = extractValueFromLink($_SERVER['REQUEST_URI']);
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
		<?php if ($housePath) { ?>
		<div class="navbar-start">
			<a class="navbar-item" href="/house/<?= $housePath?>">
				<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HEADER_FEED')?>
			</a>

			<a class="navbar-item" href="/house/<?= $housePath?>/discussions">
				<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HEADER_DISCUSSIONS')?>
			</a>

			<a class="navbar-item" href="/house/<?= $housePath?>/announcements">
				<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HEADER_ANNOUNCEMENTS')?>
			</a>

			<a class="navbar-item" href="/house/<?= $housePath?>/about">
				<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HEADER_ABOUT_HOUSE')?>
			</a>


			<a class="navbar-item" href="/house/<?=$housePath?>/add-post">
				<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HEADER_NEW_POST')?>
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
			<div class="navbar-item is-right">
				<div class="buttons has-addons">
					<a class="button is-link" href="/profile">
						<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HEADER_GO_TO_PROFILE')?>
					</a>
					<a class="button is-white" href="/logout?sessid=<?= bitrix_sessid() ?>">
						<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HEADER_LOGOUT')?>
					</a>

				</div>
			</div>
			<?php } ?>
		</div>
	</div>

</nav>