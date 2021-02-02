<?php 
  /* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */

   /**
   * FriendsListModel
   *
   * @author     Colton Davies
   */
class FriendsListModel{
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
       * This method returns all the requests sent by this user
       *
       * @return object
       */
    public function getSentRequests(){
        $this->db->query('SELECT * FROM friendrequestconnection WHERE SenderId = :userId' );

        $this->db->bind(':userId', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       * 
       * This method returns and object of all the items that match the users first and last name search
       *
       * 
       * @param string $firstName  The first name of the user search
       * @param string $lastName  The last name of the user search
       *  
       * @return object
       */
    public function userSearch($firstName, $lastName){
        $query = "SELECT User_Id, User_First_Name, User_Last_Name, Email FROM users WHERE User_Id !=" . $_SESSION['user_id'] . " AND User_First_Name LIKE '%" . $firstName ."%' OR '%" . $lastName . "%'   ";
        
        $this->db->query($query);

        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       * 
       * This method sends a friend request to another user
       *
       * 
       * @param string $otherUsersId  a user id other than the current logged in user
       * @param string $otherUsersName  The other users name
       *  
       * @return boolean
       */
    public function sendRequest($otherUsersId, $otherUsersName){

        $otherUsersFullName = $otherUsersName->User_First_Name . " " . $otherUsersName->User_Last_Name;

        $this->db->query('INSERT INTO friendrequestconnection ( ReceiverId, SenderId, SenderName, ReceiverName) 
        VALUES(:userTwoId, :sender, :senderName, :receiverName)');        
        $this->db->bind(':userTwoId', $otherUsersId);
        $this->db->bind(':sender', $_SESSION['user_id']);
        $this->db->bind(':senderName', $_SESSION['user_name']);
        $this->db->bind(':receiverName', $otherUsersFullName);

        
        //call execute if you want to insert
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }

    }
    
    /**
       * 
       * This method returns a single record of a users first and last name
       *
       * 
       * @param string $otherUsersId  a user id other than the current logged in user
       *  
       * @return object
       */
    public function getOtherUsersName($otherUsersId){
        $this->db->query('SELECT User_First_Name, User_Last_Name FROM users WHERE User_Id = :otherUserId');
        //bind values
        $this->db->bind(':otherUserId', $otherUsersId);

        $row = $this->db->single();

        return $row;
    }

    /**
       * 
       * This method deletes the request connection between two users
       *
       * 
       * @param string $friendConnectionId  the connection id of a friend request
       *  
       * @return boolean
       */
    public function cancelRequest($friendConnectionId){
        $this->db->query("DELETE FROM friendrequestconnection WHERE FriendConnectionId = :connectionId");
        //bind values
        $this->db->bind(':connectionId', $friendConnectionId);

        //call execute if you want to insert
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
       * 
       * This method returns al the friend request the use has been sent
       *
       *  
       * @return object
       */
    public function getFriendRequests(){
        $this->db->query('SELECT * FROM friendrequestconnection WHERE ReceiverId = :userId' );

        $this->db->bind(':userId', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       * 
       * This method is called when a user accepts a friend request and creates a new friend connection
       *
       * 
       * @param string $otherUsersName  The users name who sent the request
       * @param string $senderId  the user who sent the requests id
       *  
       * @return object
       */
    public function requestAccepted($otherUsersName, $senderId){

        $otherUsersFullName = $otherUsersName->User_First_Name . " " . $otherUsersName->User_Last_Name;

        $this->db->query('INSERT INTO friendconnection ( PersonOneId, PersonTwoId, PersonOneName, PersonTwoName) 
        VALUES(:personOneId, :personTwoId, :personOneName, :personTwoName)'); 

        $this->db->bind(':personOneId', $senderId);
        $this->db->bind(':personTwoId', $_SESSION['user_id']);
        $this->db->bind(':personOneName', $otherUsersFullName);
        $this->db->bind(':personTwoName', $_SESSION['user_name']);
        
        //call execute if you want to insert
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
       * 
       * this method returns all the friend connections of the current user
       *
       * 
       * @return object
       */
    public function getFriends(){
        $this->db->query('SELECT * FROM friendconnection WHERE PersonOneId = :idOne OR PersonTwoId = :idTwo' );

        $this->db->bind(':idOne', $_SESSION['user_id']);
        $this->db->bind(':idTwo', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       * 
       * This method deletes a friend connection between this user and another
       *
       * 
       * @param string $friendConnectionId the friend connection id between the two users  
       *  
       * @return boolean
       */
    public function removeFriend($friendConnectionId){
        $this->db->query("DELETE FROM friendconnection WHERE FriendConnectionId = :connectionId");
        //bind values
        $this->db->bind(':connectionId', $friendConnectionId);

        //call execute if you want to insert
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
       * 
       * Gets all the friend request connections that include this user
       *
       * 
       *  
       * @return object
       */
    public function getConnections(){
        $this->db->query('SELECT * FROM friendrequestconnection WHERE ReceiverId = :idOne OR SenderId = :idTwo' );

        $this->db->bind(':idOne', $_SESSION['user_id']);
        $this->db->bind(':idTwo', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       * 
       * This method returns all the friend requests 
       *
       * 
       *  
       * @return object
       */
    public function getFriendRequestCount(){
        $this->db->query('SELECT * FROM friendrequestconnection WHERE ReceiverId = :idOne' );

        $this->db->bind(':idOne', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       * 
       * This method gets all the group request connections
       *
       *  
       *  
       * @return object
       */
    public function getGroupRequests(){
        $this->db->query('SELECT * FROM grouprequestconnection WHERE Receiver_Id = :idOne' );

        $this->db->bind(':idOne', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       * 
       * This method gets a single group id from a connection between a user and a group
       *
       * 
       * @param string $groupConnectionId the connection id between the user and the group
       *  
       * @return object
       */
    public function getGroupId($groupConnectionId){
        $this->db->query('SELECT Group_Id FROM grouprequestconnection WHERE Group_Request_Connection_Id = :groupId');
        //bind values
        $this->db->bind(':groupId', $groupConnectionId);

        $row = $this->db->single();

        return $row;
    }

    /**
       * 
       * This method deletes a group connection id when a user leaves a group
       *
       * 
       * @param string $groupConnectionId the connection id between the user and the group
       *  
       * @return boolean
       */
    public function removeGroupConnectionId($groupConnectionId){
        $this->db->query("DELETE FROM grouprequestconnection WHERE Group_Request_Connection_Id = :connectionId");
        //bind values
        $this->db->bind(':connectionId', $groupConnectionId);

        //call execute if you want to insert
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
       * 
       * This method creates a group connection when a user accepts a request
       *
       * 
       * @param string $groupId the group id
       *  
       * @return boolean
       */
    public function acceptGroupRequest($groupId){
        
        $this->db->query('INSERT INTO groupconnection (Group_Id, User_Id) 
        VALUES(:groupId, :userId)'); 

        $this->db->bind(':groupId', $groupId);
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