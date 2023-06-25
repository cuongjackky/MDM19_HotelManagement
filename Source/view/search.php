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
<h1> Tìm kiếm khách sạn </h1>
<div  >
    
</div>

<div class="row" style = "width: 100%;">
  <div class="col-6">
    
    <input type="text" id="addressInput" name = "address" class="form-control" placeholder="">
    <label for="addressInput">Địa chỉ</label>
  </div>
 
  <div class="col-2">
    <input type="text" id="checkInInput" name = "date_check_in" class="form-control" placeholder="">
    <label for="checkInInput">Ngày check-in</label>
   </div>
  <div class="col-2">
    
    <input type="text" id="checkOutInput" name = "date_check_out" class="form-control" placeholder="">
    <label for="checkOutInput">Ngày check-out</label>
    </div>
  <div class="col-1">
    
    <input type="number" id="roomCountInput" name ="num_room" class="form-control"  min="1">
    <label for="roomCountInput">Số phòng</label>
   </div>
   
  <div class="col-1"><button id="searchButton" class="btn btn-primary">Tìm kiếm</button></div>
</div>


<br>
<br>
  <div class="row">
    <div class="col-lg-2" style="margin-left: 20px;">

      <!-- Cột bên trái -->
      <br>
      <div><b>Bộ lọc</b>  </div>
      <br>
      <div style="padding: 20px;border: 1px solid grey;">Tiện nghi
      <hr>
      
      <div>
        <input type="checkbox" id="checkbox1" value ="wifi" name ="amenities">
        <label for="checkbox1">Wifi</label>
      </div>
      <div>
        <input type="checkbox" id="checkbox2" value ="nha hang" name ="amenities">
        <label for="checkbox2">Nhà hàng</label>
      </div>
      <div>
        <input type="checkbox" id="checkbox1" value ="be boi" name ="amenities">
        <label for="checkbox1">Bể bơi</label>
      </div>
      <div>
        <input type="checkbox" id="checkbox2" value = "phong tap gym" name ="amenities">
        <label for="checkbox2">Phòng tập gym</label>
      </div>
      </div>
      <br>
      <div style="padding: 20px;border: 1px solid grey;"> Ngân sách của bạn
      <hr>
      
        <div id="slider"></div>
        <br>
          <label for="minPriceInput">Giá thấp nhất</label>
          <input type="text" id="minPriceInput" readonly>
          <label for="maxPriceInput">Giá cao nhất</label>
          <input type="text" id="maxPriceInput" readonly>
      </div>
      <br>
     
      
      <!-- Thêm checkbox khác tại đây -->
    </div>
    <div class="col-lg-9" style = "margin-left:10px;" id ="tableContainer">
      <!-- Cột bên phải -->
      <br>
      <br>
      <br>
      
    </div>
  </div>





  
</body>

