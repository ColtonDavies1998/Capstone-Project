<?php 
class IndividualGroupController extends Controller { 
    public function __construct(){
        $this->individualGroupModel = $this->model('IndividualGroupModel');
    }

    public function individualGroup(){
        $_SESSION['current_page'] = 'IndividualGroup';

        $_SESSION['current_group'] = $_GET['groupId'];

        $groupId = $_GET['groupId'];

        $actualUsersGroup = $this->individualGroupModel->checkForUserGroupMatch($groupId);

        if($actualUsersGroup >= 1){
            $data["actualUsersGroup"] = true;
        }else{
            $data["actualUsersGroup"] = false;
        }

        $data["groupInformation"] = $this->individualGroupModel->getGroupInformation($groupId);
        $data["groupTasks"] = $this->individualGroupModel->getGroupTasks($groupId);

        $groupUserIds = $this->individualGroupModel->getUserIds($groupId);
        $data["users"] = [];

        for($i=0; $i < sizeof($groupUserIds); $i++){
            $userInfo = $this->individualGroupModel->getUserInfo($groupUserIds[$i]->User_id);
            array_push($data["users"], $userInfo);
        }

        $data["userOwnsThisGroup"] = $this->individualGroupModel->checkIfUserOwnsGroup($groupId);
    
        $this->view('individualGroup/IndividualGroup', $data);
    }

    public function createTask(){
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
    
            //Validate Name
            if(empty($data['task_name'])){
              $data['task_name_error'] = 'Please enter a name for the task';
            }
            if(empty($data['task_type'])){
              $data['task_type_error'] = 'Please select a task type';
            }
            if(isset($data['startTimeInput'])){
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
            if(isset($data['endTimeInput'])){
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
            if(isset($data['startDateInput'])){
              $data['task_start_date_error'] = 'Please enter in a start date for the task';
            }
            if(isset($data['endDateInput'])){
              $data['task_end_date_error'] = 'Please enter in a end date for the task';
            }
    
    
            //Checks the difference in days when start and end. If the end date starts before the start date then throw and error
            $dateDifference = date_diff(date_create($data['task_start_date']), date_create($data['task_end_date']));
            $dateDifference = $dateDifference->format('%R%a');
            $dateDifference = intval($dateDifference);
    
            if($dateDifference < 0){
              $data['task_start_date_error'] = 'The start date cannot be after the end date';
              $data['task_end_date_error'] = 'The end date cannot be before the start date ';
            }
    
            if($dateDifference == 0){
              $to_time = strtotime($data['task_end_time']);
              $from_time = strtotime($data['task_start_time']);
              $timeDifference = round(($to_time - $from_time) / 60,2);
    
              if($timeDifference < 0){
                $data['task_start_time_error'] = 'Start time cannot be before end time of a task if they are on the same day';
              }elseif($timeDifference == 0){
                $data['task_start_time_error'] = 'Start time cannot be at the same time as the end of the time';
              }
    
            }
    
            if(empty($data['task_name_error']) && empty($data['task_type_error']) && empty($data['task_start_time_error']) && empty($data['task_end_time_error'])
            && empty( $data['task_start_date_error']) && empty( $data['task_end_date_error'])){
              //Validated
    
              //Input New Task
    
              if($this->individualGroupModel->createNewTask($data)){

                $path = '/IndividualProjectController/individualProject?groupId=' . $_SESSION['current_group'];          
                redirect($path);
              }else{
                  die('Something went Wrong');
              } 
      
    
            }else{
                //Load view with errors
                $_SESSION['errorData'] = $data;
                $this->individualGroup();
                //redirect('IndividualProjectController/individualProject?projectId='+ $_SESSION['current_project']);
            }
            
          }
    }
    //NOT COMPLETE FUNCTION, ERROR WITH RETURN
    public function getUsers(){
      $inputValue = $_GET["input"];

      $returnData = $this->individualGroupModel->userSearch($inputValue);

      echo  json_encode($returnData);
    }

    public function removeUserFromGroup(){
      $removeId = $_GET["input"];

      $this->individualGroupModel->removeUserFromTheGroup($removeId);
    }



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