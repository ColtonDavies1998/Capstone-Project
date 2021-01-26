<!-- 
    - There still might be an issue with the bootstrap row when there is less than 3 items displying, check it out later.

-->
<?php if($data["actualUsersProject"] == true): ?>
    <?php if(isset($_SESSION['user_id'])): ?>
 
    <?php require APPROOT . '/views/inc/header.php'; ?>

    <?php if(isset($_SESSION['fileErrorData'])):?>
        <style>
            #confirmationOverlay{
                display: block;
            }
        </style>
    <?php endif;?>

    <?php require APPROOT . '/views/inc/sideNav.php'; ?>


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

        <!-- Topbar -->
        <?php require APPROOT . '/views/inc/topNav.php'; ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">


            <!-- Page Heading -->            
            <h1 id="projectHeading" class="h3 mb-0 text-gray-800"><?php echo $data["projectInformation"]->Project_Name;?> <a class="addFileBtn" id="addFileBtn">+</a></h1>
       

            <!-- Content Row -->
            <div class="row">
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4" id="taskDisplayBtn">
                    <div class="card border-primary shadow h-100 py-2" id="taskBtnBorder">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-lg font-weight-bold text-primary text-uppercase mb-1" id="taskBtnText">Task Display</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tasks fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4" id="projectFilesBtn">
                <div class="card shadow h-100 py-2" id="fileBtnBorder">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-lg font-weight-bold text-uppercase mb-1" id="fileBtnText">Project Files</div>
                            </div>
                            <div class="col-auto">     
                                <i class="fas fa-file fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="taskDisplay">
            <!-- Content Row -->
            <div class="row">
                <div class="col-xl-7 col-lg-6">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Incomplete Projects Tasks</h6>
                            
                        </div>
                    <!-- Card Body -->
                    <div class="card-body" style="overflow-y:scroll;height: 450px; ">
                        <div class="list-group" >
                            <?php foreach($data['projectsTasks'] as $tasks):?>
                                <?php if($tasks->Task_Completed == 0):?>
                                    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start ">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1"><?php echo $tasks->Task_Name; ?></h5>
                                            <small><b>Start Time: </b><?php echo militaryToCivilianTime($tasks->Task_Start_Time); ?></small> 
                                            <small><b>End Time: </b><?php echo militaryToCivilianTime($tasks->Task_End_Time); ?></small>
                                        </div>
                                        <?php if($tasks->Task_Completed == 0):?>
                                            <form action="<?php echo URLROOT;?>/IndividualProjectController/incompleteToComplete" method="post">
                                                <input type="hidden" name="taskId" value="<?php echo $tasks->Task_Id ?>">
                                                <input type="submit" value="Incomplete" class="mb-1 btn btn-danger singleTask">
                                            </form>
                                        <?php else: ?>
                                            <form action="<?php echo URLROOT;?>/IndividualProjectController/completeToIncomplete" method="post">
                                                <input type="hidden" name="taskId" value="<?php echo $tasks->Task_Id ?>">
                                                <input type="submit" value="Completed" class="mb-1 btn btn-success singleTask">
                                            </form>

                                        <?php endif;?>

                                        
                                        
                                    </a>
                                <?php endif;?>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>

            <div class=" col-xl-5 col-lg-6 mb-4">
                <!-- Illustrations -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Create New Task</h6>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo URLROOT;?>/IndividualProjectController/createNewTask" method="post">
                        <div class="form-group">
                            <label for="nameInput">Task Name</label>
                            <input type="hidden" class="form-control" name="idInput" id="idInput" value="<?php echo $_SESSION['current_project'];?>">
                            <input type="text" class="form-control" name="nameInput" id="nameInput"  placeholder="Enter Name">
                            <?php if(isset($_SESSION['errorData']['task_name_error'])): ?>
                            <span class="text-danger"> <?php echo $_SESSION['errorData']['task_name_error'] ?> </span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="typeInput">Task Type</label>
                            <select class="form-control" id="typeInput" name="typeInput">
                            <option value="Work">Work</option>
                            <option value="Education">Education</option>
                            <option value="Home">Home</option>
                            <option value="Chores">Chores</option>
                            <option value="Other">Other</option>
                            </select>
                            <?php if(isset($_SESSION['errorData']['task_type_error'])): ?>
                            <span class="text-danger"> <?php echo $_SESSION['errorData']['task_type_error'] ?> </span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="startTimeInput">Start Time</label>
                            <input type="time" class="form-control" name="startTimeInput" id="startTimeInput" step="300">
                            <?php if(isset($_SESSION['errorData']['task_start_time_error'])): ?>
                            <span class="text-danger"> <?php echo $_SESSION['errorData']['task_start_time_error'] ?> </span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="endTimeInput">End Time</label>
                            <input type="time" class="form-control" name="endTimeInput" id="endTimeInput" step="300" >
                            <?php if(isset($_SESSION['errorData']['task_end_time_error'])): ?>
                            <span class="text-danger"> <?php echo $_SESSION['errorData']['task_end_time_error'] ?> </span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="startDateInput">Start Date</label>
                            <input type="date" class="form-control" name="startDateInput" id="startDateInput" >
                            <?php if(isset($_SESSION['errorData']['task_start_date_error'])): ?>
                            <span class="text-danger"> <?php echo $_SESSION['errorData']['task_start_date_error'] ?> </span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="endDateInput">End Date</label>
                            <input type="date" class="form-control" name="endDateInput" id="endDateInput"  >
                            <?php if(isset($_SESSION['errorData']['task_end_date_error'])): ?>
                            <span class="text-danger"> <?php echo $_SESSION['errorData']['task_end_date_error'] ?> </span>
                            <?php endif; ?>
                        </div>

                        <input id="formButton"  type="submit" value="Create" class="btn btn-success" >

                        </form>
                    </div>
                </div>
            </div>
        </div>

            <!-- Content Row -->
            <div class="row">
                <div class="col-xl-7 col-lg-6">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">All Project Tasks</h6>
                            </div>
                        <!-- Card Body -->
                        <div class="card-body" style="overflow-y:scroll;height: 450px; ">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <table id="table" class="table"></table>
                                </div>    
                            </div>
                            
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <ul class="pagination" id="pagination"></ul>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div id="fileDisplay">
        <?php $counter = 1;?>
       <?php if(sizeof($data["projectFiles"]) > 0): ?>
        <?php foreach($data['projectFiles'] as $file): ?>
            <?php if($counter == 1):?><div class="row"> <?php endif;?>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 projects" id="project-<?php echo $file->File_Id; ?>">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary headerLink">
                                <a class="fileOverlayDisplayLink" data-myval = "<?php echo $file->File_Link; ?>" id="file-<?php echo $file->File_Id; ?>-id"><?php echo $file->File_Name; ?></a>
                            </h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in dropdownClass" aria-labelledby="dropdownMenuLink" x-placement="bottom-end">
                                    <div class="dropdown-header">Options</div>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item fileEditOption" id="file-<?php echo $file->File_Id; ?>-edit">Edit Name</a>
                                    <a class="dropdown-item fileDeleteOption" id="file-<?php echo $file->File_Id; ?>-delete">Delete</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if($file->File_Type == "excel"):?>
                                <div class="img-wrapper imageLink fileOverlayDisplayLink " data-myval = "<?php echo $file->File_Link; ?>" id="file-<?php echo $file->File_Id; ?>-id-img"  style="background-image:url('../img/excel.png"></div>
                            <?php elseif($file->File_Type == "pdf"):?>
                                <div class="img-wrapper imageLink fileOverlayDisplayLink " data-myval = "<?php echo $file->File_Link; ?>" id="file-<?php echo $file->File_Id; ?>-id-img"  style="background-image:url('../img/pdf.png');"></div>
                            <?php elseif($file->File_Type == "powerPoint"):?>
                                <div class="img-wrapper imageLink fileOverlayDisplayLink " data-myval = "<?php echo $file->File_Link; ?>" id="file-<?php echo $file->File_Id; ?>-id-img"  style="background-image:url('../img/powerPoint.png');"></div>
                            <?php elseif($file->File_Type == "word"):?>
                                <div class="img-wrapper imageLink fileOverlayDisplayLink " data-myval = "<?php echo $file->File_Link; ?>" id="file-<?php echo $file->File_Id; ?>-id-img"  style="background-image:url('../img/word.png');"></div>
                            <?php else:?>
                                <div class="img-wrapper imageLink fileOverlayDisplayLink " data-myval = "<?php echo $file->File_Link; ?>" id="file-<?php echo $file->File_Id; ?>-id-img"   style="background-image:url('../img/unknown.png');"></div>
                            <?php endif;?>
                            
                        </div>
                    </div>
                </div>
            <?php if($counter == 4):?></div> <?php endif;?>
            <?php if($counter == 4):?>
                <?php $counter = 1; ?>
            <?php else: ?>
                <?php $counter++; ?>
            <?php endif;?>
        <?php endforeach;?>
            <?php if($counter != 4):?>
                </div>
            <?php endif;?>
       <?php else:?>
        <h1>You do not have any Projects</h2>
       <?php endif;?>

        </div>

            

        </div>
        <!-- /.container-fluid -->
        <?php require APPROOT . '/views/inc/footer.php'; ?>
        </div>
        <!-- End of Main Content -->


        <script>

        document.getElementById("closeOverlayBtn").addEventListener("click", function(){
            document.getElementById("documentDisplayIFrame").setAttribute("src", "");

            document.getElementById("fileDisplayOverlay").style.display = "none"; 
        });
    
        document.getElementById("projectFilesBtn").addEventListener("click", function(){
            document.getElementById("fileBtnBorder").classList.add("border-primary");
            document.getElementById("fileBtnText").classList.add("text-primary");

            document.getElementById("taskBtnBorder").classList.remove("border-primary");
            document.getElementById("taskBtnText").classList.remove("text-primary");

            
            document.getElementById("taskDisplay").style.display = "none";
            document.getElementById("fileDisplay").style.display = "block";

        });

        document.getElementById("taskDisplayBtn").addEventListener("click", function(){
            document.getElementById("fileBtnBorder").classList.remove("border-primary");
            document.getElementById("fileBtnText").classList.remove("text-primary");

            document.getElementById("taskBtnBorder").classList.add("border-primary");
            document.getElementById("taskBtnText").classList.add("text-primary");

            document.getElementById("taskDisplay").style.display = "block";
            document.getElementById("fileDisplay").style.display = "none";

        });
        
        document.getElementById("addFileBtn").addEventListener("click", function(){
            document.getElementById("confirmationOverlay").style.display = "block";
        });

        document.getElementById("cancelCreateFile").addEventListener("click", function(){

            document.getElementById("fileName").value = ""
            document.getElementById("fileLink").value = ""

            document.getElementById("confirmationOverlay").style.display = "none";
        });

        document.getElementById("cancelEditFile").addEventListener("click",function(){

            document.getElementById("fileEditId").value = ""
            document.getElementById("fileEditProjectId").value = ""
            document.getElementById("FileNameEdit").value = ""
            document.getElementById("FileLinkEdit").value = ""


            document.getElementById("editFileOverlay").style.display = "none";
        });
        
        document.getElementById("cancelDeleteFile").addEventListener("click", function(){
            document.getElementById("deleteFileOverlay").style.display = "none";
        })

        let fileEditOptions = document.getElementsByClassName("fileEditOption");
        let fileDeleteOptions = document.getElementsByClassName("fileDeleteOption");

        let fileOverlayDisplayLink = document.getElementsByClassName("fileOverlayDisplayLink");

        for(let i = 0; i < fileOverlayDisplayLink.length; i++){
            fileOverlayDisplayLink[i].addEventListener("click", displayFileOverlay);
        }

        for(let i = 0; i < fileEditOptions.length; i++){
            fileEditOptions[i].addEventListener("click", editFileDisplay);
            fileDeleteOptions[i].addEventListener("click", deleteFileDisplay);
        }

        function editFileDisplay(e){
            
            let splitString = e.target.id.split("-");
            let id = splitString[1];
            
            $.ajax({url: "<?php echo URLROOT; ?>/IndividualProjectController/getFileInfo?id=" + id, async: false, success: function(result){
        
                let data = JSON.parse(result);
          

                document.getElementById("editFileOverlay").style.display = "block";

                document.getElementById("fileEditId").value = data.File_Id;
                document.getElementById("FileNameEdit").value = data.File_Name;
                document.getElementById("FileLinkEdit").value = data.File_Link;
                let typeDropdown = document.getElementById("FileTypeEdit");
                for(let i = 0; i < typeDropdown.length; i++){
                    if(typeDropdown.options[i].value == data.File_Type){
                        typeDropdown.selectedIndex = i;
                        break;
                    }
                }
                
            }});
        }

        function deleteFileDisplay(e){
            let splitString = e.target.id.split("-");
            let id = splitString[1];
            
            $.ajax({url: "<?php echo URLROOT; ?>/IndividualProjectController/getFileInfo?id=" + id, async: false, success: function(result){
        
                let data = JSON.parse(result);
                
                document.getElementById("deleteFileOverlay").style.display = "block";

                document.getElementById("deleteFileId").value = data.File_Id;
                
                
            }});
        }

        function displayFileOverlay(e){
            let splitString = e.target.id.split("-");
            let id = splitString[1];
            
            let link = e.target.attributes[1].value;

            $.ajax({url: "<?php echo URLROOT; ?>/IndividualProjectController/getFileInfo?id=" + id, async: false, success: function(result){
        
                let data = JSON.parse(result);

                document.getElementById("fileDisplayOverlay").style.display = "block";
                
                document.getElementById("documentDisplayIFrame").src = data.File_Link;
                
                
            }});
        }

         /*This function when called  sets the values of the inputs in the overlay, to the values
            of the row that was clicked*/
            function editTask(e) {
              console.log("edit")
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
           
        $.ajax({url: "<?php echo URLROOT; ?>/IndividualProjectController/getProjectTasks", async: false, success: function(result){
            
             
            var table = new Table(JSON.parse(result), {
              tableHeaders: tableHeads,
              tableId: sourceId,
              fields: objectFields,
              numOfItemsDropdownDisplay: {
                display: false,
                numberList: ["5"]
              },
              searchBarDisplay: false,
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
            document.getElementById("taskConfirmationOverlay").style.display = "block";
          }

          //This button hides the delete project overlay
          function cancelDeletion() {
            document.getElementById("taskConfirmationOverlay").style.display = "none";
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

          firstEditEvents();
          firstDeleteEvents();
          addPageItemListener();


        </script>


        

        <?php 
        unset($_SESSION["errorData"]) ;
        unset($_SESSION['fileErrorData']) ;
        ?>

    <?php else: ?>
    <?php redirect('userController/login'); ?>
    <?php endif;?>

<?php else: ?>
<h1>This project either does not exist or is not connected to your account</h1>

<?php endif;?>






