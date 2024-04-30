<?php

class DatabaseHelper {
    private $conn;

    function __construct($serverName, $username, $password, $connName, $port) {
        // Reports MySQL errors
        // mysqli_report(MYSQLI_REPORT_ALL);
        mysqli_report(MYSQLI_REPORT_STRICT);
        $this->conn = new mysqli($serverName, $username, $password, $connName, $port);
        if (mysqli_connect_errno()) {
            $error = mysqli_connect_error();
            die("Connection with MySQL failed: ".$error);
        }
    }
    function __destruct() {
        $this->conn->close();
    }

    // USERS LOGIN
    private function checkBrute($user_id) {
        if ($stmt = $this->conn->prepare('SELECT *
                                          FROM `LOGIN_ATTEMPTS`
                                          WHERE `EkIdUser` = ?
                                            AND `timestamp` > DATE_SUB(NOW(), INTERVAL '.LOGIN_HOURS_ATTEMPTS_VALIDITY.' HOUR);')) {
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > LOGIN_MAX_ATTEMPTS) {
                return true;
            }
        }
        return false;
    }

    function userIsAlreadyLogged() {
        if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
            $user_id = $_SESSION['user_id'];
            $username = $_SESSION['username'];
            $login_string = $_SESSION['login_string'];
            $user_browser = $_SERVER['HTTP_USER_AGENT'];

            if ($stmt = $this->conn->prepare('SELECT `IdUser`, `passwordHash`
                                              FROM `USER`
                                              WHERE `username` = ?;')) {
                $stmt->bind_param('s', $username);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $passwordHash);
                    $stmt->fetch();
                    if ($id == $user_id) {
                        $login_check = sha512($passwordHash.$user_browser);
                        if ($login_check == $login_string) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    function userLogin($username, $password) {
        if ($stmt = $this->conn->prepare('SELECT `IdUser`, `passwordSalt`, `passwordHash`
                                          FROM `USER`
                                          WHERE `username` = ?;')) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($user_id, $salt, $passwordHash);
            $stmt->fetch();
            $computedPasswordHash = sha512($salt.$password);

            if ($stmt->num_rows == 1) {
                if ($this->checkBrute($user_id)) {
                    $GLOBALS['log']->logWarning($username.' account was denied access because '.LOGIN_MAX_ATTEMPTS
                        .' attempts of logins where reached in the last '.LOGIN_HOURS_ATTEMPTS_VALIDITY.' hours');
                } else if ($passwordHash == $computedPasswordHash) {
                    $userBrowser = $_SERVER['HTTP_USER_AGENT'];

                    // Preventing XSS attacks
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    $username = preg_replace("/[^a-zA-Z0-9._\-]+/", "", $username);
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = sha512($passwordHash.$userBrowser);
                    return true;
                } else {
                    $stmt = $this->conn->prepare('INSERT INTO `LOGIN_ATTEMPTS` (`EkIdUser`) VALUES (?);');

                    $stmt->bind_param('s', $user_id);
                    $stmt->execute();
                }
            }
        }
        return false;
    }

    function userRegister($username, $password) {
        $profileName = 'default.svg';
        $stmt = $this->conn->prepare('INSERT INTO `USER` (`username`, `passwordSalt`, `passwordHash`, `imageURL`)
                                      VALUES (?, ?, ?, \''.$profileName.'\');');
        $salt = generate_random_string(255);
        $passwordHash = sha512($salt.$password);
        $stmt->bind_param('sss', $username, $salt, $passwordHash);

        if ($stmt->execute()) {
            $user_id = $this->conn->insert_id;
            return create_user_dirs($user_id, $profileName);
        }
        return false;
    }

    function userExists($username) {
        $stmt = $this->conn->prepare('SELECT `username`
                                      FROM `USER`
                                      WHERE `username` = ?;');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        $rows = $result->fetch_all(MYSQLI_ASSOC);
        return count($rows) == 1;
    }

    // USERS MANAGEMENT
    function usersGetByBaseName($name) {
        $stmt = $this->conn->prepare('SELECT `IdUser`, `username`, `imageURL`
                                      FROM `USER`
                                      WHERE `username` LIKE ?
                                        OR `name` LIKE ?
                                        OR `surname` LIKE ?;');
        $pattern = '%'.$name.'%';
        $stmt->bind_param('sss', $pattern, $pattern, $pattern);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    function userGetInfoById($user_id) {
        $stmt = $this->conn->prepare('SELECT `username`, `name`, `surname`, `bio`, `imageURL`, `nFollowers`, `nFollowing`, `nPosts`
                                      FROM `USER`
                                      WHERE `IdUser` = ?;');
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function userGetFollowing($user_id) {
        $stmt = $this->conn->prepare('SELECT U.`IdUser`, U.`username`, U.`imageURL`
                                      FROM `FOLLOW` F JOIN `USER` U ON (F.`EkIdUserFollowed` = U.`IdUser`)
                                      WHERE F.`EkIdUserFollower` = ?
                                      ORDER BY F.`timestamp` DESC;');
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    function userGetMyFollowing() {
        $user_id = get_user_id();
        return $this->userGetFollowing($user_id);
    }
    function userGetFollowers($user_id) {
        $stmt = $this->conn->prepare('SELECT U.`IdUser`, U.`username`, U.`imageURL`
                                      FROM `FOLLOW` F JOIN `USER` U ON (F.`EkIdUserFollower` = U.`IdUser`)
                                      WHERE F.`EkIdUserFollowed` = ?
                                      ORDER BY F.`timestamp` DESC;');
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    function userGetMyFollowers() {
        $user_id = get_user_id();
        return $this->userGetFollowers($user_id);
    }

    function userFollow($user_id) {
        $stmt = $this->conn->prepare('INSERT INTO `FOLLOW` (`EkIdUserFollower`, `EkIdUserFollowed`)
                                      VALUES (?, ?);');
        $stmt->bind_param('ii', $_SESSION['user_id'], $user_id);
        $stmt->execute();
    }
    function userUnfollow($user_id) {
        $stmt = $this->conn->prepare('DELETE FROM `FOLLOW`
                                      WHERE `EkIdUserFollower` = ?
                                        AND `EkIdUserFollowed` = ?;');
        $stmt->bind_param('ii', $_SESSION['user_id'], $user_id);
        $stmt->execute();
    }

    function userEditProfile($username, $name, $surname, $bio, $imageURL) {
        $stmt = $this->conn->prepare('UPDATE `USER`
                                      SET `username` = ?,
                                          `name` = ?,
                                          `surname` = ?,
                                          `imageURL` = ?,
                                          `bio` = ?,
                                          `caption` = ?,
                                      WHERE `username` = ?;');
        $oldUsername = get_username();
        $stmt->bind_param('sssssss', $username, $name, $surname, $imageURL, $bio, $caption, $oldUsername);

        if ($stmt->execute()) {
            $_SESSION['username'] = $username;
        }
    }

    // COMMENTS
    function commentsGetByPost($postID) {
        $stmt = $this->conn->prepare('SELECT C.`EkIdUser`, C.`content`, C.`timestamp`, U.`imageURL`
                                      FROM `COMMENT` C JOIN `USER` U ON (C.`EkIdUser` = U.`IdUser`)
                                      WHERE C.`EkIdPost` = ?
                                      ORDER BY C.`timestamp` DESC;');
        $stmt->bind_param('i', $postID);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function commentLike($commentID) {
        $stmt = $this->conn->prepare('INSERT INTO `LIKE_COMMENT` (`EkIdUser`, `EkIdComment`)
                                      VALUES (?, ?);');
        $user_id = get_user_id();
        $stmt->bind_param('ii', $user_id, $postID);
        $stmt->execute();
    }
    function commentUnlike($commentID) {
        $stmt = $this->conn->prepare('DELETE FROM `LIKE_COMMENT`
                                      WHERE `EkIdUser` = ?
                                        AND `EkIdComment` = ?;');
        $user_id = get_user_id();
        $stmt->bind_param('ii', $user_id, $postID);
        $stmt->execute();
    }
    function commentPost($postID, $content) {
        $stmt = $this->conn->prepare('INSERT INTO `COMMENT` (`EkIdUser`, `EkIdPost`, `content`)
                                      VALUES (?, ?, ?);');
        $user_id = get_user_id();
        $stmt->bind_param('iis', $user_id, $postID, $content);
        $stmt->execute();
    }

    // NOTIFICATIONS
    function notificationsGet() {
        $stmt = $this->conn->prepare('SELECT `EkIdUserSrc`, `message`, `timestamp`
                                      FROM `NOTIFICATION`
                                      WHERE `EkIdUserDst` = ?
                                      ORDER BY `timestamp` DESC;');
        $user_id = get_user_id();
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function notificationSend($postID, $content) {
        $stmt = $this->conn->prepare('DELETE FROM `COMMENT`
                                      WHERE `EkIdUser` = ?
                                        AND `EkIdPost` = ?
                                        AND `content` = ?;');
        $username = get_user_id();
        $stmt->bind_param('iis', $user_id, $postID, $content);
        $stmt->execute();
    }

    // POSTS
    function postsGetFromFollowingUsers() {
        $stmt = $this->conn->prepare('SELECT U.`username`, U.`imageURL` AS `imgProfile`, P.`EkIdUser`, P.`imageURL` AS `imgPost`, P.`caption`, P.`nLikes`, P.`timestamp`
                                      FROM `USER` U,`FOLLOW` F JOIN `POST` P ON (P.`EkIdUser` = F.`EkIdUserFollowed`)
                                      WHERE F.`EkIdUserFollower` = ?
                                      AND U.`IdUser` = P.`EkIdUser`
                                      ORDER BY P.`timestamp` DESC;');
        $user_id = get_user_id();
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    function postsGetAll() {
        $stmt = $this->conn->prepare('SELECT U.`username`, U.`imageURL` AS `imgProfile`, P.`EkIdUser`, P.`imageURL` AS `imgPost`, P.`caption`, P.`nLikes`, P.`timestamp`
                                      FROM `POST` P JOIN `USER` U ON (U.`IdUser` = P.`EkIdUser`)
                                      ORDER BY RAND();');
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    function postsGetFromUser($user_id) {
        $stmt = $this->conn->prepare('SELECT `EkIdUser`, `imageURL`, `caption`, `nLikes`, `timestamp`
                                      FROM `POST`
                                      WHERE `EkIdUser` = ?
                                      ORDER BY `timestamp` DESC;');
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    function postsGetMy() {
        $user_id = get_user_id();
        return $this->postsGetFromUser($user_id);
    }

    function postLike($postID) {
        $stmt = $this->conn->prepare('INSERT INTO `LIKE_POST` (`EkIdUser`, `EkIdUser`)
                                      VALUES (?, ?);');
        $username = get_user_id();
        $stmt->bind_param('ii', $user_id, $postID);
        $stmt->execute();
    }
    function postUnlike($postID) {
        $stmt = $this->conn->prepare('DELETE FROM `LIKE_POST`
                                      WHERE `EkIdUser` = ?
                                        AND `EkIdPost` = ?;');
        $username = get_user_id();
        $stmt->bind_param('ii', $user_id, $postID);
        $stmt->execute();
    }
    function postAdd($imageURL, $caption = '') {
        $stmt = $this->conn->prepare('INSERT INTO `POST` (`EkIdUser`, `imageURL`, `caption`)
                                      VALUES (?, ?, ?);');
        $username = get_user_id();
        $stmt->bind_param('iis', $user_id, $imageURL, $caption);
        $stmt->execute();
    }
}

?>
