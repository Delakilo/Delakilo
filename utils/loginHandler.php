<!-- Francesco Filippini -->
<?php
require_once '../config.php';
if(isset($_POST['username'], $_POST['pwd'])) { 
        if (!$GLOBALS['db']->userLogin($_POST['username'], $_POST['pwd'])) {
            if ($GLOBALS['db']->userExists($_POST['username'])) {
                $templateParams['error'] = 'Wrong password';
                $GLOBALS['log']->logInfo($_POST['username'].' username tried wrong password in login, from loginHandler');
            } else {
                    $templateParams['error'] = 'Wrong username';
                    $GLOBALS['log']->logInfo($_POST['username'].' username invalid in login, from loginHandler');
                }
            } else {
                $GLOBALS['log']->logInfo($_POST['username'].' logged in, from loginHandler');
                header('Location: ../loginHome.php');
            }
        } else if (isset($_POST['pwd1'])) {
            if ($GLOBALS['db']->userExists($_POST['username'])) {
                $templateParams['error'] = $_POST['username'].' username yet in use';
                $GLOBALS['log']->logInfo($_POST['username'].' cannot register, username yet present in database, from loginHandler');
            } else {
                $GLOBALS['db']->userRegister($_POST['username'], $_POST['pwd1']);
                $GLOBALS['log']->logInfo($_POST['username'].' registered, from loginHandler');
            }
        } else {
            $GLOBALS['log']->logError($_POST['username'].' invalid data in login form, from loginHandler');
        }
?>

<!-- 
$email = $_POST['username'];
   $password = $_POST['pwd'];
   if($dbh->userLogin($email, $password) == true) {
      // Login eseguito
      header('Location: ../loginHome.php');
   } else {
      // Login fallito
      $GLOBALS['log']->logError('Login failed, from loginHandler');
      //header('Location: ../login.php?error=1');
   }
} else { 
   // Le variabili corrette non sono state inviate a questa pagina dal metodo POST.
   echo 'Invalid Request';
} -->