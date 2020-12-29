<?php 

class IndividualGroupModel{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function checkForUserGroupMatch($id){
        $this->db->query('SELECT * FROM groupconnection WHERE User_Id = :userId && Group_Id = :groupId');

        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':groupId', $id);

        $this->db->resultSet();

        $row = $this->db->rowCount();

        return $row;
    }

    public function getGroupInformation($id){
        $this->db->query('SELECT * FROM groups WHERE Group_Id = :groupId');

        $this->db->bind(':groupId', $id);

        $row = $this->db->single();

        return $row;
    }

    public function getGroupTasks($id){
        $this->db->query('SELECT * FROM tasks WHERE Group_Id = :groupId' );

        $this->db->bind(':groupId', $id);

        $rows = $this->db->resultSet();

        return $rows;
    }

    public function getUserIds($id){
        $this->db->query('SELECT User_id FROM groupconnection WHERE Group_Id = :groupId' );

        $this->db->bind(':groupId', $id);

        $rows = $this->db->resultSet();

        return $rows;
    }

    public function getUserInfo($userId){
        $this->db->query('SELECT User_id, User_First_Name, User_Last_Name, Img_Link FROM users WHERE User_Id = :userId' );

        $this->db->bind(':userId', $userId);

        $row = $this->db->single();

        return $row;
    }

    public function checkIfUserOwnsGroup($groupId){
        $this->db->query('SELECT * FROM groups WHERE Group_Leader = :userId && Group_Id = :groupId');

        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':groupId', $groupId);

        $this->db->resultSet();

        $row = $this->db->rowCount();

        if($row == 0){
            return false;
        }else{
            return true;
        }    
    }

    public function createNewTask($data){
        $this->db->query('INSERT INTO tasks (Task_Name, Task_Type, Task_Start_Time, Task_End_Time, Task_Start_Date, Task_End_Date, Task_Completed, Group_Id, User_Id) 
        VALUES(:taskName, :taskType, :TaskStartTime, :TaskEndTime, :TaskStartDate, :TaskEndDate, :TaskCompleted, :groupId ,:userId)');
        //bind values
        $this->db->bind(':taskName', $data['task_name']);
        $this->db->bind(':taskType', $data['task_type']);
        $this->db->bind(':TaskStartTime', $data['task_start_time']);
        $this->db->bind(':TaskEndTime', $data['task_end_time']);
        $this->db->bind(':TaskStartDate', $data['task_start_date']);
        $this->db->bind(':TaskEndDate', $data['task_end_date']);
        $this->db->bind(':TaskCompleted', 0);
        $this->db->bind(':groupId', $data['project_id']);
        $this->db->bind(':userId', $_SESSION['user_id']);

        //call execute if you want to insert
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function removeUserFromTheGroup($removedUserId){
        $this->db->query('DELETE FROM groupconnection WHERE User_Id = :userId && Group_Id = :groupId');

        $this->db->bind(':userId', $removedUserId);
        $this->db->bind(':groupId', $_SESSION['current_group']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    //NOT COMPLETE FUNCTION, ERROR WITH RETURN
    public function userSearch($userInput){
        $query = "SELECT * FROM users WHERE User_First_Name LIKE '%:firstName%'";

        $this->db->query($query);

        $this->db->bind(':firstName', $userInput);
        //$this->db->bind(':lastName', $userInput);

        $rows = $this->db->resultSet();

        return $rows;
    }

}