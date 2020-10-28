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

        

        if(isset($data['buisness_user'])){
            if($data['buisness_user'] == "sub"){
                $this->db->query('UPDATE users SET User_First_Name = :firstName, User_Last_Name = :lastName, Email = :email, 
                Buisness_User = :buisness_user WHERE User_Id = :userId ');
                $this->db->bind(':firstName', $data['first_name'] );
                $this->db->bind(':lastName', $data['last_name'] );
                $this->db->bind(':email', $data['email'] );

                $this->db->bind(':buisness_user', 1);

                $_SESSION['buisness_user_account_type'] == true;

            }else if($data['buisness_user'] == "unSub"){
                $this->db->query('UPDATE users SET User_First_Name = :firstName, User_Last_Name = :lastName, Email = :email, 
                Buisness_User = :buisness_user WHERE User_Id = :userId ');
                $this->db->bind(':firstName', $data['first_name'] );
                $this->db->bind(':lastName', $data['last_name'] );
                $this->db->bind(':email', $data['email'] );
                $this->db->bind(':buisness_user', 0);
                $_SESSION['buisness_user_account_type'] == false;
            }else{
                $this->db->query('UPDATE users SET User_First_Name = :firstName, User_Last_Name = :lastName, Email = :email
                WHERE User_Id = :userId ');
                $this->db->bind(':firstName', $data['first_name'] );
                $this->db->bind(':lastName', $data['last_name'] );
                $this->db->bind(':email', $data['email'] );
            }
        }


        $this->db->bind(':userId', $_SESSION['user_id']);

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

    public function getGroups(){
        $this->db->query('SELECT * FROM groups WHERE Group_Leader = :userId' );

        $this->db->bind(':userId', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }
}