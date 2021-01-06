<?php 

class AccountModel{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getAccountInfo(){
        $this->db->query('SELECT * FROM users WHERE User_Id = :userId' );

        $this->db->bind(':userId', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }

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

    public function changeInfo($data){
        
        $this->db->query('UPDATE users SET User_First_Name = :firstName, User_Last_Name = :lastName, Email = :email, Timezone = :timezone,
        Buisness_User = :buisness_user WHERE User_Id = :userId ');
         
        $this->db->bind(':firstName', $data['first_name'] );
        $this->db->bind(':lastName', $data['last_name'] );
        $this->db->bind(':email', $data['email'] );
        $this->db->bind(':timezone', $data['timezone'] );

        if($data['buisness_user'] == "sub"){
            $this->db->bind(':buisness_user', 1);

            $_SESSION['buisness_user_account_type'] == true;
        }else{
            $this->db->bind(':buisness_user', 0);

            $_SESSION['buisness_user_account_type'] == false;
        }
        
        $this->db->bind(':userId', $_SESSION['user_id']);

        $_SESSION['user_timezone'] = $data['timezone'];

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function checkPassword($password){
        $this->db->query('SELECT * FROM users WHERE User_Id = :userId ');

        $this->db->bind(':userId', $_SESSION['user_id']);

        $row = $this->db->single();

        $hashed_password = $row->Password;
        if(password_verify($password, $hashed_password)){
            return true;
        }else{
            return false;
        }
    }

    public function changePassword($data){
        $this->db->query('UPDATE users SET Password = :newPassword WHERE User_Id = :userId ');

        $this->db->bind(':newPassword', $data['new_password']);
        $this->db->bind(':userId', $_SESSION['user_id']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function changeDashboardCalendar($result){
        $this->db->query('UPDATE users SET Dashboard_Calendar_Display = :DCD WHERE User_Id = :userId ');

        if($result == "true"){
            $input = 1;
        }else{
            $input = 0;
        }
        $this->db->bind(':DCD', $input);
        $this->db->bind(':userId', $_SESSION['user_id']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function changeDashboardProjects($result){
        $this->db->query('UPDATE users SET Dashboard_Projects_Display = :DPD WHERE User_Id = :userId ');

        if($result == "true"){
            $input = 1;
        }else{
            $input = 0;
        }
        $this->db->bind(':DPD', $input);
        $this->db->bind(':userId', $_SESSION['user_id']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function changeNotificationStatus($result){
        $this->db->query('UPDATE users SET Notification_Display = :notificationDisplay WHERE User_Id = :userId ');

        if($result == "true"){
            $input = 1;
        }else{
            $input = 0;
        }
        $this->db->bind(':notificationDisplay', $input);
        $this->db->bind(':userId', $_SESSION['user_id']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function getGroups(){
        $this->db->query('SELECT * FROM groups WHERE Group_Leader = :userId' );

        $this->db->bind(':userId', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }

    public function changeFriendConnectionNames($firstName, $lastName, $isPersonOne){
        if($isPersonOne == true){
            $this->db->query('UPDATE friendconnection SET PersonOneName = :personOneName WHERE PersonOneId = :userId ');

            $FullName = $firstName . " " . $lastName;

            $this->db->bind(':personOneName', $FullName);
            $this->db->bind(':userId', $_SESSION['user_id']);

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

    public function changeFriendRequestConnectionNames($firstName, $lastName, $isReceiver){
        if($isReceiver == true){
            $this->db->query('UPDATE friendrequestconnection SET ReceiverName = :receiverName WHERE ReceiverId = :userId ');

            $FullName = $firstName . " " . $lastName;

            $this->db->bind(':receiverName', $FullName);
            $this->db->bind(':userId', $_SESSION['user_id']);

            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }else{
            $this->db->query('UPDATE friendrequestconnection SET SenderName = :senderName WHERE SenderId = :userId ');

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