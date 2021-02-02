<?php
  /* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */

 /**
   * NotificationController
   * 
   * 
   * @package    Controller
   * @author     Colton Davies
   */
  class NotificationController extends Controller {

    /**
    * 
    * This is the constructor for the class, a common theme for most constructors throughout the project
    * is that they just initialize the model that goes with the controller
    *
    */
    public function __construct(){
        $this->notificationModel = $this->model('NotificationModel');
    }

    /**
     * This controller does not have a main page like the other controllers, 
     * it is used using Ajax calls whenever the header and footer loads. They 
     * call this method to get the notifications that the user has
     */
    public function getNotifications(){
        //Gets the missed tasks
        $missedTasks = $this->notificationModel->getMissedTasks();
        //Notification type (this is if wanted to add different notifications after the capstone project)
        $notificationType = "Missed Task";
        //Gets the notifications that have been checked
        $checkNotifications = $this->notificationModel->checkNotifications();

        //Runs a through a for each loop and compares notification Id to the missed task id
        foreach($missedTasks as $missedTask){
          $matchFound = false;
          foreach($checkNotifications as $notification){
            if($missedTask->Task_Id == $notification->Task_Id){
              $matchFound = true;
              break;
            }
          }
          if($matchFound == false){
            $this->notificationModel->createMissedTaskNotification($missedTask, $notificationType);
          }
        }
        //Gets notifications
        $notifications = $this->notificationModel->getNotifications();

        //echos out a json encoded array
        echo  json_encode($notifications);
    }

    /**
     * Gets the notification setting seeing if the notification should even be displayed
     */
    public function getNotificationSetting(){
      $notificationDisplay = $this->notificationModel->getNotificationSetting();


      echo  json_encode($notificationDisplay);
    }

    /**
     * the notificationViewed method is called when the user clicks on the notification 
     * button when there are notifications. What this does is it takes all the notifications 
     * that have not been viewed and sets them as viewed.
     */
    public function notificationsViewed(){
      //Gets notifications
      $notificationsViewed = $_POST["notifications"];

      //Runs through the notifications and sets them to viewed
      foreach($notificationsViewed as $notification){
        $this->notificationModel->setNotificationsViewed($notification["Task_Id"]);
      }

      echo  json_encode($notificationsViewed);
    }
  }