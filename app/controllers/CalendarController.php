<?php
  /* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */

  /**
   * CalendarController
   * 
   * 
   * @package    Controller
   * @author     Colton Davies
   */
  class CalendarController extends Controller {
     /**
       * 
       * This is the constructor for the class, a common theme for most constructors throughout the project
       * is that they just initialize the model that goes with the controller
       *
       */
    public function __construct(){
      $this->calendarModel = $this->model('CalendarModel');
    }
     /**
       * The calendar function is the main function called when accessing the page. It loads the 
       * view and all the data that is required for the view to run, this controller is smaller 
       * compared to other controllers since most of the calendar work is not is JS, all this controller 
       * does is access tasks to display on the calendar.
       *
       */
    public function calendar(){
      //Sets the session page to Calendar
      $_SESSION['current_page'] = 'Calendar';
      
      $data = [];
      //Directs to the view
      $this->view('calendar/Calendar', $data);
    }
    /**
     * The getUsersTasks gets all the tasks for the given user, and then echos them out to the page.
     * This function is only called using ajax from the Javascript so when the users changes the view 
     * of the calendar that is auto-updates the tasks
     */
    public function getUsersTasks(){
      //Get the tasks that have the users id and echo them to the screen
      $tasks = $this->calendarModel->getAllUsersTasks();

      echo json_encode($tasks);
    }

    

  
  }