<?php

/**
 * @var array $arResult
 * @var array $arParams
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>

<script src="https://kit.fontawesome.com/cfd6832a09.js" crossorigin="anonymous"></script>
<div class="container">
<div class="content">

	<?php foreach ($arResult['HOUSE'] as $house) {?>
	<section class="section">
		<h1 class="title">
			<a href="<?= '/house/' . $house['UNIQUE_PATH'] . '/about' ?>"><?= htmlspecialcharsbx($house['NAME']) ?></a>
		</h1>
		<h2 class="subtitle">
			<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSELIST_ADDRESS')?>: <?= htmlspecialcharsbx($house['ADDRESS']) ?>
		</h2>
		<h5><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSELIST_NUMBER_OF_APARTMENT')?>: <?= $house['NUMBER_OF_APARTMENT'] ?> </h5>
		<a class="button is-dark" href="<?= '/house/' . $house['UNIQUE_PATH'] . '/about' ?>"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSELIST_REDACT')?></a>
	</section>
	<?php } ?>

	<section class="section">
		<a class="button" href="/add-house"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_HOUSELIST_ADD_HOUSE')?></a>
	</section>
</div>
</div>