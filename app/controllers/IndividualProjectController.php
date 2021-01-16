<?php 
class IndividualProjectController extends Controller { 

    
    public function __construct(){
        $this->individualProjectModel = $this->model('IndividualProjectModel');
    }

    public function individualProject(){
        $_SESSION['current_page'] = 'IndividualProject';

       
        $_SESSION['current_project'] = $_GET['projectId'];
        
        

        $projectId = $_SESSION['current_project'];

        $actualUsersProject = $this->individualProjectModel->checkForUserProjectMatch($projectId);

   

        if($actualUsersProject >= 1){
            $data["actualUsersProject"] = true;
        }else{
            $data["actualUsersProject"] = false;
        }

        $data["projectInformation"] = $this->individualProjectModel->getProjectsInformation($projectId);
        $data["projectsTasks"] = $this->individualProjectModel->getProjectsTasks($_SESSION['current_project']);

        $data["projectFiles"] = $this->individualProjectModel->getProjectFiles($projectId);
        

        //Update completion rate of project incomplete tasks/ completed tasks
        $totalCompleteTasks = $this->individualProjectModel->getCompletedProjectTasks($_SESSION['current_project']);
        $completionPercent = (sizeof($totalCompleteTasks) / sizeof($this->individualProjectModel->getProjectsTasks($_SESSION['current_project']))) * 100;
        $this->individualProjectModel->changeProjectCompletion($projectId, $completionPercent);

        $this->view('individualProject/IndividualProject', $data);
    }

    public function getFileInfo(){
      $fileId = $_GET["id"];

      $info = $this->individualProjectModel->getFileInformation($fileId);

      echo  json_encode($info);

    }

    public function createNewTask(){
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
              'project_id' => trim($_POST['idInput']),
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
            if(empty($data['task_start_date'])){
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
            if(empty($data['task_end_time'])){
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
            if(empty($data['task_start_date'])){
              $data['task_start_date_error'] = 'Please enter in a start date for the task';
            }
            if(empty($data['task_end_date'])){
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
    
              if($this->individualProjectModel->createNewTask($data)){
                
                $path = '/IndividualProjectController/individualProject?projectId=' . $_SESSION['current_project'];          
                redirect($path);
              }else{
                  die('Something went Wrong');
              } 
      
    
            }else{
                //Load view with errors
                $_SESSION['errorData'] = $data;
                $path = '/IndividualProjectController/individualProject?projectId=' . $_SESSION['current_project'];     
              
                redirect($path);
    
            }
            
          }
    }

    public function createFile(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        //Init Data
        $fileData = [
          'file_name'=> trim($_POST['fileName']),
          'file_type'=> trim($_POST['fileType']),
          'file_link'=> trim($_POST['fileLink']),
          'project_id' => trim($_POST['projectId']),
          'file_name_error' => '',
          'file_type_error' => '',
          'file_link_error'=> '',
        ];

        //Validate Name
        if(empty($fileData['file_name'])){
          $fileData['file_name_error'] = 'Please enter a file name';
        }
        if(empty($fileData['file_type'])){
          $fileData['file_type_error'] = 'Please enter a file type';
        }
        if(empty($fileData['file_link'])){
          $fileData['file_link_error'] = 'Please enter a file link';
        }

        if(empty($fileData['file_link_error']) ){
          //fix the google doc link
          $stringArray = str_split($fileData['file_link']);
          $startingIndex = 0;
          $endingIndex = 0;
          
          
          for($i= sizeof($stringArray)- 1; $i >= 0; $i-- ){
            
            if($stringArray[$i] == "?"){
              $endingIndex = $i - 1;
              
              $temp = $i - 1;
              $loopCheck = false;
              while($loopCheck == false){
                if($stringArray[$temp] == "/"){
                  $startingIndex = $temp + 1;
                  $loopCheck = true;
                }else{
                  $temp--;
                }
              }
            break;
            }
          }

          $endOfString = "";

          for($i = $endingIndex + 1;  $i < sizeof($stringArray); $i++){
            $endOfString = $endOfString . $stringArray[$i];
          }

          $newString =  substr_replace($fileData['file_link'], 'preview' , $startingIndex, $endingIndex);

          $fileData["file_link"] = $newString . $endOfString;

        }

        

        

        //https://drive.google.com/file/d/1pL6N7eUKtBJvgHiCyXa53kUgtmjZYi9-/preview?usp=sharing
        //https://drive.google.com/file/d/1pL6N7eUKtBJvgHiCyXa53kUgtmjZYi9-/preview?usp=sharing

        
        if(empty($fileData['file_name_error']) && empty($fileData['file_type_error']) && empty($fileData['file_link_error'])){
          if($this->individualProjectModel->storeNewFile($fileData)){

            $path = '/IndividualProjectController/individualProject?projectId=' . $_SESSION['current_project'];          
            redirect($path);

          }else{
              die('Something went Wrong');
          }  
        }else{
          $_SESSION['fileErrorData'] = $fileData;
          redirect('individualProjectController/individualProject');
        }


      }else{
        //Load view with errors
        $_SESSION['errorData'] = $data;
        $this->individualProject();
        //redirect('IndividualProjectController/individualProject?projectId='+ $_SESSION['current_project']);
      }
    }

