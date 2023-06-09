CREATE TABLE IF NOT EXISTS hc_houseceeper_house (
    ID INT NOT NULL AUTO_INCREMENT,
    NAME VARCHAR(50) NOT NULL,
    ADDRESS VARCHAR(100),
    NUMBER_OF_APARTMENT INT NOT NULL,
    UNIQUE_PATH VARCHAR(50) NOT NULL,
    INFO VARCHAR(1000),
    PRIMARY KEY (ID)
);

CREATE TABLE IF NOT EXISTS hc_houseceeper_apartment (
    ID INT NOT NULL AUTO_INCREMENT,
    NUMBER INT NOT NULL,
    HOUSE_ID INT NOT NULL,
    REG_KEY VARCHAR(30) NOT NULL,
    PRIMARY KEY (ID)
);
CREATE TABLE IF NOT EXISTS hc_houseceeper_apartment_user (
  USER_ID INT NOT NULL,
  APARTMENT_ID INT NOT NULL,
  PRIMARY KEY (USER_ID, APARTMENT_ID)
);

CREATE TABLE IF NOT EXISTS hc_houseceeper_role (
    ID INT NOT NULL AUTO_INCREMENT,
    NAME VARCHAR(50) NOT NULL,
    PRIMARY KEY (ID)
);


CREATE TABLE IF NOT EXISTS hc_houseceeper_post_type (
    ID INT NOT NULL AUTO_INCREMENT,
    NAME VARCHAR(50) NOT NULL,
    PRIMARY KEY (ID)
);

CREATE TABLE IF NOT EXISTS hc_houseceeper_post (
    ID INT NOT NULL AUTO_INCREMENT,
    HOUSE_ID INT NOT NULL,
    USER_ID INT,
    TITLE VARCHAR(100) NOT NULL,
    CONTENT VARCHAR(1000),
    DATETIME_CREATED TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
    TYPE_ID INT NOT NULL,
    PRIMARY KEY (ID)
);

CREATE TABLE IF NOT EXISTS hc_houseceeper_post_file (
    POST_ID INT NOT NULL,
    FILE_ID INT NOT NULL,
    PRIMARY KEY (POST_ID, FILE_ID)
);

CREATE TABLE IF NOT EXISTS hc_houseceeper_comment (
    ID INT NOT NULL AUTO_INCREMENT,
    USER_ID INT NOT NULL,
    POST_ID INT NOT NULL,
    CONTENT VARCHAR(200) NOT NULL,
    DATETIME_CREATED TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
    PARENT_COMMENT_ID INT,
    PRIMARY KEY (ID)
);

CREATE TABLE IF NOT EXISTS hc_houseceeper_tag (
    ID INT NOT NULL AUTO_INCREMENT,
    NAME VARCHAR(50) NOT NULL,
    PRIMARY KEY (ID)
);

CREATE TABLE IF NOT EXISTS hc_houseceeper_post_tag (
    POST_ID INT NOT NULL,
    TAG_ID INT NOT NULL,
    PRIMARY KEY (POST_ID, TAG_ID)
);

INSERT INTO hc_houseceeper_role (ID, NAME)
VALUES (1, 'admin'),
       (2, 'headman'),
       (3, 'user');


INSERT INTO hc_houseceeper_post_type (ID, NAME)
VALUES (1, 'announcement'),
       (2, 'discussion'),
       (3, 'unconfirmed');

ALTER TABLE hc_houseceeper_post add index IX_TITLE (TITLE);
ALTER TABLE hc_houseceeper_post add index IX_HOUSE_ID (HOUSE_ID);
ALTER TABLE hc_houseceeper_post add index IX_DATETIME_CREATED (DATETIME_CREATED);
ALTER TABLE hc_houseceeper_post add index IX_TYPE_ID (TYPE_ID);
ALTER TABLE hc_houseceeper_comment add index IX_POST_ID (POST_ID);
ALTER TABLE hc_houseceeper_comment add index IX_DATETIME_CREATED (DATETIME_CREATED);
ALTER TABLE hc_houseceeper_apartment add index IX_HOUSE_ID (HOUSE_ID);


CREATE TABLE IF NOT EXISTS hc_houseceeper_user_role(
                                                       USER_ID INT NOT NULL,
                                                       ROLE_ID INT NOT NULL,
                                                       HOUSE_ID INT NOT NULL,
                                                       PRIMARY KEY (USER_ID, HOUSE_ID)
);