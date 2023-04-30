<?php

/**
 * @var array $arResult
 * @var array $arParams
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
global $USER;
?>

<script src="https://kit.fontawesome.com/cfd6832a09.js" crossorigin="anonymous"></script>

<div class="container">

<div class="content">

	<?php if(!$arResult['HOUSE']) : ?>
		<section class="hero is-danger mt-5">
			<div class="hero-body">
				<p class="title">
					Вы не зарегистрированы ни в одном доме
				</p>
				<p class="subtitle">
					Если Ваш дом подключен к этой системе, обратитесь к председателю ТСЖ за кодом доступа.
					<br>
					Если у Вас есть код, <a href="/get-into" class="is-underlined has-text-weight-bold">Добавьте дом в этот профиль</a>
				</p>
			</div>
		</section>
	<?php foreach ($arResult['HOUSE'] as $house) {?>

		<section class="section">
			<h1 class="title">
				<a href="<?= '/house/' . $house['UNIQUE_PATH']?>"> <?= htmlspecialcharsbx($house['NAME']) ?></a>
			</h1>
			<h2 class="subtitle">
				<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSELIST_ADDRESS')?>: <?= htmlspecialcharsbx($house['ADDRESS']) ?>
			</h2>
			<?php if ($USER->IsAdmin()) : ?>
				<a class="button is-dark" href="<?= '/house/' . $house['UNIQUE_PATH'] . '/about' ?>"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSELIST_REDACT')?></a>
			<?php endif; ?>
			<a class="button is-info" href="<?= '/house/' . $house['UNIQUE_PATH']?>"> <?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSELIST_GO_TO_HOUSE')?> </a>
		</section>

	<?php } ?>
	<?php if ($USER->IsAdmin()) : ?>

		<div class="buttons is-centered">
			<a class="button is-large" href="/add-house"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSELIST_ADD_HOUSE')?></a>
		</div>
	<?php endif; ?>
	<?php endif; ?>
</div>
</div>