    public function editFile(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        //Init Data
        $fileData = [
          'file_name'=> trim($_POST['FileNameEdit']),
          'file_type'=> trim($_POST['FileTypeEdit']),
          'file_link'=> trim($_POST['FileLinkEdit']),
          'project_id' => trim($_POST['projectId']),
          'file_id' => trim($_POST['fileEditId']),
          'file_name_error' => '',
          'file_type_error' => '',
          'file_link_error'=> '',
        ];

        //Validate Name
        if(empty($fileData['file_name'])){
          $fileData['file_name_error'] = 'Please enter a file name';
        }
        if(empty($fileData['file_type'])){
          $fileData['file_type_error'] = 'Please enter a file type';
        }
        if(empty($fileData['file_link'])){
          $fileData['file_link_error'] = 'Please enter a file link';
        }


        if(empty($fileData['file_name_error']) && empty($fileData['file_type_error']) && empty($fileData['file_link_error'])){
          if($this->individualProjectModel->editFile($fileData)){

            $path = '/IndividualProjectController/individualProject?projectId=' . $_SESSION['current_project'];          
            redirect($path);

          }else{
              die('Something went Wrong');
          } 
        }

      }else{
        //Load view with errors
        $_SESSION['errorData'] = $data;
        $path = '/IndividualProjectController/individualProject?projectId=' . $_SESSION['current_project'];          
        redirect($path);
        //redirect('IndividualProjectController/individualProject?projectId='+ $_SESSION['current_project']);
      }
    }

    public function deleteFile(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $fileId = trim($_POST['deleteFileId']);

        

        if($this->individualProjectModel->deleteFile($fileId)){
          //flash('task_message', 'Post Removed');
          $path = '/IndividualProjectController/individualProject?projectId=' . $_SESSION['current_project'];          
          redirect($path);

        }else{
          die('something went wrong');
        }
      }else{
        $path = '/IndividualProjectController/individualProject?projectId=' . $_SESSION['current_project'];          
        redirect($path);
      }
    }

    public function incompleteToComplete(){
      $taskId = $_POST["taskId"];

      //Check if the taskId belongs to the user and project
      $taskInfo = $this->individualProjectModel->getIndividualTaskInfo($taskId, $_SESSION['current_project']);
      if(sizeof($taskInfo) == 1){
        $this->individualProjectModel->changeTaskCompletion($taskId, true);
        $path = '/IndividualProjectController/individualProject?projectId=' . $_SESSION['current_project'];          
        redirect($path);
      }


    }

    public function completeToIncomplete (){
      $taskId = $_POST["taskId"];

      //Check if the taskId belongs to the user and project
      $taskInfo = $this->individualProjectModel->getIndividualTaskInfo($taskId, $_SESSION['current_project']);
      if(sizeof($taskInfo) == 1){
        $this->individualProjectModel->changeTaskCompletion($taskId, false);
        $path = '/IndividualProjectController/individualProject?projectId=' . $_SESSION['current_project'];          
        redirect($path);
      }
    }

    public function getProjectTasks(){
      $tasks = $this->individualProjectModel->getProjectsTasks($_SESSION['current_project']);

      echo json_encode($tasks);
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