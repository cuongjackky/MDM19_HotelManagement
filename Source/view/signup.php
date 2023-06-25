<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//đã login thì điều hướng về home
if (isset($_SESSION['username'])){
    header('Location: ../index.php');
    exit();
}

include_once('./view/partials/htmlHead.php');
?>

<body>
    <div class="container-fluid">
        <?php
    include_once('./view/partials/header.php');
    include_once('./view/partials/nav.php');
    ?>
        <div class="row my-2">
            <div class="col-sm-9 col-md-7 col-lg-4 mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="card-body p-3 p-sm-4">
                        <h5 class="card-title text-center mb-5 fw-light fs-5">Sign up account</h5>
                        <form action="index.php" method="post">
                            <div class="form-floating mb-3">
                                <input name="un" type="text" class="form-control" id="floatingInput"
                                    placeholder="Username">
                                <label for="floatingInput">Username</label>
                            </div>
                            <!--div class="form-floating mb-3">
                            <input name="email" type="email" class="form-control" id="floatingInput" placeholder="Email">
                            <label for="floatingInput">Email</label>
                        </div-->
                            <div class="form-floating mb-3">
                                <input name="pw" type="password" class="form-control pw" id="floatingPassword"
                                    placeholder="Password">
                                <label for="floatingPassword">Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control con_pw" id="floatingPassword"
                                    placeholder="Confirm password">
                                <label for="floatingPassword">Confirm password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="name" type="text" class="form-control pw" id="floatingPassword"
                                    placeholder="Full Name">
                                <label for="floatingInput">Full Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="email" type="text" class="form-control pw" id="floatingPassword"
                                    placeholder="Email">
                                <label for="floatingInput">Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="phone" type="text" class="form-control pw" id="floatingPassword"
                                    placeholder="Phone Number">
                                <label for="floatingInput">Phone Number</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="address" type="text" class="form-control pw" id="floatingPassword"
                                    placeholder="Address">
                                <label for="floatingInput">Address</label>
                            </div>
                            <div class="d-grid">
                                <input name='action' value="signup" hidden>
                                <button class="btn btn-danger btn-login text-uppercase fw-bold" id="suBtn"
                                    type="submit">Sign up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    include_once('./view/partials/footer.php');
    ?>
    </div>
</body>

</html>
<script>
$(function() {
    $('#suBtn').click(function(e) {
        if ($('.pw').val() != $('.con_pw').val() || $(':text').val() === '' || $(':password').val() ===
            '') {
            e.preventDefault();
        }
    });
});
</script>