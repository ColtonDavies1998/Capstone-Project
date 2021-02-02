<?php
  /* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */

   /**
   * MessageController
   * 
   * 
   * @package    Controller
   * @author     Colton Davies
   */
class MessageController extends Controller {

    /**
    * 
    * This is the constructor for the class, a common theme for most constructors throughout the project
    * is that they just initialize the model that goes with the controller
    *
    */
    public function __construct(){
        $this->messageModel = $this->model('MessageModel');
    }

    /**
     * The message method is the main method of the class, it directs the user to the message page 
     * and sets up all the data required for the view to run correctly.
     */
    public function messages(){
        //Sets the current page to Message
        $_SESSION['current_page'] = 'Message';
        //Gets all the users friends
        $data["friends"] = $this->messageModel->getFriends();

        //NEW CODE
        //This section gets all the messages from the people who are the users friend and runs them through the loop
        //In this loop we create a new object with the user their id and other information so we can easily collect 
        //the messages between them
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
        
        //This next section does almost the same as the previous section except it is for users that are not apart of the users
        //Friend group, basically there are 2 ways to send a direct message to someone, you have to be 1) friends or 2) in the 
        //same group as them. This goes through a foor lop and creates the same objects that are created in the previous loops
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

        //The reason the above code is the way it is, is because in order to get the messages from a user who is in the same group
        //I have to have the group id which is not a colum in the regular user friend connect so by grouping them together into a 
        //new custom object and storing that into an array allows me to easily navigate through message both friends and group connections

        //Gets the default convo this is the conversation that is loaded first when the page is first loaded
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
     
        //directs to the view
        $this->view('messages/Messages', $data);
    }

       /**
       * 
       * The createObject method when called takes the parameters and puts them into a custome object that is stored 
       * into an array this is to make 1 object out of the friend connection and the group connection making navigating 
       * through messages easier on the coding side 
       *
       * @param string $firstName  The other users first name
       * @param string $lastName  The other users last name
       * @param integer $userId  The other users Id
       * @param integer $groupId  The common group connection Id between the users (if they are friends then this is null)
       * @param string $groupName  The common group connection Name between the users (if they are friends then this is null)
       * @return object
       */
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

    /**
     * The getMessages method is called when the user is clicking between friend and group connections, 
     * this method is called and receives both the other user id and the group id and searches through 
     * the database to get the messages and return them via Ajax call
     */
    public function getMessages(){

        //Gets the other users Id and the group id
        $friendId = $_GET["otherUserId"];
        $GroupId = $_GET["groupId"];
        //Checks if the group id is null that means they are friends and this message was not sent from a common group
        if($GroupId == "null"){
            //Check if the user and this id are friends incase someone switched IDs in the HTML
            $friendCheck = $this->messageModel->checkIfFriends($friendId);
            //Checks if both users are friends (this is to check if someone edited the HTML id input)
            if($friendCheck == true){
                //Gets the messages from the model
                $messages = $this->messageModel->getMessages($friendId);
                //If there are more than 0 messages echo out the messages else ech empty array
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
                //Gets the messages from the model (these are message sent from a user in the same group)
                $messages = $this->messageModel->getGroupSentMessages($GroupId ,$friendId);
                //If there are more than 0 messages echo out the messages else ech empty array
                if(sizeof($messages) > 0){
                    echo  json_encode($messages);
                }else{
                    echo  json_encode([]);
                }
            }
        }
    }

    /**
     * The sendNewMessage method is called when the user wants to send a message from the page to another 
     * user. This function checks which type of friend connection is being made, if its to a real friend 
     * or someone in a common group. From there it sends the message and updates the users chat box with 
     * the latest messages
     */
    public function sendNewMessage(){
        //Gets the message, other user id and the group id from the form submit
        $messageText = $_GET["message"];
        $otherUserId = $_GET["userId"];
        $groupId = $_GET["groupId"];

        //Checks if the connection between the two users is friend related or group related
        if($groupId == "null"){
            //Check if the user and this id are friends incase someone switched IDs in the HTML
            $friendCheck = $this->messageModel->checkIfFriends($otherUserId);

            //Get the other users full name
            $firstLastName = $this->messageModel->getReceiversName($otherUserId);
         
            //Creates the other users full name
            $receiversFullName = $firstLastName->User_First_Name  . " " . $firstLastName->User_Last_Name;

            //Checks if the users are actually friends
            if($friendCheck == true){
                //Adds the message to the database
                if($this->messageModel->addNewMessage($messageText, $otherUserId, $receiversFullName)){
                    //Get all messages between the two users
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
        
        
            //Creates other users full name
            $receiversFullName = $firstLastName->User_First_Name  . " " . $firstLastName->User_Last_Name;

            if($connection == true){
                //Creates the message and adds it to the database
                if($this->messageModel->addNewGroupSentMessage($messageText, $otherUserId, $receiversFullName, $groupId)){
                    //Gets all the messages between the users
                    $messages = $this->messageModel->getGroupSentMessages($groupId ,$otherUserId);
                    echo  json_encode($messages);
                }else{
                    echo  false;
                }
            }
        }     
    }

    /**
     * The checkForNewMessages is called by the header when the page is loaded, what this does is everytime 
     * the use changes the page it checks if a new message has been sent to the user and if there are 1 or more 
     * new messages that number is displayed with a red background on the message icon. Once that is clicked then 
     * the messaged are viewed and the notification goes away.
     */
    public function checkForNewMessages(){
        //Gets the new messages
        $newMessages = $this->messageModel->getNewMessages();
        //Changes the users message count which is the number of messages not seen
        $this->messageModel->changeUserMsgCount(sizeof($newMessages));
        //Display the new messages
        echo  sizeof($newMessages);
    }

}