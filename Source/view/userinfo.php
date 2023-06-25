<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once('./view/partials/htmlHead.php');
include_once('./view/partials/header.php');
include_once('./view/partials/nav.php');

?>
<body>
    <hr>

    <div class = "container">
    <?php if (isset($userinfo)){ ?>

<form>
    
    <div class="form-group">
      <label for="username">Login name</label>
      <input type="text" class="form-control" id="username" value ="<?php echo $userinfo['username'];?>" disabled >
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="text" class="form-control" id="password" value= "<?php echo $userinfo['password'];?>" disabled>
    </div>
  
  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" value ="<?php echo $userinfo['name'];?>" disabled>
  </div>
  <div class="form-group">
    <label for="email">Email</label>
    <input type="text" class="form-control" id="email" value ="<?php echo $userinfo['email'];?>" disabled>
  </div>
  <div class="form-group">
    <label for="phone">Phone</label>
    <input type="text" class="form-control" id="phone" value ="<?php echo $userinfo['phone'];?>" disabled>
  </div>
  <div class="form-group">
    <label for="address">Address</label>
    <input type="text" class="form-control" id="address" value ="<?php echo $userinfo['address'];?>" disabled>
  </div>
</form>
<?php }?>
    </div>

</body>
<?php include_once('./view/partials/footer.php');  ?>