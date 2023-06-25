<?php
//ko cho access directly = http
if (!defined('DirectAccess')) {
    die('Direct access not permitted');
}
require_once "./configs/db.php";
class BookingModel
{
    public $hotel_name;
    public $guest_name;
    public $checkin_date;
    public $checkout_date;


    function __construct()
    {
    }

    public static function getUserBookingHistory($user_name)
    {
        $database = "MDM";
        $collection = "bookings";
        $mongo = DB::getMongoDBInstance($database, $collection);
        $filter = ['guest_name'   =>  $user_name];
        $data = $mongo->find($filter);
        $result = iterator_to_array($data);
        return $result;
    }

    public function getCurrentUserName()
    {
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];

            $database = "MDM";
            $collection = "accounts";
            $mongo = DB::getMongoDBInstance($database, $collection);

            $query = ['username' => $username];
            $projection = ['name' => 1];

            $result = $mongo->findOne($query, $projection);

            if ($result) {
                return $result['name'];
            }
        }

        return null; // Return null if the username is not set or not found in the database
    }
    public function createBooking($hotelName, $guestName, $checkinDate, $checkoutDate)
    {
        $database = "MDM";
        $collection = "bookings";
        $mongo = DB::getMongoDBInstance($database, $collection);

        $bookingData = [
            'hotel_name' => $hotelName,
            'guest_name' => $guestName,
            'checkin_date' => $checkinDate,
            'checkout_date' => $checkoutDate,
        ];

        $result = $mongo->insertOne($bookingData);
        return $result;
    }
}
