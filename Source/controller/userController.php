<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//ko cho access directly = http
if(!defined('DirectAccess')) {
    die('Direct access not permitted');
}

class userController {
    public function login($un, $pw) {
        $user = UserModel::getUserByUn($un,$pw);
        if (!$user) {
            include_once('./view/partials/htmlHead.php');
            echo '<form action="index.php" method="" class="m-2">' .
               "<input name='action' value='' hidden>" .
               "<h5 class='text-danger'>Login failed! Check if the information is correct!</h5>" .
               '<button class="text-bg-light fw-semibold" type="submit">Back to login page</button>' .
            "</form>";
        }
        else {
            $_SESSION['username'] = $un;
            
            require('./view/home.php');
        }
    }

    public function logout() {
        unset($_SESSION['username']);
       
        //header('Location: ./view/login.php');
        require('./view/login.php');
        //exit();
    }


}

?>