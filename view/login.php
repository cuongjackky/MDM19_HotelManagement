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
                    <h5 class="card-title text-center mb-5 fw-light fs-4">Log In</h5>
                    <form action="index.php" method="post">
                        <div class="form-floating mb-3">
                            <input name="un" type="text" class="form-control" id="floatingInput" placeholder="Username">
                            <label for="floatingInput">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="pw" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <!--div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="" id="rememberPasswordCheck">
                            <label class="form-check-label" for="rememberPasswordCheck">Remember password</label>
                        </div-->
                        <div class="d-grid">
                            <input name='action' value="signin" hidden>
                            <button class="btn btn-primary btn-login text-uppercase fw-bold" id="siBtn" type="submit">Sign in</button>
                        </div>
                        <hr>
                    </form>
                    <form action="index.php" method="">
                        <div class="d-grid">
                            <input name='action' value="signup_page" hidden>
                            <button class="btn btn-danger btn-login text-uppercase fw-bold" type="submit">Sign up</button>
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
        $('#siBtn').click(function(e) {
            if($('#floatingInput').val() === '' || $('#floatingPassword').val() === '') {
                e.preventDefault();
            }
        });
    });
</script>