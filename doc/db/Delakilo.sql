-- Enrico Marchionni

-- **************************************************************************
-- * SQL - MySQL
-- *-------------------------------------------------------------------------
-- * DB-MAIN version: 11.0.2
-- * LUN file: ./doc/db/DELAKILO.lun
-- * Generated from DB-MAIN relational schema and modified
-- * There could be some differences between this rules and 'DB-MAIN E-R.png'
-- **************************************************************************


-- Database Section
-- ________________

DROP DATABASE IF EXISTS `Delakilo`;
CREATE DATABASE `Delakilo` DEFAULT CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_bin';
USE `Delakilo`;


-- Tables Section
-- ______________

CREATE TABLE `USER` (
     `Username` VARCHAR(50) NOT NULL,
     -- `email` VARCHAR(50) UNIQUE DEFAULT NULL,
     `passwordSalt` CHAR(255) NOT NULL,
     `passwordHash` CHAR(128) NOT NULL,
     `name` VARCHAR(50) NOT NULL DEFAULT '',
     `surname` VARCHAR(50) NOT NULL DEFAULT '',
     -- `birthday` DATE DEFAULT NULL,
     `bio` VARCHAR(500) NOT NULL DEFAULT '',
     `imageURL` VARCHAR(400) NOT NULL DEFAULT 'defaultProfile.svg',
     `nFollowers` INT UNSIGNED NOT NULL DEFAULT 0,
     `nFollowing` INT UNSIGNED NOT NULL DEFAULT 0,
     `nPosts` INT UNSIGNED NOT NULL DEFAULT 0,
     `timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`Username`)
     -- CONSTRAINT `UsernameNotEmptyOrSpacesCheck` CHECK (`Username` <> ''
     --      AND `Username` NOT LIKE '% %')
) ENGINE = InnoDB;

CREATE TABLE `LOGIN_ATTEMPTS` (
     `EkUser` VARCHAR(50) NOT NULL,
     `timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB;

CREATE TABLE `FOLLOW` (
     `EkUserFollower` VARCHAR(50) NOT NULL,
     `EkUserFollowed` VARCHAR(50) NOT NULL,
     `timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`EkUserFollower`, `EkUserFollowed`),
     CONSTRAINT `FollowerNotFollowedCheck` CHECK (`EkUserFollower` <> `EkUserFollowed`)
) ENGINE = InnoDB;

CREATE TABLE `POST` (
     `IdPost` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     `EkUser` VARCHAR(50) NOT NULL,
     `imageURL` VARCHAR(400) NOT NULL,
     `caption` VARCHAR(1000) NOT NULL DEFAULT '',
     `nLikes` INT UNSIGNED NOT NULL DEFAULT 0,
     `timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`IdPost`),
     CONSTRAINT `CaptionNotHeadingTrailingSpacesCheck` CHECK (`caption` NOT LIKE ' %'
          AND `caption` NOT LIKE '% ')
) ENGINE = InnoDB;

CREATE TABLE `LIKE_POST` (
     `EkUser` VARCHAR(50) NOT NULL,
     `EkPost` INT UNSIGNED NOT NULL,
     `timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`EkUser`, `EkPost`)
) ENGINE = InnoDB;

CREATE TABLE `COMMENT` (
     `IdComment` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     `EkUser` VARCHAR(50) NOT NULL,
     `EkPost` INT UNSIGNED NOT NULL,
     -- `EkCommentParent` INT UNSIGNED DEFAULT NULL,
     `content` VARCHAR(1000) NOT NULL,
     -- `nLikes` INT UNSIGNED NOT NULL DEFAULT 0,
     `timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`IdComment`),
     CONSTRAINT `ContentNotEmptyAndHeadingTrailingSpacesCheck` CHECK (`content` <> ''
          AND `content` NOT LIKE ' %'
          AND `content` NOT LIKE '% ')
) ENGINE = InnoDB;

