<?php
// models/HotelModel.php

// Không cho phép truy cập trực tiếp thông qua HTTP
if (!defined('DirectAccess')) {
    die('Direct access not permitted');
}

require_once "./configs/db.php";

class HotelModel
{
    public function getAllHotels()
    {
        $database = "MDM";
        $collection = "hotels";
        $mongo = DB::getMongoDBInstance($database, $collection);

        $query = $mongo->find([]);
        $hotels = $query->toArray();

        return $hotels;
    }

    public function getAvailableRooms($hotelName, $checkinDate, $checkoutDate)
    {
        $database = "MDM";
        $collection = "bookings";
        $mongo = DB::getMongoDBInstance($database, $collection);

        $filter = [
            'hotel_name' => $hotelName,
            '$or' => [
                ['checkin_date' => ['$gte' => $checkinDate, '$lt' => $checkoutDate]],
                ['checkout_date' => ['$gt' => $checkinDate, '$lte' => $checkoutDate]],
                ['$and' => [
                    ['checkin_date' => ['$lt' => $checkinDate]],
                    ['checkout_date' => ['$gt' => $checkoutDate]],
                ]],
            ],
        ];

        $options = [];
        $query = $mongo->find($filter, $options);
        $bookings = $query->toArray();

        $occupiedRooms = [];
        foreach ($bookings as $booking) {
            $occupiedRooms = array_merge($occupiedRooms, $booking['room_numbers']);
        }

        $filter = ['hotel_name' => $hotelName];
        $query = $mongo->find($filter, $options);
        $allRooms = $query->toArray();

        $availableRooms = [];
        foreach ($allRooms as $room) {
            if (!in_array($room['room_number'], $occupiedRooms)) {
                $availableRooms[] = $room;
            }
        }

        return $availableRooms;
    }
}
