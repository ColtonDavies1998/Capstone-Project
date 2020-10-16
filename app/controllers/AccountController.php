<?php
  class AccountController extends Controller { 
    public function __construct(){
        $this->accountModel = $this->model('AccountModel');
    }

    public function accountSetting(){
        $_SESSION['current_page'] = 'Account';

        $data= $this->accountModel->getAccountInfo();

        $this->view('account/AccountSettings', $data);
    }

    public function dashboardChange(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $id = $_POST['id'];

        if($id == "dashboardCalendar"){
          $this->accountModel->changeDashboardCalendar($_POST['result']);
        }elseif($id == "dashboardProject"){
          $this->accountModel->changeDashboardProjects($_POST['result']);
        }        
       
      }
    }

    public function changePassword(){
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

        
        //var_dump($this->accountModel->checkPassword($data['old_password'])) ;


        if($this->accountModel->checkPassword($data['old_password']) == false){
          $data['old_password_error'] = 'The old password you inputed does not match the one in the database';
        }

        

        //Validate new password
        if(empty($data['new_password'])){
          $data['new_password_error'] = 'You cannot leave the new password blank';
        }

        if(strlen($data['new_password']) < 6){
          $data['new_password_error'] = 'Password must be at least 6 characters';
        }



        //Validate confirm new password
        if(empty($data['confirm_new_password'])){
          $data['confirm_password_error'] = 'You cannot leave the confirm new password blank';
        }

        if($data['new_password'] != $data['confirm_new_password']){
          $data['password_error'] = 'New password and confirm new password must be the same';
        }

        if(empty($data['old_password_error']) && empty($data['new_password_error']) && empty($data['confirm_password_error']) &&
        empty($data['password_error'])){
          //var_dump($data);

          //Hash password
          $data['new_password'] = password_hash($data['new_password'], PASSWORD_DEFAULT);

          
          if($this->accountModel->changePassword($data)){
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
        redirect('accountController/accountSetting');
      }
    }

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
       if(empty($data['first_name_error']) && empty($data['last_name_error']) && empty($data['email_error'])){
          
          if($this->accountModel->changeInfo($data)){
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
        //this->view('user/Register', $data);
      }
    }

    
  }