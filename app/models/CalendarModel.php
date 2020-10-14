<?php 

class CalendarModel{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getAllUsersTasks(){
        $this->db->query('SELECT * FROM tasks WHERE User_Id = :userId');

        $this->db->bind(':userId', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }

 


    

}

?>