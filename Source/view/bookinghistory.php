<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once('./view/partials/htmlHead.php');
include_once('./view/partials/header.php');
include_once('./view/partials/nav.php');
?>
<body>
  <br><br>
<h1> Lịch sử thuê phòng </h1>
<hr>

<hr>
<table class="table">
  <thead>
    <tr>
 
      <th scope="col">Hotel Name</th>
      <th scope="col">Guest Name</th>
      <th scope="col">Num Room</th>
      <th scope="col">Check In Date</th>
      <th scope="col">Check Out Date</th>
</tr>
</thead>
<tbody>
<?php if(isset($result)){
        foreach($result as $booking){?>
            <tr>
     
               <td><?php echo $booking['hotel_name'] ;?></td>
               <td><?php echo $booking['guest_name']; ?></td>
               <td><?php echo $booking['num_room']; ?></td>
               <td><?php echo $booking['checkin_date'] ;?></td>
               <td><?php echo $booking['checkout_date'] ;?></td>
        </tr>
        <?php }} ?>
</tbody>
</table>





  
</body>
<?php include_once('./view/partials/footer.php');  ?>
<script>
    // Khởi tạo datetimepicker cho ngày check-in
    $('#checkInInput').datetimepicker({
      format: 'Y-m-d',
      timepicker: false
    });

    // Khởi tạo datetimepicker cho ngày check-out
    $('#checkOutInput').datetimepicker({
      format: 'Y-m-d',
      timepicker: false
    });

    // Xử lý sự kiện click nút tìm kiếm
    $('#searchButton').on('click', function() {
      let address = $('#addressInput').val();
      let checkInDate = $('#checkInInput').val();
      let checkOutDate = $('#checkOutInput').val();
      let roomCount = $('#roomCountInput').val();

      // Xử lý logic tìm kiếm dựa trên giá trị đã nhập

      // Ví dụ: In ra các giá trị đã nhập
      console.log('Địa chỉ:', address);
      console.log('Ngày check-in:', checkInDate);
      console.log('Ngày check-out:', checkOutDate);
      console.log('Số phòng:', roomCount);
    });
  </script>


