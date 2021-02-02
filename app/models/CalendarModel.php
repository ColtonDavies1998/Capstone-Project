<?php 
  /* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */

   /**
   * CalendarModel
   *
   * @author     Colton Davies
   */
class CalendarModel{
    //create a private db variable
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
       * The getAllUsersTasks when called selects all the tasks from the table that belond to the currently logged in user
       *
       * @return object
       */
    public function getAllUsersTasks(){
        $this->db->query('SELECT * FROM tasks WHERE User_Id = :userId');
        //bind
        $this->db->bind(':userId', $_SESSION['user_id']);
        //query
        $rows = $this->db->resultSet();

        return $rows;
    }

 


    

}

?>