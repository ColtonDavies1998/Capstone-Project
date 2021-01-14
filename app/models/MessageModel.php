<?php 

class MessageModel{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getFriends(){
        $this->db->query('SELECT * FROM friendconnection WHERE PersonOneId = :idOne OR PersonTwoId = :idTwo' );

        $this->db->bind(':idOne', $_SESSION['user_id']);
        $this->db->bind(':idTwo', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }

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

    public function getReceiversName($friendId){
        $this->db->query('SELECT User_First_Name, User_Last_Name FROM users WHERE User_Id = :friendId');
    
        $this->db->bind(':friendId', $friendId);
 
        $row = $this->db->single();

        return $row;
    }

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

    public function getMessages($otherUserId){
        $this->db->query('SELECT * FROM messages WHERE Message_Sent_By_Id = :userIdOne AND Message_Received_By_Id = :personIdOne OR Message_Received_By_Id = :personIdTwo AND Message_Sent_By_Id = :userIdTwo ORDER BY Date_Time_Sent DESC' );

        $this->db->bind(':userIdOne', $_SESSION['user_id']);
        $this->db->bind(':personIdOne', $otherUserId);
        $this->db->bind(':personIdTwo', $_SESSION['user_id'] );
        $this->db->bind(':userIdTwo', $otherUserId);

        $rows = $this->db->resultSet();

        return $rows;
    }

    public function getNewMessages(){
        $this->db->query('SELECT * FROM messages WHERE Message_Received_By_Id = :userIdOne AND Viewed = 1' );
    
        $this->db->bind(':userIdOne', $_SESSION['user_id']);
    
        $rows = $this->db->resultSet();

        return $rows;
    }

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

}