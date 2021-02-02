<?php 
  /* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */

     /**
     * UserController
     * 
     * 
     * @package    Controller
     * @author     Colton Davies
     */
    class UserController extends Controller{

        /**
        * 
        * This is the constructor for the class, a common theme for most constructors throughout the project
        * is that they just initialize the model that goes with the controller
        *
        */
        public function __construct(){
            $this->userModel = $this->model('UserModel');
        }

        /**
         * the register method is called when the user is on the register page and submits a new account. 
         * This method checks for any errors in the form submission data and if everything is ok then the 
         * new account is created when the model is called if not then it is returned to the page with the 
         * form errors
         */
        public function register(){
            //Sets the current page to the register page
            $_SESSION['current_page'] = 'Register';

            //Check for POST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //Process form

                //Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $theZones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
                //Init Data
                $data = [
                    'first_name'=> trim($_POST['first_name']),
                    'last_name'=> trim($_POST['last_name']),
                    'email'=> trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'timezone' => trim($_POST['timezones']),
                    'buisness_user' =>   (empty($_POST['buisnessUser']) ? '' : trim($_POST['buisnessUser'])) ,
                    'first_name_error' => '',
                    'last_name_error' => '',
                    'email_error'=> '',
                    'password_error' => '',
                    'confirm_password_error' => '',
                    'timezones' => $theZones

                ];

                //Validate Name
                if(empty($data['first_name'])){
                    $data['first_name_error'] = 'Please enter first name';
                }
                if(empty($data['last_name'])){
                    $data['last_name_error'] = 'Please enter last name';
                }
                //Validate Email
                if(empty($data['email'])){
                    $data['email_error'] = 'Please enter an email';
                }else{
                    //check email
                    if($this->userModel->findUserByEmail($data['email'])){
                        $data['email_error'] = 'Email is already taken'; 
                    }else{
                        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                            $data['email_error'] = 'Incorrect email format'; 
                        }
                    }
                }
                //Validate password
                if(empty($data['password'])){
                    $data['password_error'] = 'Please enter a password';
                }elseif(strlen($data['password']) < 6){
                    $data['password_error'] = 'Password must be at least 6 characters';
                }
                //Validate confirm password
                if(empty($data['confirm_password'])){
                    $data['confirm_password_error'] = 'Please confirm your password';
                }else{
                    if($data['password'] != $data['confirm_password']){
                        $data['confirm_password_error'] = 'Passwords do not match!';
                    }
                }
                //Checks if all the errors are empty
                if(empty($data['first_name_error']) && empty($data['last_name_error']) && empty($data['email_error']) && empty($data['password_error'])
                   && empty( $data['confirm_password_error'])){
                    //Validate

                    //Hash password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    //Register User
                    if($this->userModel->register($data)){
                        flash('register_success', 'You are registered and can log in');
                        redirect('userController/login');
                    }else{
                        die('Something went Wrong');
                    }
                    

                }else{
                    //Load view with errors
                    
                    $this->view('user/Register',$data);
                }


            }else{
                //Init Data
                $timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);

                $data = [
                    'first_name'=> '',
                    'last_name'=> '',
                    'email'=> '',
                    'password' => '',
                    'confirm_password' => '',
                    'buisness_user' => '',
                    'first_name_error' => '',
                    'last_name_error' => '',
                    'email_error'=> '',
                    'password_error' => '',
                    'confirm_password_error' => '',
                    'timezones' => $timezones
                ];

                //load view
                $this->view('user/Register', $data);
            }
        }

        /**
         * The login form is called when the user submitted the form to login to the website. 
         * This checks if the account that the user imputed is valid by checking the email and 
         * password to records in the database. If the users login data is correct then the sessions 
         * are set and the user is logged in, else the the user returns to the login page with the errors.
         */
        public function login(){
            //Sets the current page session to login
            $_SESSION['current_page'] = 'Login';

            //Check for POST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //Process form

                //Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                //Init Data
                $data = [
                    'email'=> trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'email_error'=> '',
                    'password_error' => ''
                ];


                //Validate Email
                if(empty($data['email'])){
                    $data['email_error'] = 'Please enter an email';
                }

                //Validate password
                if(empty($data['password'])){
                    $data['password_error'] = 'Please enter a password';
                }

                //check for user/email
                if($this->userModel->findUserByEmail($data['email'])){
                    //user found
                }else{
                    //no user found
                    $data['email_error'] = 'No user found';
                }
                //Checks if the errors are empty
                if(empty($data['email_error']) && empty($data['password_error'])){
                     //validated
                     //check and set logged in user
                     $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                     if($loggedInUser){
                        //create session
                        $this->createUserSession($loggedInUser);
                     }else{
                        $data['password_error'] = 'Password incorrect';
                        //Load the view
                        $this->view('user/login', $data);
                     }
                }else{
                     //Load view with errors
                     $this->view('user/login',$data);
                 }

            }else{
                //Init Data
                $data = [
                    'email'=> '',
                    'password' => '',
                    'email_error'=> '',
                    'password_error' => ''
                ];

                //load view
                $this->view('user/login', $data);
            }
        }
        /**
         * the createUserSession when called when the user has provided the proper email 
         * and password. This functions sets the sessions that will be used to make the 
         * page unique to that user, things like their id or email of their name.
         */
        public function createUserSession($user){
            //Sets the sessions
            $_SESSION['user_id'] = $user->User_Id;
            $_SESSION['user_email'] = $user->Email;
            $_SESSION['user_name'] = $user->User_First_Name . ' ' . $user->User_Last_Name;    
            $_SESSION['user_timezone'] = $user->Timezone;       

            if($user->Buisness_User == 1){
                $_SESSION['buisness_user_account_type'] = true;
            }else{
                $_SESSION['buisness_user_account_type'] = false;
            }
            //Redirects to the dashboard
            redirect('DashboardController/dashboard');
        }

        /**
         * The logout function is called when a user logouts, it unsets and destroys all the sessions. 
         * also redirects the user to the login page
         */
        public function logout(){
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            unset($_SESSION['buisness_user_account_type']);
            session_destroy();
            redirect('userController/login');
        }

        /**
         * Checks if the user is logged
         */
        public function isLoggedIn(){
            if(isset($_SESSION['user_id'])){
                return true;
            }else{
                false;
            }
        }

    }
?>