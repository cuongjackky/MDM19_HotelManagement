<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//ko cho access directly = http
if(!defined('DirectAccess')) {
    die('Direct access not permitted');
}

class BookingController {
    public function getUserBookingHistory($username) {
        $result = BookingModel::getUserBookingHistory($username);
        
        require('./view/bookinghistory.php');
    }

    

}

?>