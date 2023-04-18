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
			<a href="/house-about/<?= $house['UNIQUE_PATH'] ?>"><?= $house['NAME'] ?></a>
		</h1>
		<h2 class="subtitle">
			Адрес: <?= $house['ADDRESS'] ?>
		</h2>
		<h5><?= $house['NUMBER_OF_APARTMENT'] ?> квартир</h5>
		<a class="button is-dark" href="/house-about/<?= $house['UNIQUE_PATH'] ?>">Редактировать</a>
	</section>
	<?php } ?>

	<section class="section">
		<a class="button" href="/add-house">Добавить дом</a>
	</section>
</div>
</div>