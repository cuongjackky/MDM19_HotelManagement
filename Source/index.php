<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//cho phép include các file
define('DirectAccess', TRUE);

require_once('./controller/userController.php');
require_once('./model/User.php');
require_once('./controller/bookingController.php');
require_once('./model/Booking.php');
require_once('./controller/hotelController.php');
require_once('./model/Hotel.php');

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
    case 'searchhotel':
        require('./view/search.php');
        break;
    case 'search':
        $controller = new HotelController();
        $dia_chi = $_POST['address'];
        $dcheck_in = $_POST['checkInDate'];
        $dcheck_out = $_POST['checkOutDate'];
        $so_phong = $_POST['roomCount'];
        $amenities = isset($_POST['amenities']) ? $_POST['amenities'] : [];
        $max_price = $_POST['maxPrice'];
        $min_price = $_POST['minPrice'];

        $controller->searchHotel($dia_chi,$dcheck_in,$dcheck_out,$so_phong,$amenities,$max_price,$min_price);
        break;

    case 'viewInfo':
        $username = $_SESSION['username'];
        $controller = new userController();
        $controller->getUserInfo($username);

        break;
    case 'viewBookinghistory':
        $username = $_SESSION['nameOfuser'];
        $controller = new BookingController();
        $controller->getUserBookingHistory($username);

        break;

    case 'reservation':
        $nameUser = $_REQUEST['username'];
        // mấy cái còn lại
        break;
    default:
        //header('Location: ');
        require('./view/login.php');
        break;
}

?>