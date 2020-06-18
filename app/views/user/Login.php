<!--
    Updated September 30th 2019: Copied the UI from a Youtube Tutorial, its basic and nice looking
    enough to use as the form login for now, if something better comes along, the UI can be easily
    updated. 
    
    NOTE (TO DO): 
        -> Add regular expression, to check if the email entered is a proper email


-->

<?php if(isset($_SESSION['user_id'])): ?>
  <?php redirect('dashboardController/Dashboard'); ?>
<?php else: ?>
  <!DOCTYPE html>
<html>
<head>
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
  <link rel="stylesheet" type="text/css" href="../css/loginStyles.css">
  <title><?php echo SITENAME; ?></title>
</head>
<body>

  <div class="modal-dialog text-center">
    <div class="col-sm-9 main-section">
      <div class="modal-content">

        <div class="col-12 user-img">
          <img src="../img/face.png">
        </div>

        <?php flash('register_success');?>

        <form action="<?php echo URLROOT;?>/userController/login" method="post">
          <div class="col-12 form-input">
            <div>
              <div class="form-group">
                <input id="email" name="email" type="email" class="form-control" placeholder="Enter Email" value="<?php echo $data['email']; ?>">
                <div class="errorMsg" id="emailError"><?php echo $data['email_error']; ?></div>
              </div>
              <div class="form-group">
                <input id="password" name="password" type="password" class="form-control" placeholder="Enter Password" value="<?php echo $data['password']; ?>">
                <div class="errorMsg" id="passwordError"><?php echo $data['password_error']; ?></div>
              </div>
              <input id="formButton"  type="submit" value="Login" class="btn btn-success" >
            </div>
          </div>
        </form>




        <div class="col-12 forgot">
          <a href="<?php echo URLROOT; ?>/userController/register">Register</a>
        </div>

        <div class="col-12 forgot">
          <a href="#">Forgot Password?</a>
        </div>

      </div>
    </div>
  </div>

 

</body>
</html>

    
<?php endif;?>

