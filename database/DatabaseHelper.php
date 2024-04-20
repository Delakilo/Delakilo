<?php

class DatabaseHelper {
    private $conn;

    function __construct($serverName, $username, $password, $connName, $port) {
        // Reports MySQL errors
        mysqli_report(MYSQLI_REPORT_ALL);
        $this->conn = new mysqli($serverName, $username, $password, $connName, $port);
        if ($this->conn->connect_error) {
            die("Connection with MySQL failed: ".$conn->connect_error);
        }
    }

    function __destruct() {
        $this->conn->close();
    }

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

            if ($stmt = $this->conn->prepare("SELECT `passwordHash` FROM `USER` WHERE `Username` = ? LIMIT 1")) { 
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
}

?>
