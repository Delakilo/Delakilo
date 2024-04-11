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
CREATE DATABASE `Delakilo` DEFAULT CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci';
USE `Delakilo`;


-- Tables Section
-- ______________

CREATE TABLE `USER` (
     `Username` VARCHAR(50) NOT NULL,
     -- `email` VARCHAR(50) UNIQUE DEFAULT NULL,
     -- TODO: random string of maximum length 1004 considering that a password has to be of 20 characters at least
     `passwordSalt` VARCHAR(1004) NOT NULL,
     `passwordHash` VARCHAR(1024) NOT NULL,
     `name` VARCHAR(50) NOT NULL DEFAULT '',
     `surname` VARCHAR(50) NOT NULL DEFAULT '',
     -- `birthday` DATE DEFAULT NULL,
     `bio` VARCHAR(500) NOT NULL DEFAULT '',
     `imageURL` VARCHAR(400) NOT NULL, -- DEFAULT 'profile.svg', TODO: decide how to do this
     `nFollowers` INT UNSIGNED NOT NULL DEFAULT 0,
     `nFollowed` INT UNSIGNED NOT NULL DEFAULT 0,
     `nPosts` INT UNSIGNED NOT NULL DEFAULT 0,
     `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`Username`)
) ENGINE = InnoDB;

CREATE TABLE `FOLLOW` (
     `EkUserFollows` VARCHAR(50) NOT NULL,
     `EkUserFollowed` VARCHAR(50) NOT NULL,
     `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`EkUserFollows`, `EkUserFollowed`)
) ENGINE = InnoDB;

CREATE TABLE `POST` (
     `IdPost` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     `EkUser` VARCHAR(50) NOT NULL,
     `imageURL` VARCHAR(400) NOT NULL,
     `caption` VARCHAR(1000) NOT NULL DEFAULT '',
     `nLikes` INT UNSIGNED NOT NULL DEFAULT 0,
     `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`IdPost`)
) ENGINE = InnoDB;

CREATE TABLE `LIKE` (
     `EkPost` INT UNSIGNED NOT NULL,
     `EkUser` VARCHAR(50) NOT NULL,
     `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`EkPost`, `EkUser`)
) ENGINE = InnoDB;

CREATE TABLE `COMMENT` (
     `IdComment` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     `EkUser` VARCHAR(50) NOT NULL,
     `EkPost` INT UNSIGNED NOT NULL,
     `EkCommentParent` INT UNSIGNED DEFAULT NULL,
     `content` VARCHAR(1000) NOT NULL,
     `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`IdComment`),
     CONSTRAINT `ContentCheck` CHECK (CHAR_LENGTH(`content`) > 0)
) ENGINE = InnoDB;

CREATE TABLE `NOTIFICATION` (
     `IdMessage` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     `EkUserDst` VARCHAR(50) NOT NULL,
     `EkUserSrc` VARCHAR(50) NOT NULL,
     `content` VARCHAR(500) NOT NULL,
     `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`IdMessage`),
     CONSTRAINT `ContentCheck` CHECK (CHAR_LENGTH(`content`) > 0)
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
          FOREIGN KEY (`EkUserFollows`)
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
          ON DELETE CASCADE,
     ADD CONSTRAINT `FK_Comment_CommentParent`
          FOREIGN KEY (`EkCommentParent`)
          REFERENCES `COMMENT` (`IdComment`)
          ON DELETE CASCADE;

ALTER TABLE `LIKE`
     ADD CONSTRAINT `FK_Like_Post`
          FOREIGN KEY (`EkPost`)
          REFERENCES `POST` (`IdPost`)
          ON DELETE CASCADE,
     ADD CONSTRAINT `FK_Like_User`
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

CREATE TRIGGER TRG_increase_nFollowers_counter AFTER INSERT ON `FOLLOW`
FOR EACH ROW
BEGIN
    UPDATE `USER`
    SET `nFollowers` = `nFollowers` + 1
    WHERE `Username` = NEW.`EkUserFollows`;
END;//

CREATE TRIGGER TRG_decrease_nFollowers_counter AFTER DELETE ON `FOLLOW`
FOR EACH ROW
BEGIN
    UPDATE `USER`
    SET `nFollowers` = `nFollowers` - 1
    WHERE `Username` = OLD.`EkUserFollowed`;
END;//

CREATE TRIGGER TRG_increase_nFollowed_counter AFTER INSERT ON `FOLLOW`
FOR EACH ROW
BEGIN
    UPDATE `USER`
    SET `nFollowed` = `nFollowed` + 1
    WHERE `Username` = NEW.`EkUserFollowed`;
END;//

CREATE TRIGGER TRG_decrease_nFollowed_counter AFTER DELETE ON `FOLLOW`
FOR EACH ROW
BEGIN
    UPDATE `USER`
    SET `nFollowed` = `nFollowed` - 1
    WHERE `Username` = OLD.`EkUserFollows`;
END;//

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

CREATE TRIGGER TRG_increase_like_counter AFTER INSERT ON `LIKE`
FOR EACH ROW
BEGIN
    UPDATE `POST`
    SET `nLikes` = `nLikes` + 1
    WHERE `EkUser` = NEW.`EkUser`;
END;//

CREATE TRIGGER TRG_decrease_like_counter AFTER DELETE ON `LIKE`
FOR EACH ROW
BEGIN
    UPDATE `POST`
    SET `nLikes` = `nLikes` - 1
    WHERE `EkUser` = OLD.`EkUser`;
END;//

delimiter ;
