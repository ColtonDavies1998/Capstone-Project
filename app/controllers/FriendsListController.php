<?php 
//TO DO
    //When the user has a friend and they head the message button take them to the message page
class FriendsListController extends Controller { 
    public function __construct(){
        $this->friendsListModel = $this->model('FriendsListModel');
    }

    public function friendsList(){
        $_SESSION['current_page'] = 'FriendsList';

        $data["friendRequestsSent"] = $this->friendsListModel->getSentRequests();
        $data["incomingFriendRequests"] = $this->friendsListModel->getFriendRequests();
        $data["friendsList"] = $this->friendsListModel->getFriends();

        $data["groupRequests"] = $this->friendsListModel->getGroupRequests();


        $this->view('friends/FriendsList', $data);
    }

    public function getUsers(){
        $firstName = $_GET["firstName"];
        $lastName = $_GET["lastName"];

        $requestConnections = $this->friendsListModel->getConnections();

        $friendsList = $this->friendsListModel->getFriends();

        $userSearch = $this->friendsListModel->userSearch($firstName, $lastName);

        $returnData = [];
        

        for($j=0; $j < sizeof($userSearch); $j++){
            $trigger = false;
            for($i=0; $i < sizeof($requestConnections); $i++){
                if($requestConnections[$i]->ReceiverId == $userSearch[$j]->User_Id || $requestConnections[$i]->SenderId == $userSearch[$j]->User_Id){
                    $trigger = true;
                    break;
                }
            }

            if($trigger == false){
                array_push($returnData, $userSearch[$j]);
            }

        }

        for($i=0; $i < sizeof($friendsList); $i++){
     
            for($j=0; $j < sizeof($returnData); $j++){
                if($returnData[$j]->User_Id == $friendsList[$i]->PersonOneId || $returnData[$j]->User_Id == $friendsList[$i]->PersonTwoId){
                    unset($returnData[$j]);
                    $returnData = array_values($returnData);
                    break;
                }
            }
            
        }

        echo  json_encode($returnData);
    }

    public function sendFriendRequest(){
        $otherUsersId = $_POST["otherUserId"];

        $otherUsersName = $this->friendsListModel->getOtherUsersName($otherUsersId);

        $returnData = $this->friendsListModel->sendRequest($otherUsersId, $otherUsersName);

        redirect('FriendsListController/friendsList');
        
    }

    public function cancelFriendRequest(){
        $friendConnectionId = $_POST["friendConnectionId"];

        $returnData = $this->friendsListModel->cancelRequest($friendConnectionId);

        redirect('FriendsListController/friendsList');
        
    }

    public function declineFriendRequest(){
        $friendConnectionId = $_POST["friendConnectionId"];

        $returnData = $this->friendsListModel->cancelRequest($friendConnectionId);

        redirect('FriendsListController/friendsList');
    }

    public function acceptFriendRequest(){
        $friendConnectionId = $_POST["friendConnectionId"];
        $senderId = $_POST["senderId"];

        $otherUsersName = $this->friendsListModel->getOtherUsersName($senderId);
        
        $this->friendsListModel->requestAccepted($otherUsersName, $senderId);

        $returnData = $this->friendsListModel->cancelRequest($friendConnectionId);

        redirect('FriendsListController/friendsList');
        
        
    }

    public function removeFriend(){
        $friendConnectionId = $_POST["friendConnectionId"];

        $this->friendsListModel->removeFriend($friendConnectionId);

        redirect('FriendsListController/friendsList');
    }

    public function getNumberOfFriendRequests(){

        $returnData = $this->friendsListModel->getFriendRequestCount();

        $count = sizeof($returnData);

        echo  json_encode($count);
    }

    public function declineGroupRequest(){

        $groupConnectionId = $_POST["groupConnectionId"];

        $this->friendsListModel->removeGroupConnectionId($groupConnectionId);

        redirect('FriendsListController/friendsList');
    }

    public function acceptGroupRequest(){

        $groupConnectionId = $_POST["groupConnectionId"];

        $groupInfo = $this->friendsListModel->getGroupId($groupConnectionId);

        $this->friendsListModel->removeGroupConnectionId($groupConnectionId);

        $this->friendsListModel->acceptGroupRequest($groupInfo->Group_Id);

        redirect('FriendsListController/friendsList');
    }
}

?>