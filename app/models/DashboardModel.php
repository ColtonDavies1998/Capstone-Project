<?php 
  /* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */

 /**
   * DashboardModel
   *
   * @author     Colton Davies
   */
class DashboardModel{
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
       * this method gets all the tasks that have a start date of today
       *
       * @return object
       */
    public function getDailyTasks(){

        $this->db->query('SELECT * FROM tasks WHERE Task_Start_Date = CURDATE() && User_Id = :userId');
        //bind
        $this->db->bind(':userId', $_SESSION['user_id']);
        //query
        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       *
       *This method creates a new task with the data provided as a parameter.
       * 
       * @param string $data  The task information data
       * @return boolean
       */
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

    /**
       *
       *This returns the total number of daily tasks
       * 
       * @return object
       */
    public function totalDailyTasks(){
        $this->db->query('SELECT * FROM tasks WHERE Task_Start_Date = CURDATE() && User_Id = :userId');

        $this->db->bind(':userId', $_SESSION['user_id']);

        $this->db->resultSet();

        $row = $this->db->rowCount();

        return $row;
    }


    /**
       *
       *This method returns the total number of tasks that have been completed
       * 
       * @return boolean
       */
    public function totalDailyTasksCompleted(){
        $this->db->query('SELECT * FROM tasks WHERE Task_Completed = 1 && Task_Start_Date = CURDATE() &&  User_Id = :userId');

        $this->db->bind(':userId', $_SESSION['user_id']);

        $this->db->resultSet();

        $row = $this->db->rowCount();

        return $row;
    }

    /**
       *
       * This method returns the users calendar dashboard display setting
       * 
       * @return object
       */
    public function Dashboard_Calendar_Display(){
        $this->db->query('SELECT Dashboard_Calendar_Display  FROM users WHERE User_Id = :userId');

        $this->db->bind(':userId', $_SESSION['user_id']);

        return $this->db->single();
    }

       /**
       *
       * This method returns the users project dashboard display setting
       * 
       * @return object
       */
    public function Dashboard_Projects_Display(){
        $this->db->query('SELECT Dashboard_Projects_Display  FROM users WHERE User_Id = :userId');

        $this->db->bind(':userId', $_SESSION['user_id']);

        return $this->db->single();
    }

     /**
       *
       *This method creates a new project with the data provided as a parameter.
       * 
       * @param string $data  The project information data
       * @return boolean
       */
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

    /**
       *
       *This method creturns all the users projects
       * 
       * @return object
       */
    public function getProjects(){

        $this->db->query('SELECT * FROM projects WHERE User_Id = :userId');

        $this->db->bind(':userId', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }


     /**
       *
       *When this method is called it changes the completion of the task of the id passed as a parameter to true
       * 
       * @param string $id  The task id
       * @return boolean
       */
    public function changeIncompleteTask($id){
        $this->db->query('UPDATE tasks SET Task_Completed = 1 WHERE Task_Id = :taskid && User_Id = :userId');
        //bind
        $this->db->bind(':taskid', $id);
        $this->db->bind(':userId', $_SESSION['user_id']);

        //call execute if you want to insert
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

}

?>