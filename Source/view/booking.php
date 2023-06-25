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

        $hotelModel = new HotelModel();
        $hotels = $hotelModel->getAllHotels();
        $hotelNames = array_column($hotels, 'name');
        ?>

        <form action="index.php" method="post">
            <div class="row mt-5">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="text-center mb-4">Choose Hotel</h1>
                            <div class="input-group">
                                <input class="form-control" type="text" name="hotelName" id="hotelInput" placeholder="Enter hotel name">
                                <ul class="list-group mt-2 w-100" id="hotelSuggestions"></ul>
                            </div>
                        </div>
                    </div>
                    <div id="hotelInfo" class="card mt-5 d-none">
                        <div class="card-body">
                            <h2>Hotel Information</h2>
                            <p><strong>Name:</strong> <span id="hotelName"></span></p>
                            <p><strong>Address:</strong> <span id="hotelAddress"></span></p>
                            <p><strong>Description:</strong> <span id="hotelDescription"></span></p>
                            <p><strong>Amenities:</strong> <span id="hotelAmenities"></span></p>
                            <p><strong>Number of Rooms:</strong> <span id="hotelNumRooms"></span></p>
                            <p><strong>Price:</strong> <span id="hotelPrice"></span></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <label for="guestName">Guest Name:</label>
                                <input class="form-control input-sm" type="text" name="guestName" id="guestName">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="checkinDate">Check-in Date:</label>
                                <input class="form-control input-sm" type="text" name="checkinDate" id="checkinDate" readonly>
                            </div>
                            <div class="col">
                                <label for="checkoutDate">Check-out Date:</label>
                                <input class="form-control input-sm" type="text" name="checkoutDate" id="checkoutDate" readonly>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <input name='action' value="create_booking" hidden>
                                <button class="btn btn-primary" id="reserveButton" disabled>Reserve</button>
                            </div>
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
        const hotelNames = <?php echo json_encode($hotelNames); ?>;
        const hotels = <?php echo json_encode($hotels); ?>;

        const hotelInput = document.getElementById('hotelInput');
        const hotelSuggestions = document.getElementById('hotelSuggestions');
        const hotelInfo = document.getElementById('hotelInfo');
        const hotelNameElement = document.getElementById('hotelName');
        const hotelAddressElement = document.getElementById('hotelAddress');
        const hotelDescriptionElement = document.getElementById('hotelDescription');
        const hotelAmenitiesElement = document.getElementById('hotelAmenities');
        const hotelNumRoomsElement = document.getElementById('hotelNumRooms');
        const hotelPriceElement = document.getElementById('hotelPrice');
        const guestNameInput = document.getElementById('guestName');
        const reserveButton = document.getElementById('reserveButton');

        hotelInput.value = '<?php echo isset($_POST["hotelName"]) ? $_POST["hotelName"] : ""; ?>';

        hotelInput.addEventListener('input', function(e) {
            const inputText = e.target.value.toLowerCase();
            const suggestions = hotelNames.filter(function(hotelName) {
                return hotelName.toLowerCase().startsWith(inputText);
            });

            renderSuggestions(suggestions);
        });

        hotelInput.addEventListener('change', function(e) {
            const selectedHotelName = e.target.value;
            const selectedHotel = hotels.find(function(hotel) {
                return hotel.name === selectedHotelName;
            });

            if (selectedHotel) {
                displayHotelInfo(selectedHotel);
                reserveButton.disabled = false;
            } else {
                hideHotelInfo();
                reserveButton.disabled = true;
            }
        });

        function renderSuggestions(suggestions) {
            hotelSuggestions.innerHTML = '';

            if (suggestions.length > 0) {
                suggestions.forEach(function(suggestion) {
                    const li = document.createElement('li');
                    li.classList.add('list-group-item');
                    li.textContent = suggestion;
                    li.addEventListener('click', function() {
                        hotelInput.value = suggestion;
                        hotelSuggestions.innerHTML = '';
                        const selectedHotel = hotels.find(function(hotel) {
                            return hotel.name === suggestion;
                        });
                        if (selectedHotel) {
                            displayHotelInfo(selectedHotel);
                            reserveButton.disabled = false;
                        }
                    });
                    hotelSuggestions.appendChild(li);
                });
            }
        }

        function displayHotelInfo(hotel) {
            hotelInfo.classList.remove('d-none');
            hotelNameElement.textContent = hotel.name;
            hotelAddressElement.textContent = hotel.address;
            hotelDescriptionElement.textContent = hotel.description;
            hotelAmenitiesElement.textContent = hotel.amenities.join(', ');
            hotelNumRoomsElement.textContent = hotel.num_rooms;
            hotelPriceElement.textContent = hotel.price;
        }

        function hideHotelInfo() {
            hotelInfo.classList.add('d-none');
            hotelNameElement.textContent = '';
            hotelAddressElement.textContent = '';
            hotelDescriptionElement.textContent = '';
            hotelAmenitiesElement.textContent = '';
            hotelNumRoomsElement.textContent = '';
            hotelPriceElement.textContent = '';
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#checkinDate').datepicker({
                format: 'yyyy-mm-dd',
                startDate: 'today',
                autoclose: true
            }).addClass('datepicker-sm');

            $('#checkoutDate').datepicker({
                format: 'yyyy-mm-dd',
                startDate: 'today',
                autoclose: true
            }).addClass('datepicker-sm');
        });
    </script>

</body>

</html>