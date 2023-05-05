<?php

/**
 * @var array $arResult
 * @var array $arParams
 * @var CMain $APPLICATION
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<link rel="stylesheet" href="style.css">
<script src="https://kit.fontawesome.com/cfd6832a09.js" crossorigin="anonymous"></script>
<main class="has-background-success-light">
	<div class="container is-max-desktop ">
		<section class="section border-none has-background-grey-light mt-6">
			<h1 class="title"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_SIGHIN_AUTORIZATION') ; ?></h1>

		</section>

		<form action="/login" method="post">


			<div class="field mt-6">
					<?php $APPLICATION->IncludeComponent('hc:errors.message', '', []); ?>
				<label class="label"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_SIGHIN_LOGIN') ; ?></label>
				<div class="control has-icons-left has-icons-right">
					<input class="input " type="text" placeholder="Введите логин" name="login">
					<span class="icon is-small is-left">
		 <i class="fa-user fa-solid"></i>
		</span>
				</div>
			</div>

			<div class="field">
				<label class="label"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_SIGHIN_PASSWORD') ; ?></label>
				<div class="control has-icons-left has-icons-right">
					<input class="input " type="password" placeholder="Введите пароль" name="password">
					<span class="icon is-small is-left">
		 <i class="fa-solid fa-lock"></i>
		</span>
				</div>
			</div>


			<div class="control mt-5">
				<div class="buttons">
					<button class="button is-link" type="submit"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_SIGHIN_BUTTON') ; ?></button>
					<div class="mb-2">
						<span><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_SIGHIN_NOT_REGISTERED') ; ?></span> <a href="/sign-up"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_SIGHIN_SIGNUP') ; ?></a>
					</div>
				</div>
			</div>

		</form>
	</div>
</main>