<?php 
  /* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */
/**
   * FriendsListController
   * 
   * 
   * @package    Controller
   * @author     Colton Davies
   */
class FriendsListController extends Controller { 
  /**
    * 
    * This is the constructor for the class, a common theme for most constructors throughout the project
    * is that they just initialize the model that goes with the controller
    *
    */
    public function __construct(){
        $this->friendsListModel = $this->model('FriendsListModel');
    }

    /**
     * The friendsList method is called to access the view like all other default methods loaded 
     * the required data needed to make the view run.
     */
    public function friendsList(){
        //Sets current page session to the friendsList
        $_SESSION['current_page'] = 'FriendsList';
        //Gets all the sent friend requests
        $data["friendRequestsSent"] = $this->friendsListModel->getSentRequests();
        //Gets all the incoming friend requests from the model
        $data["incomingFriendRequests"] = $this->friendsListModel->getFriendRequests();
        //Gets all the friends
        $data["friendsList"] = $this->friendsListModel->getFriends();
        //Gets all the group requests
        $data["groupRequests"] = $this->friendsListModel->getGroupRequests();

        //Loads the view
        $this->view('friends/FriendsList', $data);
    }
    /**
     * getUsers method when called gets a list of the users available to send friend requests to. 
     * It takes the user's input which is the user's first name and last name and searches based 
     * on those results. It then feeds out the users that the user has already sent requests to or 
     * been sent requests by. Also feeds out people already on the user's friend list
     */
    public function getUsers(){

        //Gets the first and last name from the ajax call
        $firstName = $_GET["firstName"];
        $lastName = $_GET["lastName"];
        //Gets a list of request connections
        $requestConnections = $this->friendsListModel->getConnections();
        //Gets a list of frienhds
        $friendsList = $this->friendsListModel->getFriends();
        //Gets a list of users
        $userSearch = $this->friendsListModel->userSearch($firstName, $lastName);
        //Create an empty array for the return data
        $returnData = [];
        
        //This loop runs through the user search and removes all the users that have request sent or been sent to this user
        for($j=0; $j < sizeof($userSearch); $j++){
            $trigger = false;
            for($i=0; $i < sizeof($requestConnections); $i++){
                //If there is a match means we need to fire the trigger
                if($requestConnections[$i]->ReceiverId == $userSearch[$j]->User_Id || $requestConnections[$i]->SenderId == $userSearch[$j]->User_Id){
                    $trigger = true;
                    break;
                }
            }
            //if trigger equals false then add to return data
            if($trigger == false){
                array_push($returnData, $userSearch[$j]);
            }

        }
        //This loop does the same as the previous loop except for the friend lists and it unsets data from te array
        for($i=0; $i < sizeof($friendsList); $i++){
            for($j=0; $j < sizeof($returnData); $j++){
                //Checks for a match
                if($returnData[$j]->User_Id == $friendsList[$i]->PersonOneId || $returnData[$j]->User_Id == $friendsList[$i]->PersonTwoId){
                    unset($returnData[$j]);
                    $returnData = array_values($returnData);
                    break;
                }
            }
            
        }
        //Echos and json encodes the data
        echo  json_encode($returnData);
    }
    /**
     * SendFriendRequest method is called when the user clicks the button to send a request
     * to the user you searched. When you do that this function is called and the request is 
     * created and sent then the user is redirected to the friendList method
     */
    public function sendFriendRequest(){
        //Grabs the Id from the form
        $otherUsersId = $_POST["otherUserId"];
        //Uses the otherUserId to get the users name so it can be added to the record
        $otherUsersName = $this->friendsListModel->getOtherUsersName($otherUsersId);
        //Creates the send request using the users id and other users name
        $returnData = $this->friendsListModel->sendRequest($otherUsersId, $otherUsersName);
        //redirects to friendList
        redirect('FriendsListController/friendsList');
        
    }
    /**
     * cancelFriendRequest this method is called when the user clicks the button to cancel 
     * the friend request, this method gets the id and goes to the record and deletes the 
     * record, then redirects to the friendsList
     */
    public function cancelFriendRequest(){
        //Gets the id
        $friendConnectionId = $_POST["friendConnectionId"];
        //Calls the model to cancel and delete the record
        $returnData = $this->friendsListModel->cancelRequest($friendConnectionId);
        //redirects 
        redirect('FriendsListController/friendsList');
        
    }
    /**
     * declineFriendRequest is the exact same as cancelFriendRequest, this is for requests that 
     * are sent to the user and this deletes the record in the database
     */
    public function declineFriendRequest(){
        //Gets the connection id
        $friendConnectionId = $_POST["friendConnectionId"];
        //calls to delete the request
        $returnData = $this->friendsListModel->cancelRequest($friendConnectionId);
        //redirects
        redirect('FriendsListController/friendsList');
    }
    /**
     * AcceptFriendRequest is called when the user accepts a request sent from another user. 
     * This accepts that request and deletes the request record but adds a new friend connection. 
     * This makes the users friends
     */
    public function acceptFriendRequest(){
        //Gets the connection Id to allow the model to delete the record
        $friendConnectionId = $_POST["friendConnectionId"];
        //Gets the sender id for creating the friend connection
        $senderId = $_POST["senderId"];
        //Gets the other users name to add for the friend connection record creation
        $otherUsersName = $this->friendsListModel->getOtherUsersName($senderId);
        //Creates the connection between the users
        $this->friendsListModel->requestAccepted($otherUsersName, $senderId);
        //deletes the request connection
        $returnData = $this->friendsListModel->cancelRequest($friendConnectionId);
        //redirect
        redirect('FriendsListController/friendsList');
    }

