<?php 
  /* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */

   /**
   * AccountModel
   *
   * @author     Colton Davies
   */
class AccountModel{
    //Creates a private DB variable
    private $db;

    /**
     * This constructor initializes the database and sets it to the private variable we created above. 
     * This is so it can be accessed throughout the class
     */
    public function __construct(){
        $this->db = new Database;
    }

      /**
       * 
       * The getAccountInfo gets all the information of the user who is currently login to the device
       *
       * @return object
       */
    public function getAccountInfo(){
        $this->db->query('SELECT * FROM users WHERE User_Id = :userId' );

        $this->db->bind(':userId', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }

     /**
       * The checkIfEmailExists method checks if the email that a user has provided to change to is not already 
       * in the database, the rule is if 1 email can only be used, so if there is an email with another account 
       * that same email cannot be used until either that email is no longer in use.
       *
       * @param string $email  The email to check to
       * @return object
       */
    public function checkIfEmailExists($email){
        $this->db->query('SELECT * FROM users WHERE email = :email');
        //bind values
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        //check row
        if($this->db->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

      /**
       *The changeInfo method is called when the user has submitted the form to change information in their profile. 
       *This method updates that information
       *
       * 
       * @param string $data  The user information data
       * @return object
       */
    public function changeInfo($data){
        //Creates query
        $this->db->query('UPDATE users SET User_First_Name = :firstName, User_Last_Name = :lastName, Email = :email, Timezone = :timezone,
        Buisness_User = :buisness_user WHERE User_Id = :userId ');
        //Binds the variables to the query
        $this->db->bind(':firstName', $data['first_name'] );
        $this->db->bind(':lastName', $data['last_name'] );
        $this->db->bind(':email', $data['email'] );
        $this->db->bind(':timezone', $data['timezone'] );
        //The database reads buisness user as a 0 or 1 as a boolean so have to conver string to boolean
        if($data['buisness_user'] == "sub"){
            $this->db->bind(':buisness_user', 1);
            //Changes session
            $_SESSION['buisness_user_account_type'] == true;
        }else if($data['buisness_user'] == "unSub"){
            $this->db->bind(':buisness_user', 0);
            //Changes session
            $_SESSION['buisness_user_account_type'] == false;
        }else{
            if($_SESSION['buisness_user_account_type'] == true){
                $this->db->bind(':buisness_user', 1);
            }else{
                $this->db->bind(':buisness_user', 0);
            }
        }
        
        $this->db->bind(':userId', $_SESSION['user_id']);

        $_SESSION['user_timezone'] = $data['timezone'];
        //executes query
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

     /**
       * The checkPassword method checks if the password to the user account matches the one they imputed
       *
       * 
       * @param string $password  The password the user entered
       * @return boolean
       */
    public function checkPassword($password){
        $this->db->query('SELECT * FROM users WHERE User_Id = :userId ');

        $this->db->bind(':userId', $_SESSION['user_id']);

        $row = $this->db->single();
        //Gets hased password
        $hashed_password = $row->Password;
        //Checks if passwords match
        if(password_verify($password, $hashed_password)){
            return true;
        }else{
            return false;
        }
    }

     /**
       * 
       * This method changes the password in the database
       * 
       * @param string $data  The password data
       * @return boolean
       */
    public function changePassword($data){
        $this->db->query('UPDATE users SET Password = :newPassword WHERE User_Id = :userId ');
        //Binds variables to query
        $this->db->bind(':newPassword', $data['new_password']);
        $this->db->bind(':userId', $_SESSION['user_id']);
        //Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
       * 
       * This method changes the option on the users record for if they want the dashboard to display the 
       * calendar item or not. On the account page there is an option to change that and this is the model 
       * that changes the input to true or false show or hide
       * 
       * @param string $result  What to change the calendar to on or off
       * @return boolean
       */
    public function changeDashboardCalendar($result){
        $this->db->query('UPDATE users SET Dashboard_Calendar_Display = :DCD WHERE User_Id = :userId ');

        if($result == "true"){
            $input = 1;
        }else{
            $input = 0;
        }
        $this->db->bind(':DCD', $input);
        $this->db->bind(':userId', $_SESSION['user_id']);
        //Exection
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
       * 
       * This method changes the option on the users record for if they want the dashboard to display the 
       * projects item or not. On the account page there is an option to change that and this is the model 
       * that changes the input to true or false show or hide
       * 
       * @param string $result  What to change the projects display to on or off
       * @return boolean
       */
    public function changeDashboardProjects($result){
        $this->db->query('UPDATE users SET Dashboard_Projects_Display = :DPD WHERE User_Id = :userId ');

        if($result == "true"){
            $input = 1;
        }else{
            $input = 0;
        }
        $this->db->bind(':DPD', $input);
        $this->db->bind(':userId', $_SESSION['user_id']);
        //Executions
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
       * 
       * This method changes the option on the users record for if they want the header to display the 
       * notification icon or not. On the account page there is an option to change that and this is the model 
       * that changes the input to true or false show or hide
       * 
       * @param string $result  What to change the notification to on or off
       * @return boolean
       */
    public function changeNotificationStatus($result){
        $this->db->query('UPDATE users SET Notification_Display = :notificationDisplay WHERE User_Id = :userId ');

        if($result == "true"){
            $input = 1;
        }else{
            $input = 0;
        }
        $this->db->bind(':notificationDisplay', $input);
        $this->db->bind(':userId', $_SESSION['user_id']);
        //Exection
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
       * 
       * This method gets a list of the groups that the user belongs to
       * @return Object
       */
    public function getGroups(){
        $this->db->query('SELECT * FROM groups WHERE Group_Leader = :userId' );

        $this->db->bind(':userId', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
     * 
     * When the user changes there name, there are many tables that have the users name in it other 
     * than the users table. This function changes the names on the friend connection records
     * 
     * @param string $firstName  New first name of the user
     * @param string $lastName  New last name of the user
     * @param string $isPersonOne  boolean if the id is personOne or two in the connection record colum
     * @return boolean
     */
    public function changeFriendConnectionNames($firstName, $lastName, $isPersonOne){
        //The friendconnection record has 2 persons Ids this method checks if the users ID shows up in slot 1 or 2 then change their name
        if($isPersonOne == true){
            $this->db->query('UPDATE friendconnection SET PersonOneName = :personOneName WHERE PersonOneId = :userId ');

            $FullName = $firstName . " " . $lastName;

            $this->db->bind(':personOneName', $FullName);
            $this->db->bind(':userId', $_SESSION['user_id']);
            //Execute
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }


        }else{
            $this->db->query('UPDATE friendconnection SET PersonTwoName = :personTwoName WHERE PersonTwoId = :userId ');

            $FullName = $firstName . " " . $lastName;

            $this->db->bind(':personTwoName', $FullName);
            $this->db->bind(':userId', $_SESSION['user_id']);

            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }
    }

    /**
     * 
     * When the user changes there name, there are many tables that have the users name in it other 
     * than the users table. This function changes the names on the friend request connection records
     * 
     * @param string $firstName  New first name of the user
     * @param string $lastName  New last name of the user
     * @param string $isPersonOne  boolean if the id is personOne or two in the connection record colum
     * @return boolean
     */
    public function changeFriendRequestConnectionNames($firstName, $lastName, $isReceiver){
        if($isReceiver == true){
            $this->db->query('UPDATE friendrequestconnection SET ReceiverName = :receiverName WHERE ReceiverId = :userId ');
            //Creates a string of first and last name
            $FullName = $firstName . " " . $lastName;
            //binds variables
            $this->db->bind(':receiverName', $FullName);
            $this->db->bind(':userId', $_SESSION['user_id']);
            //Executes
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }else{
            $this->db->query('UPDATE friendrequestconnection SET SenderName = :senderName WHERE SenderId = :userId ');
            //creates fullname of users first and last name
            $FullName = $firstName . " " . $lastName;
            //binds
            $this->db->bind(':senderName', $FullName);
            $this->db->bind(':userId', $_SESSION['user_id']);
            //executes
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }
    }

    /**
     * 
     * When the user changes there name, there are many tables that have the users name in it other 
     * than the users table. This function changes the names on the group message connection records
     * 
     * @param string $firstName  New first name of the user
     * @param string $lastName  New last name of the user
     * @param string $isPersonOne  boolean if the id is personOne or two in the connection record colum
     * @return boolean
     */
    public function changeGroupMessageConnectionNames($firstName, $lastName, $isPersonOne){
        if($isPersonOne == true){
            $this->db->query('UPDATE groupmessageconnection SET Person_One_Name = :personOneName WHERE Person_One_Id = :userId');
            //create a full name
            $FullName = $firstName . " " . $lastName;
            //binds
            $this->db->bind(':personOneName', $FullName);
            $this->db->bind(':userId', $_SESSION['user_id']);
            //execute
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }else{
            $this->db->query('UPDATE groupmessageconnection SET Person_Two_Name = :personTwoName WHERE Person_Two_Id = :userId');
            //create a full name
            $FullName = $firstName . " " . $lastName;
            //binds 
            $this->db->bind(':personTwoName', $FullName);
            $this->db->bind(':userId', $_SESSION['user_id']);
            //executes
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

    }

    /**
     * 
     * When the user changes there name, there are many tables that have the users name in it other 
     * than the users table. This function changes the names on the group request connection records
     * 
     * @param string $firstName  New first name of the user
     * @param string $lastName  New last name of the user
     * @param string $isPersonOne  boolean if the id is personOne or two in the connection record colum
     * @return boolean
     */
    public function changeGroupRequestConnectionNames($firstName, $lastName){
        $this->db->query('UPDATE grouprequestconnection SET Receiver_Name = :receiverName WHERE Receiver_Id = :userId');
        //full name
        $FullName = $firstName . " " . $lastName;
        //bind
        $this->db->bind(':receiverName', $FullName);
        $this->db->bind(':userId', $_SESSION['user_id']);
        //execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 
     * When the user changes there name, there are many tables that have the users name in it other 
     * than the users table. This function changes the names on the  messages  records
     * 
     * @param string $firstName  New first name of the user
     * @param string $lastName  New last name of the user
     * @param string $isPersonOne  boolean if the id is personOne or two in the connection record colum
     * @return boolean
     */
    public function changeMessageNames($firstName, $lastName, $msgSender){
        if($msgSender == false){
            $this->db->query('UPDATE messages SET Receiver_Name = :receiverName WHERE Message_Received_By_Id = :userId');
            //gets a full name for the user
            $FullName = $firstName . " " . $lastName;
            //binds
            $this->db->bind(':receiverName', $FullName);
            $this->db->bind(':userId', $_SESSION['user_id']);
            //executes
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }else{
            $this->db->query('UPDATE messages SET Sender_Name = :senderName WHERE Message_Sent_By_Id = :userId');

            $FullName = $firstName . " " . $lastName;
    
            $this->db->bind(':senderName', $FullName);
            $this->db->bind(':userId', $_SESSION['user_id']);
    
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }


        
    }

}