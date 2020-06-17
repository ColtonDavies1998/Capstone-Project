<?php 

    class Users extends Controller{
        public function __construct(){
            $this->userModel = $this->model('User');
        }

        public function register(){
            //Check for POST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //Process form

                //Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                //Init Data
                $data = [
                    'first_name'=> trim($_POST['first_name']),
                    'last_name'=> trim($_POST['last_name']),
                    'email'=> trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'buisness_user' => trim($_POST['buisnessUser']),
                    'first_name_error' => '',
                    'last_name_error' => '',
                    'email_error'=> '',
                    'password_error' => '',
                    'confirm_password_error' => ''
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

                if(empty($data['first_name_error']) && empty($data['last_name_error']) && empty($data['email_error']) && empty($data['password_error'])
                   && empty( $data['confirm_password_error'])){
                    //Validate

                    //Hash password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    //Register User
                    if($this->userModel->register($data)){
                        flash('register_success', 'You are registered and can log in');
                        redirect('users/login');
                    }else{
                        die('Something went Wrong');
                    }
                    

                }else{
                    //Load view with errors
                    $this->view('users/Register',$data);
                }


            }else{
                //Init Data
                $data = [
                    'first_name'=> '',
                    'last_name'=> '',
                    'email'=> '',
                    'password' => '',
                    'confirm_password' => '',
                    'first_name_error' => '',
                    'last_name_error' => '',
                    'email_error'=> '',
                    'password_error' => '',
                    'confirm_password_error' => ''
                ];

                //load view
                $this->view('users/register', $data);
            }
        }

        public function login(){
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

                if(empty($data['email_error']) && empty($data['password_error'])){
                     //validated
                     //check and set logged in user
                     $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                     if($loggedInUser){
                        //create session
                        $this->createUserSession($loggedInUser);
                     }else{
                        $data['password_error'] = 'Password incorrect';

                        $this->view('users/login', $data);
                     }
                }else{
                     //Load view with errors
                     $this->view('users/login',$data);
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
                $this->view('users/login', $data);
            }
        }

        public function createUserSession($user){
            $_SESSION['user_id'] = $user->User_Id;
            $_SESSION['user_email'] = $user->Email;
            $_SESSION['user_name'] = $user->User_First_Name . ' ' . $user->User_Last_Name;
            if($user->Buisness_user = 1){
                $_SESSION['user_account_type'] = true;
            }else{
                $_SESSION['user_account_type'] = false;
            }
            redirect('DashboardController/dashboard');
        }

        public function logout(){
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            unset($_SESSION['user_account_type']);
            session_destroy();
            redirect('users/login');
        }

        public function isLoggedIn(){
            if(isset($_SESSION['user_id'])){
                return true;
            }else{
                false;
            }
        }

    }
?>