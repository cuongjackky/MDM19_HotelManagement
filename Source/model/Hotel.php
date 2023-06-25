<?php
//ko cho access directly = http
if (!defined('DirectAccess')) {
    die('Direct access not permitted');
}
require_once "./configs/db.php";
class HotelModel
{
    public $name;
    public $address;
    public $description;
    public $amenities;
    public $num_rooms;
    public $price;
    public $bookings;


    function __construct()
    {
    }

    public static function searchHotel($dia_chi, $dcheck_in, $dcheck_out, $so_phong, $amenities, $max_price, $min_price)
    {

        $database = "MDM";
        $collection = "hotels";
        $mongo = DB::getMongoDBInstance($database, $collection);
        $query['address'] = ['$regex' => new MongoDB\BSON\Regex($dia_chi)];


        if (!empty($amenities)) {
            $query['amenities'] = ['$all' => $amenities];
        }
        $min_price = intval($min_price);
        $max_price = intval($max_price);

        $query['price'] = ['$gte' => $min_price, '$lte' => $max_price];
        $hotelList = $mongo->find($query);



        $result = [];

        foreach ($hotelList as $hotel) {

            $num_booked_rooms = 0;
            foreach ($hotel['bookings'] as $booking) {

                $booking_checkInD = strtotime($booking['checkin_date']);
                $booking_checkOutD = strtotime($booking['checkout_date']);
                $num_booked_room = intval($booking['num_room']);
                $dateCheckin = strtotime($dcheck_in);
                $dateCheckout = strtotime($dcheck_out);
                if (


                    ($booking_checkInD >= $dateCheckin && $booking_checkInD <= $dateCheckout) ||
                    ($booking_checkOutD >= $dateCheckin && $booking_checkOutD <= $dateCheckout) ||
                    ($booking_checkInD < $dateCheckin && $booking_checkOutD > $dateCheckout)
                ) {
                    $num_booked_rooms+=$num_booked_room;
                }
            }
            $num_available_rooms = intval($hotel['num_rooms']) - $num_booked_rooms;
            if ($num_available_rooms >= intval($so_phong)) {
                $result[] = $hotel;
            }
        }
        return $result;
    }

    public function getInfoHotels($hotelName)
    {
        $database = "MDM";
        $collection = "hotels";
        $mongo = DB::getMongoDBInstance($database, $collection);

        $query = $mongo->find(['name' => $hotelName], ['projection' => ['bookings' => 0]]);
        $hotels = $query->toArray();

        return $hotels;
    }

    public function updateHotelBooking($hotelName, $guestName,$numRoom, $checkinDate, $checkoutDate)
    {
        $database = "MDM";
        $collection = "hotels";
        $mongo = DB::getMongoDBInstance($database, $collection);

        $booking = [
            'hotel_name' => $hotelName,
            'guest_name' => $guestName,
            'num_room'  =>  $numRoom,
            'checkin_date' => $checkinDate,
            'checkout_date' => $checkoutDate
        ];

        $filter = ['name' => $hotelName];
        $update = ['$push' => ['bookings' => $booking]];
        $result = $mongo->updateOne($filter, $update);

        return $result;
    }
    public static function getUserBookingHistory($user_name){
        $database = "MDM";
        $collection = "hotels";
        $mongo = DB::getMongoDBInstance($database, $collection);
        $filter = ['bookings.guest_name'   =>  $user_name];
        $projection = [
            'bookings.$' => 1
        ];
        $result = $mongo->find($filter,[
            'projection' => $projection
        ]);
        
        $bookings = [];
        foreach ($result as $document) {
            foreach ($document["bookings"] as $booking) {
                // Tạo một mảng chứa thông tin booking
                $bookingInfo = [
                    "hotel_name" => $booking["hotel_name"],
                    "guest_name" => $booking["guest_name"],
                    "num_room"  => $booking["num_room"],
                    "checkin_date" => $booking["checkin_date"],
                    "checkout_date" => $booking["checkout_date"]
                ];
                // Thêm mảng booking vào mảng $bookings
                $bookings[] = $bookingInfo;
            }
        }
        return $bookings;
    }
}
