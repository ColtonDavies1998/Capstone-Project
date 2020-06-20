<?php 

class DashboardModel{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getDailyTasks(){

        $this->db->query('SELECT * FROM tasks WHERE Task_Start_Date = CURDATE() && User_Id = :userId');

        $this->db->bind(':userId', $_SESSION['user_id']);

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

        $this->db->resultSet();

        $row = $this->db->rowCount();

        return $row;
    }


    public function totalDailyTasksCompleted(){
        $this->db->query('SELECT * FROM tasks WHERE Task_Completed = 1');

        $this->db->resultSet();

        $row = $this->db->rowCount();

        return $row;
    }

    public function createNewProject($data){

        $this->db->query('INSERT INTO projects (Project_Name, User_Id, Group_Id, Project_Type, Project_Description, Project_Completion) 
        VALUES(:projectName, :userId, :groupId, :projectType, :projectDescription, :projectCompletion)');
        //bind values
        $this->db->bind(':projectName', $data['project_name']);
        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':groupId', null);
        $this->db->bind(':projectType', $data['project_type']);
        $this->db->bind(':projectDescription', $data['project_description']);
        $this->db->bind(':projectCompletion', 0);

        //call execute if you want to insert
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }

    }

    public function getProjects(){

        $this->db->query('SELECT * FROM projects WHERE User_Id = :userId');

        $this->db->bind(':userId', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }

}

?>