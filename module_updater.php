<?php

use Bitrix\Main\ModuleManager;
use Bitrix\Main\Config\Option;

function __projectorMigrate(int $nextVersion, callable $callback)
{
	global $DB;
	$moduleId = 'hc.houseceeper';

	if (!ModuleManager::isModuleInstalled($moduleId))
	{
		return;
	}

	$currentVersion = intval(Option::get($moduleId, '~database_schema_version', 0));

	if ($currentVersion < $nextVersion)
	{
		include_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/classes/general/update_class.php');
		$updater = new \CUpdater();
		$updater->Init('', 'mysql', '', '', $moduleId, 'DB');

		$callback($updater, $DB, 'mysql');
		Option::set($moduleId, '~database_schema_version', $nextVersion);
	}
}

__projectorMigrate(2, function($updater, $DB)
{
	if ($updater->CanUpdateDatabase() && !$updater->TableExists('hc_houseceeper_house'))
	{
		$DB->query('CREATE TABLE IF NOT EXISTS hc_houseceeper_house (
    ID INT NOT NULL AUTO_INCREMENT,
    NAME VARCHAR(50) NOT NULL,
    ADDRESS VARCHAR(100),
    NUMBER_OF_APARTMENT INT NOT NULL,
    UNIQUE_PATH VARCHAR(50) NOT NULL,
    INFO VARCHAR(1000),
    PRIMARY KEY (ID)
);');
	}

	if ($updater->CanUpdateDatabase() && !$updater->TableExists('hc_houseceeper_apartment'))
	{
		$DB->query('CREATE TABLE IF NOT EXISTS hc_houseceeper_apartment (
    ID INT NOT NULL AUTO_INCREMENT,
    NUMBER INT NOT NULL,
    HOUSE_ID INT NOT NULL,
    REG_KEY VARCHAR(50) NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY FK_HOUSE_APARTMENT (HOUSE_ID)
        REFERENCES hc_houseceeper_house(ID)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);');
	}

	if ($updater->CanUpdateDatabase() && !$updater->TableExists('hc_houseceeper_role'))
	{
		$DB->query('CREATE TABLE IF NOT EXISTS hc_houseceeper_role (
    ID INT NOT NULL AUTO_INCREMENT,
    NAME VARCHAR(50) NOT NULL,
    PRIMARY KEY (ID)
);
');
	}

	if ($updater->CanUpdateDatabase() && !$updater->TableExists('hc_houseceeper_user'))
	{
		$DB->query('CREATE TABLE IF NOT EXISTS hc_houseceeper_user (
    ID INT NOT NULL,
    ROLE_ID INT NOT NULL,
    IMAGE_PATH VARCHAR(100),
    PRIMARY KEY (ID),
    FOREIGN KEY FK_USER_ROLE (ROLE_ID)
        REFERENCES hc_houseceeper_role(ID)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    FOREIGN KEY FK_USER_BX (ID)
        REFERENCES b_user(ID)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT
);');
	}

	if ($updater->CanUpdateDatabase() && !$updater->TableExists('hc_houseceeper_apartment_user'))
	{
		$DB->query('CREATE TABLE IF NOT EXISTS hc_houseceeper_apartment_user (
    USER_ID INT NOT NULL,
    APARTMENT_ID INT NOT NULL,
    PRIMARY KEY (USER_ID, APARTMENT_ID),
    FOREIGN KEY FK_AU_USER (USER_ID)
        REFERENCES hc_houseceeper_user(ID)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY FK_AU_APARTMENT (APARTMENT_ID)
        REFERENCES hc_houseceeper_apartment(ID)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);');
	}

	if ($updater->CanUpdateDatabase() && !$updater->TableExists('hc_houseceeper_post_type'))
	{
		$DB->query('CREATE TABLE IF NOT EXISTS hc_houseceeper_post_type (
    ID INT NOT NULL AUTO_INCREMENT,
    NAME VARCHAR(50) NOT NULL,
    PRIMARY KEY (ID)
);');
	}

	if ($updater->CanUpdateDatabase() && !$updater->TableExists('hc_houseceeper_post'))
	{
		$DB->query('CREATE TABLE IF NOT EXISTS hc_houseceeper_post (
    ID INT NOT NULL AUTO_INCREMENT,
    HOUSE_ID INT NOT NULL,
    USER_ID INT,
    TITLE VARCHAR(100) NOT NULL,
    CONTENT VARCHAR(1000),
    DATETIME_CREATED TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
    TYPE_ID INT NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY FK_POST_USER (USER_ID)
        REFERENCES hc_houseceeper_user(ID)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY FK_POST_TYPE (TYPE_ID)
        REFERENCES hc_houseceeper_post_type(ID)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);');
	}

	if ($updater->CanUpdateDatabase() && !$updater->TableExists('hc_houseceeper_post_file'))
	{
		$DB->query('CREATE TABLE IF NOT EXISTS hc_houseceeper_post_file (
    POST_ID INT NOT NULL AUTO_INCREMENT,
    FILE_PATH VARCHAR(50) NOT NULL,
    PRIMARY KEY (POST_ID),
    FOREIGN KEY FK_POST_FILE (POST_ID)
        REFERENCES hc_houseceeper_post(ID)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);');
	}

	if ($updater->CanUpdateDatabase() && !$updater->TableExists('hc_houseceeper_comment'))
	{
		$DB->query('CREATE TABLE IF NOT EXISTS hc_houseceeper_comment (
    ID INT NOT NULL AUTO_INCREMENT,
    USER_ID INT NOT NULL,
    POST_ID INT NOT NULL,
    CONTENT VARCHAR(200) NOT NULL,
    DATETIME_CREATED TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
    PARENT_COMMENT_ID INT,
    PRIMARY KEY (ID),
    FOREIGN KEY FK_COMMENT_POST (POST_ID)
        REFERENCES hc_houseceeper_post(ID)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY FK_COMMENT_USER (USER_ID)
    REFERENCES hc_houseceeper_user(ID)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY FK_COMMENT_COMMENT (PARENT_COMMENT_ID)
    REFERENCES hc_houseceeper_comment(ID)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);');
	}

	if ($updater->CanUpdateDatabase() && !$updater->TableExists('hc_houseceeper_tag'))
	{
		$DB->query('CREATE TABLE IF NOT EXISTS hc_houseceeper_tag (
    ID INT NOT NULL AUTO_INCREMENT,
    NAME VARCHAR(50) NOT NULL,
    PRIMARY KEY (ID)
);');
	}

	if ($updater->CanUpdateDatabase() && $updater->TableExists('hc_houseceeper_house'))
	{
		$DB->query("INSERT INTO hc_houseceeper_house (ID, NAME, ADDRESS, NUMBER_OF_APARTMENT, UNIQUE_PATH, INFO)
VALUES (1, 'TEST HOUSE', 'address', '50', 'test-path', 'test info');");
	}

	if ($updater->CanUpdateDatabase() && $updater->TableExists('hc_houseceeper_apartment'))
	{
		$DB->query("INSERT INTO hc_houseceeper_apartment (ID, NUMBER, REG_KEY, HOUSE_ID)
VALUES (1, 1, 'secret key', 1);");
	}

	if ($updater->CanUpdateDatabase() && $updater->TableExists('hc_houseceeper_role'))
	{
		$DB->query("INSERT INTO hc_houseceeper_role (ID, NAME)
VALUES (1, 'admin'),
       (2, 'headman'),
       (3, 'user');");
	}

	if ($updater->CanUpdateDatabase() && $updater->TableExists('hc_houseceeper_user'))
	{
		$DB->query("INSERT INTO hc_houseceeper_user (ID, ROLE_ID)
VALUES (1, 1);");
	}

	if ($updater->CanUpdateDatabase() && $updater->TableExists('hc_houseceeper_apartment_user'))
	{
		$DB->query("INSERT INTO hc_houseceeper_apartment_user (USER_ID, APARTMENT_ID)
VALUES (1, 1);");
	}

	if ($updater->CanUpdateDatabase() && $updater->TableExists('hc_houseceeper_post_type'))
	{
		$DB->query("INSERT INTO hc_houseceeper_post_type (ID, NAME)
VALUES (1, 'announcement');");
	}

	if ($updater->CanUpdateDatabase() && $updater->TableExists('hc_houseceeper_post'))
	{
		$DB->query("INSERT INTO hc_houseceeper_post (HOUSE_ID, USER_ID, TITLE, CONTENT, TYPE_ID)
VALUES (1, 1, 'test post title', 'test post content', 1);");
	}
});

__projectorMigrate(3, function($updater, $DB){
	$DB->query("INSERT INTO hc_houseceeper_post_type (ID, NAME)
VALUES (2, 'discussion'),
       (3, 'unconfirmed');");
});

__projectorMigrate(4, function($updater, $DB){
	$DB->query("DROP TABLE IF EXISTS hc_houseceeper_post_file;");
	$DB->query("CREATE TABLE IF NOT EXISTS hc_houseceeper_post_file (
POST_ID INT NOT NULL,
FILE_ID INT NOT NULL,
PRIMARY KEY (POST_ID, FILE_ID),
FOREIGN KEY FK_PF_POST (POST_ID)
    REFERENCES hc_houseceeper_post(ID)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
FOREIGN KEY FK_PF_FILE (FILE_ID)
    REFERENCES b_file(ID)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);");
});


__projectorMigrate(5, function($updater, $DB){
	$DB->query("ALTER TABLE hc_houseceeper_user DROP FOREIGN KEY hc_houseceeper_user_ibfk_1;");
	$DB->query("ALTER TABLE hc_houseceeper_user DROP FOREIGN KEY hc_houseceeper_user_ibfk_2;");
	$DB->query("ALTER TABLE hc_houseceeper_user DROP COLUMN IMAGE_PATH;");
	$DB->query("ALTER TABLE hc_houseceeper_apartment_user DROP FOREIGN KEY hc_houseceeper_apartment_user_ibfk_1;");
	$DB->query("ALTER TABLE hc_houseceeper_apartment_user DROP FOREIGN KEY hc_houseceeper_apartment_user_ibfk_2;");
	$DB->query("ALTER TABLE hc_houseceeper_post DROP FOREIGN KEY hc_houseceeper_post_ibfk_1;");
	$DB->query("ALTER TABLE hc_houseceeper_post DROP FOREIGN KEY hc_houseceeper_post_ibfk_2;");
	$DB->query("ALTER TABLE hc_houseceeper_post_file DROP FOREIGN KEY hc_houseceeper_post_file_ibfk_1;");
	$DB->query("ALTER TABLE hc_houseceeper_post_file DROP FOREIGN KEY hc_houseceeper_post_file_ibfk_2;");
	$DB->query("ALTER TABLE hc_houseceeper_comment DROP FOREIGN KEY hc_houseceeper_comment_ibfk_1;");
	$DB->query("ALTER TABLE hc_houseceeper_comment DROP FOREIGN KEY hc_houseceeper_comment_ibfk_2;");
	$DB->query("ALTER TABLE hc_houseceeper_comment DROP FOREIGN KEY hc_houseceeper_comment_ibfk_3;");
	$DB->query("ALTER TABLE hc_houseceeper_post_tag DROP FOREIGN KEY hc_houseceeper_post_tag_ibfk_1;");
	$DB->query("ALTER TABLE hc_houseceeper_post_tag DROP FOREIGN KEY hc_houseceeper_post_tag_ibfk_2;");
	$DB->query("ALTER TABLE hc_houseceeper_post add index IX_TITLE (TITLE);");
	$DB->query("ALTER TABLE hc_houseceeper_post add index IX_HOUSE_ID (HOUSE_ID);");
	$DB->query("ALTER TABLE hc_houseceeper_post add index IX_DATETIME_CREATED (DATETIME_CREATED);");
	$DB->query("ALTER TABLE hc_houseceeper_post add index IX_TYPE_ID (TYPE_ID);");
	$DB->query("ALTER TABLE hc_houseceeper_comment add index IX_POST_ID (POST_ID);");
	$DB->query("ALTER TABLE hc_houseceeper_comment add index IX_DATETIME_CREATED (DATETIME_CREATED);");
	$DB->query("ALTER TABLE hc_houseceeper_apartment add index IX_HOUSE_ID (HOUSE_ID);");
	$DB->query("CREATE TABLE IF NOT EXISTS hc_houseceeper_user_role(
    USER_ID INT NOT NULL,
    ROLE_ID INT NOT NULL,
    HOUSE_ID INT NOT NULL,
    PRIMARY KEY (USER_ID, HOUSE_ID)
);");
	$DB->query("INSERT INTO hc_houseceeper_user_role (USER_ID, ROLE_ID, HOUSE_ID)
SELECT u.ID, r.ID, h.ID
FROM hc_houseceeper_user u
    JOIN hc_houseceeper_role r ON u.ROLE_ID = r.ID
    JOIN hc_houseceeper_apartment_user au ON au.USER_ID = u.ID
    JOIN hc_houseceeper_apartment a ON a.ID = au.APARTMENT_ID
    JOIN hc_houseceeper_house h ON h.ID = a.HOUSE_ID");
	$DB->query("DROP TABLE IF EXISTS hc_houseceeper_user;");
});

