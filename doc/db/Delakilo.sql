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
     `IdUser` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     `username` VARCHAR(50) NOT NULL,
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
     PRIMARY KEY (`IdUser`),
     UNIQUE KEY `UniqueUsername` (`username`)
     -- CONSTRAINT `UsernameNotEmptyOrSpacesCheck` CHECK (`username` <> ''
     --      AND `username` NOT LIKE '% %')
) ENGINE = InnoDB;

CREATE TABLE `LOGIN_ATTEMPTS` (
     `EkIdUser` INT UNSIGNED NOT NULL,
     `timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB;

CREATE TABLE `FOLLOW` (
     `EkIdUserFollower` INT UNSIGNED NOT NULL,
     `EkIdUserFollowed` INT UNSIGNED NOT NULL,
     `timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`EkIdUserFollower`, `EkIdUserFollowed`),
     CONSTRAINT `FollowerNotFollowedCheck` CHECK (`EkIdUserFollower` <> `EkIdUserFollowed`)
) ENGINE = InnoDB;

CREATE TABLE `POST` (
     `IdPost` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     `EkIdUser` INT UNSIGNED NOT NULL,
     `imageURL` VARCHAR(400) NOT NULL,
     `caption` VARCHAR(1000) NOT NULL DEFAULT '',
     `nLikes` INT UNSIGNED NOT NULL DEFAULT 0,
     `timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`IdPost`),
     CONSTRAINT `CaptionNotHeadingTrailingSpacesCheck` CHECK (`caption` NOT LIKE ' %'
          AND `caption` NOT LIKE '% ')
) ENGINE = InnoDB;

CREATE TABLE `LIKE_POST` (
     `EkIdUser` INT UNSIGNED NOT NULL,
     `EkIdPost` INT UNSIGNED NOT NULL,
     `timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`EkIdUser`, `EkIdPost`)
) ENGINE = InnoDB;

CREATE TABLE `COMMENT` (
     `IdComment` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     `EkIdUser` INT UNSIGNED NOT NULL,
     `EkIdPost` INT UNSIGNED NOT NULL,
     -- `EkIdCommentParent` INT UNSIGNED DEFAULT NULL,
     `content` VARCHAR(1000) NOT NULL,
     -- `nLikes` INT UNSIGNED NOT NULL DEFAULT 0,
     `timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`IdComment`),
     CONSTRAINT `ContentNotEmptyAndHeadingTrailingSpacesCheck` CHECK (`content` <> ''
          AND `content` NOT LIKE ' %'
          AND `content` NOT LIKE '% ')
) ENGINE = InnoDB;

CREATE TABLE `LIKE_COMMENT` (
     `EkIdUser` INT UNSIGNED NOT NULL,
     `EkIdComment` INT UNSIGNED NOT NULL,
     `timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`EkIdUser`, `EkIdComment`)
) ENGINE = InnoDB;

