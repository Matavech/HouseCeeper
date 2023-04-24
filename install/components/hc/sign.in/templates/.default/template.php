<?php

/**
 * @var array $arResult
 * @var array $arParams
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<link rel="stylesheet" href="style.css">
<script src="https://kit.fontawesome.com/cfd6832a09.js" crossorigin="anonymous"></script>
<main class="has-background-success-light">
	<div class="container is-max-desktop ">
		<section class="section border-none has-background-grey-light mt-6">
			<h1 class="title">Авторизация</h1>

		</section>

		<form action="/login" method="post">


			<div class="field mt-6">
				<label class="label">Логин</label>
				<div class="control has-icons-left has-icons-right">
					<input required class="input " type="text" placeholder="Введите логин" name="login">
					<span class="icon is-small is-left">
		 <i class="fa-user fa-solid"></i>
		</span>
				</div>
			</div>

			<div class="field">
				<label class="label">Пароль</label>
				<div class="control has-icons-left has-icons-right">
					<input required class="input " type="password" placeholder="Введите пароль" name="password">
					<span class="icon is-small is-left">
		 <i class="fa-solid fa-lock"></i>
		</span>
				</div>
			</div>


			<div class="control mt-5">
				<button class="button is-link" type="submit"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_SIGNIN') ; ?></button>
				<span><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_NOT_SIGNUP_YET')?></span> <a href="/sign-up"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_SIGNUP') ?></a>
			</div>

		</form>
	</div>
</main>