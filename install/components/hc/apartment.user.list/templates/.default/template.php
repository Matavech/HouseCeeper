<?php

/**
 * @var array $arResult
 * @var array $arParams
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>

<div class="table-container">
	<table class="table">
		<tbody>
		<form></form>
		<?php foreach ($arParams['USER_LIST'] as $user) { ?>
			<tr>
				<th style="width: 45px">
					<?php if (\Hc\Houseceeper\Repository\User::isHeadman($user['ID'], $arParams['HOUSE_ID'])) { ?>
						<i class="fa-solid fa-building-user"></i>
					<?php } else { ?>
						<i class="fa-solid fa-user"></i>
					<?php } ?>
				</th>
				<td style="width: 220px">
					<?= htmlspecialcharsbx($user['FULL_NAME']) ?>
				</td>
				<?php if ($USER->IsAdmin()) { ?>
					<td style="width: 250px">
						<?php if (\Hc\Houseceeper\Repository\User::isHeadman($user['ID'], $arParams['HOUSE_ID'])) { ?>
							<form method="post" action="delete-headman">
								<input type="hidden" name="house-id" value="<?= $arParams['HOUSE_ID'] ?>">
								<input type="hidden" name="headman-id" value="<?= $user['ID'] ?>">
								<button type="submit"
										class="button is-warning "><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_APARTMENTUSERLIST_WITHDRAW_AUTHORITY') ?>
								</button>
							</form>
						<?php } else { ?>
							<form method="post" action="add-headman">
								<input type="hidden" name="house-id" value="<?= $arParams['HOUSE_ID'] ?>">
								<input type="hidden" name="user-id" value="<?= $user['ID'] ?>">
								<button type="submit"
										class="button is-primary "><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_APARTMENTUSERLIST_ADD_HEADMAN') ?>
								</button>
							</form>
						<?php } ?>
					</td>
					<td>
						<form method="post" action="remove-user">
							<input type="hidden" name="house-id" value="<?= $arParams['HOUSE_ID'] ?>">
							<input type="hidden" name="user-id" value="<?= $user['ID'] ?>">
							<input type="hidden" name="apartment-id" value="<?= $arParams['APARTMENT_ID'] ?>">
							<button type="submit"
									class="button is-danger "><?= \Bitrix\Main\Localization\Loc::getMessage('HC_HOUSECEEPER_APARTMENTUSERLIST_REMOVE_USER') ?>
							</button>
						</form>
					</td>
				<?php } ?>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>