CREATE TABLE `NOTIFICATION` (
     `IdMessage` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     `EkIdUserDst` INT UNSIGNED NOT NULL,
     `EkIdUserSrc` INT UNSIGNED NOT NULL,
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
          FOREIGN KEY (`EkIdUserFollowed`)
          REFERENCES `USER` (`IdUser`)
          ON UPDATE CASCADE
          ON DELETE CASCADE,
     ADD CONSTRAINT `FK_Follow_UserFollows`
          FOREIGN KEY (`EkIdUserFollower`)
          REFERENCES `USER` (`IdUser`)
          ON UPDATE CASCADE
          ON DELETE CASCADE;

ALTER TABLE `LOGIN_ATTEMPTS`
     ADD CONSTRAINT `FK_Login_User`
          FOREIGN KEY (`EkIdUser`)
          REFERENCES `USER` (`IdUser`)
          ON UPDATE CASCADE
          ON DELETE CASCADE;

ALTER TABLE `POST`
     ADD CONSTRAINT `FK_Post_User`
          FOREIGN KEY (`EkIdUser`)
          REFERENCES `USER` (`IdUser`)
          ON UPDATE CASCADE
          ON DELETE CASCADE;

ALTER TABLE `COMMENT`
     ADD CONSTRAINT `FK_Comment_Post`
          FOREIGN KEY (`EkIdPost`)
          REFERENCES `POST` (`IdPost`)
          ON DELETE CASCADE,
     ADD CONSTRAINT `FK_Comment_User`
          FOREIGN KEY (`EkIdUser`)
          REFERENCES `USER` (`IdUser`)
          ON UPDATE CASCADE
          ON DELETE CASCADE;
     -- ADD CONSTRAINT `FK_Comment_CommentParent`
     --      FOREIGN KEY (`EkIdCommentParent`)
     --      REFERENCES `COMMENT` (`IdComment`)
     --      ON DELETE CASCADE;

ALTER TABLE `LIKE_POST`
     ADD CONSTRAINT `FK_LikePost_Post`
          FOREIGN KEY (`EkIdPost`)
          REFERENCES `POST` (`IdPost`)
          ON DELETE CASCADE,
     ADD CONSTRAINT `FK_LikePost_User`
          FOREIGN KEY (`EkIdUser`)
          REFERENCES `USER` (`IdUser`)
          ON UPDATE CASCADE
          ON DELETE CASCADE;

ALTER TABLE `LIKE_COMMENT`
     ADD CONSTRAINT `FK_LikeComment_Comment`
          FOREIGN KEY (`EkIdComment`)
          REFERENCES `COMMENT` (`IdComment`)
          ON DELETE CASCADE,
     ADD CONSTRAINT `FK_LikeComment_User`
          FOREIGN KEY (`EkIdUser`)
          REFERENCES `USER` (`IdUser`)
          ON UPDATE CASCADE
          ON DELETE CASCADE;

ALTER TABLE `NOTIFICATION`
     ADD CONSTRAINT `FK_Notification_UserDst`
          FOREIGN KEY (`EkIdUserDst`)
          REFERENCES `USER` (`IdUser`)
          ON UPDATE CASCADE
          ON DELETE CASCADE,
     ADD CONSTRAINT `FK_Notification_UserSrc`
          FOREIGN KEY (`EkIdUserSrc`)
          REFERENCES `USER` (`IdUser`)
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
    IF NEW.`username` NOT REGEXP BINARY '^[a-zA-Z][a-zA-Z0-9._-]*$' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Invalid username format';
    END IF;
END//

CREATE TRIGGER TRG_validate_username_before_update
BEFORE UPDATE ON `USER`
FOR EACH ROW
BEGIN
    IF NEW.`username` NOT REGEXP BINARY '^[a-zA-Z][a-zA-Z0-9._-]*$' THEN
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
    WHERE `IdUser` = NEW.`EkIdUserFollowed`;
END;//

CREATE TRIGGER TRG_decrease_nFollowers_counter AFTER DELETE ON `FOLLOW`
FOR EACH ROW
BEGIN
    UPDATE `USER`
    SET `nFollowers` = `nFollowers` - 1
    WHERE `IdUser` = OLD.`EkIdUserFollowed`;
END;//

-- following
CREATE TRIGGER TRG_increase_nFollowing_counter AFTER INSERT ON `FOLLOW`
FOR EACH ROW
BEGIN
    UPDATE `USER`
    SET `nFollowing` = `nFollowing` + 1
    WHERE `IdUser` = NEW.`EkIdUserFollower`;
END;//

CREATE TRIGGER TRG_decrease_nFollowing_counter AFTER DELETE ON `FOLLOW`
FOR EACH ROW
BEGIN
    UPDATE `USER`
    SET `nFollowing` = `nFollowing` - 1
    WHERE `IdUser` = OLD.`EkIdUserFollower`;
END;//

-- n posts
CREATE TRIGGER TRG_increase_posts_counter AFTER INSERT ON `POST`
FOR EACH ROW
BEGIN
    UPDATE `USER`
    SET `nPosts` = `nPosts` + 1
    WHERE `IdUser` = NEW.`EkIdUser`;
END;//

CREATE TRIGGER TRG_decrease_posts_counter AFTER DELETE ON `POST`
FOR EACH ROW
BEGIN
    UPDATE `USER`
    SET `nPosts` = `nPosts` - 1
    WHERE `IdUser` = OLD.`EkIdUser`;
END;//

-- post likes
CREATE TRIGGER TRG_increase_post_likes_counter AFTER INSERT ON `LIKE_POST`
FOR EACH ROW
BEGIN
    UPDATE `POST`
    SET `nLikes` = `nLikes` + 1
    WHERE `IdPost` = NEW.`EkIdPost`;
END;//

CREATE TRIGGER TRG_decrease_post_likes_counter AFTER DELETE ON `LIKE_POST`
FOR EACH ROW
BEGIN
    UPDATE `POST`
    SET `nLikes` = `nLikes` - 1
    WHERE `IdPost` = OLD.`EkIdPost`;
END;//

-- comment likes
-- CREATE TRIGGER TRG_increase_comment_likes_counter AFTER INSERT ON `LIKE_COMMENT`
-- FOR EACH ROW
-- BEGIN
--     UPDATE `COMMENT`
--     SET `nLikes` = `nLikes` + 1
--     WHERE `IdComment` = NEW.`EkIdComment`;
-- END;//

-- CREATE TRIGGER TRG_decrease_comment_likes_counter AFTER DELETE ON `LIKE_COMMENT`
-- FOR EACH ROW
-- BEGIN
--     UPDATE `COMMENT`
--     SET `nLikes` = `nLikes` - 1
--     WHERE `IdComment` = OLD.`EkIdComment`;
-- END;//

delimiter ;

-- Indexes Section
-- _______________

-- USER
CREATE INDEX `IDX_User_username`
     ON `USER` (`username`);
CREATE INDEX `IDX_User_name`
     ON `USER` (`name`);
CREATE INDEX `IDX_User_surname`
     ON `USER` (`surname`);
CREATE INDEX `IDX_User_timestamp`
     ON `USER` (`timestamp` DESC);

-- LOGIN
CREATE INDEX `IDX_LoginAttempts_user`
     ON `LOGIN_ATTEMPTS` (`EkIdUser`);
CREATE INDEX `IDX_LoginAttempts_timestamp`
     ON `LOGIN_ATTEMPTS` (`timestamp` DESC);

-- FOLLOW
CREATE INDEX `IDX_Follow_follower`
     ON `FOLLOW` (`EkIdUserFollower`);
CREATE INDEX `IDX_Follow_followed`
     ON `FOLLOW` (`EkIdUserFollowed`);
CREATE INDEX `IDX_Follow_timestamp`
     ON `FOLLOW` (`timestamp` DESC);

-- POST
CREATE INDEX `IDX_Post_user`
     ON `POST` (`EkIdUser`);
CREATE INDEX `IDX_Post_timestamp`
     ON `POST` (`timestamp` DESC);

-- LIKE POST
CREATE INDEX `IDX_LikePost_user`
     ON `LIKE_POST` (`EkIdUser`);
CREATE INDEX `IDX_LikePost_post`
     ON `LIKE_POST` (`EkIdPost`);
CREATE INDEX `IDX_LikePost_timestamp`
     ON `LIKE_POST` (`timestamp` DESC);

-- COMMENT
CREATE INDEX `IDX_Comment_user`
     ON `COMMENT` (`EkIdUser`);
CREATE INDEX `IDX_Comment_post`
     ON `COMMENT` (`EkIdPost`);
CREATE INDEX `IDX_Comment_timestamp`
     ON `COMMENT` (`timestamp` DESC);

-- LIKE COMMENT
CREATE INDEX `IDX_LikeComment_user`
     ON `LIKE_COMMENT` (`EkIdUser`);
CREATE INDEX `IDX_LikeComment_comment`
     ON `LIKE_COMMENT` (`EkIdComment`);
CREATE INDEX `IDX_LikeComment_timestamp`
     ON `LIKE_COMMENT` (`timestamp` DESC);

-- NOTIFICATION
CREATE INDEX `IDX_Notification_userdst`
     ON `NOTIFICATION` (`EkIdUserDst`);
CREATE INDEX `IDX_Notification_timestamp`
     ON `NOTIFICATION` (`timestamp` DESC);
