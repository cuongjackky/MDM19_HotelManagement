<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once('./view/partials/htmlHead.php');
?>

<body>
    <div class="container-fluid">
        <?php
        include_once('./view/partials/header.php');
        include_once('./view/partials/nav.php');
        require_once('./model/Hotel.php');
        require_once('./model/Booking.php');

        $bookingModel = new BookingModel();
        $nameCurrent = $bookingModel->getCurrentUserName();

        // Retrieve values from the POST request
        $hotelName = isset($_POST['hotelName']) ? $_POST['hotelName'] : '';
        $guestName = isset($_POST['guestName']) ? $_POST['guestName'] : '';
        $checkinDate = isset($_POST['checkinDate']) ? $_POST['checkinDate'] : '';
        $checkoutDate = isset($_POST['checkoutDate']) ? $_POST['checkoutDate'] : '';

        $hotelModel = new HotelModel();
        $hotels = $hotelModel->getInfoHotels($hotelName);
        ?>


        <form action="index.php" method="post">
            <div class="row mt-5">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="text-center mb-4">Chọn khách sạn</h1>
                            <div class="input-group">
                                <input class="form-control" type="text" name="hotelName" id="hotelInput"
                                    placeholder="Enter hotel name" value="<?php echo $hotelName; ?>" readonly>
                                <ul class="list-group mt-2 w-100" id="hotelSuggestions"></ul>
                            </div>
                        </div>
                    </div>
                    <div id="hotelInfo" class="card mt-5 <?php echo (!empty($hotels)) ? '' : 'd-none'; ?>">

                        <div class="card-body">
                            <h2>Thông tin khách sạn</h2>
                            <?php if (!empty($hotels)) : ?>
                            <p><strong>Name:</strong> <span id="hotelName"><?php echo $hotels[0]['name']; ?></span></p>
                            <p><strong>Address:</strong> <span
                                    id="hotelAddress"><?php echo $hotels[0]['address']; ?></span></p>
                            <p><strong>Description:</strong> <span
                                    id="hotelDescription"><?php echo $hotels[0]['description']; ?></span></p>
                            <p><strong>Amenities:</strong> <span
                                    id="hotelAmenities"><?php echo implode(', ', $hotels[0]['amenities']->bsonSerialize()); ?></span>
                            </p>
                            <p><strong>Number of Rooms:</strong> <span
                                    id="hotelNumRooms"><?php echo $hotels[0]['num_rooms']; ?></span></p>
                            <p><strong>Price:</strong> <span id="hotelPrice"><?php echo $hotels[0]['price']; ?></span>
                            </p>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="container">
                        <div class="row"></div>
                        <div class="col">
                            <input class="form-control input-sm" type="text" name="guestName" id="guestName"
                                value="<?php echo $guestName; ?>" hidden>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="checkinDate">Ngày Check-in:</label>
                            <input class="form-control input-sm" type="text" name="checkinDate" id="checkinDate"
                                value="<?php echo $checkinDate; ?>" readonly>
                        </div>
                        <div class="col">
                            <label for="checkoutDate">Ngày Check-out:</label>
                            <input class="form-control input-sm" type="text" name="checkoutDate" id="checkoutDate"
                                value="<?php echo $checkoutDate; ?>" readonly>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col text-center">
                            <input name='action' value="create_booking" hidden>
                            <button class="btn btn-primary" id="reserveButton">Đặt trước</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>

        <?php
        include_once('./view/partials/footer.php');
        ?>
    </div>


    <script>
    // Function to display all hotel information
    function displayHotelInfo(hotel) {
        $('#hotelName').text(hotel.name);
        $('#hotelAddress').text(hotel.address);
        $('#hotelDescription').text(hotel.description);
        $('#hotelAmenities').text(hotel.amenities.join(', '));
        $('#hotelNumRooms').text(hotel.num_rooms);
        $('#hotelPrice').text(hotel.price);
    }

    // Event listener for hotel input change
    $('#hotelInput').on('input', function() {
        var hotelName = $(this).val();
        // Send AJAX request to retrieve hotel information
        $.ajax({
            url: 'getHotelInfo.php',
            method: 'POST',
            data: {
                hotelName: hotelName
            },
            success: function(response) {
                var hotel = JSON.parse(response);
                // Display the hotel information
                displayHotelInfo(hotel);
                // Show the hotel info card
                $('#hotelInfo').removeClass('d-none');
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });
    </script>

</body>

</html>