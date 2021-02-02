<?php 
  /* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */

 /**
   * NotificationModel
   *
   * @author     Colton Davies
   */
    class NotificationModel{
        //Create private db variable
        private $db;

        /**
         * This constructor initializes the database and sets it to the private variable we created above. 
         * This is so it can be accessed throughout the class
         */
        public function __construct(){
            $this->db = new Database;
        }

        /**
       *
       * This method gets all the missed tasks of a given user, missed task being passed its end date
       * 
       * @return object
       */
        public function getMissedTasks(){
            $this->db->query('SELECT * FROM tasks WHERE Task_End_Date <= CURDATE() && User_Id = :userId && Task_Completed = 0 ORDER BY Task_End_Date DESC ');

            $this->db->bind(':userId', $_SESSION['user_id']);

            $rows = $this->db->resultSet();

            return $rows;
        }

        /**
         * This gets the users notification display preference (to display notifications or not)
         * 
         * @return object
         */
        public function getNotificationSetting(){
            $this->db->query('SELECT Notification_Display FROM users WHERE  User_Id = :userId');

             //bind values
            $this->db->bind(':userId', $_SESSION['user_id']);

            $row = $this->db->single();

            return $row;
        }

        /**
         *
         *This method inserts a new notification into the database
         * 
         * @param string $missedTask  the missed task
         * @param string $notificationType  the type of notification being created
         * @return boolean
         */
        public function createMissedTaskNotification($missedTask, $notificationType){
            $this->db->query('INSERT INTO notifications (Notification_Type, Notification_Time, Notification_Date, Notification_Viewed, Notification_Message, Task_Id ,User_Id) 
            VALUES(:notificationType, :notificationTime, :notificationDate, :notificationViewed, :notificationMessage, :taskId ,:userId )');
            //bind values
            $this->db->bind(':notificationType', $notificationType);
            $this->db->bind(':notificationTime', $missedTask->Task_End_Time);
            $this->db->bind(':notificationDate', $missedTask->Task_End_Date);
            $this->db->bind(':notificationViewed', 0);
            $this->db->bind(':notificationMessage', $missedTask->Task_Name);
            $this->db->bind(':taskId', $missedTask->Task_Id);
            $this->db->bind(':userId', $_SESSION['user_id']);


            //call execute if you want to insert
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

        /**
         *
         * This method checks the database for notifications
         * 
         * 
         * @return object
         */
        public function checkNotifications(){
            $this->db->query('SELECT * FROM notifications WHERE User_Id = :userId');
            //bind
            $this->db->bind(':userId', $_SESSION['user_id']);
            //execute
            $rows = $this->db->resultSet();

            return $rows;
        }

        /**
         *
         * this gets all the notifications for the user that are not viewed
         * 
         * @return object
         */
        public function getNotifications(){
            $this->db->query('SELECT * FROM notifications WHERE User_Id = :userId && Notification_Viewed = 0 ORDER BY Notification_Date DESC ');
            //binds
            $this->db->bind(':userId', $_SESSION['user_id']);
            //executes
            $rows = $this->db->resultSet();
            
            return $rows;
        }

       /**
         *
         *Sets the notification to being viewed
         * 
         * @param string $notificationTaskId  individual notification id
         * @return boolean
         */
        public function setNotificationsViewed($notificationTaskId){
            $this->db->query('UPDATE notifications SET Notification_Viewed = :notificationViewed WHERE User_Id = :userId && Task_Id = :taskId');
            //bind
            $this->db->bind(':notificationViewed', 1 );
            $this->db->bind(':taskId', $notificationTaskId );
            $this->db->bind(':userId', $_SESSION['user_id']);

            //Execute
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }
    }