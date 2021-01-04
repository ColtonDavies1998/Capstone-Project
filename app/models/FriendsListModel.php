<?php 

class FriendsListModel{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getSentRequests(){
        $this->db->query('SELECT * FROM friendrequestconnection WHERE SenderId = :userId' );

        $this->db->bind(':userId', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }

    
    public function userSearch($firstName, $lastName){
        //$test = "SELECT users.User_Id, users.User_First_Name, users.User_Last_Name, friendsconnection.friendConnectionId, ";

        $query = "SELECT * FROM users WHERE User_Id !=" . $_SESSION['user_id'] . " AND User_First_Name LIKE '%" . $firstName ."%' OR '%" . $lastName . "%'   ";
        
        $this->db->query($query);

        $rows = $this->db->resultSet();

        return $rows;
    }

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

    public function getOtherUsersName($otherUsersId){
        $this->db->query('SELECT User_First_Name, User_Last_Name FROM users WHERE User_Id = :otherUserId');
        //bind values
        $this->db->bind(':otherUserId', $otherUsersId);

        $row = $this->db->single();

        return $row;
    }

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

    public function getFriendRequests(){
        $this->db->query('SELECT * FROM friendrequestconnection WHERE ReceiverId = :userId' );

        $this->db->bind(':userId', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }

    public function requestAccepted($otherUsersId, $otherUsersName){

        $otherUsersFullName = $otherUsersName->User_First_Name . " " . $otherUsersName->User_Last_Name;

        $this->db->query('INSERT INTO friendconnection ( PersonOneId, PersonTwoId, PersonOneName, PersonTwoName) 
        VALUES(:personOneId, :personTwoId, :personOneName, :personTwoName)'); 

        $this->db->bind(':personOneId', $otherUsersId);
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

    public function getFriends(){
        $this->db->query('SELECT * FROM friendconnection WHERE PersonOneId = :idOne OR PersonTwoId = :idTwo' );

        $this->db->bind(':idOne', $_SESSION['user_id']);
        $this->db->bind(':idTwo', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }

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

    public function getConnections(){
        $this->db->query('SELECT * FROM friendrequestconnection WHERE ReceiverId = :idOne OR SenderId = :idTwo' );

        $this->db->bind(':idOne', $_SESSION['user_id']);
        $this->db->bind(':idTwo', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }
}


?>