CREATE TABLE `LIKE_COMMENT` (
     `EkUser` VARCHAR(50) NOT NULL,
     `EkComment` INT UNSIGNED NOT NULL,
     `timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`EkUser`, `EkComment`)
) ENGINE = InnoDB;

CREATE TABLE `NOTIFICATION` (
     `IdMessage` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     `EkUserDst` VARCHAR(50) NOT NULL,
     `EkUserSrc` VARCHAR(50) NOT NULL,
     `message` VARCHAR(500) NOT NULL,
     `timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`IdMessage`),
     CONSTRAINT `MessageNotEmptyAndHeadingTrailingSpacesCheck` CHECK (`message` <> ''
          AND `message` NOT LIKE ' %'
          AND `message` NOT LIKE '% ')
) ENGINE = InnoDB;


-- Constraints Section
-- ___________________

ALTER TABLE `FOLLOW`
     ADD CONSTRAINT `FK_Follow_UserFollowed`
          FOREIGN KEY (`EkUserFollowed`)
          REFERENCES `USER` (`Username`)
          ON UPDATE CASCADE
          ON DELETE CASCADE,
     ADD CONSTRAINT `FK_Follow_UserFollows`
          FOREIGN KEY (`EkUserFollower`)
          REFERENCES `USER` (`Username`)
          ON UPDATE CASCADE
          ON DELETE CASCADE;

ALTER TABLE `LOGIN_ATTEMPTS`
     ADD CONSTRAINT `FK_Login_User`
          FOREIGN KEY (`EkUser`)
          REFERENCES `USER` (`Username`)
          ON UPDATE CASCADE
          ON DELETE CASCADE;

ALTER TABLE `POST`
     ADD CONSTRAINT `FK_Post_User`
          FOREIGN KEY (`EkUser`)
          REFERENCES `USER` (`Username`)
          ON UPDATE CASCADE
          ON DELETE CASCADE;

ALTER TABLE `COMMENT`
     ADD CONSTRAINT `FK_Comment_Post`
          FOREIGN KEY (`EkPost`)
          REFERENCES `POST` (`IdPost`)
          ON DELETE CASCADE,
     ADD CONSTRAINT `FK_Comment_User`
          FOREIGN KEY (`EkUser`)
          REFERENCES `USER` (`Username`)
          ON UPDATE CASCADE
          ON DELETE CASCADE;
     -- ADD CONSTRAINT `FK_Comment_CommentParent`
     --      FOREIGN KEY (`EkCommentParent`)
     --      REFERENCES `COMMENT` (`IdComment`)
     --      ON DELETE CASCADE;

ALTER TABLE `LIKE_POST`
     ADD CONSTRAINT `FK_LikePost_Post`
          FOREIGN KEY (`EkPost`)
          REFERENCES `POST` (`IdPost`)
          ON DELETE CASCADE,
     ADD CONSTRAINT `FK_LikePost_User`
          FOREIGN KEY (`EkUser`)
          REFERENCES `USER` (`Username`)
          ON UPDATE CASCADE
          ON DELETE CASCADE;

ALTER TABLE `LIKE_COMMENT`
     ADD CONSTRAINT `FK_LikeComment_Comment`
          FOREIGN KEY (`EkComment`)
          REFERENCES `COMMENT` (`IdComment`)
          ON DELETE CASCADE,
     ADD CONSTRAINT `FK_LikeComment_User`
          FOREIGN KEY (`EkUser`)
          REFERENCES `USER` (`Username`)
          ON UPDATE CASCADE
          ON DELETE CASCADE;

ALTER TABLE `NOTIFICATION`
     ADD CONSTRAINT `FK_Notification_UserDst`
          FOREIGN KEY (`EkUserDst`)
          REFERENCES `USER` (`Username`)
          ON UPDATE CASCADE
          ON DELETE CASCADE,
     ADD CONSTRAINT `FK_Notification_UserSrc`
          FOREIGN KEY (`EkUserSrc`)
          REFERENCES `USER` (`Username`)
          ON UPDATE CASCADE
          ON DELETE CASCADE;


