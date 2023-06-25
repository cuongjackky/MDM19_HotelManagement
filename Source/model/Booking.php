<?php
//ko cho access directly = http
if(!defined('DirectAccess')) {
    die('Direct access not permitted');
}
require_once "./configs/db.php";
class BookingModel {
    public $hotel_name;
    public $guest_name;
    public $checkin_date;
    public $checkout_date;


    function __construct() {
        
    }

    public static function getUserBookingHistory($user_name) {
        $database = "MDM";
        $collection = "bookings";
        $mongo = DB::getMongoDBInstance($database,$collection);
        $filter = ['guest_name'   =>  $user_name];
        $data = $mongo->find($filter);
        $result = iterator_to_array($data);
        return $result;

    }

    
}

?>