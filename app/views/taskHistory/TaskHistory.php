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
            var tableHeads = ["Id", "Name", "Start Time", "Type", "Date","Priority", "Completed", "Edit", "Remove"];
            var objectFields = ["Task_Id", "Task_Name","Task_Start_Time", "Task_End_Time" ,"Task_Start_Date", "Task_End_Date","Task_Completed"];
            var sourceId = document.getElementById("table");
           
            
            $.ajax({url: "<?php echo URLROOT; ?>/TaskHistoryController/getUsersTasks", async: false, success: function(result){
                console.log(JSON.parse(result));
                
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

            
          
          </script>

<?php else: ?>
    <?php redirect('userController/login'); ?>
<?php endif;?>