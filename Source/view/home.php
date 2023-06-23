<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//chưa login thì về lại trang login
if (!isset($_SESSION['username'])){
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
    
   
   
    include_once('./view/partials/footer.php');
    ?>
</div>
</body>
</html>