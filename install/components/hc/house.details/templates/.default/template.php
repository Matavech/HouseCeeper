<?php

/**
 * @var array $arResult
 * @var array $arParams
 */

\Bitrix\Main\UI\Extension::load("ui.vue3");
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>

<script src="https://kit.fontawesome.com/cfd6832a09.js" crossorigin="anonymous"></script>
<div class="container">
	<div class="content">

		<form method="post" action="/edit-house">
			<?php bitrix_sessid_post(); ?>

			<div class="field mt-6">
				<label class="label">Название</label>
				<div class="control">
					<input class="title input" type="text" name="house-name" value="<?= htmlspecialcharsbx($arResult['HOUSE']['NAME']) ?>">
				</div>
			</div>

			<input type="hidden" name="house-id" value="<?= $arResult['HOUSE']['ID'] ?>">
			<div class="field">
				<label class="label">Техническая информация</label>
				<div class="control">
					<textarea class="input" name="info"> <?= $arResult['HOUSE']['INFO'] ?> </textarea>
				</div>
			</div>
			<div class="field">
				<label class="label">Уникальный идентификатор</label>
				<div class="control">
					<input required class="input" type="text" value="<?= $arResult['HOUSE']['UNIQUE_PATH'] ?>" name="unique-path">
				</div>
			</div>
			<div class="field">
				<label class="label">Кол-во квартир</label>
				<div class="control">
					<input required class="input" type="number" name="number-of-apartments" min="1" value="<?= $arResult['HOUSE']['NUMBER_OF_APARTMENT'] ?>">
				</div>
			</div>
			<div class="field">
				<label class="label">Адрес</label>
				<div class="control">
					<input required class="input" type="text" name="address" value="<?= $arResult['HOUSE']['ADDRESS'] ?>">
				</div>
			</div>
			<button class="button" type="submit">Сохранить</button>
		</form>

		<form method="get">
			<h3 class="title mt-6">
				Получить ссылку-приглашение
			</h3>
			<input type="hidden" name="house-id" value="<?= $arResult['HOUSE']['ID'] ?>">
			<div class="field">
				<label class="label">Номер квартиры</label>
				<div class="control">
					<input required class="input" type="number" name="number">
				</div>
			</div>
			<button class="button" type="submit" onclick="generateLink(event)">Получить</button>
			<span id="invite-key" class="tag is-large has-background-white"></span>
			<span id="invite-link" class="tag is-large has-background-white"></span>
		</form>
	</div>
</div>