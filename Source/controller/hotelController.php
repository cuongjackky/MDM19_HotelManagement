<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//ko cho access directly = http
if (!defined('DirectAccess')) {
    die('Direct access not permitted');
}

class HotelController
{
    public function searchHotel($dia_chi, $dcheck_in, $dcheck_out, $so_phong, $amenities, $max_price, $min_price)
    {
        $result = HotelModel::searchHotel($dia_chi, $dcheck_in, $dcheck_out, $so_phong, $amenities, $max_price, $min_price);
        $html = "";
        $html .= "<table class = 'table'>";
        $html .= "<thead><tr>
            <th scope='col'>Hotel Name</th>
            <th scope='col'>Address</th>
            <th scope='col'>Description</th>
            <th scope='col'>Price</th>
            <th></th>
            </tr>
            </thead>
            <tbody>";

        foreach ($result as $hotel) {
            $html .= "<tr>
                    <td>" . $hotel['name'] . "</td>";
            $html .= "<td>" . $hotel['address'] . "</td>";
            $html .= "<td>" . $hotel['description'] . "</td>";
            $html .= "<td>" . $hotel['price'] . "</td>";
            $html .= "<td><form action= 'index.php' method= 'POST'>
            <div class= 'd-grid'>
                <input name='action' value= 'reservation' hidden>
                <input name ='hotelName' value = '" . $hotel['name'] . "' hidden>
                <input name ='guestName' value = '" . $_SESSION['nameOfuser'] . "' hidden>
                <input name='checkinDate' value = '" . $dcheck_in . "' hidden>
                <input name='checkoutDate' value = '" . $dcheck_out . "' hidden>
                <button class= 'btn btn-primary btn-login text-uppercase fw-bold' type='submit'>Đặt chỗ</button>
            </div>
            </form></td>";
            $html .= "</tr>";
        }
        $html .= "</tbody></table>";

        echo $html;
    }

    public function updateHotelBooking($hotelName, $guestName, $checkinDate, $checkoutDate)
    {
        // Lấy thông tin từ yêu cầu POST
        $hotelName = $_POST['hotelName'];
        $guestName = $_POST['guestName'];
        $checkinDate = $_POST['checkinDate'];
        $checkoutDate = $_POST['checkoutDate'];

        require_once './model/Hotel.php';
        $hotelModel = new HotelModel();
        // Cập nhật thông tin đặt phòng khách sạn
        $result = $hotelModel->updateHotelBooking($hotelName, $guestName, $checkinDate, $checkoutDate);

        if ($result) {
            include_once('./view/partials/htmlHead.php');
            echo "<div class='text-center'><h5 class='text-success'>Hotel booking updated.</h5></div>";
        } else {
            include_once('./view/partials/htmlHead.php');
            echo "<div class='text-center'><h5 class='text-danger'>Failed to update hotel booking.</h5></div>";
        }
    }
}
