<?php
// models/BookingModel.php

// Prevent direct access through HTTP
defined('DirectAccess') or die('Direct access not permitted');

require_once "./configs/db.php";

class BookingModel
{
    function __construct()
    {
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
