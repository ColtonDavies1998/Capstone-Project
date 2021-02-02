<?php 
/* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */

 /**
   * IndividualProjectController
   * 
   * 
   * @package    Controller
   * @author     Colton Davies
   */
class IndividualProjectController extends Controller { 

    /**
    * 
    * This is the constructor for the class, a common theme for most constructors throughout the project
    * is that they just initialize the model that goes with the controller
    *
    */
    public function __construct(){
        $this->individualProjectModel = $this->model('IndividualProjectModel');
    }

    /**
     * This is the main method called when a user wants to access the page, it gets the project id from 
     * the url and gets all the data associated with it and directs the user to the view page
     */
    public function individualProject(){
        //Sets current page
        $_SESSION['current_page'] = 'IndividualProject';

        //Sets current project id
        $_SESSION['current_project'] = $_GET['projectId'];
        
        //set project id
        $projectId = $_SESSION['current_project'];

        //checks if the project being accessed actually belongs to the user
        $actualUsersProject = $this->individualProjectModel->checkForUserProjectMatch($projectId);

   
        //sets true or false this allows the user to access the page
        if($actualUsersProject >= 1){
            $data["actualUsersProject"] = true;
        }else{
            $data["actualUsersProject"] = false;
        }
        //gets project information and task
        $data["projectInformation"] = $this->individualProjectModel->getProjectsInformation($projectId);
        $data["projectsTasks"] = $this->individualProjectModel->getProjectsTasks($_SESSION['current_project']);
        //get projects files
        $data["projectFiles"] = $this->individualProjectModel->getProjectFiles($projectId);
        

        //Update completion rate of project incomplete tasks/ completed tasks
        $totalCompleteTasks = $this->individualProjectModel->getCompletedProjectTasks($_SESSION['current_project']);
        $numOfTasks = sizeof($this->individualProjectModel->getProjectsTasks($_SESSION['current_project']));
        if($numOfTasks == 0){
          $completionPercent = 100;
        }else{
          $completionPercent = (sizeof($totalCompleteTasks) / $numOfTasks) * 100;
        }

        
        $this->individualProjectModel->changeProjectCompletion($projectId, $completionPercent);
        //go to view
        $this->view('individualProject/IndividualProject', $data);
    }

    /**
     * When this method is called it gets the information of a file
     */
    public function getFileInfo(){
      //file id
      $fileId = $_GET["id"];
      //File info
      $info = $this->individualProjectModel->getFileInformation($fileId);
      //echo out file info
      echo  json_encode($info);

    }