    /**
     * removeFriend method is called when the user wants to remove a friend, they click a button 
     * and this method is called. The connection Id is received and used to delete the friend connection 
     * record, then it redirects
     */
    public function removeFriend(){
        //Gets friendConnectionId
        $friendConnectionId = $_POST["friendConnectionId"];
        //Deletes the record
        $this->friendsListModel->removeFriend($friendConnectionId);
        //redirects to friendList
        redirect('FriendsListController/friendsList');
    }

    /**
     * getNumberOfFriendRequests method is called by the footer when every page is loaded and what it does is it gets the number
     * of friend requests the user has and uses them as a notification
     */
    public function getNumberOfFriendRequests(){
        //Returns all friend requests
        $returnData = $this->friendsListModel->getFriendRequestCount();
        //Gets the count of records
        $count = sizeof($returnData);
        //Echos out count number
        echo  json_encode($count);
    }

    /**
     * The declineGroupRequest works similar to the declineFriendRequest, what it does is 
     * delete the record connection for that request without adding a new record to the group 
     * connection
     */
    public function declineGroupRequest(){
        //Gets the connect id
        $groupConnectionId = $_POST["groupConnectionId"];
        //deletes record
        $this->friendsListModel->removeGroupConnectionId($groupConnectionId);
        //redirects
        redirect('FriendsListController/friendsList');
    }

    /**
     * acceptGroupRequest works similar to the acceptFriendRequest method where the 
     * request connection is deleted and a new record connecting the group to the user 
     * is created
     */
    public function acceptGroupRequest(){
        //gets the group request connection Id
        $groupConnectionId = $_POST["groupConnectionId"];
        //gets the group info for the new record to be created
        $groupInfo = $this->friendsListModel->getGroupId($groupConnectionId);
        //Deletes the request record in the database
        $this->friendsListModel->removeGroupConnectionId($groupConnectionId);
        //Creates a new connectionr record between the user and the group
        $this->friendsListModel->acceptGroupRequest($groupInfo->Group_Id);
        //redirect
        redirect('FriendsListController/friendsList');
    }
}

?>