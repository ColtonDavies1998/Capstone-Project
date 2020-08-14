<?php
  class DashboardController extends Controller {
    public function __construct(){
      $this->userModel = $this->model('DashboardModel');
    }

    public function dashboard(){
      $_SESSION['current_page'] = 'Dashboard';
      
      $data['dailyTasks'] = $this->userModel->getDailyTasks();
      $data['taskCount'] = $this->userModel->totalDailyTasks();
      $data['projects'] = $this->userModel->getProjects();

      $numberOfCompleted = $this->userModel->totalDailyTasksCompleted();

      if($data['taskCount'] == 0){
        $data['taskCompletion'] = 100;
      }else{
        $data['taskCompletion'] = $numberOfCompleted / $data['taskCount'] * 100;
      }
      
      $this->view('dashboard/Dashboard', $data);
    }

    public function newTask(){
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

        //Validate Name
        if(empty($data['task_name'])){
          $data['task_name_error'] = 'Please enter a name for the task';
        }
        if(empty($data['task_type'])){
          $data['task_type_error'] = 'Please select a task type';
        }
        if(isset($data['startTimeInput'])){
          $data['task_start_time_error'] = 'Please enter in a start time for the task';
        }
        if(isset($data['endTimeInput'])){
          $data['task_end_time_error'] = 'Please enter in a end time for the task';
        }
        if(isset($data['startDateInput'])){
          $data['task_start_date_error'] = 'Please enter in a start date for the task';
        }
        if(isset($data['endDateInput'])){
          $data['task_end_date_error'] = 'Please enter in a end date for the task';
        }

        

        if(empty($data['task_name_error']) && empty($data['task_type_error']) && empty($data['task_start_time_error']) && empty($data['task_end_time_error'])
        && empty( $data['task_start_date_error']) && empty( $data['task_end_date_error'])){
          //Validate

          //Input New Task
          if($this->userModel->createNewTask($data)){
              redirect('dashboardController/dashboard');
          }else{
              die('Something went Wrong');
          }
         

        }else{
            //Load view with errors
            redirect('dashboardController/dashboard');
        }
        
      }

    }

    
    public function newProject(){
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
        if(empty($data['project_type'])){
          $data['project_type_error'] = 'Please enter a type for the project';
        }
        if(empty($data['project_description'])){
          $data['project_description_error'] = 'Please enter a description for the project';
        }


        if(empty($data['project_name_error']) && empty($data['project_type_error']) && empty($data['task_start_time_error']) && empty($data['project_description_error'])){

          //Input New Task
          if($this->userModel->createNewProject($data)){
            redirect('dashboardController/dashboard');
          }else{
            die('Something went Wrong');
          }

        }else{
          //Load view with errors
          $this->view('dashboard/Dashboard',$data);
        }


      }
    }

    function taskCompleteChange(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $id = $_POST['id'];

        $this->userModel->changeIncompleteTask($id);

      }
    }

  }