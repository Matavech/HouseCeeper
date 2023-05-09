<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
class hc_houseceeper extends CModule
{
	public $MODULE_ID = 'hc.houseceeper';
	public $MODULE_VERSION;
	public $MODULE_VERSION_DATE;
	public $MODULE_NAME;
	public $MODULE_DESCRIPTION;

	public function __construct()
	{
		$arModuleVersion = [];
		include(__DIR__ . '/version.php');

		if (is_array($arModuleVersion) && $arModuleVersion['VERSION'] && $arModuleVersion['VERSION_DATE'])
		{
			$this->MODULE_VERSION = $arModuleVersion['VERSION'];
			$this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
		}

		$this->MODULE_NAME = Loc::getMessage('HC_HOUSECEEPER_MODULE_NAME');
		$this->MODULE_DESCRIPTION = Loc::getMessage('HC_HOUSECEEPER_MODULE_DESCRIPTION');
	}

	public function installDB(): void
	{
		global $DB;

		$DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT'] . '/local/modules/hc.houseceeper/install/db/install.sql');
		$this->installDemoData();

		ModuleManager::registerModule($this->MODULE_ID);
	}

	public function installDemoData(): void
	{
		global $DB;
		$userIdList = $this->installDemoUsers();
		$this->installDemoPersonalPhoto($userIdList);
		$sql = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/local/modules/hc.houseceeper/install/db/demodata.sql');
		foreach ($userIdList as $key => $userId){
			$sql = str_replace('id' . $key, $userId, $sql);
		}

		$tmp_file = tempnam(sys_get_temp_dir(), 'sql');
		file_put_contents($tmp_file, $sql);

		$DB->RunSQLBatch($tmp_file);
		unlink($tmp_file);
	}

	public function installDemoPersonalPhoto($userIdList): void
	{
		global $USER;
		$fileIdList = [];

		$fileArray = \CFile::MakeFileArray(__DIR__ . "/files/user-avatars/demo-avatar-1.png");
		$fileArray["MODULE_ID"] = "hc.houseceeper";
		$fileId = \CFile::SaveFile($fileArray, "user-avatars/{$userIdList[1]}");

		$USER->Update($userIdList[1], [
			"PERSONAL_PHOTO" => $fileArray
		]);

		$fileArray = \CFile::MakeFileArray(__DIR__ . "/files/user-avatars/demo-avatar-2.png");
		$fileArray["MODULE_ID"] = "hc.houseceeper";
		$fileId = \CFile::SaveFile($fileArray, "user-avatars/{$userIdList[2]}");

		$USER->Update($userIdList[2], [
			"PERSONAL_PHOTO" => $fileArray
		]);
	}

	public function installDemoUsers(): array
	{
		global $USER;
		$userIdList = [];

		$userIdList[] = $USER->Add([
			"LOGIN" => "demodanil",
			"NAME" => "Demo Данил",
			"LAST_NAME" => "Царь",
			"PASSWORD" => "123456",
			"WORK_COMPANY" => "HouseCeeper",
			"EMAIL" => "danil@demo.com"
		]);

		$userIdList[] = $USER->Add([
			"LOGIN" => "demoivan",
			"NAME" => "Demo Иван",
			"LAST_NAME" => "Битриксовский",
			"PASSWORD" => "123456",
			"WORK_COMPANY" => "HouseCeeper",
			"EMAIL" => "ivan@demo.com"
		]);

		$userIdList[] = $USER->Add([
			"LOGIN" => "demostanislav",
			"NAME" => "Demo Станислав",
			"LAST_NAME" => "Душниловский",
			"PASSWORD" => "123456",
			"WORK_COMPANY" => "HouseCeeper",
			"EMAIL" => "stanislav@demo.com"
		]);

		$userIdList[] = $USER->Add([
			"LOGIN" => "demoroman",
			"NAME" => "Demo Роман",
			"LAST_NAME" => "Веселый",
			"PASSWORD" => "123456",
			"WORK_COMPANY" => "HouseCeeper",
			"EMAIL" => "roman@demo.com"
		]);
		return $userIdList;
	}

	public function uninstallDB($arParams = []): void
	{
		global $DB;

		$DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT'] . '/local/modules/hc.houseceeper/install/db/uninstall.sql');

		ModuleManager::unRegisterModule($this->MODULE_ID);
	}

	public function installFiles(): void
	{
		CopyDirFiles(
			$_SERVER['DOCUMENT_ROOT'] . '/local/modules/hc.houseceeper/install/components',
			$_SERVER['DOCUMENT_ROOT'] . '/local/components/',
			true,
			true
		);

		CopyDirFiles(
			$_SERVER['DOCUMENT_ROOT'] . '/local/modules/hc.houseceeper/install/templates',
			$_SERVER['DOCUMENT_ROOT'] . '/local/templates/',
			true,
			true
		);

		CopyDirFiles(
			$_SERVER['DOCUMENT_ROOT'] . '/local/modules/hc.houseceeper/install/routes',
			$_SERVER['DOCUMENT_ROOT'] . '/local/routes/',
			true,
			true
		);
	}

	public function uninstallFiles(): void
	{
		\Bitrix\Main\IO\Directory::deleteDirectory(\Bitrix\Main\Application::getDocumentRoot() . '/upload/post-files');
		\Bitrix\Main\IO\Directory::deleteDirectory(\Bitrix\Main\Application::getDocumentRoot() . '/upload/user-avatars');
	}

	public function installEvents(): void
	{
	}

	public function uninstallEvents(): void
	{
	}

	public function doInstall(): void
	{
		global $USER, $APPLICATION;

		if (!$USER->isAdmin())
		{
			return;
		}

		$this->installDB();
		$this->installFiles();
		$this->installEvents();

		$APPLICATION->IncludeAdminFile(
			Loc::getMessage('HC_HOUSECEEPER_INSTALL_TITLE'),
			$_SERVER['DOCUMENT_ROOT'] . '/local/modules/' . $this->MODULE_ID . '/install/step.php'
		);
	}

	public function doUninstall(): void
	{
		global $USER, $APPLICATION, $step;

		if (!$USER->isAdmin())
		{
			return;
		}

		$step = (int)$step;
		if($step < 2)
		{
			$APPLICATION->IncludeAdminFile(
				Loc::getMessage('HC_HOUSECEEPER_UNINSTALL_TITLE'),
				$_SERVER['DOCUMENT_ROOT'] . '/local/modules/' . $this->MODULE_ID . '/install/unstep1.php'
			);

		}
		elseif($step === 2)
		{
			$this->uninstallDB();
			$this->uninstallFiles();
			$this->uninstallEvents();

			$APPLICATION->IncludeAdminFile(
				Loc::getMessage('HC_HOUSECEEPER_UNINSTALL_TITLE'),
				$_SERVER['DOCUMENT_ROOT'] . '/local/modules/' . $this->MODULE_ID . '/install/unstep2.php'
			);
		}

	}
}