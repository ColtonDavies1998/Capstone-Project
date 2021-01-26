<?php 
class IndividualProjectModel{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getProjectsTasks($projectId){
        $this->db->query('SELECT * FROM tasks WHERE User_Id = :userId AND Project_Id = :projectId' );

        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':projectId', $projectId);

        $rows = $this->db->resultSet();

        return $rows;
    }

    public function checkForUserProjectMatch($projectId){
        $this->db->query('SELECT * FROM projects WHERE User_Id = :userId AND Project_Id = :projectId');

        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':projectId', $projectId);

        $this->db->resultSet();

        $row = $this->db->rowCount();

        return $row;

    }

    public function getProjectsInformation($projectId){
        $this->db->query('SELECT * FROM projects WHERE User_Id = :userId && Project_Id = :projectId');

        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':projectId', $projectId);

        $row = $this->db->single();

        return $row;
    }

    public function getProjectFiles($projectId){
        $this->db->query('SELECT * FROM files WHERE User_Id = :userId && Project_Id = :projectId' );

        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':projectId', $projectId);

        $rows = $this->db->resultSet();

        return $rows;
    }

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

    public function getFileInformation($id){
        $this->db->query('SELECT * FROM files WHERE User_Id = :userId && File_Id = :fileId');

        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':fileId', $id);

        $row = $this->db->single();

        return $row;
    }

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

    public function getIndividualTaskInfo($taskId, $project_Id){
        $this->db->query('SELECT * FROM tasks WHERE User_Id = :userId AND Project_Id = :projectId AND Task_Id = :taskId' );

        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':projectId', $projectId);
        $this->db->bind(':taskId', $taskId);

        $row = $this->db->single();

        return $row;
    }

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

    public function getCompletedProjectTasks($projectId){
        $this->db->query('SELECT * FROM tasks WHERE User_Id = :userId AND Project_Id = :projectId AND Task_Completed = :completionValue' );

        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':projectId', $projectId);
        $this->db->bind(':completionValue', 1);

        $rows = $this->db->resultSet();

        return $rows;
    }

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