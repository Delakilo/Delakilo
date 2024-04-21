<?php

class DatabaseHelper {
    private $conn;

    function __construct($serverName, $username, $password, $connName, $port) {
        // Reports MySQL errors
        mysqli_report(MYSQLI_REPORT_ALL);
        $this->conn = new mysqli($serverName, $username, $password, $connName, $port);
        if ($this->conn->connect_error) {
            die("Connection with MySQL failed: ".$this->conn->connect_error);
        }
    }

    function __destruct() {
        $this->conn->close();
    }


    // USERS LOGIN
    private function checkBrute($username) {
        if ($stmt = $this->conn->prepare('SELECT `timestamp`
                                          FROM `LOGIN_ATTEMPTS`
                                          WHERE `EkUser` = ?
                                            AND `timestamp` > DATE_SUB(NOW(), INTERVAL '.LOGIN_HOURS_ATTEMPTS_VALIDITY.' HOUR)')) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > LOGIN_MAX_ATTEMPTS) {
                return true;
            } else {
                return false;
            }
        }
    }

    function userLoginCheck() {
        if (is_user_logged() && isset($_SESSION['login_string'])) {
            $login_string = $_SESSION['login_string'];
            $username = get_username();
            $user_browser = $_SERVER['HTTP_USER_AGENT'];

            if ($stmt = $this->conn->prepare('SELECT `passwordHash` FROM `USER` WHERE `Username` = ? LIMIT 1;')) { 
                $stmt->bind_param('s', $username);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($passwordHash);
                    $stmt->fetch();
                    $login_check = sha512($passwordHash.$user_browser);
                    if ($login_check == $login_string) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function userLogin($username, $password) {
        if ($stmt = $this->conn->prepare('SELECT `passwordSalt`, `passwordHash`
                                          FROM `USER`
                                          WHERE `Username` = ? LIMIT 1;')) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($salt, $passwordHash);
            $stmt->fetch();
            $computedPasswordHash = sha512($salt.$password);
            if ($stmt->num_rows == 1) {
                if($this->checkBrute($username, $this->conn) == true) {
                    $GLOBALS['log']->logWarning('"'.$username.'" account was denied access because '.LOGIN_MAX_ATTEMPTS
                        .' attempts of logins where reached in the last '.LOGIN_HOURS_ATTEMPTS_VALIDITY.' hours');
                    return false;
                } else {
                    if($passwordHash === $computedPasswordHash) {
                        $userBrowser = $_SERVER['HTTP_USER_AGENT'];

                        // Prevents XSS attack
                        $username = preg_replace("/[^a-zA-Z0-9._\-]+/", "", $username);
                        register_logged_user($username);
                        $_SESSION['login_string'] = sha512($passwordHash.$userBrowser);
                        return true;
                    } else {
                        $stmt = $this->conn->prepare('INSERT INTO `LOGIN_ATTEMPTS` (`EkUser`) VALUES (?);');

                        $stmt->bind_param('s', $username);
                        $stmt->execute();
                        if ($stmt->affected_rows != 1) {
                            $GLOBALS['log']->logError('Unable to trace '.$username.' login attempt correctly');
                        }
                        return false;
                    }
                }
            } else {
                return false;
            }
        }
    }

    function userRegister($username, $password) {
        $stmt = $this->conn->prepare('INSERT INTO `USER` (`Username`, `passwordSalt`, `passwordHash`)
                                      VALUES (?, ?, ?);');

        $salt = generate_random_string(255);
        $passwordHash = sha512($salt.$password);
        $stmt->bind_param('sss', $username, $salt, $passwordHash);
        $stmt->execute();
    }

    function userExists($username) {
        $stmt = $this->conn->prepare('SELECT `Username`
                                      FROM `USER`
                                      WHERE `Username` = ?;');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        $rows = $result->fetch_all(MYSQLI_ASSOC);
        return count($rows) > 0;
    }

    // USERS MANAGEMENT
    function usersGetNamesByBaseName($name) {
        $stmt = $this->conn->prepare('SELECT `Username`, `imageURL`
                                    FROM `USER`
                                    WHERE `Username` LIKE ?
                                        OR `name` LIKE ?
                                        OR `surname` LIKE ?;');
        $pattern = '%'.$name.'%';
        $stmt->bind_param('sss', $pattern, $pattern, $pattern);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    function userGetInfoByName($username) {
        $stmt = $this->conn->prepare('SELECT `Username`, `name`, `surname`, `bio`, `imageURL`, `nFollowers`, `nFollowed`, `nPosts`
                                    FROM `USER`
                                    WHERE `Username` = ?;');
        $username = get_username();
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function userGetFollowing($username) {
        $stmt = $this->conn->prepare('SELECT U.`Username`, U.`imageURL`
                                    FROM `FOLLOW` F JOIN `USER` U ON (F.`EkUserFollowed` = U.`Username`)
                                    WHERE F.`EkUserFollower` = ?
                                    ORDER BY F.`timestamp` DESC;');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    function userGetMyFollowing() {
        $username = get_username();
        return $this->userGetFollowing($username);
    }
    function userGetFollowers($username) {
        $stmt = $this->conn->prepare('SELECT U.`Username`, U.`imageURL`
                                    FROM `FOLLOW` F JOIN `USER` U ON (F.`EkUserFollower` = U.`Username`)
                                    WHERE F.`EkUserFollowed` = ?
                                    ORDER BY F.`timestamp` DESC;');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    function userGetMyFollowers() {
        $username = get_username();
        return $this->userGetFollowers($username);
    }

    function userFollow($username) {
        $stmt = $this->conn->prepare('INSERT INTO `FOLLOW` (`EkUserFollower`, `EkUserFollowed`)
                                    VALUES (?, ?);');
        $stmt->bind_param('ss', $username, $username);
        $stmt->execute();
    }
    function userUnfollow($username) {
        $stmt = $this->conn->prepare('DELETE FROM `FOLLOW`
                                    WHERE `EkUserFollower` = ?
                                        AND `EkUserFollowed` = ?;');
        $stmt->bind_param('ss', $username, $username);
        $stmt->execute();
    }

    function userEditProfile($username, $name, $surname, $bio, $imageURL) {
        $stmt = $this->conn->prepare('UPDATE `USER`
                                    SET `Username` = ?,
                                        `name` = ?,
                                        `surname` = ?,
                                        `bio` = ?,
                                        `imageURL` = ?
                                    WHERE `Username` = ?;');
        $oldUsername = get_username();
        $stmt->bind_param('ssssss', $username, $name, $surname, $imageURL, $bio, $caption, $oldUsername);
        $stmt->execute();

        if ($stmt) {
            register_logged_user($username);
        }
    }

    // COMMENTS
    function commentsGetByPost($postID) {
        $stmt = $this->conn->prepare('SELECT C.`EkUser`, C.`content`, C.`timestamp`, U.`imageURL`
                                    FROM `COMMENT` C JOIN `USER` U ON (C.`EkUser` = U.`Username`)
                                    WHERE C.`EkPost` = ?
                                    ORDER BY C.`timestamp` DESC;');
        $stmt->bind_param('s', $postID);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function commentLike($commentID) {
        $stmt = $this->conn->prepare('INSERT INTO `LIKE_COMMENT` (`EkUser`, `EkComment`)
                                    VALUES (?, ?);');
        $username = get_username();
        $stmt->bind_param('ss', $username, $postID);
        $stmt->execute();
    }
    function commentUnlike($commentID) {
        $stmt = $this->conn->prepare('DELETE FROM `LIKE_COMMENT`
                                    WHERE `EkUser` = ?
                                        AND `EkComment` = ?;');
        $username = get_username();
        $stmt->bind_param('ss', $username, $postID);
        $stmt->execute();
    }
    function commentPost($postID, $content) {
        $stmt = $this->conn->prepare('INSERT INTO `COMMENT` (`EkUser`, `EkPost`, `content`)
                                    VALUES (?, ?, ?);');
        $username = get_username();
        $stmt->bind_param('ss', $username, $postID, $content);
        $stmt->execute();
    }

    // NOTIFICATIONS
    function notificationsGet() {
        $stmt = $this->conn->prepare('SELECT `EkUserSrc`, `content`, `timestamp`
                                    FROM `NOTIFICATION`
                                    WHERE `EkUserDst` = ?
                                    ORDER BY `timestamp` DESC;');
        $username = get_username();
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function notificationSend($postID, $content) {
        $stmt = $this->conn->prepare('DELETE FROM `COMMENT`
                                    WHERE `EkUser` = ?
                                        AND `EkPost` = ?
                                        AND `content` = ?;');
        $username = get_username();
        $stmt->bind_param('sss', $username, $postID, $content);
        $stmt->execute();
    }

    // POSTS
    function postsGetFromFollowingUsers() {
        $stmt = $this->conn->prepare('SELECT P.`EkUser`, P.`imageURL`, P.`caption`, P.`nLikes`, P.`timestamp`
                                    FROM `FOLLOW` F JOIN `POST` P ON (P.`EkUser` = F.`EkUserFollowed`)
                                    WHERE F.`EkUserFollower` = ?
                                    ORDER BY P.`timestamp` DESC;');
        $username = get_username();
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    function postsGetAll() {
        $stmt = $this->conn->prepare('SELECT `EkUser`, `imageURL`, `caption`, `nLikes`, `timestamp`
                                    FROM `POST`
                                    ORDER BY RAND();');
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    function postsGetFromUser($username) {
        $stmt = $this->conn->prepare('SELECT `EkUser`, `imageURL`, `caption`, `nLikes`, `timestamp`
                                    FROM `POST`
                                    WHERE `EkUser` = ?
                                    ORDER BY `timestamp` DESC;');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    function postsGetMy() {
        $username = get_username();
        return $this->postsGetFromUser($username);
    }

    function postLike($postID) {
        $stmt = $this->conn->prepare('INSERT INTO `LIKE_POST` (`EkUser`, `EkUser`)
                                    VALUES (?, ?);');
        $username = get_username();
        $stmt->bind_param('ss', $username, $postID);
        $stmt->execute();
    }
    function postUnlike($postID) {
        $stmt = $this->conn->prepare('DELETE FROM `LIKE_POST`
                                    WHERE `EkUser` = ?
                                        AND `EkPost` = ?;');
        $username = get_username();
        $stmt->bind_param('ss', $username, $postID);
        $stmt->execute();
    }
    function postAdd($imageURL, $caption = '') {
        $stmt = $this->conn->prepare('INSERT INTO `POST` (`EkUser`, `imageURL`, `caption`)
                                    VALUES (?, ?, ?);');
        $username = get_username();
        $stmt->bind_param('ss', $username, $imageURL, $caption);
        $stmt->execute();
    }
}

?>
