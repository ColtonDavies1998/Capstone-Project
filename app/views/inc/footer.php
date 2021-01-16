      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="<?php echo URLROOT; ?>/userController/logout">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo URLROOT; ?>/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo URLROOT; ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo URLROOT; ?>/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo URLROOT; ?>/js/sb-admin-2.js"></script>

  <!-- Page level plugins -->
  <script src="<?php echo URLROOT; ?>/vendor/chart.js/Chart.js"></script>

  <!-- Page level custom scripts -->
  <script src="<?php echo URLROOT; ?>/js/demo/chart-area-demo.js"></script>
  <script src="<?php echo URLROOT; ?>/js/demo/chart-pie-demo.js"></script>

  <script src="<?php echo URLROOT; ?>/js/main.js"></script>
  
  <?php if($_SESSION['current_page'] == 'TaskHistory' || $_SESSION['current_page'] == 'IndividualProject'):?>
    <!--Only for task history module -->
    <script src="<?php echo URLROOT; ?>/js/taskHistoryScript.js"></script>
  <?php endif;?>

  <?php if($_SESSION['current_page'] == 'MultipleProjects'):?>
    <script src="<?php echo URLROOT; ?>/js/multipleProjectsScript.js"></script>
  <?php endif;?>

  <?php if($_SESSION['current_page'] == 'Groups'):?>
    <script src="<?php echo URLROOT; ?>/js/groupsScript.js"></script>
  <?php endif;?>

  <?php 
    $date = new DateTime("now", new DateTimeZone($_SESSION["user_timezone"]) );    

  ?>

  
  <script>
  let notificationDisplay;
    let notifications;

    
    document.getElementById("notificationNumDisplay").addEventListener("click", function(){
     
      var notificationIcon = document.getElementById("notificationAlert");

      if(notificationIcon){
        notificationIcon.remove();
      }
      
      $.ajax({url: "<?php echo URLROOT; ?>/NotificationController/notificationsViewed" ,type: 'POST',data: {notifications: notifications}, async: false, success: function(result){
         
      }}) 

    }) 


    $.ajax({url: "<?php echo URLROOT; ?>/NotificationController/getNotificationSetting", async: false, success: function(result){
        let data = JSON.parse(result);
        

        if(parseInt(data.Notification_Display) == 0){
          notificationDisplay = false;
        }else{
          notificationDisplay = true;
        }
        
    }})

  
    if(notificationDisplay == true){
      $.ajax({url: "<?php echo URLROOT; ?>/NotificationController/getNotifications", async: false, success: function(result){
     
          let data = JSON.parse(result);
    
          notifications = data;
    
          if(data.length > 3){
            for(let j = 0; j < 3; j++){
              let dropdownItem = document.createElement("a");
              dropdownItem.classList.add("dropdown-item");
              dropdownItem.classList.add("d-flex");
              dropdownItem.classList.add("align-items-center");
              dropdownItem.classList.add("notification-dropdown-Item");
    
              let mr = document.createElement("div");
              mr.classList.add("mr-3");
    
              let iconCircle = document.createElement("div");
              iconCircle.classList.add("icon-circle");
              iconCircle.classList.add("bg-danger");
    
              let i = document.createElement("i");
              i.classList.add("fas");
              i.classList.add("fa-file-alt");
              i.classList.add("text-white");
    
              let nonClassDiv = document.createElement("div");
    
              let smallText = document.createElement("div");
              smallText.classList.add("small");
              smallText.classList.add("text-gray-500");
              smallText.innerText = data[j].Notification_Date;
          
    
              nonClassDiv.appendChild(smallText);
    
              let taskMissedDiv = document.createElement("div");
              taskMissedDiv.innerText = "Task '" + data[j].Notification_Message + " ' was not completed"
    
              nonClassDiv.appendChild(taskMissedDiv);
    
              iconCircle.appendChild(i);
    
              mr.appendChild(iconCircle);
    
              dropdownItem.appendChild(mr);
              dropdownItem.appendChild(nonClassDiv);
    
              document.getElementById("notificationSection").appendChild(dropdownItem);
    
            }
            //Create show all alerts
            let showAllTag = document.createElement("a");
              showAllTag.classList.add("dropdown-item");
              showAllTag.classList.add("text-center");
              showAllTag.classList.add("small");
              showAllTag.classList.add("text-gray-500");
              showAllTag.innerText = "Show All Alerts";
              
              showAllTag.addEventListener("click", function(){
                let notificationSetting = document.getElementById("notificationSection");

                while (notificationSetting.firstChild) {
                  notificationSetting.removeChild(notificationSetting.firstChild);
                }

                let dropdownHeader = document.createElement("h6");
                dropdownHeader.classList.add("dropdown-header");
                dropdownHeader.innerText = "Notifications"

                notificationSetting.appendChild(dropdownHeader);

                for(let z = 0; z < notifications.length; z++){

                  let dropdownItem = document.createElement("a");
                  dropdownItem.classList.add("dropdown-item");
                  dropdownItem.classList.add("d-flex");
                  dropdownItem.classList.add("align-items-center");
                  dropdownItem.classList.add("notification-dropdown-Item");
        
                  let mr = document.createElement("div");
                  mr.classList.add("mr-3");
        
                  let iconCircle = document.createElement("div");
                  iconCircle.classList.add("icon-circle");
                  iconCircle.classList.add("bg-danger");
        
                  let i = document.createElement("i");
                  i.classList.add("fas");
                  i.classList.add("fa-file-alt");
                  i.classList.add("text-white");
        
                  let nonClassDiv = document.createElement("div");
        
                  let smallText = document.createElement("div");
                  smallText.classList.add("small");
                  smallText.classList.add("text-gray-500");
                  smallText.innerText = data[z].Notification_Date;

        
                  nonClassDiv.appendChild(smallText);
        
                  let taskMissedDiv = document.createElement("div");
                  taskMissedDiv.innerText = "Task '" + data[z].Notification_Message + " ' was not completed"
        
                  nonClassDiv.appendChild(taskMissedDiv);
        
                  iconCircle.appendChild(i);
        
                  mr.appendChild(iconCircle);
        
                  dropdownItem.appendChild(mr);
                  dropdownItem.appendChild(nonClassDiv);
        
                  document.getElementById("notificationSection").appendChild(dropdownItem);
        
                  
                }
              });
    
              document.getElementById("notificationSection").appendChild(showAllTag);
    
              let totalNotificationCount = document.createElement("span");
              totalNotificationCount.classList.add("badge");
              totalNotificationCount.classList.add("badge-danger");
              totalNotificationCount.classList.add("badge-counter");
              totalNotificationCount.innerText = "3+";

              totalNotificationCount.setAttribute("id", "notificationAlert");
    
              document.getElementById("notificationNumDisplay").appendChild(totalNotificationCount);
    
          }else{
            for(let j = 0; j < data.length; j++){
              let dropdownItem = document.createElement("a");
              dropdownItem.classList.add("dropdown-item");
              dropdownItem.classList.add("d-flex");
              dropdownItem.classList.add("align-items-center");
              dropdownItem.classList.add("notification-dropdown-Item");
    
              let mr = document.createElement("div");
              mr.classList.add("mr-3");
    
              let iconCircle = document.createElement("div");
              iconCircle.classList.add("icon-circle");
              iconCircle.classList.add("bg-danger");
    
              let i = document.createElement("i");
              i.classList.add("fas");
              i.classList.add("fa-file-alt");
              i.classList.add("text-white");
    
              let nonClassDiv = document.createElement("div");
    
              let smallText = document.createElement("div");
              smallText.classList.add("small");
              smallText.classList.add("text-gray-500");
              smallText.innerText = data[j].Notification_Date;

    
              nonClassDiv.appendChild(smallText);
    
              let taskMissedDiv = document.createElement("div");
              taskMissedDiv.innerText = "Task '" + data[j].Notification_Message + " ' was not completed"
    
              nonClassDiv.appendChild(taskMissedDiv);
    
              iconCircle.appendChild(i);
    
              mr.appendChild(iconCircle);
    
              dropdownItem.appendChild(mr);
              dropdownItem.appendChild(nonClassDiv);
    
              document.getElementById("notificationSection").appendChild(dropdownItem);
    
              let totalNotificationCount = document.createElement("span");
              totalNotificationCount.classList.add("badge");
              totalNotificationCount.classList.add("badge-danger");
              totalNotificationCount.classList.add("badge-counter");
              totalNotificationCount.innerText = data.length;

              totalNotificationCount.setAttribute("id", "notificationAlert");
    
              document.getElementById("notificationNumDisplay").appendChild(totalNotificationCount);
            }
          }
            
        }});
    }else{
      let dropdownItem = document.createElement("a");
      dropdownItem.classList.add("dropdown-item");
      dropdownItem.classList.add("d-flex");
      dropdownItem.classList.add("align-items-center");
      dropdownItem.classList.add("notification-dropdown-Item");
    
      let mr = document.createElement("div");
      mr.classList.add("mr-3");
    
      let iconCircle = document.createElement("div");
      iconCircle.classList.add("icon-circle");
      iconCircle.classList.add("bg-secondary");
    
      let i = document.createElement("i");
      i.classList.add("fas");
      i.classList.add("fa-file-alt");
      i.classList.add("text-white");
    
      let nonClassDiv = document.createElement("div");
    
      let notificationDiv = document.createElement("div");
      notificationDiv.innerText = "Notifications have been turned off"
    
      nonClassDiv.appendChild(notificationDiv);
    
      iconCircle.appendChild(i);
    
      mr.appendChild(iconCircle);
    
      dropdownItem.appendChild(mr);
      dropdownItem.appendChild(nonClassDiv);
    
      document.getElementById("notificationSection").appendChild(dropdownItem);

    }


    $.ajax({url: "<?php echo URLROOT; ?>/FriendsListController/getNumberOfFriendRequests", async: false, success: function(result){
        let friendRequestCount = result;

        

        if(friendRequestCount != 0){
          let friendListBadge = document.createElement("span");
          friendListBadge.classList.add("badge");
          friendListBadge.classList.add("badge-danger");
          friendListBadge.classList.add("badge-counter");
          friendListBadge.innerText = friendRequestCount;

          document.getElementById("friendsListLink").appendChild(friendListBadge);
        }



    }})

    $.ajax({url: "<?php echo URLROOT; ?>/MessageController/checkForNewMessages", async: false, success: function(result){
        let messageCount = result;

        

        if(messageCount != 0){
          let messageCountBadge = document.createElement("span");
          messageCountBadge.classList.add("badge");
          messageCountBadge.classList.add("badge-danger");
          messageCountBadge.classList.add("badge-counter");
          messageCountBadge.innerText = messageCount;

          document.getElementById("messageNumDisplay").appendChild(messageCountBadge);
        }



    }})


  </script>


</body>

</html>