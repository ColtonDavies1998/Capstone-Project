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


            /*This function when called  sets the values of the inputs in the overlay, to the values
            of the row that was clicked*/
            function editTask(e) {

              //console.log(e.target.parentElement.parentElement.firstChild.innerText);
              
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
            
          
          </script>

<?php else: ?>
    <?php redirect('userController/login'); ?>
<?php endif;?>