<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//chưa login thì không xuất nav bar
if (isset($_SESSION['username'])){
    echo '<div class="col-12">
        <div class="alert alert-primary text-end text-info mb-0">
            <ul class="nav nav-tabs nav-stacked">
                <li class="nav-item">
                    <form action="index.php" method="post" class="d-flex align-items-center">
                        <input name="action" value="viewInfo" hidden>
                        <button type="submit" class="btn btn-link" style="text-decoration:none;">Thông tin cá nhân</button>
                    </form>
                </li>
                <li class="nav-item">
                    <form action="index.php" method="" class="d-flex align-items-center">
                        <input name="action" value="searchhotel" hidden>
                        <button type="submit" class="btn btn-link" style="text-decoration:none;">Thuê khách sạn</button>
                    </form>
                </li>
                <li class="nav-item">
                    <form action="index.php" method="" class="d-flex align-items-center">
                        <input name="action" value="viewBookinghistory" hidden>
                        <button type="submit" class="btn btn-link" style="text-decoration:none;">Lịch sử thuê phòng</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>';
}
?>