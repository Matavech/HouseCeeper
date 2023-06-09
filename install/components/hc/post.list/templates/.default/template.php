<?php

/**
 * @var array $arResult
 * @var array $arParams
 * @var CMain $APPLICATION
 */
\Bitrix\Main\UI\Extension::load('hc.hc-constantmanager');
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>

<script src="https://kit.fontawesome.com/cfd6832a09.js" crossorigin="anonymous"></script>
<div class="container">
	<section class="hero">
		<div class="hero-body">
			<p class="title">
			<form method="get" class="field has-addons">
				<div class="control">
					<input class="input is-medium" type="text" name="search">
				</div>
				<div class="control">
					<button class="button is-info is-medium">
						<?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTLIST_SEARCH') ?>
					</button>
				</div>
			</form>
			</p>
			<?php if ($arParams['search']) { ?>
				<p class="subtitle">
					<?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTLIST_SEARCH_RESULT') ?>
					"<?= $arParams['search'] ?>"
				</p>
			<?php } ?>
		</div>
	</section>


	<div class="content">
		<?php foreach ($arResult['POSTS'] as $post) { ?>
			<?php if ($post['HC_HOUSECEEPER_MODEL_POST_TYPE_NAME'] === \Hc\HouseCeeper\Constant\PostType::HC_HOUSECEEPER_POSTTYPE_UNCONFIRMED &&
				!$USER->IsAdmin() && !\Hc\Houseceeper\Repository\User::isHeadman($USER->GetID(), $arResult['HOUSE']['ID'])) continue ?>
			<section class="section post">
				<h1 class="title">
					<a href="/house/<?= $arParams['housePath'] . '/post/' . $post['ID'] ?>"><?= htmlspecialcharsbx($post['TITLE']) ?></a>
					<span class="tag is-medium" id="type">
		  				<?= $post['HC_HOUSECEEPER_MODEL_POST_TYPE_NAME'] ?>
					</span>
				</h1>
				<h2 class="subtitle">
					<?= htmlspecialcharsbx($post['CONTENT']) ?>
				</h2>
				<h5><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTLIST_PUBLISHED') ?>
					: <?= $post['DATETIME_CREATED'] ?></h5>
				<a class="button is-dark"
				   href="/house/<?= $arParams['housePath'] . '/post/' . $post['ID'] ?>"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_POSTLIST_GO_TO_DISCUSS') ?> </a>
			</section>
		<?php } ?>
	</div>

	<?php if ($arResult['NAV_OBJECT']->getPageCount() > 1): ?>
		<div class="pagination">
			<?php $APPLICATION->IncludeComponent(
				"bitrix:main.pagenavigation",
				"modern",
				[
					"NAV_OBJECT" => $arResult["NAV_OBJECT"],
					"SEF_MODE" => "N",
					"SHOW_ALWAYS" => "Y",
					"PAGE_WINDOW" => 3
				],
				false
			); ?>
		</div>
	<?php endif; ?>
</div>