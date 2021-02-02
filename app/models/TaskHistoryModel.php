<?php 
  /* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */

 /**
   * TaskHistoryModel
   *
   * @author     Colton Davies
   */
class TaskHistoryModel{
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
       *This method gets all the users tasks
       * 
       * @return object
       */
    public function getAllUsersTasks(){
        $this->db->query('SELECT * FROM tasks WHERE User_Id = :userId');

        $this->db->bind(':userId', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       *
       *This method removes the task from the database given the taskid
       * 
       * @param string $taskId  The task id
       * @return boolean
       */
    public function deleteTask($taskId){
        $this->db->query('DELETE FROM tasks WHERE User_Id = :userId && Task_Id = :taskId');
        //bind
        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':taskId', $taskId);
        //execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
       *
       *This method gets the task info for the program to display on the edit form
       * 
       * @param string $taskId  The task id
       * @return object
       */
    public function getTaskInfo($taskId){
        $this->db->query('SELECT * FROM tasks WHERE User_Id = :userId && Task_Id = :taskId');
        //bind
        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':taskId', $taskId);
        //execute
        $row = $this->db->single();

        return $row;
    }

    /**
       *
       *This method updates the task and its infromation with the information provided by the user
       * 
       * @param string $data  the edited tasks information data
       * @return boolean
       */
    public function editTask($data){
        $this->db->query('UPDATE tasks SET Task_Name = :taskName, Task_Type = :taskType, Task_Start_Time = :startTime,
                          Task_End_Time = :endTime, Task_Start_Date = :startDate, Task_End_Date = :endDate, Task_Completed = :isComplete
                          WHERE User_Id = :userId && Task_Id = :taskId');
    //bind
        $this->db->bind(':taskName', $data['edit_task_name'] );
        $this->db->bind(':taskType', $data['edit_task_type'] );
        $this->db->bind(':startTime', $data['edit_task_start_time'] );
        $this->db->bind(':endTime', $data['edit_task_end_time'] );
        $this->db->bind(':startDate', $data['edit_task_start_date'] );
        $this->db->bind(':endDate', $data['edit_task_end_date'] );

        if($data['edit_isComplete'] == "complete"){
            $this->db->bind(':isComplete', 1);
        }else{
            $this->db->bind(':isComplete', 0);
        }
        
        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':taskId', $data['edit_task_id'] );
        //execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }

    }

    /**
       *
       * This method is used to validate that a task id belongs to the given user. This is to prevent someone from editing the 
       * HTML and deleting tasks that are not their own
       * 
       * @param string $taskId  The task id
       * @return object
       */
    public function validateId($taskId){
        $this->db->query('SELECT * FROM tasks WHERE User_Id = :userId && Task_Id = :taskId');

        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':taskId', $taskId);

        $row = $this->db->single();

        return $row;
    }

}

?>