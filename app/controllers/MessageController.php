<?php

class MessageController extends Controller {
    
    //NOTE The image of the users will not show because the friend list page does not currently 
    //add the image to the colum even though it is there, in the future add this functionality
    //Have the friend list controller add images to the request and friend connections

    //Note, later add in functionality so if the user types in to long of a paragraph it will split it up into smaller
    //messages

    public function __construct(){
        $this->messageModel = $this->model('MessageModel');
    }

    public function messages(){
        $_SESSION['current_page'] = 'Message';

        $data["friends"] = $this->messageModel->getFriends();

        $counter = 0;
        $defaultConvoFriendId;
        foreach($data['friends'] as $friend){
            if($counter == 0){
                if($friend->PersonOneName != $_SESSION['user_id']){
                    $defaultConvoFriendId = $friend->PersonOneId;
                }else{
                    $defaultConvoFriendId = $friend->PersonTwoId;
                }
                break;
            }
            $counter++;
        }



        $data["defaultConvo"] = $this->messageModel->getMessages($defaultConvoFriendId);


        
        $this->view('messages/Messages', $data);
    }

    public function getMessages(){
        $friendId = $_GET["otherUserId"];

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
    }

    public function sendNewMessage(){
       
        $messageText = $_GET["message"];
        $otherUserId = $_GET["userId"];
       
        
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
    }

    public function checkForNewMessages(){
        $newMessages = $this->messageModel->getNewMessages();

        $this->messageModel->changeUserMsgCount(sizeof($newMessages));

        echo  sizeof($newMessages);

        
    }

}