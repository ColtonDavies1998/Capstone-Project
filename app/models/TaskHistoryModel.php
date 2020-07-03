<?php 

class TaskHistoryModel{
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

    public function getTaskInfo($taskId){
        $this->db->query('SELECT * FROM tasks WHERE User_Id = :userId && Task_Id = :taskId');

        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':taskId', $taskId);

        $row = $this->db->single();

        return $row;
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

?>