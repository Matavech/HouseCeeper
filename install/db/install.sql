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
    PRIMARY KEY (ID),
    FOREIGN KEY FK_HOUSE_APARTMENT (HOUSE_ID)
        REFERENCES hc_houseceeper_house(ID)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS hc_houseceeper_role (
    ID INT NOT NULL AUTO_INCREMENT,
    NAME VARCHAR(50) NOT NULL,
    PRIMARY KEY (ID)
);

CREATE TABLE IF NOT EXISTS hc_houseceeper_user (
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
);

CREATE TABLE IF NOT EXISTS hc_houseceeper_apartment_user (
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
    PRIMARY KEY (ID),
    FOREIGN KEY FK_POST_USER (USER_ID)
        REFERENCES hc_houseceeper_user(ID)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY FK_POST_TYPE (TYPE_ID)
        REFERENCES hc_houseceeper_post_type(ID)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS hc_houseceeper_post_file (
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
);

CREATE TABLE IF NOT EXISTS hc_houseceeper_comment (
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
);

CREATE TABLE IF NOT EXISTS hc_houseceeper_tag (
    ID INT NOT NULL AUTO_INCREMENT,
    NAME VARCHAR(50) NOT NULL,
    PRIMARY KEY (ID)
);

CREATE TABLE IF NOT EXISTS hc_houseceeper_post_tag (
    POST_ID INT NOT NULL,
    TAG_ID INT NOT NULL,
    PRIMARY KEY (POST_ID, TAG_ID),
    FOREIGN KEY FK_PT_POST (POST_ID)
        REFERENCES hc_houseceeper_post(ID)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY FK_PT_TAG (TAG_ID)
        REFERENCES hc_houseceeper_tag(ID)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

INSERT INTO hc_houseceeper_house (ID, NAME, ADDRESS, NUMBER_OF_APARTMENT, UNIQUE_PATH, INFO)
VALUES (1, 'TEST HOUSE', 'address', '50', 'test-path', 'test info');

INSERT INTO hc_houseceeper_apartment (ID, NUMBER, REG_KEY, HOUSE_ID)
VALUES (1, 1, 'secret key', 1);

INSERT INTO hc_houseceeper_role (ID, NAME)
VALUES (1, 'admin'),
       (2, 'headman'),
       (3, 'user');

INSERT INTO hc_houseceeper_user (ID, ROLE_ID)
VALUES (1, 1);

INSERT INTO hc_houseceeper_apartment_user (USER_ID, APARTMENT_ID)
VALUES (1, 1);

INSERT INTO hc_houseceeper_post_type (ID, NAME)
VALUES (1, 'announcement'),
       (2, 'discussion'),
       (3, 'unconfirmed');

INSERT INTO hc_houseceeper_post (HOUSE_ID, USER_ID, TITLE, CONTENT, TYPE_ID)
VALUES (1, 1, 'test post title', 'test post content', 1);