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
     `username` VARCHAR(50) NOT NULL,
     -- `email` VARCHAR(50) UNIQUE DEFAULT NULL,
     -- TODO: random string of maximum length 1004 considering that a password has to be of 20 characters at least
     `salt` VARCHAR(1004) NOT NULL,
     `password_hash` VARCHAR(1024) NOT NULL,
     `name` VARCHAR(50) NOT NULL DEFAULT '',
     `surname` VARCHAR(50) NOT NULL DEFAULT '',
     -- `birthday` DATE DEFAULT NULL,
     `bio` VARCHAR(500) NOT NULL DEFAULT '',
     -- TODO: come default va messa l'URL all'immagine profilo standard
     `image_URL` VARCHAR(400) NOT NULL,
     `registration_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
     `n_followers` INT UNSIGNED NOT NULL DEFAULT 0,
     `n_followed` INT UNSIGNED NOT NULL DEFAULT 0,
     `n_posts` INT UNSIGNED NOT NULL DEFAULT 0,
     PRIMARY KEY (`username`)
) ENGINE = InnoDB;

CREATE TABLE `POST` (
     `ID_post` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     `image_URL` VARCHAR(400) NOT NULL,
     `caption` VARCHAR(1000) NOT NULL DEFAULT '',
     `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
     `PK_User` VARCHAR(50) NOT NULL,
     PRIMARY KEY (`ID_post`)
) ENGINE = InnoDB;

CREATE TABLE `COMMENT` (
     `ID_comment` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     `PK_User` VARCHAR(50) NOT NULL,
     `PK_Post` INT UNSIGNED NOT NULL,
     `content` VARCHAR(1000) NOT NULL,
     `PK_Comment_parent` INT UNSIGNED DEFAULT NULL,
     `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`ID_comment`),
     CONSTRAINT `ContentCheck` CHECK (CHAR_LENGTH(`content`) > 0)
) ENGINE = InnoDB;

CREATE TABLE `FOLLOW` (
     `PK_User_follows` VARCHAR(50) NOT NULL,
     `PK_User_followed` VARCHAR(50) NOT NULL,
     `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`PK_User_follows`, `PK_User_followed`)
) ENGINE = InnoDB;

CREATE TABLE `LIKE` (
     `PK_Post` INT UNSIGNED NOT NULL,
     `PK_User` VARCHAR(50) NOT NULL,
     `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`PK_Post`, `PK_User`)
) ENGINE = InnoDB;

CREATE TABLE `NOTIFICATION` (
     `ID_message` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     `content` VARCHAR(500) NOT NULL,
     `PK_User_dst` VARCHAR(50) NOT NULL,
     `PK_User_src` VARCHAR(50) NOT NULL,
     `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`ID_message`),
     CONSTRAINT `ContentCheck` CHECK (CHAR_LENGTH(`content`) > 0)
) ENGINE = InnoDB;


-- Constraints Section
-- ___________________

ALTER TABLE `COMMENT` ADD CONSTRAINT `FK_Comment_Post`
     FOREIGN KEY (`PK_Post`)
     REFERENCES `POST` (`ID_post`)
     ON DELETE CASCADE;

ALTER TABLE `COMMENT` ADD CONSTRAINT `FK_Comment_User`
     FOREIGN KEY (`PK_User`)
     REFERENCES `USER` (`username`)
     ON UPDATE CASCADE
     ON DELETE CASCADE;

ALTER TABLE `COMMENT` ADD CONSTRAINT `FK_Comment_CommentParent`
     FOREIGN KEY (`PK_Comment_parent`)
     REFERENCES `COMMENT` (`ID_comment`)
     ON DELETE CASCADE;

ALTER TABLE `FOLLOW` ADD CONSTRAINT `FK_Follow_UserFollowed`
     FOREIGN KEY (`PK_User_followed`)
     REFERENCES `USER` (`username`)
     ON UPDATE CASCADE
     ON DELETE CASCADE;

ALTER TABLE `FOLLOW` ADD CONSTRAINT `FK_Follow_UserFollows`
     FOREIGN KEY (`PK_User_follows`)
     REFERENCES `USER` (`username`)
     ON UPDATE CASCADE
     ON DELETE CASCADE;

ALTER TABLE `LIKE` ADD CONSTRAINT `FK_Like_Post`
     FOREIGN KEY (`PK_Post`)
     REFERENCES `POST` (`ID_post`)
     ON DELETE CASCADE;

ALTER TABLE `LIKE` ADD CONSTRAINT `FK_Like_User`
     FOREIGN KEY (`PK_User`)
     REFERENCES `USER` (`username`)
     ON UPDATE CASCADE
     ON DELETE CASCADE;

ALTER TABLE `NOTIFICATION` ADD CONSTRAINT `FK_Notification_UserDst`
     FOREIGN KEY (`PK_User_dst`)
     REFERENCES `USER` (`username`)
     ON UPDATE CASCADE
     ON DELETE CASCADE;

ALTER TABLE `NOTIFICATION` ADD CONSTRAINT `FK_Notification_UserSrc`
     FOREIGN KEY (`PK_User_src`)
     REFERENCES `USER` (`username`)
     ON UPDATE CASCADE
     ON DELETE CASCADE;

ALTER TABLE `POST` ADD CONSTRAINT `FK_Post_User`
     FOREIGN KEY (`PK_User`)
     REFERENCES `USER` (`username`)
     ON UPDATE CASCADE
     ON DELETE CASCADE;
