<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//chưa login thì không xuất nav bar
if (isset($_SESSION['username'])) {
    echo '<div class="col-12">
        <div class="alert alert-primary text-end text-info mb-0">
            <ul class="nav nav-tabs nav-stacked">
                <li class="nav-item">
                    <form action="" method="" class="d-flex align-items-center">
                        <input name="action" value="" hidden>
                        <button type="submit" class="btn btn-link" style="text-decoration:none;">Task 1</button>
                    </form>
                </li>
                <li class="nav-item">
                    <form action="" method="" class="d-flex align-items-center">
                        <input name="action" value="" hidden>
                        <button type="submit" class="btn btn-link" style="text-decoration:none;">Task 2</button>
                    </form>
                </li>
                <li class="nav-item">
                    <form action="" method="" class="d-flex align-items-center">
                        <input name="action" value="" hidden>
                        <button type="submit" class="btn btn-link" style="text-decoration:none;">Task 3</button>
                    </form>
                </li>

                <li class="nav-item">
                    <form action="" method="" class="d-flex align-items-center">
                        <input name="action" value="booking" hidden>
                        <button type="submit" class="btn btn-link" style="text-decoration:none;">Select your room</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>';
}
