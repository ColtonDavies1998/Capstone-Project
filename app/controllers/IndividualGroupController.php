<?php 
/* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */

 /**
   * IndividualGroupController
   * 
   * 
   * @package    Controller
   * @author     Colton Davies
   */
class IndividualGroupController extends Controller { 
  /**
    * 
    * This is the constructor for the class, a common theme for most constructors throughout the project
    * is that they just initialize the model that goes with the controller
    *
    */
    public function __construct(){
        $this->individualGroupModel = $this->model('IndividualGroupModel');
    }

    /**
     * This method is the method called when the user wants to access the individual project page, this method is 
     * the method that sets up all the data and passes it to the view and redirects the page to the view page
     */
    public function individualGroup(){
        //Sets the current page to individual group
        $_SESSION['current_page'] = 'IndividualGroup';
        //gets the specific group id that has to be passed through the url
        $_SESSION['current_group'] = $_GET['groupId'];
        //Sets session of the group id
        $groupId = $_SESSION['current_group'];
        //Checks if the users group actually belongs to the user
        $actualUsersGroup = $this->individualGroupModel->checkForUserGroupMatch($groupId);
        //Sets it to true or false if record is found
        if($actualUsersGroup >= 1){
            $data["actualUsersGroup"] = true;
        }else{
            $data["actualUsersGroup"] = false;
        }
        //Gets the information on this group
        $data["groupInformation"] = $this->individualGroupModel->getGroupInformation($groupId);
        //The tasks associated to that group
        $data["groupTasks"] = $this->individualGroupModel->getGroupTasks($groupId);
        //Get users that belong to that group
        $groupUserIds = $this->individualGroupModel->getUserIds($groupId);
        //create an empty variable for the users
        $data["users"] = [];

        //This loops through and gets each users info and stores it into the empty array we created
        for($i=0; $i < sizeof($groupUserIds); $i++){
            $userInfo = $this->individualGroupModel->getUserInfo($groupUserIds[$i]->User_id);
            array_push($data["users"], $userInfo);
        }
        //Checks if the user accessing this page owns this groups/ was the creator
        $data["userOwnsThisGroup"] = $this->individualGroupModel->checkIfUserOwnsGroup($groupId);
        //Gets a list of all the group requests
        $data['groupRequest'] = $this->individualGroupModel->getRequestedConnections();
        //redirects to view
        $this->view('individualGroup/IndividualGroup', $data);
    }

