<?php
  /* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */

  /**
   * TaskHistoryController
   * 
   * 
   * @package    Controller
   * @author     Colton Davies
   */
  class TaskHistoryController extends Controller {

    /**
    * 
    * This is the constructor for the class, a common theme for most constructors throughout the project
    * is that they just initialize the model that goes with the controller
    *
    */
    public function __construct(){
        $this->taskHistoryModel = $this->model('TaskHistoryModel');
    }

    /**
     * the taskHistory method is the main method of the class, it is called to access the view, for 
     * this calls there are very few items needed to be set n place only the session page and empty 
     * data variable
     */
    public function taskHistory(){
        //Changes the current page to TaskHistory
        $_SESSION['current_page'] = 'TaskHistory';
        //No data needs to be loaded but the variable is still requored
        $data = [];
        //Load the view
        $this->view('taskHistory/TaskHistory', $data);
    }

    /**
     * the getUsersTasks is called when the page loads it makes an ajax call and gets all the tasks 
     * that belong to the user and creates the special pagination table I created. This could not be 
     * done at the start since there was a runtime issue with the tasks not showing up when the table 
     * was being created
     */
    public function getUsersTasks(){
        //Gets tasks
        $tasks = $this->taskHistoryModel->getAllUsersTasks();
        //echos out a jason encoded of the tasks
        echo json_encode($tasks);
    }

    /**
     * The getSingleTaskInfo is called when the user wants to edit an individual task, this function 
     * takes the id from the AJax request and calls the model, and returns the task information for the 
     * individual task, and echos out a JSON encoded info variable
     */
    public function getSingleTaskInfo(){
      //Checks for a post request
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //stores the id from the post request
        $id = $_POST['id'];
        //Stores the information
        $info = $this->taskHistoryModel->getTaskInfo($id);
        //Echos out the JSON
        echo  json_encode($info);
       
      }
    }

    /**
     * the deleteTask method is called when a user wants to delete an individual task, this function gets 
     * the id from the user and does a check to see if the user id matches the user and if it does then the 
     * task is deleted if not its redirected
     */
    public function deleteTask(){
      //checks to see if the request method is a post
      if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        //Grabs and trims the delete Id
        $taskId = trim($_POST['deleteId']);
          //Deletes the task
          if($this->taskHistoryModel->deleteTask($taskId)){

            if($_SESSION['current_page'] == "TaskHistory"){
              redirect('TaskHistoryController/taskHistory');

            }elseif($_SESSION['current_page'] == "IndividualProject"){
              $link = 'IndividualProjectController/individualProject?projectId='. $_SESSION['current_project'];

              redirect($link);

            }else{
              $link = 'IndividualGroupController/individualGroup?groupId='. $_SESSION['current_group'];

              redirect($link);
            }

            
  
          }else{
            //For testing
            die('something went wrong');
          }

        }else{
          //redirects
          redirect('TaskHistoryController/taskHistory');
        }

      
    }

    /**
     * The editTask method is called when the user submits a request to edit an individual task. 
     * This method makes sure there are no errors in the submission, if there are errors then the 
     * errors are returned and the user must fix them. If everything is ok then the task selected 
     * is edited and sent to the model
     */
    public function editTask(){
      //Checks if the request is a post request
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

        //Checks if the name is empty
        if(empty($data['edit_task_name'])){
          $data['edit_task_name_error'] = 'Please enter a name for the task';
        }
        //Checks if the type is empty
        if(empty($data['edit_task_type'])){
          $data['edit_task_type_error'] = 'Please select a task type';
        }
        //Checks if the start time is empty
        if(empty($data['edit_task_start_time'])){
          $data['edit_task_start_time_error'] = 'Please enter in a start time for the task';
        }
        //Checks if the end time is empty
        if(empty($data['edit_task_end_time'])){
          $data['edit_task_end_time_error'] = 'Please enter in a end time for the task';
        }
        //Checks if the start date is empty
        if(empty($data['edit_task_start_date'])){
          $data['edit_task_start_date_error'] = 'Please enter in a start date for the task';
        }
        //Checks if the end date is empty
        if(empty($data['edit_task_end_date'])){
          $data['edit_task_end_date_error'] = 'Please enter in a end date for the task';
        }
        //Checks if all the errors are empty
        if(empty($data['edit_task_name_error']) && empty($data['edit_task_type_error']) && empty($data['edit_task_start_time_error']) &&
           empty($data['edit_task_end_time_error']) && empty( $data['edit_task_start_date_error']) && empty( $data['edit_task_end_date_error'])){
          //Validate

          $validation = $this->taskHistoryModel->validateId($data['edit_task_id']);
          //Checks if the id inputed by the user was correct
          if(sizeof($validation) > 0){
            //Input New Task
            if($this->taskHistoryModel->editTask($data)){
              if($_SESSION['current_page'] == "TaskHistory"){
                redirect('TaskHistoryController/taskHistory');
  
              }elseif($_SESSION['current_page'] == "IndividualProject"){
                $link = 'IndividualProjectController/individualProject?projectId='. $_SESSION['current_project'];
  
                redirect($link);
  
              }else{
                $link = 'IndividualGroupController/individualGroup?groupId='. $_SESSION['current_group'];
  
                redirect($link);
              }

            }else{
                die('Something went Wrong');
            }

          }else{
            redirect('TaskHistoryController/taskHistory');
          }

        }else{
            //Load view with errors
            $_SESSION["taskEditErrors"] = $data;
            redirect('TaskHistoryController/taskHistory');
        }

      }
    }
  }