    /**
     * This method is similar to all the other createTask methods, it checks if the users input to create 
     * a task is valid. If it is then the record is inserted into the table the only difference is that this 
     * task will have a project id
     */
    public function createNewTask(){
        //Checks if the request made is a post request
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
    
            //Checks if the name is empty
            if(empty($data['task_name'])){
              $data['task_name_error'] = 'Please enter a name for the task';
            }
            //Checks if the type is empty
            if(empty($data['task_type'])){
              $data['task_type_error'] = 'Please select a task type';
            }
            //Checks if the start date is empty
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
            //if date difference equals 0 than we have to make sure the times are correct
            if($dateDifference == 0){
              $to_time = strtotime($data['task_end_time']);
              $from_time = strtotime($data['task_start_time']);
              $timeDifference = round(($to_time - $from_time) / 60,2);
              //throw error end time cannot be before start time
              if($timeDifference < 0){
                $data['task_start_time_error'] = 'Start time cannot be before end time of a task if they are on the same day';
              }elseif($timeDifference == 0){
                $data['task_start_time_error'] = 'Start time cannot be at the same time as the end of the time';
              }
    
            }
           
            //if all errors are empty submit the task
            if(empty($data['task_name_error']) && empty($data['task_type_error']) && empty($data['task_start_time_error']) && empty($data['task_end_time_error'])
            && empty( $data['task_start_date_error']) && empty( $data['task_end_date_error'])){
              //Validated
    
              //Input New Task
              
              if($this->individualProjectModel->createNewTask($data)){
                //redirect
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

    /**
     * When this method is called it is when the user wants to create a file. This validates the 
     * user's input and and if everything is correct it creates a new file
     */
    public function createFile(){
      //checks the request method is post
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

        //Validates Name type and file link
        if(empty($fileData['file_name'])){
          $fileData['file_name_error'] = 'Please enter a file name';
        }
        if(empty($fileData['file_type'])){
          $fileData['file_type_error'] = 'Please enter a file type';
        }
        if(empty($fileData['file_link'])){
          $fileData['file_link_error'] = 'Please enter a file link';
        }

        //if the file link is not empty then the link is created
        if(empty($fileData['file_link_error'])){
          //fix the google doc link
          $stringArray = str_split($fileData['file_link']);
          $startingIndex = 0;
          $endingIndex = 0;
          
          //See how the file display works is it displays a word document on an iframe and allows the user to view through that
          //The link must be a google drive preview link, so the below code makes sure the drive link is legit and if so 
          //changes the drive view tag to preview tag
          
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
        //if the errors are empty then create new file in database
        if(empty($fileData['file_name_error']) && empty($fileData['file_type_error']) && empty($fileData['file_link_error'])){
          if($this->individualProjectModel->storeNewFile($fileData)){
            //redirects to project
            $path = '/IndividualProjectController/individualProject?projectId=' . $_SESSION['current_project'];          
            redirect($path);

          }else{
              die('Something went Wrong');
          }  
        }else{
          //returns  with errors
          $_SESSION['fileErrorData'] = $fileData;
          redirect('individualProjectController/individualProject');
        }


      }else{
        //Load view with errors
        $_SESSION['errorData'] = $data;
        $this->individualProject();
      
      }
    }

    /**
     * This method when called makes an edit to an individual file, the user can change things like 
     * their type link or name. It also makes sure that it is validated
     */
    public function editFile(){
      //Checks if the request is a post request
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

        //Validate Name type and link
        if(empty($fileData['file_name'])){
          $fileData['file_name_error'] = 'Please enter a file name';
        }
        if(empty($fileData['file_type'])){
          $fileData['file_type_error'] = 'Please enter a file type';
        }
        if(empty($fileData['file_link'])){
          $fileData['file_link_error'] = 'Please enter a file link';
        }

        //Checks if all the error variables are empty so the edit can be updated in the database
        if(empty($fileData['file_name_error']) && empty($fileData['file_type_error']) && empty($fileData['file_link_error'])){
          if($this->individualProjectModel->editFile($fileData)){
            //redirects
            $path = '/IndividualProjectController/individualProject?projectId=' . $_SESSION['current_project'];          
            redirect($path);

          }else{
              //For testing
              die('Something went Wrong');
          } 
        }

      }else{
        //Load view with errors
        $_SESSION['errorData'] = $data;
        $path = '/IndividualProjectController/individualProject?projectId=' . $_SESSION['current_project'];          
        redirect($path);
        
      }
    }

    /**
     * This method when called deletes a file
     */
    public function deleteFile(){
      //checks for if the request is a post request
      if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        //gets the file id
        $fileId = trim($_POST['deleteFileId']);

        

        if($this->individualProjectModel->deleteFile($fileId)){
          //deletes file and redirects
          $path = '/IndividualProjectController/individualProject?projectId=' . $_SESSION['current_project'];          
          redirect($path);

        }else{
          //for testing
          die('something went wrong');
        }
      }else{
        //redirect
        $path = '/IndividualProjectController/individualProject?projectId=' . $_SESSION['current_project'];          
        redirect($path);
      }
    }

    /**
     * this method when called changes a task from incmplete to complete
     */
    public function incompleteToComplete(){
      //Task id
      $taskId = $_POST["taskId"];

      //Check if the taskId belongs to the user and project
      $taskInfo = $this->individualProjectModel->getIndividualTaskInfo($taskId, $_SESSION['current_project']);
      if(sizeof($taskInfo) == 1){
        $this->individualProjectModel->changeTaskCompletion($taskId, true);
        //redirects to page
        $path = '/IndividualProjectController/individualProject?projectId=' . $_SESSION['current_project'];          
        redirect($path);
      }


    }

    /**
     * When this method is called changes a task from complete to incomplete
     */
    public function completeToIncomplete (){
      //gets task id
      $taskId = $_POST["taskId"];

      //Check if the taskId belongs to the user and project
      $taskInfo = $this->individualProjectModel->getIndividualTaskInfo($taskId, $_SESSION['current_project']);
      if(sizeof($taskInfo) == 1){
        $this->individualProjectModel->changeTaskCompletion($taskId, false);
        //redirects
        $path = '/IndividualProjectController/individualProject?projectId=' . $_SESSION['current_project'];          
        redirect($path);
      }
    }

    /**
     * gets all the tasks for a given project
     */
    public function getProjectTasks(){
      $tasks = $this->individualProjectModel->getProjectsTasks($_SESSION['current_project']);

      echo json_encode($tasks);
    }

    /**
     * This method is called when the user submits an edit task form and it checks to make sure the data is formatted correctly
     * and then calls the model
     */
    public function editTask(){
      //checks for request type
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        //Init Data
       $data = [
         'edit_task_id'=> trim($_POST['taskId']),
         'edit_task_name'=> trim($_POST['taskNameEdit']),
         'edit_task_type'=> trim($_POST['taskTypeInput']),
         'edit_task_start_time'=> trim($_POST['startTimeEdit']),
         'edit_task_end_time' => trim($_POST['endTimeEdit']),
         'edit_task_start_date' => trim($_POST['startDateInput']),
         'edit_task_end_date' => trim($_POST['endDateInput']),
         'edit_isComplete' => trim($_POST['isComplete']),
         'edit_task_name_error' => '',
         'edit_task_type_error' => '',
         'edit_task_start_time_error'=> '',
         'edit_task_end_time_error' => '',
         'edit_task_start_date_error' => '',
         'edit_task_end_date_error' => ''
       ];

       //Validate Name type start and end time and start and end date
       if(empty($data['edit_task_name'])){
         $data['edit_task_name_error'] = 'Please enter a name for the task';
       }
       if(empty($data['edit_task_type'])){
         $data['edit_task_type_error'] = 'Please select a task type';
       }
       if(isset($data['edit_task_start_time']) == false){
         $data['edit_task_start_time_error'] = 'Please enter in a start time for the task';
       }
       if(isset($data['edit_task_end_time'])  == false){
         $data['edit_task_end_time_error'] = 'Please enter in a end time for the task';
       }
       if(isset($data['edit_task_start_date'])  == false){
         $data['edit_task_start_date_error'] = 'Please enter in a start date for the task';
       }
       if(isset($data['edit_task_end_date'])  == false){
         $data['edit_task_end_date_error'] = 'Please enter in a end date for the task';
       }

       //If all the errors are  empty then submit the changes
       if(empty($data['edit_task_name_error']) && empty($data['edit_task_type_error']) && empty($data['edit_task_start_time_error']) &&
          empty($data['edit_task_end_time_error']) && empty( $data['edit_task_start_date_error']) && empty( $data['edit_task_end_date_error'])){
         //Validate

         //Input New Task
         if($this->individualProjectModel->editTask($data)){
           //redirect
          $path = '/IndividualProjectController/individualProject?projectId=' . $_SESSION['current_project'];          
          redirect($path);
         }else{
             die('Something went Wrong');
         }
        
       }else{
           //Load view with errors
           $path = '/IndividualProjectController/individualProject?projectId=' . $_SESSION['current_project'];          
          redirect($path);
       }

     }
    }

    /**
     * This method when called deletes an individual task based on the id
     */
    public function deleteTask(){
      //Checks for the request type
      if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        //get task id
        $taskId = trim($_POST['deleteId']);
        //call delete task model
        if($this->individualProjectModel->deleteTask($taskId)){
          //redirect back to project
          $path = '/IndividualProjectController/individualProject?projectId=' . $_SESSION['current_project'];          
          redirect($path);

        }else{
          //for testing
          die('something went wrong');
        }
      }else{
        $path = '/IndividualProjectController/individualProject?projectId=' . $_SESSION['current_project'];          
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