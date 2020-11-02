<?php 
    class NotificationModel{
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function getMissedTasks(){
            $this->db->query('SELECT * FROM tasks WHERE Task_End_Date <= CURDATE() && User_Id = :userId && Task_Completed = 0 ORDER BY Task_End_Date DESC ');

            $this->db->bind(':userId', $_SESSION['user_id']);

            $rows = $this->db->resultSet();

            return $rows;
        }

        public function getNotificationSetting(){
            $this->db->query('SELECT Notification_Display FROM users WHERE  User_Id = :userId');

             //bind values
            $this->db->bind(':userId', $_SESSION['user_id']);

            $row = $this->db->single();

            return $row;
        }

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

        public function checkNotifications(){
            $this->db->query('SELECT * FROM notifications WHERE User_Id = :userId');

            $this->db->bind(':userId', $_SESSION['user_id']);

            $rows = $this->db->resultSet();

            return $rows;
        }

        public function getNotifications(){
            $this->db->query('SELECT * FROM notifications WHERE User_Id = :userId && Notification_Viewed = 0 ORDER BY Notification_Date DESC ');

            $this->db->bind(':userId', $_SESSION['user_id']);

            $rows = $this->db->resultSet();

            return $rows;
        }

        public function setNotificationsViewed($notificationTaskId){
            $this->db->query('UPDATE notifications SET Notification_Viewed = :notificationViewed WHERE User_Id = :userId && Task_Id = :taskId');

            $this->db->bind(':notificationViewed', 1 );
            $this->db->bind(':taskId', $notificationTaskId );
            $this->db->bind(':userId', $_SESSION['user_id']);


            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }
    }