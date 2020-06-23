<?php 

class UserModel{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    //Register User
    public function register($data){
        if($data['buisness_User'] == "Yes"){
            //if the buisness user was checked then the user has a different account type
            $buisnessUser = 1;
        }else{
            $buisnessUser = 0;
        }


        $this->db->query('INSERT INTO users (User_First_Name, User_Last_Name, Dashboard_Calendar_Display, Dashboard_Projects_Display, Password, Email, Buisness_User) 
        VALUES(:firstName, :lastName, :dashboardCalendar, :dashboardProject, :password, :email, :buisnessUser)');
        //bind values
        $this->db->bind(':firstName', $data['first_name']);
        $this->db->bind(':lastName', $data['last_name']);
        $this->db->bind(':dashboardCalendar', 0);
        $this->db->bind(':dashboardProject', 0);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':buisnessUser', $buisnessUser);

        //call execute if you want to insert
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    //login user
    public function login($email, $password){
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        $hashed_password = $row->Password;
        if(password_verify($password, $hashed_password)){
            return $row;
        }else{
            return false;
        }
    }

    //find user by email
    public function findUserByEmail($email){
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
}
?>

