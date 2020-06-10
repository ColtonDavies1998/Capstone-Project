<!--
    Updated September 30th 2019: Copied the UI from a Youtube Tutorial, its basic and nice looking
    enough to use as the form login for now, if something better comes along, the UI can be easily
    updated. 
    
    NOTE (TO DO): 
        -> Add regular expression, to check if the email entered is a proper email
        -> Add the backend to validate the user account, sending the email and password 
           through an ajax call.

-->

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

        <form action="<?php echo URLROOT;?>/users/register" method="post">
            <div class="col-12 form-input">
            <div>
                <div class="form-group">
                    <input id="firstName" name="first_name" type="text" class="form-control <?php echo (!empty($data['first_name_error'])) ? 'is-invalid': '';?>" 
                    placeholder="Enter First Name" value="<?php echo $data['first_name']; ?>">

                    <div class="errorMsg" id="firstNameError"><?php echo $data['first_name_error']; ?></div>
                </div>
                <div class="form-group">
                    <input id="lastName" name="last_name" type="text" class="form-control <?php echo (!empty($data['last_name_error'])) ? 'is-invalid': '';?>" 
                    placeholder="Enter Last Name" value="<?php echo $data['last_name']; ?>">
                    <div class="errorMsg" id="lastNameError"><?php echo $data['last_name_error']; ?></div>
                </div>
                <div class="form-group">
                    <input id="email" name="email" type="text" class="form-control <?php echo (!empty($data['email_error'])) ? 'is-invalid': '';?>" 
                    placeholder="Enter Email" value="<?php echo $data['email']; ?>">
                    <div class="errorMsg" id="emailError"><?php echo $data['email_error']; ?></div>
                </div>
                <div class="form-group">
                    <input id="password" name="password" type="password" class="form-control <?php echo (!empty($data['password_error'])) ? 'is-invalid': '';?>" 
                    placeholder="Enter Password" value="<?php echo $data['password']; ?>">
                    <div class="errorMsg" id="passwordError"><?php echo $data['password_error']; ?></div>
                </div>
                <div class="form-group">
                    <input id="confirmPassword" name="confirm_password" type="password" class="form-control <?php echo (!empty($data['confirm_password_error'])) ? 'is-invalid': '';?>"  
                    placeholder="Confirm Password" value="<?php echo $data['confirm_password']; ?>">
                    <div class="errorMsg" id="confirmPasswordError"><?php echo $data['confirm_password_error']; ?></div>
                </div>
              
                <input id="formButton"  type="submit" value="Register" class="btn btn-success" >
                </div>
            </div>

        </form>



        <div class="col-12 forgot">
          <a href="<?php echo URLROOT; ?>/users/login">Have an account? Log In</a>
        </div>


      </div>
    </div>
  </div>

  <script src="<?php echo URLROOT; ?>/js/login.js"></script>

</body>
</html>