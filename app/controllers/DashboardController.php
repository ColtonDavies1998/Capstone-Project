<?php
  /* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */
  /**
   * DashboardController
   * 
   * 
   * @package    Controller
   * @author     Colton Davies
   */
  class DashboardController extends Controller {
  /**
    * 
    * This is the constructor for the class, a common theme for most constructors throughout the project
    * is that they just initialize the model that goes with the controller
    *
    */
    public function __construct(){
      $this->userModel = $this->model('DashboardModel');
    }

    /**
     * The dashboard function is the function that is called when accessing the page, 
     * it links to the dashboard view page and gets all the data required for the view to work.
     */
    public function dashboard(){
      //Sets the current_page session variable to Dashboard
      $_SESSION['current_page'] = 'Dashboard';
      //Sets the Dashboard calendar and project display these are the on the users profile and say if the user wants 
      //the calendar and or project to be displayed on tehir dashboard
      $_SESSION['Dashboard_Calendar_Display'] = $this->userModel->Dashboard_Calendar_Display();
      $_SESSION['Dashboard_Projects_Display'] = $this->userModel->Dashboard_Projects_Display();
      //Gets the daily tasks and stores them
      $data['dailyTasks'] = $this->userModel->getDailyTasks();
      //Gets the number of tasks for that day
      $data['taskCount'] = $this->userModel->totalDailyTasks();
      //Gets a list of all the users projects
      $data['projects'] = $this->userModel->getProjects();
      
      //Gets the number of daily tasks completed
      $numberOfCompleted = $this->userModel->totalDailyTasksCompleted();

      //If the total tasks for the day is 0 then the compleition % is 100 percent else the percent is calculated
      if($data['taskCount'] == 0){
        $data['taskCompletion'] = 100;
      }else{
        $data['taskCompletion'] = $numberOfCompleted / $data['taskCount'] * 100;
      }
      //Loads the view with the data gathered from this method
      $this->view('dashboard/Dashboard', $data);
    }

    /**
     * The newTask method is called when the user wants to create a new task. On the dashboard
     * there is a form to create a new task, that form loads into this method. The method validates
     * the input from the form and checks if it is valid, if it is valid then a task is created and 
     * stored in the database if not then the dashboard method is loaded and the errors are displayed 
     * on the page.
     */
    public function newTask(){
      //Checks if the request is a post
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
          'task_name_error' => '',
          'task_type_error' => '',
          'task_start_time_error'=> '',
          'task_end_time_error' => '',
          'task_start_date_error' => '',
          'task_end_date_error' => ''
        ];

        //Checks if task name is empty
        if(empty($data['task_name'])){
          $data['task_name_error'] = 'Please enter a name for the task';
        }
        //Checks if task type is empty
        if(empty($data['task_type'])){
          $data['task_type_error'] = 'Please select a task type';
        }
        //Checks if the start time is empty
        if(empty($data['task_start_time'])){
          $data['task_start_time_error'] = 'Please enter in a start time for the task';
        }else{
          //makes sure the minutes are in 5 minute intervals
          $roundedStartMinutes = $this->roundMinutes($data['task_start_time']);
          $tempStartTime = explode(":", $data['task_start_time']);
          //Checks for rounding     
          if($roundedStartMinutes >= 60){
            $roundedStartMinutes = "55";
          }
          
          if($roundedStartMinutes < 10){
            $data['task_start_time'] = $tempStartTime[0] . ":" . $roundedStartMinutes;
          }else{
            $data['task_start_time'] = $tempStartTime[0] . ":" . $roundedStartMinutes;
          }
        }
        //Checks if the end time is empty
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
        //Checks if start date is empty
        if(empty($data['task_start_date'])){
          $data['task_start_date_error'] = 'Please enter in a start date for the task';
        }
        //Check if end date is empty
        if(empty($data['task_end_date'])){
          $data['task_end_date_error'] = 'Please enter in a end date for the task';
        }


        //Checks the difference in days when start and end. If the end date starts before the start date then throw and error
        $dateDifference = date_diff(date_create($data['task_start_date']), date_create($data['task_end_date']));
        $dateDifference = $dateDifference->format('%R%a');
        $dateDifference = intval($dateDifference);
        //If the start date is after the end date then throw and error
        if($dateDifference < 0){
          $data['task_start_date_error'] = 'The start date cannot be after the end date';
          $data['task_end_date_error'] = 'The end date cannot be before the start date ';
        }
        //If data different is 0 it means the task start and end date is the same date so time to check the times
        if($dateDifference == 0){
          //check the time difference
          $to_time = strtotime($data['task_end_time']);
          $from_time = strtotime($data['task_start_time']);
          $timeDifference = round(($to_time - $from_time) / 60,2);
          //If the time difference is not greater than 0 throw an error
          if($timeDifference < 0){
            $data['task_start_time_error'] = 'Start time cannot be before end time of a task if they are on the same day';
          }elseif($timeDifference == 0){
            $data['task_start_time_error'] = 'Start time cannot be at the same time as the end of the time';
          }

        }
        //If all the error sections of data are empty it means everything is good to go and the item is inserted into the database.
        //If not then the session error is loaded
        if(empty($data['task_name_error']) && empty($data['task_type_error']) && empty($data['task_start_time_error']) && empty($data['task_end_time_error'])
        && empty( $data['task_start_date_error']) && empty( $data['task_end_date_error'])){
          //Validated call the model and create the task Input New Task
          if($this->userModel->createNewTask($data)){
              redirect('dashboardController/dashboard');
          }else{
              //For testing purposes
              die('Something went Wrong');
          } 
        }else{
            //Load view with errors
            $_SESSION['errorData'] = $data;
            redirect('dashboardController/dashboard');
        }
        
      }

    }

    /**
     * The newProject method is called when the user wants to create a new project of course.
     *  On the dashboard page, there is also a way to create a new project, there is a small 
     * form that the user can input all the data required, and then it is submitted to this method. 
     * If there are no errors then a project is created else errors are set displayed on the view.
     */
    public function newProject(){
      //Checks if the request is a post request
      if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        //Init Data
        $data = [
          'project_name'=> trim($_POST['projectNameInput']),
          'project_type'=> trim($_POST['projectTypeInput']),
          'project_description'=> trim($_POST['projectDescriptionInput']),
          'project_name_error' => '',
          'project_type_error' => '',
          'project_description_error'=> ''
        ];

        //Validate Project Name
        if(empty($data['project_name'])){
          $data['project_name_error'] = 'Please enter a name for the project';
        }
        //Checks if the project type is empty
        if(empty($data['project_type'])){
          $data['project_type_error'] = 'Please enter a type for the project';
        }
        //Checks if the project description is empty
        if(empty($data['project_description'])){
          $data['project_description_error'] = 'Please enter a description for the project';
        }

        //If all the error colums of the data array are empty it means a new project can be created else load errors
        if(empty($data['project_name_error']) && empty($data['project_type_error']) && empty($data['task_start_time_error']) && empty($data['project_description_error'])){

          //Input New Task
          if($this->userModel->createNewProject($data)){
            redirect('dashboardController/dashboard');
          }else{
            //For testing purposes
            die('Something went Wrong');
          }

        }else{
          //Load view with errors   
          $_SESSION['projectErrorData'] = $data;
          redirect('dashboardController/dashboard');
        }


      }
    }
    /**
     * The taskCompleteChange is called when the user clicks to complete a task on the dashboard page. 
     * See the Dashboard displays a list of tasks for the day, the user can then complete those tasks 
     * by clicking a button. That button makes an ajax call to this function passing through the ID and 
     * this function calls the model to change the task to being completed from 0 to 1
     */
    function taskCompleteChange(){
      //Makes sure the request is a post request
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //Gets the id being passed through
        $id = $_POST['id'];
        //Calls the model and passes through the Id
        $this->userModel->changeIncompleteTask($id);

      }
    }
      /**
       * 
       * roundMinutes method takes in a time string and rounds the minutes, this is used when 
       * calculating things like the time difference.
       *
       * @param string $timestring  string
       * @return number
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