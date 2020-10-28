<?php
/* 
 - For some reason I sort of left out adding images to groups. The functionality is easy to add and should not take 
 no more than 30 mins or so. 
 - Also because I dont have the functionality to add other users to a group, the only groups that are displayed are the ones the 
 user created. I created a function to display groups the user was invited to (and does not run). That will be used later
*/
class GroupsModel{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }
    
    public function getUsersCreatedGroups(){
        $this->db->query('SELECT * FROM groups WHERE Group_Leader = :userId' );

        $this->db->bind(':userId', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }
    //This is to display the groups the user has been invited to. functionality to come soon
    public function getUsersGroups (){

    }

    public function createNewGroup($data){
        $this->db->query('INSERT INTO groups (Group_Name, Group_Description, Group_Leader) 
        VALUES(:groupName, :groupDescription, :groupLeader)');
        //bind values
        $this->db->bind(':groupName', $data['group_name']);
        $this->db->bind(':groupDescription', $data['group_description']);
        $this->db->bind(':groupLeader', $_SESSION['user_id']);

        //call execute if you want to insert
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function getGroupRelation(){
        $this->db->query('SELECT * FROM groupconnection WHERE user_Id = :userId' );

        $this->db->bind(':userId', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }

    public function insertGroupRelation($id){
        $this->db->query('INSERT INTO groupconnection (Group_Id, User_Id) 
        VALUES(:groupId, :userId)');
        //bind values
        $this->db->bind(':groupId', $id);
        $this->db->bind(':userId', $_SESSION['user_id']);

        //call execute if you want to insert
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function getGroupInformation($id){
        $this->db->query('SELECT * FROM groups WHERE Group_Id = :groupId && Group_Id = :userId' );

        $this->db->bind(':groupId', $id);
        $this->db->bind(':userId', $_SESSION['user_id']);

        $row = $this->db->single();

        return $row;
    }

    public function deleteGroup($id){
        $this->db->query('DELETE FROM groups WHERE Group_Leader = :userId && Group_Id = :groupId');

        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':groupId', $id);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function deleteGroupConnections($id){
        $this->db->query('DELETE FROM groupconnection WHERE Group_Id = :groupId');

        $this->db->bind(':groupId', $id);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function updateGroupInfo($data){
        $this->db->query('UPDATE groups SET Group_Name = :groupName, Group_Description = :groupDescription
        WHERE Group_Leader = :userId && Group_Id = :groupId');

        $this->db->bind(':groupName', $data['group_name']);
        $this->db->bind(':groupDescription', $data['group_description']);
        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':groupId', $data['group_id']);
        
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }
}