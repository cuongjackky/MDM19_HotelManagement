<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//ko cho access directly = http
if (!defined('DirectAccess')) {
    die('Direct access not permitted');
}

class userController
{
    function __construct()
    {
        $redis = DB::getRedisInstance();
    }

    public function login($un, $pw)
    {
        $user = UserModel::getUserByUn($un, $pw);
        if (!$user) {
            include_once('./view/partials/htmlHead.php');
            echo '<form action="index.php" method="" class="m-2">' .
               "<input name='action' value='' hidden>" .
               "<h5 class='text-danger'>Login failed! Check if the information is correct!</h5>" .
               '<button class="text-bg-light fw-semibold" type="submit">Back to login page</button>' .
            "</form>";
        }
        else {
            
            
            require('./view/home.php');
        }
    }

    public function logout()
    {
        unset($_SESSION['username']);
        unset($_SESSION['nameOfuser']);

        //header('Location: ./view/login.php');
        require('./view/login.php');
        //exit();
    }
    public function getUserInfo($username){
        $userinfo = UserModel::getUserInfoByUn($username);

        require('./view/userinfo.php');
    }
    public function signup($un, $pw, $name, $email, $phone, $address)
    {
        $isExist = UserModel::IsExistUser($un);
        if ($isExist) {
            include_once('./view/partials/htmlHead.php');
            echo "<h5 class='text-danger'>username is existed.</h5>";
        } else {
            $user = UserModel::create($un, $pw, $name, $email, $phone, $address);
            if($user != null){
                $_SESSION['username'] = $un;
                require('./view/home.php');
            }
        }
    }

   
}

?>