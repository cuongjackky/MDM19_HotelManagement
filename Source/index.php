<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//cho phép include các file
define('DirectAccess', TRUE);

require_once('./controller/userController.php');
require_once('./model/User.php');

$action = "";
if (isset($_REQUEST['action'])){
    $action = $_REQUEST['action'];
}

//if still in session, go to home instead of login 
if (isset($_SESSION['username']) && $action == ""){
    $action = "home";
}

switch ($action) {
    //đăng nhập
    case 'signin':
        $controller = new userController();
        $controller->login($_REQUEST['un'], $_REQUEST['pw']);
        break;
    //đăng xuất
    case 'signout':
        $controller = new userController();
        $controller->logout();
        break;
    //đến trang đăng ký
    case 'signup_page':
        require('./view/signup.php');
        break;
    //đăng ký
    case 'signup':
        $controller = new userController();
        $controller->signup($_REQUEST['un'], $_REQUEST['pw']);
        break;
    //back home
    case 'home':
        //header('Location: ');
        require('./view/home.php');
        break;
    default:
        //header('Location: ');
        require('./view/login.php');
        break;
}

?>