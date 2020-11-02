<?php

  class NotificationController extends Controller {
    public function __construct(){
        $this->notificationModel = $this->model('NotificationModel');
    }

    public function getNotifications(){
        $missedTasks = $this->notificationModel->getMissedTasks();

        $notificationType = "Missed Task";

        $checkNotifications = $this->notificationModel->checkNotifications();


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

        $notifications = $this->notificationModel->getNotifications();


        echo  json_encode($notifications);
    }

    public function getNotificationSetting(){
      $notificationDisplay = $this->notificationModel->getNotificationSetting();


      echo  json_encode($notificationDisplay);
    }

    public function notificationsViewed(){
      $notificationsViewed = $_POST["notifications"];

      
      foreach($notificationsViewed as $notification){
        $this->notificationModel->setNotificationsViewed($notification["Task_Id"]);
      }

      var_dump($notificationsViewed);

      echo  json_encode($notificationsViewed);
    }
  }