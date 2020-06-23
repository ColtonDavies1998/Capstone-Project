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
  }