    /**
     * This method is similar to all the other createTask methods, it checks if the users input to create 
     * a task is valid. If it is then the record is inserted into the table the only difference is that this 
     * task will have a group id
     */
    public function createTask(){
        //checks if the request is a post request
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //Init Data
            $data = [
              'task_name'=> trim($_POST['nameInput']),
              'task_type'=> trim($_POST['typeInput']),
              'task_start_time'=> trim($_POST['startTimeInput']),
              'task_end_time' => trim($_POST['endTimeInput']),
              'task_start_date' => trim($_POST['startDateInput']),
              'task_end_date' => trim($_POST['endDateInput']),
              'group_id' => trim($_POST['idInput']),
              'task_name_error' => '',
              'task_type_error' => '',
              'task_start_time_error'=> '',
              'task_end_time_error' => '',
              'task_start_date_error' => '',
              'task_end_date_error' => ''
            ];
    
            //Checks if the name field was empty
            if(empty($data['task_name'])){
              $data['task_name_error'] = 'Please enter a name for the task';
            }
            //Checks if the type field was empty
            if(empty($data['task_type'])){
              $data['task_type_error'] = 'Please select a task type';
            }
            //Checks if the start time field was empty
            if(empty($data['startTimeInput'])){
              $data['task_start_time_error'] = 'Please enter in a start time for the task';
            }else{
              //makes sure the minutes are in 5 minute intervals
              $roundedStartMinutes = $this->roundMinutes($data['task_start_time']);
              $tempStartTime = explode(":", $data['task_start_time']);
                    
              if($roundedStartMinutes >= 60){
                $roundedStartMinutes = "55";
              }
              
              if($roundedStartMinutes < 10){
                $data['task_start_time'] = $tempStartTime[0] . ":" . $roundedStartMinutes;
              }else{
                $data['task_start_time'] = $tempStartTime[0] . ":" . $roundedStartMinutes;
              }
            }
            //Checks if the end time field was empty
            if(empty($data['endTimeInput'])){
              $data['task_end_time_error'] = 'Please enter in a end time for the task';
            }else{
              //makes sure the minutes for end time are in 5 minute intervals
              $roundedEndMinutes = $this->roundMinutes($data['task_end_time']);
              $tempEndTime = explode(":", $data['task_end_time']);  
    
              if($roundedEndMinutes >= 60){
                $roundedEndMinutes = "55";
    
              }
    
              if($roundedEndMinutes < 10){
                $data['task_end_time'] = $tempEndTime[0] . ":" . $roundedEndMinutes;
              }else{
                $data['task_end_time'] = $tempEndTime[0] . ":" . $roundedEndMinutes;
              }
            }
            if(empty($data['startDateInput'])){
              $data['task_start_date_error'] = 'Please enter in a start date for the task';
            }
            if(empty($data['endDateInput'])){
              $data['task_end_date_error'] = 'Please enter in a end date for the task';
            }
    
    
            //Checks the difference in days when start and end. If the end date starts before the start date then throw and error
            $dateDifference = date_diff(date_create($data['task_start_date']), date_create($data['task_end_date']));
            $dateDifference = $dateDifference->format('%R%a');
            $dateDifference = intval($dateDifference);
            //if the date difference is smaller than 0 then means the task end date was before the start and should throw an error
            if($dateDifference < 0){
              $data['task_start_date_error'] = 'The start date cannot be after the end date';
              $data['task_end_date_error'] = 'The end date cannot be before the start date ';
            }
            //If the date difference is exactly 0 means that the task starts and end on the same date which means we must look at the 
            //times and make sure the end time does not start before the end time
            if($dateDifference == 0){
              $to_time = strtotime($data['task_end_time']);
              $from_time = strtotime($data['task_start_time']);
              $timeDifference = round(($to_time - $from_time) / 60,2);
              //Throws the errors
              if($timeDifference < 0){
                $data['task_start_time_error'] = 'Start time cannot be before end time of a task if they are on the same day';
              }elseif($timeDifference == 0){
                $data['task_start_time_error'] = 'Start time cannot be at the same time as the end of the time';
              }
    
            }
    
            //Checks if all the error variables are emtpy if they are then the task is created
            if(empty($data['task_name_error']) && empty($data['task_type_error']) && empty($data['task_start_time_error']) && empty($data['task_end_time_error'])
            && empty( $data['task_start_date_error']) && empty( $data['task_end_date_error'])){
              //Validated
              //Input New Task
              if($this->individualGroupModel->createNewTask($data)){
                $path = '/IndividualGroupController/individualGroup?groupId=' . $_SESSION['current_group'];          
                redirect($path);
              }else{
                  //For testing purposes
                  die('Something went Wrong');
              } 
      
            //Loads the page with the error date
            }else{
                //Load view with errors
                $_SESSION['errorData'] = $data;
                $path = '/IndividualGroupController/individualGroup?groupId=' . $_SESSION['current_group'];          
                redirect($path);
            }
          }
    }

    /**
     * This method when called takes the first and last name inputs of the user search form and searches for users based on 
     * that criteria
     */
    public function getUsers(){
      //Gets the users inputed search first and last name
      $firstName = $_GET["firstName"];
      $lastName = $_GET["lastName"];
      //This function gets all the group requests that have been sent out
      $requestConnections = $this->individualGroupModel->getRequestedConnections();
      //Gets all the people who are already in the group
      $friendsList = $this->individualGroupModel->getGroupFriends();
      //Gets a search result based on the first and last name input
      $userSearch = $this->individualGroupModel->userSearch($firstName, $lastName);
      //declare empty return variables
      $returnData = [];
      
      //This runs through two for loops and comprares the search results ids and the request connection ids.
      //Anybody who has already been sent a group request does not show up in the search result
      for($j=0; $j < sizeof($userSearch); $j++){
          //Sets the trigger to check if the ids match if they dont match then the item is pushed to the created empty array
          $trigger = false;
          for($i=0; $i < sizeof($requestConnections); $i++){
              //Checks for connection
              if($requestConnections[$i]->Receiver_Id == $userSearch[$j]->User_Id){
                  $trigger = true;
                  break;
              }
          }
          //If trigger is false means there was no match
          if($trigger == false){
              array_push($returnData, $userSearch[$j]);
          }

      }

      //These loops do a similar thing to the two loops above the difference is this loop checks for users that have 
      //already been added to the group. If they have been then the array is unset
      for($i=0; $i < sizeof($friendsList); $i++){
          for($j=0; $j < sizeof($returnData); $j++){
              if($returnData[$j]->User_Id == $friendsList[$i]->User_Id){
                  unset($returnData[$j]);
                  $returnData = array_values($returnData);
                  break;
              }
          }
          
      }
      //echos out the result json encoded
      echo  json_encode($returnData);
    }

    /**
     * this method when called removes an individual from the group
     */
    public function removeUserFromGroup(){
      //Gets the id frim the input
      $removeId = $_GET["input"];
      //This model removes the connection record from the table
      $this->individualGroupModel->removeUserFromTheGroup($removeId);
    }

    /**
     * This method when called sends a group invitiation to the user fro the search
     */
    public function sendGroupInvite(){
      //Gets the other users id
      $otherUserId = $_POST["otherUserId"];
      //Gets the other users information
      $userInfo = $this->individualGroupModel->getUserInfo($otherUserId);
      //Gets the group information
      $groupInfo = $this->individualGroupModel->getGroupInformation($_SESSION['current_group']); 
      //Sets the group name
      $groupName = $groupInfo->Group_Name;
      //creates the group request in the table
      $this->individualGroupModel->SendGroupInviteRecord($otherUserId, $userInfo, $groupName);

      //redirects
      $path = '/IndividualGroupController/individualGroup?groupId=' . $_SESSION['current_group'];          
      redirect($path);

    }

    /**
     * This method when called cancels a request that was sent to an individual
     */
    public function cancelRequest(){
      //the other users Id
      $otherUserId = $_POST["otherUserId"];
      //deletes the record in the database
      $this->individualGroupModel->cancelGroupRequestInvitation($otherUserId); 
      //redirects
      $path = '/IndividualGroupController/individualGroup?groupId=' . $_SESSION['current_group'];          
      redirect($path);
    }

    /**
     * this method when called gets a users name based on an ID
     */
    public function getUsersName(){
      //Get the Id
      $userId = $_GET["userId"];
      //Gets the users name 
      $usersName = $this->individualGroupModel->getTheUsersName($userId); 
      //echos out a created users name given the first and last name
      echo $usersName->User_First_Name . " " . $usersName->User_Last_Name;
    }

    /**
     * This method is called when the user wants to send a message from the group page to another user who belongs to the 
     * same group
     */
    public function sendMessage(){
      //Gets the recievers id
      $userId = $_POST["userIdForMessage"];
      //gets the message text
      $messageText = $_POST["messageText"];
      //Makes sure not of the above variables are empty
      if(empty($userId) == false && empty($messageText) == false){
        //Gets the other users name
        $usersName = $this->individualGroupModel->getTheUsersName($userId); 
        //Checks if the users have already been connected
        $groupUserToUserConnection = $this->individualGroupModel->checkGroupMessageConnection($userId); 

        //If the size of groupuser to user connection is 0 means the users have never messaged before
        if(sizeof($groupUserToUserConnection) == 0){
          $groupInfo =  $this->individualGroupModel->getGroupInformation($_SESSION['current_group']); 
          $this->individualGroupModel->createGroupMessageConnectionRecord($userId, $usersName, $groupInfo);
        }
        //Insert message
        $this->individualGroupModel->sendMessageFromGroup($userId, $messageText, $usersName); 
        //redirect to the group page
        $path = '/IndividualGroupController/individualGroup?groupId=' . $_SESSION['current_group'];          
        redirect($path);
      }else{
        //redirect
        $path = '/IndividualGroupController/individualGroup?groupId=' . $_SESSION['current_group'];          
        redirect($path);
      }
    }


    /**
       * 
       * This method helps round the minutes when calculating the time
       *
       * @param string $timestring  the time the user has inputed
       * @return boolean
       */
    function roundMinutes($timestring) {
        $minutes = date('i', strtotime($timestring));
        $minutesLeft = $minutes % 5;
  
        switch($minutesLeft){
          case 0:
            return $minutes;
            break;
          
          case 1:
            return $minutes - 1;
            break;
  
          case 2:
            return $minutes - 2;
            break;
          
          case 3:
            return $minutes + 2;
            break;
          
          case 4:
            return $minutes + 1;
            break;
        
        }     
      }
}