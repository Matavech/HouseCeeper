<?php
/**
* @var array $arResult
* @var array $arParams
*/

?>
<script src="https://kit.fontawesome.com/cfd6832a09.js" crossorigin="anonymous"></script>

<div class="container">
	<div class="content mt-5">
		<div class="columns">
			<div class="column mr-5">
		<h1 class="has-text-primary-dark">Основная информация</h1>
		<form action="/profile/changeGeneral" method="post">
			<h2>Имя</h2>
			<input class="input" type="text" id="userName" name="userName" value="<?=$arResult['USER']['NAME']?>" readonly required>
			<h2>Фамилия</h2>
			<input class="input" type="text" id="userLastName" name="userLastName" value="<?=$arResult['USER']['LAST_NAME']?>" readonly>
			<h2>Логин</h2>
			<input class="input" type="text" id="userLogin" name="userLogin" value="<?=$arResult['USER']['LOGIN']?>" readonly required>
			<input type="hidden" value="<?=$arResult['USER']['ID']?>" name="userId">
			<button class="button is-success mt-3" type="submit" id="save" onclick="hide();">Сохранить</button>
			<button class="button is-warning mt-3" type="reset" id="reset" onclick="hide();">Отменить</button>
		</form>
			<button class="button is-success mt-3" id="change" onclick="openChanges();">Изменить параметры</button>


			</div>
			<div class="column ml-5">
		<h1 class="has-text-primary-dark">Изменение пароля</h1>
		<form action="/profile/changePassword" method="post">
			<h2>Старый пароль</h2>
			<input type="password" class="input" name="oldPassword" required>
			<h2>Новый пароль</h2>
			<input type="password" class="input" name="newPassword" required>
			<h2>Повторите пароль</h2>
			<input type="password" class="input" name="confirmPassword" required>
			<button class="button is-success mt-3" type="submit">Change password</button>
		</form>

			</div>
		</div>
		<h1 class="has-text-primary-dark has-text-centered">Информация о домах</h1>
		<?php foreach ($arResult['HOUSES'] as $house) :?>
			<section class="section">
				<h1 class="title">
					Название дома: <?=$house['NAME']?>
				</h1>
				<h2 class="subtitle">
					<strong>Адрес: </strong><?=$house['ADDRESS']?>
					<br>
					<strong>Квартиры: </strong>
					<?php foreach ($house['APARTMENTS'] as $key => $apartment)  : ?>
					<div class="buttons">
							<form action="/profile/leaveApartment" method="post" class="mt-3">
								<input type="hidden" name="apartmentId" value="<?=$apartment?>">
								<div class="buttons has-addons">
									<button class="button is-black disabled" disabled>
										<?=$key?>
									</button>
									<button class="button is-warning" type="submit">
										Выселиться
									</button>
								</div>
							</form>
					</div>
					<?php endforeach; ?>
				</h2>
				<form action="profile?leaveHouse" method="post">
					<input type="hidden" name="houseId" value="<?=$house['ID']?>">
					<button class="button is-danger" type="submit">Покинуть дом</button>
				</form>
			</section>
		<?php endforeach; ?>

	</div>
</div>