<script>
$(document).ready(function() {
  var checkInInput = $('#checkInInput');
  var checkOutInput = $('#checkOutInput');

  // Khởi tạo datetimepicker cho ngày check-in
  checkInInput.datetimepicker({
    format: 'Y-m-d',
    timepicker: false,
    minDate: 0, // Ngăn chọn ngày trước ngày hiện tại
    onShow: function(ct) {
      this.setOptions({
        maxDate: checkOutInput.val() ? checkOutInput.val() : false // Ngăn chọn ngày sau ngày check-out
      });
    },
    onSelectDate: function(selectedDate) {
      checkOutInput.datetimepicker('show'); // Mở datetimepicker ngày check-out khi ngày check-in được chọn
    }
  });

  // Khởi tạo datetimepicker cho ngày check-out
  checkOutInput.datetimepicker({
    format: 'Y-m-d',
    timepicker: false,
    minDate: 0, // Ngăn chọn ngày trước ngày hiện tại
    onShow: function(ct) {
      this.setOptions({
        minDate: checkInInput.val() ? checkInInput.val() : false // Ngăn chọn ngày trước ngày check-in
      });
    }
  });
});


   
   
   

    // Xử lý sự kiện click nút tìm kiếm
    $('#searchButton').on('click', function(e) {
      let address = $('#addressInput').val();
      let checkInDate = $('#checkInInput').val();
      let checkOutDate = $('#checkOutInput').val();
      let roomCount = $('#roomCountInput').val();
      let minPrice = $('#minPriceInput').val();
      let maxPrice = $('#maxPriceInput').val();
      let selectedAmenities = [];
      $('input[name="amenities"]:checked').each(function() {
        selectedAmenities.push($(this).val());
      });

      if (address === "" || checkInDate === "" || checkOutDate === "" || roomCount === "") {
        e.preventDefault();
      } else {
        // Gửi AJAX request lên server

        // Tạo đối tượng data chứa các thông tin cần gửi
        let data = {
          action: "search",
          address: address,
          checkInDate: checkInDate,
          checkOutDate: checkOutDate,
          roomCount: roomCount,
          minPrice: minPrice,
          maxPrice: maxPrice,
          amenities: selectedAmenities
        };

        // Gửi AJAX request sử dụng jQuery
        $.ajax({
          type: 'POST',
          url: 'index.php', // Đường dẫn tới file PHP xử lý request
          data: data,
          success: function(response) {
            // Xử lý kết quả trả về từ server
             $('#tableContainer').html(response);
          },
          error: function(xhr, status, error) {
            // Xử lý lỗi nếu có
            console.error(error);
          }
        });
      }
    });


    var slider = document.getElementById('slider');
    var minPriceInput = document.getElementById('minPriceInput');
    var maxPriceInput = document.getElementById('maxPriceInput');

    noUiSlider.create(slider, {
      start: [50000, 10000000], // Giá trị mặc định cho giá thấp nhất và giá cao nhất
      connect: true, // Kết nối đường kéo giữa 2 đầu
      step: 10000,
      range: {
        'min': 50000, // Giá trị tối thiểu
        'max': 10000000 // Giá trị tối đa
      },
      format: {
        to: function (value) {
          return parseInt(value);
        },
        from: function (value) {
          return parseInt(value);
        }
      }
    });

    slider.noUiSlider.on('update', function (values, handle) {
      if (handle === 0) {
        minPriceInput.value = values[handle];
      } else {
        maxPriceInput.value = values[handle];
      }
    });

        
    slider.noUiSlider.on('set', function (values, handle) {
      if (handle === 0) {
        minPriceInput.value = values[handle];
      } else {
        maxPriceInput.value = values[handle];
      }

      // Gọi hàm Ajax ở đây
      let address = $('#addressInput').val();
      let checkInDate = $('#checkInInput').val();
      let checkOutDate = $('#checkOutInput').val();
      let roomCount = $('#roomCountInput').val();
      let minPrice = $('#minPriceInput').val();
      let maxPrice = $('#maxPriceInput').val();
      let selectedAmenities = [];
      $('input[name="amenities"]:checked').each(function() {
        selectedAmenities.push($(this).val());
      });

      if (address === "" || checkInDate === "" || checkOutDate === "" || roomCount === "") {
        e.preventDefault();
      } else {
        // Gửi AJAX request lên server

        // Tạo đối tượng data chứa các thông tin cần gửi
        let data = {
          action: "search",
          address: address,
          checkInDate: checkInDate,
          checkOutDate: checkOutDate,
          roomCount: roomCount,
          minPrice: minPrice,
          maxPrice: maxPrice,
          amenities: selectedAmenities
        };

        // Gửi AJAX request sử dụng jQuery
        $.ajax({
          type: 'POST',
          url: 'index.php', // Đường dẫn tới file PHP xử lý request
          data: data,
          success: function(response) {
            // Xử lý kết quả trả về từ server
             $('#tableContainer').html(response);
          },
          error: function(xhr, status, error) {
            // Xử lý lỗi nếu có
            console.error(error);
          }
        });
      }
    });
  </script>


