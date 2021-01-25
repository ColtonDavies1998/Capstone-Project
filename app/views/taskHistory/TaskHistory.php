<?php if(isset($_SESSION['user_id'])): ?>
   <!--NOTE
    Still have to add the php code to edit and delete a task
    The time on the edit is not matching with the code
    -->
    <?php require APPROOT . '/views/inc/header.php'; ?>

    <!-- Sidebar -->
    <?php require APPROOT . '/views/inc/sideNav.php'; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php require APPROOT . '/views/inc/topNav.php'; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->

          <!--====================MY CODE==================-->

          <h1 class="h3 mb-4 text-gray-800">Task History</h1>
          
          <div id="searchBar"></div>
          
          <!--Number of items per page-->
          
          <div id="numOfItemsDisplay"></div>
          
          <!--Table-->
          <table id="table" class="table"></table>
          
          <hr>
          
          <ul class="pagination" id="pagination"></ul>

          

          <!--====================END OF MY CODE==================-->

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <?php require APPROOT . '/views/inc/footer.php'; ?>

      <script>


             /*This function when called  sets the values of the inputs in the overlay, to the values
            of the row that was clicked*/
            function editTask(e) {
              
              var http = new XMLHttpRequest();
              var url = '<?php echo URLROOT; ?>/TaskHistoryController/getSingleTaskInfo';
              var params = 'id=' + e.target.parentElement.parentElement.firstChild.innerText;
              http.open('POST', url, true);

              //Send the proper header information along with the request
              http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

              http.onreadystatechange = function() {//Call a function when the state changes.
                  if(http.readyState == 4 && http.status == 200) {
                    
                      var info = JSON.parse(http.responseText);

                      document.getElementById("editTaskNameOverlay").style.display = "block";

                      document.getElementById("taskNameEdit").value = info.Task_Name;  

                      document.getElementById("taskId").value = info.Task_Id; 

                      document.getElementById("startDateInput").value =  info.Task_Start_Date;

                      document.getElementById("endDateInput").value =  info.Task_End_Date;

                      document.getElementById("startTimeInput").value = info.Task_Start_Time;

                      document.getElementById("endTimeInput").value = info.Task_End_Time;

                      if(info.Task_Type == "Work"){
                        document.getElementById("taskTypeInput").selectedIndex = "0";
                      }else if(info.Task_Type == "Education"){
                        document.getElementById("taskTypeInput").selectedIndex = "1";
                      }else if(info.Task_Type == "Home"){
                        document.getElementById("taskTypeInput").selectedIndex = "2";
                      }else if(info.Task_Type == "Chores"){
                        document.getElementById("taskTypeInput").selectedIndex = "3";
                      }else{
                        document.getElementById("taskTypeInput").selectedIndex = "4";
                      }

                     

                      if(info.Task_Completed == 1){
                          document.getElementById("CompletedRadio1").checked = true;
                      }else{
                          document.getElementById("CompletedRadio2").checked = true;
                      }

                  }
              }
              http.send(params);

            }


            var tableHeads = ["Id", "Name", "Start Time", "End Time", "Start Date","End Date", "Task Type" , "Completed", "Edit", "Remove"];
            var objectFields = ["Task_Id", "Task_Name","Task_Start_Time", "Task_End_Time" ,"Task_Start_Date", "Task_End_Date", "Task_Type","Task_Completed"];
            var sourceId = document.getElementById("table");
           
            
            $.ajax({url: "<?php echo URLROOT; ?>/TaskHistoryController/getUsersTasks", async: false, success: function(result){
                
                
              var table = new Table(JSON.parse(result), {
              tableHeaders: tableHeads,
              tableId: sourceId,
              fields: objectFields,
              numOfItemsDropdownDisplay: {
                display: true,
                numberList: ["5", "10", "15", "25"]
              },
              searchBarDisplay: true,
              specialButtons: [
                {
                  btnName: "edit",
                  btnClasses: ["btn", "btn-warning"],
                  text: "Edit"
                },
                {
                  btnName: "delete",
                  btnClasses: ["btn", "btn-danger", "deleteButtons"],
                  text: "Delete"
                }
              ]
            });

            table.createTable();
                
            }});
            
      
          //The eventListeners for the edit and deletion button for when they are clicked.
          document.getElementById("cancelDelete").addEventListener("click", cancelDeletion);
          document.getElementById("cancelEdit").addEventListener("click", cancelEditTask);

          //eventListener with built in function to add eventlisteners to the edit and delete
          //buttons for when the table re displays them when the user uses the searchbar and dropdown
          document.getElementById("searchName").addEventListener("keyup", function(){
            addPageItemListener();
            firstEditEvents();
            firstDeleteEvents();
          });
          document.getElementById("NumberDropdown").addEventListener("change", function(){
            addPageItemListener();
            firstEditEvents();
            firstDeleteEvents();
          });

          /*This function gets all the page items in the UL except for the buttons that are disabled
          and every time one of them are clicked  they automatically add the addEventLsiteners for the
          edit delete and new Ul pagination items*/
          function addPageItemListener() {
            var paginationItems = document.getElementsByClassName("page-item");

            for (var i = 0; i < paginationItems.length; i++) {
                if (!paginationItems[i].classList.contains("disabled")) {
                    paginationItems[i].addEventListener("click", loadDeleteFunctions);
                    paginationItems[i].addEventListener("click", loadEditFunctions);
                    paginationItems[i].addEventListener("click", addPageItemListener);
                }
            }
          }

          /*This function is called when the page first loads and it adds the eventListeners to the delete
          buttons that are displayed first */
          function firstDeleteEvents() {
            var deleteButtons = document.getElementsByClassName("deleteButtons");

            for (var i = 0; i < deleteButtons.length; i++) {
                deleteButtons[i].addEventListener("click", deleteTask);  
            }
          }

          /*This function adds eventListner to delete buttons */
          function loadDeleteFunctions() {
            var deleteButtons = document.getElementsByClassName("deleteButtons");
            for (var i = 0; i < deleteButtons.length; i++) {
                deleteButtons[i].addEventListener("click", deleteTask);
            }
          }

          //displays the delete task overlay
          function deleteTask(e) {
           
            document.getElementById("deleteValueId").value = e.target.parentElement.parentElement.firstChild.innerText.toString();
            document.getElementById("confirmationOverlay").style.display = "block";
          }

          //This button hides the delete project overlay
          function cancelDeletion() {
            document.getElementById("confirmationOverlay").style.display = "none";
          }

          //This function is called when the cancel button is clicked on the edit overlay and it hides it
          function cancelEditTask(){
            /*
            document.getElementById("taskNameEdit").classList.remove("is-invalid");
            document.getElementById("startTimeInput").classList.remove("is-invalid");
            document.getElementById("endTimeInput").classList.remove("is-invalid");
            document.getElementById("taskTypeInput").classList.remove("is-invalid");
            document.getElementById("startDateInput").classList.remove("is-invalid");
            document.getElementById("endDateInput").classList.remove("is-invalid"); */
            
            document.getElementById("editTaskNameOverlay").style.display = "none";
          }

          /*This function is called when the page first loads and it adds the eventListeners to the edit
          buttons that are displayed first */
          function firstEditEvents() {
            var editButtons = document.getElementsByClassName("btn-warning");
            for (var i = 0; i < editButtons.length; i++) {
                editButtons[i].addEventListener("click", editTask);
            }
          }

          /*This function when called adds eventListeners to the edit buttons */
          function loadEditFunctions() {
            var editButtons = document.getElementsByClassName("btn-warning");
            for (var i = 0; i < editButtons.length; i++) {
                editButtons[i].addEventListener("click", editTask);
            }
          }


          /*This function when called takes a parameter of the time from the row clicked. and then converts
          the time to something the input tag can read */
          function convertTime(time){
              //This goes from hour format to hh/mm format
              var timeArr = time.split(" ");
              var tempNumber = parseInt(timeArr[0]);
              if (timeArr[1] == "am" || timeArr[1] == "AM") {
                if (tempNumber < 10) {
                  return ("0" + timeArr[0] + ":" + "00");
                } else {
                  return (timeArr[0] + ":" + "00");
                }

              } else {
                var tempNum = parseInt(timeArr[0]);
                switch (tempNum) {
                  case 1:
                    return ("13" + ":" + "00");
                  case 2:
                    return ("14" + ":" + "00");
                  case 3:
                    return ("15" + ":" + "00");
                  case 4:
                    return ("16" + ":" + "00");
                  case 5:
                    return ("17" + ":" + "00");
                  case 6:
                    return ("18" + ":" + "00");
                  case 7:
                    return ("19" + ":" + "00");
                  case 8:
                    return ("20" + ":" + "00");
                  case 9:
                    return ("21" + ":" + "00");
                  case 10:
                    return ("22" + ":" + "00");
                  case 11:
                    return ("23" + ":" + "00");
                  case 12:
                    return ("00" + ":" + "00");
                }
              }
          }

          /*This function when called takes 1 parameter which is the date from the  row clicked. It then
          converts that date into something that the input tag can read*/
          function convertDate(formatString, date){
            var months = new Array();
            months[0] = "January";
            months[1] = "February";
            months[2] = "March";
            months[3] = "April";
            months[4] = "May";
            months[5] = "June";
            months[6] = "July";
            months[7] = "August";
            months[8] = "September";
            months[9] = "October";
            months[10] = "November";
            months[11] = "December";

            //This goes from mm/dd/yyyy format to month/dd/yyyy format
            if (formatString == "mm/dd/yyyy") {
              var dateArr = date.split(" ");
              var tempNum = parseInt(dateArr[0]);
              tempNum--;

              var day = parseInt(dateArr[1]);

              if (day < 10) {
                return (months[tempNum] + " " + "0" + dateArr[1] + " " + dateArr[2]);
              } else {
                return (months[tempNum] + " " + dateArr[1] + " " + dateArr[2]);
              }

            }
            //This goes from month/dd/yyyy format to mm/dd/yyyy format
            else if (formatString == "month/dd/yyyy") {
              var dateArr = date.split(" ");
              for (var i = 0; i < months.length; i++) {
                if (dateArr[0] == months[i]) {
                  var tempMonthNumber = i + 1;
                  break;
                }
              }
              if (tempMonthNumber < 10) {  
                if(dateArr[1] < 10){
                    return (dateArr[2] + "-" + "0" + tempMonthNumber.toString() + "-" + "0" + dateArr[1]);
                }else{
                    return (dateArr[2] + "-" + "0" + tempMonthNumber.toString() + "-" + dateArr[1]);
                }
                
              } else {
                if(dateArr[1] < 10){
                    return (dateArr[2] + "-" + tempMonthNumber.toString() + "-" + "0" + dateArr[1]);
                }else{
                    return (dateArr[2] + "-" + tempMonthNumber.toString() + "-" + dateArr[1]);
                }
                
              }
            }
          }

          function frontEndValidation(TaskName, TaskStartTime, TaskType, TaskDate, TaskPriority){
            var isValid = true;
            if (TaskName.length == 0) {
              isValid = false;
              document.getElementById("taskNameEdit").classList.add("is-invalid");
              //document.getElementById("TaskNameResponse").classList.add("invalid-feedback");
            } else {
              document.getElementById("taskNameEdit").classList.remove("is-invalid");
            }
            if (TaskStartTime.length == 0) {
              isValid = false;
              document.getElementById("startTimeInput").classList.add("is-invalid");

            } else {
              document.getElementById("startTimeInput").classList.remove("is-invalid");
            }
            if (TaskType.length == 0) {
              isValid = false;
              document.getElementById("taskTypeInput").classList.add("is-invalid");
            } else {
              document.getElementById("taskTypeInput").classList.remove("is-invalid");
            }
            if (TaskDate.length == 0) {
              isValid = false;
              document.getElementById("taskDateInput").classList.add("is-invalid");
            } else {
              document.getElementById("taskDateInput").classList.remove("is-invalid");
            }
            if (TaskPriority.length == 0) {
              isValid = false;
              document.getElementById("priorityInput").classList.add("is-invalid");
            } else {
              document.getElementById("priorityInput").classList.remove("is-invalid");
            }

            return isValid;
          }


          firstEditEvents();
          firstDeleteEvents();
          addPageItemListener();




          
          </script>

<?php else: ?>
    <?php redirect('userController/login'); ?>
<?php endif;?>