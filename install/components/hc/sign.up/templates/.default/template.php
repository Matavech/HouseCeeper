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
		<h1 class="title">Регистрация</h1>
		<h2 class="subtitle">
			Для доступа вам потребуется уникальный код от Председателя ТСЖ
		</h2>
	</section>

	<form action="/reg" method="post">

		<div class="field mt-6">
			<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_NAME')?></label>
			<div class="control">
				<input required class="input" type="text" placeholder="Введите имя" name="firstname">
			</div>
		</div>

		<div class="field">
			<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_LAST_NAME')?></label>
			<div class="control">
				<input class="input" type="text" placeholder="Введите фамилию" name="lastname">
			</div>
		</div>

		<div class="field">
			<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_LOGIN')?></label>
			<div class="control has-icons-left has-icons-right">
				<input required class="input " type="text" placeholder="Введите логин" name="login">
				<span class="icon is-small is-left">
		 <i class="fa-user fa-solid"></i>
		</span>
			</div>
		</div>

		<div class="field">
		<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_EMAIL')?></label>
		<div class="control has-icons-left has-icons-right">
			<input required class="input " type="text" placeholder="Введите почту" name="email">
			<span class="icon is-small is-left">
		 <i class="fa-user fa-solid"></i>
		</span>
		</div>
		</div>

		<div class="field">
			<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_PASSWORD')?></label>
			<div class="control has-icons-left has-icons-right">
				<input required class="input " type="password" placeholder="Введите пароль" name="password">
				<span class="icon is-small is-left">
		 <i class="fa-solid fa-lock"></i>
		</span>
			</div>
		</div>

		<div class="field mt-6">
			<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_KEY')?></label>
			<div class="control has-icons-left has-icons-right">
				<input required class="input " type="text" placeholder="Введите ключ" value="<?= $arParams['key'] ?>" name="key">
				<span class="icon is-small is-left">
		<i class="fa-solid fa-key"></i>
		</span>
				<p class="help ">Если у вас нет ключа, обратитесь к Председателю ТСЖ</p>
			</div>
		</div>
		<div class="control mt-5">
			<button class="button is-link" type="submit"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_SIGNUP')?></button>
			<span><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_SIGNIN_ALREADY')?></span> <a href="/sign-in"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_SIGNIN')?></a>
		</div>

	</form>
</div>
</main>