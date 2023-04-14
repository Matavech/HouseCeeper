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
			Регистрация в дом <strong>г. Калининград, ул. Ленина, 13</strong>
			<br> Для доступа вам потребуется уникальный код от Председателя ТСЖ
		</h2>
	</section>

	<form action="signup">

		<div class="field mt-6">
			<label class="label">Firstname</label>
			<div class="control">
				<input required class="input" type="text" placeholder="Введите имя" name="firstname">
			</div>
		</div>

		<div class="field">
			<label class="label">Lastname</label>
			<div class="control">
				<input class="input" type="text" placeholder="Введите фамилию" name="lastname">
			</div>
		</div>

		<div class="field">
			<label class="label">Username</label>
			<div class="control has-icons-left has-icons-right">
				<input required class="input " type="text" placeholder="Введите логин" name="login">
				<span class="icon is-small is-left">
		 <i class="fa-user fa-solid"></i>
		</span>
			</div>
		</div>

		<div class="field">
			<label class="label">Password</label>
			<div class="control has-icons-left has-icons-right">
				<input required class="input " type="password" placeholder="Введите пароль" name="password">
				<span class="icon is-small is-left">
		 <i class="fa-solid fa-lock"></i>
		</span>
			</div>
		</div>

		<div class="field mt-6">
			<label class="label">House key</label>
			<div class="control has-icons-left has-icons-right">
				<input required class="input " type="text" placeholder="Введите пароль" value="U23Dsv2" name="key">
				<span class="icon is-small is-left">
		<i class="fa-solid fa-key"></i>
		</span>
				<p class="help ">Если у вас нет ключа, обратитесь к Председателю ТСЖ</p>
			</div>
		</div>
		<div class="control mt-5">
			<button class="button is-link" type="submit">Sign up</button>
		</div>

	</form>
</div>
</main>