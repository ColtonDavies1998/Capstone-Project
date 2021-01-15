<!-- 
    - There still might be an issue with the bootstrap row when there is less than 3 items displying, check it out later.

-->
<?php if($data["actualUsersProject"] == true): ?>
    <?php if(isset($_SESSION['user_id'])): ?>
 
    <?php require APPROOT . '/views/inc/header.php'; ?>

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
                            <h6 class="m-0 font-weight-bold text-primary">Daily Tasks</h6>
                            <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Task Display:</div>
                                <a class="dropdown-item text-success" href="#">Incomplete Only</a>
                                <a class="dropdown-item" href="#">Completed Only</a>
                                <a class="dropdown-item" href="#">Both</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
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
                                        <p class="mb-1">Add task description later</p>
                                        <button class="mb-1 btn btn-danger singleTask taskId-<?php echo $tasks->Task_Id ?>">Incomplete</button>
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
                            <input type="hidden" class="form-control" name="idInput" id="idInput" value="<?php echo $data["projectInformation"]->Project_Id;?>">
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

        </script>


        

        <?php 
        unset($_SESSION["errorData"]) 
        ?>

    <?php else: ?>
    <?php redirect('userController/login'); ?>
    <?php endif;?>

<?php else: ?>
<h1>This project either does not exist or is not connected to your account</h1>

<?php endif;?>






