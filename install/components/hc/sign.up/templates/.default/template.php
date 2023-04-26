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
		<h1 class="title"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_SIGNUP_REGISTRATION')?></h1>
		<h2 class="subtitle">
			<?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_SIGNUP_FOR_ENTRY_YOU_NEED_KEY')?>
		</h2>
	</section>

	<form action="/reg" method="post">

		<div class="field mt-6">
			<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_SIGNUP_NAME')?></label>
			<div class="control">
				<input required class="input" type="text" placeholder="Введите имя" name="firstname">
			</div>
		</div>

		<div class="field">
			<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_SIGNUP_LAST_NAME')?></label>
			<div class="control">
				<input class="input" type="text" placeholder="Введите фамилию" name="lastname">
			</div>
		</div>

		<div class="field">
			<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_SIGNUP_LOGIN')?></label>
			<div class="control has-icons-left has-icons-right">
				<input required class="input " type="text" placeholder="Введите логин" name="login">
				<span class="icon is-small is-left">
		 <i class="fa-user fa-solid"></i>
		</span>
			</div>
		</div>

		<div class="field">
		<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_SIGNUP_EMAIL')?></label>
		<div class="control has-icons-left has-icons-right">
			<input required class="input " type="text" placeholder="Введите почту" name="email">
			<span class="icon is-small is-left">
		 <i class="fa-user fa-solid"></i>
		</span>
		</div>
		</div>

		<div class="field">
			<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_SIGNUP_PASSWORD')?></label>
			<div class="control has-icons-left has-icons-right">
				<input required class="input " type="password" placeholder="Введите пароль" name="password">
				<span class="icon is-small is-left">
		 <i class="fa-solid fa-lock"></i>
		</span>
			</div>
		</div>

		<div class="field mt-6">
			<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_SIGNUP_KEY')?></label>
			<div class="control has-icons-left has-icons-right">
				<input required class="input " type="text" placeholder="Введите ключ" value="<?= $arParams['key'] ?>" name="key">
				<span class="icon is-small is-left">
		<i class="fa-solid fa-key"></i>
		</span>
				<p class="help "><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_SIGNUP_IF_YOU_HAVENT_KEY')?></p>
			</div>
		</div>
		<div class="control mt-5">
			<button class="button is-link" type="submit"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_SIGNUP_BUTTON')?></button>
			<span><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_SIGHUP_SIGNIN_ALREADY')?></span> <a href="/sign-in"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_SIGHUP_SIGNIN')?></a>
		</div>

	</form>
</div>
</main>