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
			<h1 class="title"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_GETINTO_NEW_HOUSE') ; ?></h1>
			<h2 class="subtitle"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_GETINTO_FOR_SUCCESS_YOU_NEED_PROFILE') ; ?></h2>
		</section>

		<?php $APPLICATION->IncludeComponent('hc:errors.message', '', []); ?>

		<form action="/get-into" method="post">
			<?= bitrix_sessid_post(); ?>

			<div class="field mt-6">
				<label class="label"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_GETINTO_LOGIN') ; ?></label>
				<div class="control has-icons-left has-icons-right">
					<input  class="input " type="text" placeholder="Введите логин" name="login">
					<span class="icon is-small is-left">
		 <i class="fa-user fa-solid"></i>
		</span>
				</div>
			</div>

			<div class="field">
				<label class="label"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_GETINTO_PASSWORD') ; ?></label>
				<div class="control has-icons-left has-icons-right">
					<input  class="input " type="password" placeholder="Введите пароль" name="password">
					<span class="icon is-small is-left">
		 <i class="fa-solid fa-lock"></i>
		</span>
				</div>
			</div>
			<div class="field mt-6">
				<label class="label"><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_GETINTO_KEY')?></label>
				<div class="control has-icons-left has-icons-right">
					<input required class="input " type="text" placeholder="Введите ключ" value="<?= $arParams['key'] ?>" name="key">
					<span class="icon is-small is-left">
		<i class="fa-solid fa-key"></i>
		</span>
					<p class="help "><?=\Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_GETINTO_IF_YOU_HAVENT_KEY')?></p>
				</div>
			</div>

			<div class="control mt-5">
				<button class="button is-link" type="submit"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_GETINTO_BUTTON') ; ?></button>
				<span><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_GETINTO_NOT_REGISTERED') ; ?></span> <a href="/sign-up"><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_GETINTO_SIGNUP') ; ?></a>
			</div>

		</form>
	</div>
</main>