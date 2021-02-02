<?php 
  /* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */

 /**
   * UserModel
   *
   * @author     Colton Davies
   */
class UserModel{
    //creates private db variable
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
       *This method creates a new user in the user table
       * 
       * @param string $data  the register data
       * @return boolean
       */
    public function register($data){
        if($data['buisness_User'] == "Yes"){
            //if the buisness user was checked then the user has a different account type
            $buisnessUser = 1;
        }else{
            $buisnessUser = 0;
        }


        $this->db->query('INSERT INTO users (User_First_Name, User_Last_Name, Dashboard_Calendar_Display, Dashboard_Projects_Display, Password, Email, Timezone , Buisness_User) 
        VALUES(:firstName, :lastName, :dashboardCalendar, :dashboardProject, :password, :email, :timezone , :buisnessUser)');
        //bind values
        $this->db->bind(':firstName', $data['first_name']);
        $this->db->bind(':lastName', $data['last_name']);
        $this->db->bind(':dashboardCalendar', 0);
        $this->db->bind(':dashboardProject', 0);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':timezone', $data['timezone']);
        $this->db->bind(':buisnessUser', $buisnessUser);

        //call execute if you want to insert
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
       *
       * This method checks the database for a user with the matching login credentials
       * 
       * @param string $email  the users email
       * @param string $password  the users password
       * @return boolean
       * OR
       * @return object
       */
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


    /**
       *
       * This method finds the user by a given email address and returns a row count
       * 
       * @param string $email  the users email
       * @return boolean
       */
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