-- Triggers Section
-- ________________

delimiter //

-- username validation
CREATE TRIGGER TRG_validate_username_before_insert
BEFORE INSERT ON `USER`
FOR EACH ROW
BEGIN
    IF NEW.`Username` NOT REGEXP BINARY '^[a-zA-Z][a-zA-Z0-9._-]*$' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Invalid username format';
    END IF;
END//

CREATE TRIGGER TRG_validate_username_before_update
BEFORE UPDATE ON `USER`
FOR EACH ROW
BEGIN
    IF NEW.`Username` NOT REGEXP BINARY '^[a-zA-Z][a-zA-Z0-9._-]*$' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Invalid username format';
    END IF;
END//

-- followers
CREATE TRIGGER TRG_increase_nFollowers_counter AFTER INSERT ON `FOLLOW`
FOR EACH ROW
BEGIN
    UPDATE `USER`
    SET `nFollowers` = `nFollowers` + 1
    WHERE `Username` = NEW.`EkUserFollowed`;
END;//

CREATE TRIGGER TRG_decrease_nFollowers_counter AFTER DELETE ON `FOLLOW`
FOR EACH ROW
BEGIN
    UPDATE `USER`
    SET `nFollowers` = `nFollowers` - 1
    WHERE `Username` = OLD.`EkUserFollowed`;
END;//

-- following
CREATE TRIGGER TRG_increase_nFollowing_counter AFTER INSERT ON `FOLLOW`
FOR EACH ROW
BEGIN
    UPDATE `USER`
    SET `nFollowing` = `nFollowing` + 1
    WHERE `Username` = NEW.`EkUserFollower`;
END;//

CREATE TRIGGER TRG_decrease_nFollowing_counter AFTER DELETE ON `FOLLOW`
FOR EACH ROW
BEGIN
    UPDATE `USER`
    SET `nFollowing` = `nFollowing` - 1
    WHERE `Username` = OLD.`EkUserFollower`;
END;//

-- n posts
CREATE TRIGGER TRG_increase_posts_counter AFTER INSERT ON `POST`
FOR EACH ROW
BEGIN
    UPDATE `USER`
    SET `nPosts` = `nPosts` + 1
    WHERE `Username` = NEW.`EkUser`;
END;//

CREATE TRIGGER TRG_decrease_posts_counter AFTER DELETE ON `POST`
FOR EACH ROW
BEGIN
    UPDATE `USER`
    SET `nPosts` = `nPosts` - 1
    WHERE `Username` = OLD.`EkUser`;
END;//

-- post likes
CREATE TRIGGER TRG_increase_post_likes_counter AFTER INSERT ON `LIKE_POST`
FOR EACH ROW
BEGIN
    UPDATE `POST`
    SET `nLikes` = `nLikes` + 1
    WHERE `IdPost` = NEW.`EkPost`;
END;//

CREATE TRIGGER TRG_decrease_post_likes_counter AFTER DELETE ON `LIKE_POST`
FOR EACH ROW
BEGIN
    UPDATE `POST`
    SET `nLikes` = `nLikes` - 1
    WHERE `IdPost` = OLD.`EkPost`;
END;//

-- comment likes
-- CREATE TRIGGER TRG_increase_comment_likes_counter AFTER INSERT ON `LIKE_COMMENT`
-- FOR EACH ROW
-- BEGIN
--     UPDATE `COMMENT`
--     SET `nLikes` = `nLikes` + 1
--     WHERE `IdComment` = NEW.`EkComment`;
-- END;//

-- CREATE TRIGGER TRG_decrease_comment_likes_counter AFTER DELETE ON `LIKE_COMMENT`
-- FOR EACH ROW
-- BEGIN
--     UPDATE `COMMENT`
--     SET `nLikes` = `nLikes` - 1
--     WHERE `IdComment` = OLD.`EkComment`;
-- END;//

delimiter ;
