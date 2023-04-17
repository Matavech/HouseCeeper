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

		<form method="post" action="/edit-house">
			<?php bitrix_sessid_post(); ?>

			<h1 class="title mt-6">
				<?= $arResult['HOUSE']['NAME'] ?>
			</h1>

			<input type="hidden" name="id" value="">
			<div class="field">
				<label class="label">Техническая информация</label>
				<div class="control has-icons-left has-icons-right">
					<textarea class="input" name="info"> <?= $arResult['HOUSE']['INFO'] ?> </textarea>
				</div>
			</div>
			<div class="field">
				<label class="label">Уникальный идентификатор</label>
				<div class="control has-icons-left has-icons-right">
					<input required class="input" type="text" value="<?= $arResult['HOUSE']['UNIQUE_PATH'] ?>" name="unique-path">
				</div>
			</div>
			<div class="field">
				<label class="label">Кол-во квартир</label>
				<div class="control has-icons-left has-icons-right">
					<input required class="input" type="number" name="number-of-apartments" value="<?= $arResult['HOUSE']['NUMBER_OF_APARTMENT'] ?>">
				</div>
			</div>
			<div class="field">
				<label class="label">Адрес</label>
				<div class="control has-icons-left has-icons-right">
					<input required class="input" type="text" name="address" value="<?= $arResult['HOUSE']['ADDRESS'] ?>">
				</div>
			</div>
			<button class="button" type="submit">Сохранить</button>
		</form>

		<form method="get" action="/reg-link">
			<h3 class="title mt-6">
				Получить ссылку-приглашение
			</h3>
			<input type="hidden" name="house-id" value="">
			<div class="field">
				<label class="label">Номер квартиры</label>
				<div class="control has-icons-left has-icons-right">
					<input required class="input" type="number" name="number">
				</div>
			</div>
			<button class="button" type="submit">Получить</button>
		</form>
	</div>
</div>