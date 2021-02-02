<?php 
  /* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */

   /**
   * IndividualGroupModel
   *
   * @author     Colton Davies
   */
class IndividualProjectModel{
    //Creates a private DB variable
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
       * This method gets all the tasks related to the current project
       *
       * 
       * @param string $projectId  The project id pased through
       *  
       * @return object
       */
    public function getProjectsTasks($projectId){
        $this->db->query('SELECT * FROM tasks WHERE User_Id = :userId AND Project_Id = :projectId' );

        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':projectId', $projectId);

        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       * 
       * This method checks for if the project the user is trying to access is connected to them
       *
       * 
       * @param string $projectId  The project id pased through
       *  
       * @return object
       */
    public function checkForUserProjectMatch($projectId){
        $this->db->query('SELECT * FROM projects WHERE User_Id = :userId AND Project_Id = :projectId');

        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':projectId', $projectId);

        $this->db->resultSet();

        $row = $this->db->rowCount();

        return $row;

    }

    /**
       * 
       * This method gets the project information
       *
       * 
       * @param string $projectId  The project id pased through
       *  
       * @return object
       */
    public function getProjectsInformation($projectId){
        $this->db->query('SELECT * FROM projects WHERE User_Id = :userId && Project_Id = :projectId');

        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':projectId', $projectId);

        $row = $this->db->single();

        return $row;
    }

    /**
       * 
       * This method gets all files related to the project
       *
       * 
       * @param string $projectId  The project id pased through
       *  
       * @return object
       */
    public function getProjectFiles($projectId){
        $this->db->query('SELECT * FROM files WHERE User_Id = :userId && Project_Id = :projectId' );

        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':projectId', $projectId);

        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       * 
       * This method creates a new task for the project
       *
       * 
       * @param string $data  task data
       *  
       * @return boolean
       */
    public function createNewTask($data){
        $this->db->query('INSERT INTO tasks (Task_Name, Task_Type, Task_Start_Time, Task_End_Time, Task_Start_Date, Task_End_Date, Task_Completed, Project_Id, User_Id) 
        VALUES(:taskName, :taskType, :TaskStartTime, :TaskEndTime, :TaskStartDate, :TaskEndDate, :TaskCompleted, :projectId ,:userId)');
        //bind values
        $this->db->bind(':taskName', $data['task_name']);
        $this->db->bind(':taskType', $data['task_type']);
        $this->db->bind(':TaskStartTime', $data['task_start_time']);
        $this->db->bind(':TaskEndTime', $data['task_end_time']);
        $this->db->bind(':TaskStartDate', $data['task_start_date']);
        $this->db->bind(':TaskEndDate', $data['task_end_date']);
        $this->db->bind(':TaskCompleted', 0);
        $this->db->bind(':projectId', $data['project_id']);
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
       * This method creates a new file record in the database
       *
       * 
       * @param string $data  the data to create a file
       *  
       * @return boolean
       */
    public function storeNewFile($data){
        $this->db->query('INSERT INTO files (File_Link, File_Type, File_Name, Project_Id, User_Id) 
        VALUES(:fileLink, :fileType, :fileName, :projectId, :userId)');
        //bind values
        $this->db->bind(':fileLink', $data['file_link']);
        $this->db->bind(':fileType', $data['file_type']);
        $this->db->bind(':fileName', $data['file_name']);
        $this->db->bind(':projectId', $data['project_id']);
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
       * This method gets the file information of a single record given the id
       *
       * 
       * @param string $id  The file id
       *  
       * @return object
       */
    public function getFileInformation($id){
        $this->db->query('SELECT * FROM files WHERE User_Id = :userId && File_Id = :fileId');

        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':fileId', $id);

        $row = $this->db->single();

        return $row;
    }

    /**
       * 
       * This method edits a files information given its id
       *
       * 
       * @param string $data  The edited data of a file
       *  
       * @return boolean
       */
    public function editFile ($data){
        $this->db->query('UPDATE files SET File_Name = :fileName, File_Type = :fileType, 
        File_Link = :fileLink
        WHERE User_Id = :userId && project_Id = :projectId && File_Id = :fileId');

        $this->db->bind(':fileName', $data['file_name']);
        $this->db->bind(':fileType', $data['file_type']);
        $this->db->bind(':fileLink', $data['file_link']);

        $this->db->bind(':projectId', $data['project_id']);
        $this->db->bind(':fileId', $data['file_id']);
        $this->db->bind(':userId', $_SESSION['user_id']);
        
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
       * 
       * This method deletes the file record given the id
       *
       * 
       * @param string $fileId  the file id
       *  
       * @return boolean
       */
    public function deleteFile($fileId){
        $this->db->query('DELETE FROM files WHERE User_Id = :userId && File_Id = :fileId');

        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':fileId', $fileId);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
       * 
       * This method gets the information of an individual task
       *
       * 
       * @param string $taskId  The id of an individual task
       * @param string $project_Id  The project id
       * 
       * @return object
       */
    public function getIndividualTaskInfo($taskId, $project_Id){
        $this->db->query('SELECT * FROM tasks WHERE User_Id = :userId AND Project_Id = :projectId AND Task_Id = :taskId' );

        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':projectId', $projectId);
        $this->db->bind(':taskId', $taskId);

        $row = $this->db->single();

        return $row;
    }

    /**
       * 
       * This method changes the task completion of an individual task
       *
       * 
       * @param string $taskId  The id of an individual task
       * @param string $changeToComplete  boolean if true change task to complete else false
       * 
       * @return boolean
       */
    public function changeTaskCompletion($taskId, $changeToComplete){
        $this->db->query('UPDATE tasks SET Task_Completed = :completionValue WHERE Task_Id = :taskid && User_Id = :userId');


        if($changeToComplete == true){
            $this->db->bind(':completionValue', 1);
        }else{
            $this->db->bind(':completionValue', 0);
        }
        $this->db->bind(':taskid', $taskId);
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
       * This method gets completed tasks for the project
       *
       * 
       * @param string $projectId  The id of an individual project
       * 
       * @return object
       */
    public function getCompletedProjectTasks($projectId){
        $this->db->query('SELECT * FROM tasks WHERE User_Id = :userId AND Project_Id = :projectId AND Task_Completed = :completionValue' );

        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':projectId', $projectId);
        $this->db->bind(':completionValue', 1);

        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       * 
       * This method updates the project completion percent of a project
       *
       * 
       * @param string $projectId  The id of an individual project
       * @param string $completionPercent  percent of completion for project
       * 
       * @return object
       */
    public function changeProjectCompletion($projectId, $completionPercent){
        $this->db->query('UPDATE projects SET Project_Completion = :completionPercent WHERE Project_Id = :projectId ');

        $this->db->bind(':completionPercent', $completionPercent);
        $this->db->bind(':projectId', $projectId);

        //call execute if you want to insert
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
       * 
       * This method deletes an individual task given the id
       *
       * 
       * @param string $taskId  The id of an individual task
       * 
       * @return boolean
       */
    public function deleteTask($taskId){
        $this->db->query('DELETE FROM tasks WHERE User_Id = :userId && Task_Id = :taskId');

        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':taskId', $taskId);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
       * 
       * This method edits the task information of a task given the id
       *
       * 
       * @param string $data  The data to edit the information of a task
       * 
       * @return boolean
       */
    public function editTask($data){
        $this->db->query('UPDATE tasks SET Task_Name = :taskName, Task_Type = :taskType, Task_Start_Time = :startTime,
                          Task_End_Time = :endTime, Task_Start_Date = :startDate, Task_End_Date = :endDate, Task_Completed = :isComplete
                          WHERE User_Id = :userId && Task_Id = :taskId');

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

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }

    }
}