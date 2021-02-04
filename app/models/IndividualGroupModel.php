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
class IndividualGroupModel{
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
       * This method is used to pull a row count out of the database, to make sure that the user connection is valid 
       *
       * 
       * @param string $id  Group id
       *  
       * @return object
       */
    public function checkForUserGroupMatch($id){
        $this->db->query('SELECT * FROM groupconnection WHERE User_Id = :userId && Group_Id = :groupId');

        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':groupId', $id);

        $this->db->resultSet();

        $row = $this->db->rowCount();

        return $row;
    }

    /**
       * 
       * Gets the information on the group id presented
       *
       * 
       * @param string $id  Group id
       *  
       * @return object
       */
    public function getGroupInformation($id){
        $this->db->query('SELECT * FROM groups WHERE Group_Id = :groupId');

        $this->db->bind(':groupId', $id);

        $row = $this->db->single();

        return $row;
    }

    /**
       * 
       * This method gets all the tasks that have the same group id as the one provided
       *
       * 
       * @param string $id  Group id
       *  
       * @return object
       */
    public function getGroupTasks($id){
        $this->db->query('SELECT * FROM tasks WHERE Group_Id = :groupId' );

        $this->db->bind(':groupId', $id);

        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       * 
       * This method gets the user ids that have the same group id in the groupconnection table
       *
       * 
       * @param string $id  Group id
       *  
       * @return object
       */
    public function getUserIds($id){
        $this->db->query('SELECT User_id FROM groupconnection WHERE Group_Id = :groupId' );

        $this->db->bind(':groupId', $id);

        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       * 
       * This method gets the user info for the user id provided
       *
       * 
       * @param string $userId  user id
       *  
       * @return object
       */
    public function getUserInfo($userId){
        $this->db->query('SELECT User_id, User_First_Name, User_Last_Name, Img_Link FROM users WHERE User_Id = :userId' );

        $this->db->bind(':userId', $userId);

        $row = $this->db->single();

        return $row;
    }

    /**
       * 
       * This method checks if the user is the admin of a group (they created)
       *
       * 
       * @param string $groupId  group id
       *  
       * @return boolean
       */
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

    /**
       * 
       * This method insets a new task into the database
       *
       * 
       * @param string $data  task data
       *  
       * @return boolean
       */
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

    /**
       * 
       * This method removes the connection between a group and an individual user
       *
       * 
       * @param string $removedUserId  the user id to remove from the group
       *  
       * @return boolean
       */
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

    /**
       * 
       * This method searches through the users based on the first and last name provided by the user
       *
       * 
       * @param string $firstName  the first name the user inputed to search
       * @param string $lastName  the last name the user inputed to search
       * @return object
       */
    public function userSearch($firstName, $lastName){
        $query = "SELECT User_Id, User_First_Name, User_Last_Name, Email FROM users WHERE User_Id !=" . $_SESSION['user_id'] . " AND Buisness_User = 1 AND User_First_Name LIKE '%" . $firstName ."%' OR '%" . $lastName . "%'   ";
        
        $this->db->query($query);

        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       * 
       * This method creates a new request record in the grouprequestconnection
       *
       * 
       * @param string $otherUserId  The user id who is being sent the invite
       * @param string $userInfo  the first and last name of the user
       * @param string $groupName  the group name
       * @return boolean
       */
    public function SendGroupInviteRecord($otherUserId, $userInfo, $groupName){
        $this->db->query('INSERT INTO grouprequestconnection (Receiver_Id, Group_Id, Group_Name, Receiver_Name) 
        VALUES(:receiverId, :groupId, :groupName, :receiverName)');
        //bind values
        $this->db->bind(':receiverId', $otherUserId);
        $this->db->bind(':groupId', $_SESSION['current_group']);
        $this->db->bind(':groupName', $groupName);
        $this->db->bind(':receiverName', $userInfo->User_First_Name . " " . $userInfo->User_Last_Name);

        //call execute if you want to insert
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
       * 
       * This method gets all the requested group connections to display, the sent requests of the group
       *
       * 
       * @return object
       */
    public function getRequestedConnections(){
        $this->db->query('SELECT * FROM grouprequestconnection WHERE Group_Id = :idOne' );

        $this->db->bind(':idOne', $_SESSION['current_group']);


        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       * 
       * This method gets all the group connection of all the users connected to the group
       *
       * 
       * @return object
       */
    public function getGroupFriends(){
        $this->db->query('SELECT * FROM groupconnection WHERE Group_Id = :idOne ' );

        $this->db->bind(':idOne', $_SESSION['current_group']);

        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       * 
       * This method cancels a group request invitation
       *
       * @param string $otherUserId  the other users id
       * @return boolean
       */
    public function cancelGroupRequestInvitation($otherUserId){
        $this->db->query('DELETE FROM grouprequestconnection WHERE Receiver_Id = :userId && Group_Id = :groupId');

        $this->db->bind(':userId', $otherUserId);
        $this->db->bind(':groupId', $_SESSION['current_group']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
       * 
       * This method gets the first and last name of a user given the id
       *
       * @param string $userId  the other users id
       * @return object
       */
    public function getTheUsersName($userId){
        $this->db->query('SELECT User_First_Name, User_Last_Name FROM users WHERE User_Id = :userId' );

        $this->db->bind(':userId', $userId);

        $row = $this->db->single();

        return $row;
    }
     /**
       * 
       * This method creates a new message that also has a group id
       *
       * @param string $userId  the other users id
       * @param string $messageText  the message content
       * @param string $usersName  the user name of the user being sent the message
       * @return boolean
       */
    public function sendMessageFromGroup($userId, $messageText, $usersName){
        $this->db->query('INSERT INTO messages (Message_Info, Message_Sent_By_Id, Message_Received_By_Id, Receiver_Name, Sender_Name, Group_Id, Date_Time_Sent) 
        VALUES(:messageInfo, :messageSentById, :messageReceivedById, :receiverName, :senderName, :groupId, :dateTimeSent)');
        //bind values
        $this->db->bind(':messageInfo', $messageText);
        $this->db->bind(':messageSentById', $_SESSION['user_id']);
        $this->db->bind(':messageReceivedById', $userId);

        $fullName = $usersName->User_First_Name . " " . $usersName->User_Last_Name;
        $this->db->bind(':receiverName', $fullName);
        $this->db->bind(':senderName', $_SESSION['user_name']);
        $this->db->bind(':groupId', $_SESSION['current_group']);

        $Object = new DateTime();  
        $Object->setTimezone(new DateTimeZone('America/Toronto'));
        $DateAndTime = $Object->format("Y-m-d h:i:s");  

        $this->db->bind(':dateTimeSent', $DateAndTime);


        //call execute if you want to insert
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
       * 
       * This method check for if 2 users have a connection before sending a message from the group page
       *
       * @param string $userId  the other users id
       * @return object
       */
    public function checkGroupMessageConnection($userId){
        $this->db->query('SELECT * FROM groupmessageconnection WHERE Person_Two_Id = :userIdOne AND Person_One_Id = :otherIdOne OR Person_Two_Id = :otherIdTwo AND Person_One_Id = :userIdTwo');

        $this->db->bind(':userIdOne', $_SESSION['user_id']);
        $this->db->bind(':otherIdOne', $userId);
        $this->db->bind(':otherIdTwo', $userId);
        $this->db->bind(':userIdTwo', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       * 
       * This method creates a group message connection
       *
       * @param string $userId  the other users id
       * @param string $usersName  users first and last name
       * @param string $groupInfo  the information of a given group
       * @return boolean
       */
    public function createGroupMessageConnectionRecord($userId, $usersName, $groupInfo){
        $this->db->query('INSERT INTO groupmessageconnection (Person_One_Id, Person_Two_Id, Person_Two_Name, Person_One_Name, Group_Id, Group_Name) 
        VALUES(:receiverId, :senderId, :senderName, :receiverName, :groupId, :groupName)');

        $this->db->bind(':receiverId', $userId);
        $this->db->bind(':senderId', $_SESSION['user_id']);
        $this->db->bind(':senderName', $_SESSION['user_name']);
        $this->db->bind(':receiverName', $usersName->User_First_Name . " " . $usersName->User_Last_Name);
        $this->db->bind(':groupId', $groupInfo->Group_Id);
        $this->db->bind(':groupName', $groupInfo->Group_Name);

        //call execute if you want to insert
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

}