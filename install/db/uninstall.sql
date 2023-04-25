DROP TABLE IF EXISTS hc_houseceeper_post_tag;
DROP TABLE IF EXISTS hc_houseceeper_tag;
DROP TABLE IF EXISTS hc_houseceeper_comment;
DROP TABLE IF EXISTS hc_houseceeper_post_file;
DROP TABLE IF EXISTS hc_houseceeper_post;
DROP TABLE IF EXISTS hc_houseceeper_post_type;
DROP TABLE IF EXISTS hc_houseceeper_apartment_user;
DROP TABLE IF EXISTS hc_houseceeper_role;
DROP TABLE IF EXISTS hc_houseceeper_user_role;
DROP TABLE IF EXISTS hc_houseceeper_apartment;
DROP TABLE IF EXISTS hc_houseceeper_house;

DELETE FROM b_user WHERE WORK_COMPANY = 'HouseCeeper';