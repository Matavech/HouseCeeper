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

		<form method="post" action="/add-house">
			<?php bitrix_sessid_post(); ?>

			<h1 class="title mt-6">
  				Новый дом
			</h1>
			<div class="field">
				<label class="label">Название дома</label>
				<div class="control has-icons-left has-icons-right">
					<input required class="input" type="text" placeholder="дом" name="house-name">
				</div>
			</div>
			<div class="field">
				<label class="label">Техническая информация</label>
				<div class="control has-icons-left has-icons-right">
					<textarea class="input" placeholder="" name="info"></textarea>
				</div>
			</div>
			<div class="field">
				<label class="label">Уникальный идентификатор</label>
				<div class="control has-icons-left has-icons-right">
					<input required class="input" type="text" placeholder="dom1" name="unique-path">
				</div>
			</div>
			<div class="field">
				<label class="label">Кол-во квартир</label>
				<div class="control has-icons-left has-icons-right">
					<input required class="input" min="1" type="number" name="number-of-apartments">
				</div>
			</div>
			<div class="field">
				<label class="label">Адрес</label>
				<div class="control has-icons-left has-icons-right">
					<input required class="input" type="text" name="address">
				</div>
			</div>
			<h1 class="title">
				Профиль председателя
			</h1>
			<div class="field">
				<label class="label">Имя</label>
				<div class="control has-icons-left has-icons-right">
					<input required class="input" type="text" name="headman-name">
				</div>
			</div>
			<div class="field">
				<label class="label">Фамилия</label>
				<div class="control has-icons-left has-icons-right">
					<input required class="input" type="text" name="headman-lastname">
				</div>
			</div>
			<div class="field">
				<label class="label">Email</label>
				<div class="control has-icons-left has-icons-right">
					<input required class="input" type="email" name="headman-email">
				</div>
			</div>
			<div class="field">
				<label class="label">Номер квартиры</label>
				<div class="control has-icons-left has-icons-right">
					<input required class="input" min="1" type="number" name="headman-apartment-number">
				</div>
			</div>
			<div class="field">
				<label class="label">Логин</label>
				<div class="control has-icons-left has-icons-right">
					<input required class="input" type="text" name="headman-login">
				</div>
			</div>
			<div class="field">
				<label class="label">Пароль</label>
				<div class="control has-icons-left has-icons-right">
					<input required class="input" type="password" name="headman-password">
				</div>
			</div>
			<button class="button" type="submit">Добавить дом</button>
		</form>

	</div>
</div>