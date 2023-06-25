<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//ko cho access directly = http
if(!defined('DirectAccess')) {
    die('Direct access not permitted');
}

class HotelController {
    public function searchHotel($dia_chi,$dcheck_in,$dcheck_out,$so_phong,$amenities,$max_price,$min_price){
        $result = HotelModel::searchHotel($dia_chi,$dcheck_in,$dcheck_out,$so_phong,$amenities,$max_price,$min_price);
        $html = "";
        $html.= "<table class = 'table'>";
        $html.="<thead><tr>
            <th scope='col'>Hotel Name</th>
            <th scope='col'>Address</th>
            <th scope='col'>Description</th>
            <th scope='col'>Price</th>
            <th></th>
            </tr>
            </thead>
            <tbody>";

        foreach($result as $hotel){
            $html.="<tr>
                    <td>".$hotel['name']."</td>";
            $html.="<td>".$hotel['address']."</td>";
            $html.="<td>".$hotel['description']."</td>";
            $html.="<td>".$hotel['price']."</td>";
            $html.="<td><form action= 'index.php' method= 'POST'>
            <div class= 'd-grid'>
                <input name='action' value= 'reservation' hidden>
                <input name ='hotelname' value = '".$hotel['name']."' hidden>
                <input name ='username' vaue = '".$_SESSION['nameOfuser']."' hidden>
                <input name='dcheck_in' value = '".$dcheck_in."' hidden>
                <input name='dcheck_in' value = '".$dcheck_out."' hidden>
                <button class= 'btn btn-primary btn-login text-uppercase fw-bold' type='submit'>Đặt chỗ</button>
            </div>
            </form></td>";
            $html.="</tr>";

        }
        $html.="</tbody></table>";

        echo $html;
        
    }

    

}

?>