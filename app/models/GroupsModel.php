<?php
  /* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */

   /**
   * GroupsModel
   *
   * @author     Colton Davies
   */
class GroupsModel{
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
       * This method gets all the groups that are created by the user
       *
       * @return object
       */
    public function getUsersCreatedGroups(){
        $this->db->query('SELECT * FROM groups WHERE Group_Leader = :userId' );

        $this->db->bind(':userId', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       * 
       * This method creates a new group with the data given to it
       *
       * 
       * @param string $data  the data to create a new group
       *  
       * @return boolean
       */
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

    /**
       * 
       * This method gets all the relations between a group and the user
       *
       *  
       * @return object
       */
    public function getGroupRelation(){
        $this->db->query('SELECT * FROM groupconnection WHERE user_Id = :userId' );

        $this->db->bind(':userId', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       * 
       * This method creates a relation record of the group and the given user
       *
       * 
       * @param string $id  The id of group
       *  
       * @return boolean
       */
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

    /**
       * 
       * This method gets the information of the group provided the id
       *
       * 
       * @param string $id  The id of a group
       *  
       * @return object
       */
    public function getGroupInformation($id){
        $this->db->query('SELECT * FROM groups WHERE Group_Id = :groupId' );

        $this->db->bind(':groupId', $id);

        $row = $this->db->single();

        return $row;
    }

    /**
       * 
       * This method deletes a group that the user has created
       *
       * 
       * @param string $id  The id of a group
       *  
       * @return boolean
       */
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

    /**
       * 
       * This method deletes all the connections that contain the given group id, used for when a user admin deletes the group
       *
       * 
       * @param string $id  The id of the group
       *  
       * @return boolean
       */
    public function deleteGroupConnections($id){
        $this->db->query('DELETE FROM groupconnection WHERE Group_Id = :groupId');

        $this->db->bind(':groupId', $id);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
       * 
       * This method updates the information of a group
       *
       * 
       * @param string $data  The updated information for the group
       *  
       * @return boolean
       */
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

    /**
       * 
       * This method checks if the group leader of given group is the current user
       *
       * 
       * @param string $groupId  The id of the group
       *  
       * @return object
       */
    public function validationCheck($groupId){
        $this->db->query('SELECT * FROM groups WHERE Group_Id = :groupId && Group_Leader = :groupLeader' );

        $this->db->bind(':groupId', $id);
        $this->db->bind(':groupLeader', $_SESSION['user_id']);

        $row = $this->db->single();

        return $row;
    }

    /**
       * 
       * This method deletes the connection of a user to a certain group, this is used when a user who is not the admin of a group
       * wants to leave, so they just delete the connection instead of the whole group
       *
       * 
       * @param string $groupId  The id of the group
       *  
       * @return boolean
       */
    public function deleteGroupUserConnection($groupId){
        $this->db->query('DELETE FROM groupconnection WHERE Group_Id = :groupId AND User_Id = :userId' );

        $this->db->bind(':groupId', $groupId);
        $this->db->bind(':userId', $_SESSION['user_id']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }
}