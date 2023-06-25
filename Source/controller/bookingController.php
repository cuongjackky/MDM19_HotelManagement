<?php
// controllers/BookingController.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//ko cho access directly = http
if (!defined('DirectAccess')) {
    die('Direct access not permitted');
}

class BookingController
{
    public function showAvailableHotels()
    {
        $hotelModel = new HotelModel();
        $hotels = $hotelModel->getAllHotels();

        // Display the interface for users to select a hotel and check-in/check-out dates
        include_once('./view/availableHotels.php');
    }

    // Handle new booking request
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

        // Process the result and display the interface for users
        if ($result) {
            // Successful booking
            include_once('./view/partials/htmlHead.php');
            echo "<h5 class='text-success'>Booking successful.</h5>";
        } else {
            // No more rooms available
            include_once('./view/partials/htmlHead.php');
            echo "<h5 class='text-danger'>No more rooms available.</h5>";
        }
    }
}
