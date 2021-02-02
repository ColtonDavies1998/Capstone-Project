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
class MessageModel{
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
       * This method gets an array of all the friends connected to the user
       *
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
       * This method gets all the records that have the user id and the friend id, its used to check if the users are friends
       *
       * 
       * @param string $friendId  The id of the friend
       *  
       * @return boolean
       */
    public function checkIfFriends($friendId){
        $this->db->query('SELECT * FROM friendconnection WHERE PersonOneId = :friendId AND PersonTwoId = :userId OR PersonOneId = :userIdTwo AND PersonTwoId = :friendIdTwo' );
    
        $this->db->bind(':friendId', $friendId);
        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':userIdTwo', $_SESSION['user_id']);
        $this->db->bind(':friendIdTwo', $friendId);

        $row = $this->db->single();

        //check row
        if($this->db->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    /**
       * 
       * This method gets a users first and last name given an id
       *
       * 
       * @param string $friendId  The id of the friend
       *  
       * @return object
       */
    public function getReceiversName($friendId){
        $this->db->query('SELECT User_First_Name, User_Last_Name FROM users WHERE User_Id = :friendId');
    
        $this->db->bind(':friendId', $friendId);
 
        $row = $this->db->single();

        return $row;
    }

    /**
       * 
       * This method creates a new message
       *
       * 
       * @param string $messageText  The message content
       * @param string $otherUserId  The id of the other user
       * @param string $receiversFullName  The full name of hte other user
       *  
       * @return boolean
       */
    public function addNewMessage($messageText, $otherUserId, $receiversFullName){
        $this->db->query('INSERT INTO messages ( Message_Info, Message_Sent_By_Id, Message_Received_By_Id, Receiver_Name, Sender_Name, Date_Time_Sent) 
        VALUES(:messageInfo, :sentById, :receiverId, :receiverName, :senderName, :dateTimeStamp)'); 

        $this->db->bind(':messageInfo', $messageText);
        $this->db->bind(':sentById', $_SESSION['user_id']);
        $this->db->bind(':receiverId', $otherUserId);
        $this->db->bind(':receiverName', $receiversFullName);
        $this->db->bind(':senderName',$_SESSION['user_name']);


        $Object = new DateTime();  
        $Object->setTimezone(new DateTimeZone('America/Toronto'));
        $DateAndTime = $Object->format("Y-m-d h:i:s");  

        $this->db->bind(':dateTimeStamp', $DateAndTime);

         //call execute if you want to insert
         if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
       * 
       * This method gets all the messages between the user and another user given the other users id
       *
       * @param string $otherUserId  The id of the other user
       *  
       * @return object
       */
    public function getMessages($otherUserId){
        $this->db->query('SELECT * FROM messages WHERE Message_Sent_By_Id = :userIdOne AND Message_Received_By_Id = :personIdOne AND Group_Id IS null OR Message_Received_By_Id = :personIdTwo AND Message_Sent_By_Id = :userIdTwo AND Group_Id IS null ORDER BY Date_Time_Sent DESC' );

        $this->db->bind(':userIdOne', $_SESSION['user_id']);
        $this->db->bind(':personIdOne', $otherUserId);
        $this->db->bind(':personIdTwo', $_SESSION['user_id'] );
        $this->db->bind(':userIdTwo', $otherUserId);

        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       * 
       * This method gets all the new messages
       *
       *  
       * @return object
       */
    public function getNewMessages(){
        $this->db->query('SELECT * FROM messages WHERE Message_Received_By_Id = :userIdOne AND Viewed = 1' );
    
        $this->db->bind(':userIdOne', $_SESSION['user_id']);
    
        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       * 
       * This method updates the ammount of new messages the user has not seen yet
       *
       * @param string $newMessagesCount  The count of new messages the user has not seen
       *  
       * @return boolean
       */
    public function changeUserMsgCount($newMessagesCount){
        $this->db->query('UPDATE users SET Msg_Count = :messageCount WHERE User_Id = :userId ');
         
        
        $this->db->bind(':messageCount', $newMessagesCount);
        $this->db->bind(':userId', $_SESSION['user_id']);
 
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
        
    }

    /**
       * 
       * This method gets all the group ids
       *
       *  
       * @return object
       */
    public function getGroupIds(){
        $this->db->query('SELECT Group_Id FROM groupconnection WHERE User_Id = :userId' );
    
        $this->db->bind(':userId', $_SESSION['user_id']);
    
        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       * 
       * This method gets the info of the group id present
       *
       * @param string $groupId  The group id of the individual group
       *  
       * @return object
       */
    public function getGroupInfo($groupId){
        $this->db->query('SELECT * FROM groups WHERE Group_Id = :groupId');
    
        $this->db->bind(':groupId', $groupId);
 
        $row = $this->db->single();

        return $row;
    }

    /**
       * 
       * This method this gets all the user ids that are not the own users id
       *
       * @param string $groupId  Id of the group
       *  
       * @return object
       */
    public function getDefaultGroupsUsers($groupId){
        $this->db->query('SELECT User_Id FROM groupconnection WHERE Group_Id = :groupId && User_Id != :userId' );
    
        $this->db->bind(':groupId', $groupId);
        $this->db->bind(':userId', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       * 
       * This method gets the information of the default user id which is the conversation loaded first 
       * on the message page
       *
       * @param string $userId  a users id
       *  
       * @return object
       */
    public function getDefaultGroupsUsersInformation($userId){
        $this->db->query('SELECT User_First_Name, User_Last_Name, User_Id, Img_Link FROM users WHERE User_Id = :userId' );
    
        $this->db->bind(':userId', $userId);
    
        $row = $this->db->single();

        return $row;
    }

    /**
       * 
       * This method gets all the group message connections (users that have sent messages before from common group)
       *
       *  
       * @return object
       */
    public function getgroupMessageConnection(){
        $this->db->query('SELECT * FROM groupmessageconnection WHERE Person_One_Id = :userId || Person_Two_Id = :userIdTwo' );
    
        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':userIdTwo', $_SESSION['user_id']);
    
        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       * 
       * This method gets messages that are sent between users that are not friends but that have sent messages to each other 
       * cause they are in a group together
       *
       * @param string $GroupId  The group id
       * @param string $otherUserId  The other users id
       * 
       * @return object
       */
    public function getGroupSentMessages($GroupId, $otherUserId){
        $this->db->query('SELECT * FROM messages WHERE Message_Sent_By_Id = :userIdOne AND Message_Received_By_Id = :personIdOne AND Group_Id = :groupIdOne OR Message_Received_By_Id = :personIdTwo AND Message_Sent_By_Id = :userIdTwo AND Group_Id = :groupIdTwo ORDER BY Date_Time_Sent DESC' );
    
        $this->db->bind(':userIdOne', $_SESSION['user_id']);
        $this->db->bind(':personIdOne', $otherUserId);
        $this->db->bind(':groupIdOne', $GroupId);
        $this->db->bind(':personIdTwo', $_SESSION['user_id'] );
        $this->db->bind(':userIdTwo', $otherUserId);
        $this->db->bind(':groupIdTwo', $GroupId);
    
        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
       * 
       * This method checks if the users are in the same group
       *
       * @param string $friendId the id of the friend
       * @param string $GroupId  The group id
       * @param string $userId  The  users id
       * 
       * @return boolean
       */
    public function checkIfInSameGroup($friendId, $groupId, $userId){
        $this->db->query('SELECT * FROM groupmessageconnection WHERE Person_One_Id = :friendId AND Person_Two_Id = :userId OR Person_One_Id = :userIdTwo AND Person_Two_Id = :friendIdTwo' );
    
        $this->db->bind(':friendId', $friendId);
        $this->db->bind(':userId', $userId);
        $this->db->bind(':userIdTwo', $userId);
        $this->db->bind(':friendIdTwo', $friendId);

        $row = $this->db->single();

        //check row
        if($this->db->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    /**
       * 
       * This method inserts a new message between two users
       *
       * @param string $messageText the content of the meesage
       * @param string $otherUserId  the other users full id
       * @param string $receiversFullName  The other users full name
       * @param string $groupId  The group id
       * 
       * @return boolean
       */
    public function addNewGroupSentMessage($messageText, $otherUserId, $receiversFullName, $groupId){
        $this->db->query('INSERT INTO messages ( Message_Info, Message_Sent_By_Id, Message_Received_By_Id, Receiver_Name, Sender_Name, Group_Id, Date_Time_Sent) 
        VALUES(:messageInfo, :sentById, :receiverId, :receiverName, :senderName, :groupId, :dateTimeStamp)'); 

        $this->db->bind(':messageInfo', $messageText);
        $this->db->bind(':sentById', $_SESSION['user_id']);
        $this->db->bind(':receiverId', $otherUserId);
        $this->db->bind(':receiverName', $receiversFullName);
        $this->db->bind(':senderName',$_SESSION['user_name']);


        $Object = new DateTime();  
        $Object->setTimezone(new DateTimeZone('America/Toronto'));
        $DateAndTime = $Object->format("Y-m-d h:i:s");  

        $this->db->bind(':groupId',$groupId);

        $this->db->bind(':dateTimeStamp', $DateAndTime);

         //call execute if you want to insert
         if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

}