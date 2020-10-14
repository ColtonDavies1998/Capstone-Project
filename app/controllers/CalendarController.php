<?php
  class CalendarController extends Controller {
    public function __construct(){
      $this->calendarModel = $this->model('CalendarModel');
    }

    public function calendar(){
      $_SESSION['current_page'] = 'Calendar';
      
      $data = [];
      
      $this->view('calendar/Calendar', $data);
    }

    public function getUsersTasks(){
      $tasks = $this->calendarModel->getAllUsersTasks();

      echo json_encode($tasks);
    }

    

  
  }