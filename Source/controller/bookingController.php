<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//ko cho access directly = http
if (!defined('DirectAccess')) {
    die('Direct access not permitted');
}

class BookingController
{
    public function getUserBookingHistory($username)
    {
        $result = BookingModel::getUserBookingHistory($username);

        require('./view/bookinghistory.php');
    }

    public function createBooking($hotelName, $guestName, $checkinDate, $checkoutDate)
    {
        // Get information from the POST request
        $hotelName = $_POST['hotelName'];
        $guestName = $_POST['guestName'];
        $checkinDate = $_POST['checkinDate'];
        $checkoutDate = $_POST['checkoutDate'];

        require_once './model/Booking.php';
        $bookingModel = new BookingModel();
        // Create a new booking
        $result = $bookingModel->createBooking($hotelName, $guestName, $checkinDate, $checkoutDate);

        if ($result) {
            // Successful booking
            include_once('./view/partials/htmlHead.php');
            echo "<div class='text-center'><h5 class='text-success'>Booking successful.</h5></div>";
        } else {
            // No more rooms available
            include_once('./view/partials/htmlHead.php');
            echo "<div class='text-center'><h5 class='text-danger'>No more rooms available.</h5></div>";
        }
    }
}
