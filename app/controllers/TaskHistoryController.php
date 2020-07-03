<?php
  class TaskHistoryController extends Controller {
    public function __construct(){
        $this->taskHistoryModel = $this->model('TaskHistoryModel');
    }

    public function taskHistory(){
        $_SESSION['current_page'] = 'TaskHistory';

        $data = [];

        $this->view('taskHistory/TaskHistory', $data);
    }

    public function getUsersTasks(){
        $tasks = $this->taskHistoryModel->getAllUsersTasks();

        echo json_encode($tasks);
    }

    public function getSingleTaskInfo(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $id = $_POST['id'];

        $info = $this->taskHistoryModel->getTaskInfo($id);

        echo  json_encode($info);
       
      }
    }

    public function deleteTask(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $taskId = trim($_POST['deleteId']);

        

        if($this->taskHistoryModel->deleteTask($taskId)){
          flash('task_message', 'Post Removed');
          redirect('TaskHistoryController/taskHistory');

        }else{
          die('something went wrong');
        }
      }else{
        redirect('TaskHistoryController/taskHistory');
      }
    }

    public function editTask(){
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

        //Validate Name
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

        if(empty($data['edit_task_name_error']) && empty($data['edit_task_type_error']) && empty($data['edit_task_start_time_error']) &&
           empty($data['edit_task_end_time_error']) && empty( $data['edit_task_start_date_error']) && empty( $data['edit_task_end_date_error'])){
          //Validate

          //Input New Task
          if($this->taskHistoryModel->editTask($data)){
            redirect('TaskHistoryController/taskHistory');
          }else{
              die('Something went Wrong');
          }
         

        }else{
            //Load view with errors
            $this->view('TaskHistoryController/taskHistory',$data);
        }

      }
    }
  }