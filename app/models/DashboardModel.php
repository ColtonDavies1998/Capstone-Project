<?php 

class DashboardModel{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getDailyTasks(){

        $this->db->query('SELECT * FROM tasks WHERE Task_Start_Date = CURDATE()');

        $rows = $this->db->resultSet();

        return $rows;
    }

    public function createNewTask($data){
        

        $this->db->query('INSERT INTO tasks (Task_Name, Task_Type, Task_Start_Time, Task_End_Time, Task_Start_Date, Task_End_Date, Task_Completed, User_Id) 
        VALUES(:taskName, :taskType, :TaskStartTime, :TaskEndTime, :TaskStartDate, :TaskEndDate, :TaskCompleted, :userId)');
        //bind values
        $this->db->bind(':taskName', $data['task_name']);
        $this->db->bind(':taskType', $data['task_type']);
        $this->db->bind(':TaskStartTime', $data['task_start_time']);
        $this->db->bind(':TaskEndTime', $data['task_end_time']);
        $this->db->bind(':TaskStartDate', $data['task_start_date']);
        $this->db->bind(':TaskEndDate', $data['task_end_date']);
        $this->db->bind(':TaskCompleted', 0);
        $this->db->bind(':userId', $_SESSION['user_id']);

        //call execute if you want to insert
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function totalDailyTasks(){
        $this->db->query('SELECT * FROM tasks WHERE Task_Start_Date = CURDATE()');

        $this->db->execute();

        $row = $this->db->rowCount();

        return $row;
    }

}