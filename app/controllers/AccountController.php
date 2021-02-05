<?php
  /* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */


  /**
   * AccountController
   * 
   * 
   * @package    Controller
   * @author     Colton Davies
   */
  class AccountController extends Controller { 

    /**
     * This is the constructor for the class, a common theme for most constructors throughout the project
     * is that they just initialize the model that goes with the controller
     * 
     */
    public function __construct(){
        $this->accountModel = $this->model('AccountModel');
    }

    /**
     * The accountSettings method is the base method of the class, this is the method is called every time the page
     * tries to visit the account page view. This method sets up and gets all the defaulted data for the page that 
     * is required for it to load. 
     * 
     */
    public function accountSetting(){
      //Sets the current page session to account, this is so the program can keep track of the different pages
      $_SESSION['current_page'] = 'Account';
      ///Gets the account info basically everything from the users table
      $AccountInfo= $this->accountModel->getAccountInfo();
      if($AccountInfo[0]->Buisness_User == 1){
        $_SESSION['buisness_user_account_type'] = true;
      }else{
        $_SESSION['buisness_user_account_type'] = false;
      }
      $data["accountInfo"] = $AccountInfo[0];
      //Gets the groups that the user belongs to along with their given Ids
      $data["groupsInfo"] = $this->accountModel->getGroups();
      $data["timezones"] = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
      //Directs the site to the controllers given view
      $this->view('account/AccountSettings', $data);
    }

    /**
     * The dashboardChange method is called when the user makes a change to the Utilities section
     * of the account page, this has 3 toggles to display things like the calendar, the project 
     * display on the dashboard, and the notifications. The user has the option to turn these things 
     * on or off and this method gets the ID of the utility changed and makes a call to the database.
     * 
     */
    public function dashboardChange(){
      //Checks if the request made is a post request
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //Gets the post id and depending on what Id untility is selected it calls the model with the result
        $id = $_POST['id'];
        //Sends to one of the 3 if options if it does not match any of these means someone changed the Id and this 
        //prevents the program from throwing an error
        if($id == "dashboardCalendar"){
          $this->accountModel->changeDashboardCalendar($_POST['result']);
        }elseif($id == "dashboardProject"){
          $this->accountModel->changeDashboardProjects($_POST['result']);
        }elseif($id == "notificationsDisplay"){
          $this->accountModel->changeNotificationStatus($_POST['result']);
        }       
       
      }
    }
   /**
     * The changePassword method is called when the user submits a request to change their password
     * on the account page. It handles the errors if there are any and if there are no errors then 
     * it calls the model
     * 
     */
    public function changePassword(){
      //checks if the request made is a post request
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        //Init Data
        $data = [
          'old_password' => trim($_POST['oldPassword']),
          'new_password' => trim($_POST['newPassword']),
          'confirm_new_password'=> trim($_POST['confirmNewPassword']),
          'old_password_error' => '',
          'new_password_error' => '',
          'confirm_password_error' => '',
          'password_error' => '',
        ];

        //Validate old password
        if(empty($data['old_password'])){
          $data['old_password_error'] = 'You cannot leave the old password blank';
        }

        //Checks if the old password that the user submitted matches the one in the database
        if($this->accountModel->checkPassword($data['old_password']) == false){
          $data['old_password_error'] = 'The old password you inputed does not match the one in the database';
        }

        
        //Validate new password check if its empty
        if(empty($data['new_password'])){
          $data['new_password_error'] = 'You cannot leave the new password blank';
        }
        //Check for a proper length for new password
        if(strlen($data['new_password']) < 6){
          $data['new_password_error'] = 'Password must be at least 6 characters';
        }


        //Validate confirm new password, checks if confirm new password is empty
        if(empty($data['confirm_new_password'])){
          $data['confirm_password_error'] = 'You cannot leave the confirm new password blank';
        }
        //checks if the passwords match
        if($data['new_password'] != $data['confirm_new_password']){
          $data['password_error'] = 'New password and confirm new password must be the same';
        }
        //If all the error slots in the data variable are empty then everything is good and the password can be changed
        if(empty($data['old_password_error']) && empty($data['new_password_error']) && empty($data['confirm_password_error']) &&
        empty($data['password_error'])){

          //Hash password
          $data['new_password'] = password_hash($data['new_password'], PASSWORD_DEFAULT);

          //Calls the model to contact the database to change the users password
          if($this->accountModel->changePassword($data)){
            //redirects back to the view after everything is complete
            redirect('accountController/accountSetting');
          }else{
            //This if is meant for testing, leaving it in so if something does go wrong the program just dies
            die('Something went Wrong');
          } 

        }else{
          //If there are errors then a session variable with the data Load view with errors
          $_SESSION['passwordErrorData'] = $data;
          redirect('accountController/accountSetting');
        }

      }else{
        //load view
        redirect('accountController/accountSetting');
      }
    }
    
    /**
     * The changeInfo method when called updates the user information. If you look at the view there
     * is a section that displays the user's account info from things like their first and last name 
     * to if they have a business account or not. This method then validates the inputs and if everything 
     * is submitted correctly it calls the model to submit the data to the database
     * 
     */
    public function changeInfo(){
      //Check for POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        //Init Data
        $data = [
          'first_name' => trim($_POST['firstName']),
          'last_name' => trim($_POST['lastName']),
          'email'=> trim($_POST['email']),
          'buisness_user' => (isset($_POST['buisnessUser']))? trim($_POST['buisnessUser']): "" ,
          'timezone' => trim($_POST['timezone']),
          'first_name_error' => '',
          'last_name_error' => '',
          'email_error'=> '',
        ];

        //Validate first_name
        if(empty($data['first_name'])){
          $data['first_name_error'] = 'You cannot leave the first name blank';
        }

        //Validate last_name
        if(empty($data['last_name'])){
          $data['last_name_error'] = 'You cannot leave the last name blank';
        }

        //Validate Email
        if(empty($data['email'])){
          $data['email_error'] = 'You cannot leave the last name blank';
        }else{
          //check email
          if($_SESSION['user_email'] != $data['email']){
            if($this->accountModel->checkIfEmailExists($data['email'])){
              $data['email_error'] = 'Email is already taken'; 
            }else{
              if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                  $data['email_error'] = 'Incorrect email format'; 
              }
            }
          }

       }
       //If all the errors are emtpy then submit the data and change the users info as well as the information in the group connections
       if(empty($data['first_name_error']) && empty($data['last_name_error']) && empty($data['email_error']) && empty($data['email_error'])){
          //changes the information on the users table
          if($this->accountModel->changeInfo($data)){

            $this->accountModel->changeFriendConnectionNames($data["first_name"], $data["last_name"], true);
            $this->accountModel->changeFriendRequestConnectionNames($data["first_name"], $data["last_name"], true);

            $this->accountModel->changeFriendConnectionNames($data["first_name"], $data["last_name"], false);
            $this->accountModel->changeFriendRequestConnectionNames($data["first_name"], $data["last_name"], false);

            $this->accountModel->changeGroupMessageConnectionNames($data["first_name"], $data["last_name"], true);
            $this->accountModel->changeGroupMessageConnectionNames($data["first_name"], $data["last_name"], false);

            $this->accountModel->changeGroupRequestConnectionNames($data["first_name"], $data["last_name"]);

            $this->accountModel->changeMessageNames($data["first_name"], $data["last_name"], true);
            $this->accountModel->changeMessageNames($data["first_name"], $data["last_name"], false);

            $_SESSION['user_name'] = $data["first_name"] . ' ' . $data["last_name"];    
            
            redirect('accountController/accountSetting');
          }else{
            die('Something went Wrong');
          }
        }else{
          //Load view with errors
          redirect('accountController/accountSetting');
        }



      }else{
        //load view
        $this->view('user/Register', $data);
      }
    }
 
  }