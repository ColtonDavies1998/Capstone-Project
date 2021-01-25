<?php

class MessageController extends Controller {
    
    //NOTE The image of the users will not show because the friend list page does not currently 
    //add the image to the colum even though it is there, in the future add this functionality
    //Have the friend list controller add images to the request and friend connections


    public function __construct(){
        $this->messageModel = $this->model('MessageModel');
    }

    public function messages(){
        $_SESSION['current_page'] = 'Message';

        $data["friends"] = $this->messageModel->getFriends();

        //NEW CODE
        $data["messagesFrom"] = [];
        foreach($data['friends'] as $friend){
            if($friend->PersonOneId != $_SESSION['user_id']){
                $temp = $this->messageModel->getDefaultGroupsUsersInformation($friend->PersonOneId);
                $object = $this->createObject($temp->User_First_Name, $temp->User_Last_Name, $friend->PersonOneId,null, null);
                array_push($data["messagesFrom"], $object);

            }else{
                $temp = $this->messageModel->getDefaultGroupsUsersInformation($friend->PersonTwoId);
                $object = $this->createObject($temp->User_First_Name, $temp->User_Last_Name, $friend->PersonTwoId,null, null);
                array_push($data["messagesFrom"], $object);
            }
        }
        

        $groupMessageConnection = $this->messageModel->getgroupMessageConnection();
        foreach($groupMessageConnection as $connection){
            if($connection->Person_One_Id != $_SESSION['user_id']){
                $temp = $this->messageModel->getDefaultGroupsUsersInformation($connection->Person_One_Id);
                $object = $this->createObject($temp->User_First_Name, $temp->User_Last_Name, $connection->Person_One_Id, $connection->Group_Id, $connection->Group_Name);
                array_push($data["messagesFrom"], $object);
            }else{
                $temp = $this->messageModel->getDefaultGroupsUsersInformation($connection->Person_Two_Id);
                $object = $this->createObject($temp->User_First_Name, $temp->User_Last_Name, $connection->Person_Two_Id, $connection->Group_Id, $connection->Group_Name);
                array_push($data["messagesFrom"], $object);
            }
        }

        $data['defaultConvo'] = [];
        if(sizeof($data["messagesFrom"]) > 0){
            if($data["messagesFrom"][0]->Group_Id != null){
                $data['defaultConvo'] = $this->messageModel->getGroupSentMessages($data["messagesFrom"][0]->Group_Id, $data["messagesFrom"][0]->User_Id);
                
            }else{
                $data['defaultConvo'] = $this->messageModel->getMessages($data["messagesFrom"][0]->User_Id);
            }
        }else{
            $data['defaultConvo'] = null;
        }
     
        //End of new code


        
        $this->view('messages/Messages', $data);
    }

    public function createObject($firstName, $lastName, $userId, $groupId, $groupName){
        $object = (object) [
            'First_Name' => $firstName,
            'Last_Name' => $lastName,
            'User_Id' => $userId,
            'Group_Id' => $groupId,
            'Group_Name' => $groupName
        ];

        return $object;
    }

    public function getMessages(){
        $friendId = $_GET["otherUserId"];
        $GroupId = $_GET["groupId"];

        if($GroupId == "null"){
            //Check if the user and this id are friends incase someone switched IDs in the HTML
            $friendCheck = $this->messageModel->checkIfFriends($friendId);

            if($friendCheck == true){
                
                $messages = $this->messageModel->getMessages($friendId);

                if(sizeof($messages) > 0){
                    echo  json_encode($messages);
                }else{
                    echo  json_encode([]);
                }
            }

        }else{
            //check if the users are in the same group
            $connection = $this->messageModel->checkIfInSameGroup($friendId, $GroupId, $_SESSION['user_id']);
            if($connection == true){
                $messages = $this->messageModel->getGroupSentMessages($GroupId ,$friendId);

                if(sizeof($messages) > 0){
                    echo  json_encode($messages);
                }else{
                    echo  json_encode([]);
                }
            }


        }

        
    }

    public function sendNewMessage(){
       
        $messageText = $_GET["message"];
        $otherUserId = $_GET["userId"];
        $groupId = $_GET["groupId"];

        if($groupId == "null"){
            //Check if the user and this id are friends incase someone switched IDs in the HTML
            $friendCheck = $this->messageModel->checkIfFriends($otherUserId);

            //Get the other users full name
            $firstLastName = $this->messageModel->getReceiversName($otherUserId);
        
        
            
            $receiversFullName = $firstLastName->User_First_Name  . " " . $firstLastName->User_Last_Name;


            if($friendCheck == true){
                if($this->messageModel->addNewMessage($messageText, $otherUserId, $receiversFullName)){
                    $messages = $this->messageModel->getMessages($otherUserId);
                    echo  json_encode($messages);
                }else{
                    echo  false;
                }
            } 

        }else{

            //Get the other users full name
            $firstLastName = $this->messageModel->getReceiversName($otherUserId);

            //check if the users are in the same group
            $connection = $this->messageModel->checkIfInSameGroup($otherUserId, $groupId, $_SESSION['user_id']);

            //Get the other users full name
            $firstLastName = $this->messageModel->getReceiversName($otherUserId);
        
        
            
            $receiversFullName = $firstLastName->User_First_Name  . " " . $firstLastName->User_Last_Name;

            if($connection == true){
                if($this->messageModel->addNewGroupSentMessage($messageText, $otherUserId, $receiversFullName, $groupId)){
                    $messages = $this->messageModel->getGroupSentMessages($groupId ,$otherUserId);
                    echo  json_encode($messages);
                }else{
                    echo  false;
                }

            }

        }
       
        
        
    }

    public function checkForNewMessages(){
        $newMessages = $this->messageModel->getNewMessages();

        $this->messageModel->changeUserMsgCount(sizeof($newMessages));

        echo  sizeof($newMessages);

        
    }

}