<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?php echo SITENAME; ?></title>

  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">

  <!-- Custom fonts for this template-->
  <link href="<?php echo URLROOT; ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?php echo URLROOT; ?>/css/sb-admin-2.css" rel="stylesheet">

</head>

<?php if($_SESSION['current_page'] == 'Calendar' || $_SESSION['current_page'] == 'Dashboard'):?>
  <script src="<?php echo URLROOT; ?>/vendor/CalendarJS/calendarJS.js"></script>
<?php endif;?>

<?php if($_SESSION['current_page'] == 'MultipleProjects'):?>
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/multipleProjectStyle.css">
<?php endif;?>

<?php if($_SESSION['current_page'] == 'IndividualProject'):?> 
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/individualProjectStyle.css">
<?php endif;?>

<?php if($_SESSION['current_page'] == 'Groups'):?>
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/groupsStyle.css">
<?php endif;?>

<?php if($_SESSION['current_page'] == 'TaskHistory' || $_SESSION['current_page'] == 'IndividualProject'):?>
  

<script src="<?php echo URLROOT; ?>/vendor/PaginationJS/paginationJS.js"></script>

<div id="projectConfirmationOverlay">
  <div id="confirmationOverlayBlock">
    <h5>Are you sure you want to delete this item?</h5>
    <form action="<?php echo URLROOT;?>/TaskHistoryController/deleteTask" method="post"> 
      <input type="hidden" id="deleteValueId" name="deleteId" >
      <input type="submit" value="delete" class="btn btn-danger"> 
      <button type="button" class="btn btn-primary" id="cancelDelete">Cancel</button>
    </form>
    
    
  </div>
</div>

<div id="editTaskNameOverlay">
  <div id="editTaskOverlayBlock">
    <h5>Edit Task Name</h5>
    <div class="form-group">
      <form action="<?php echo URLROOT;?>/TaskHistoryController/editTask" method="post">
        <input name="taskId" id="taskId" type="hidden">

        <label for="taskNameInput">Task Name</label>
        <input type="text" class="form-control" style="margin-bottom: 5px;" name="taskNameEdit" id="taskNameEdit" >

        <label for="startTimeInput">Start Time</label>
        <input class="form-control" type="time" name="startTimeEdit"  id="startTimeInput">

        <label for="startTimeInput">End Time</label>
        <input class="form-control" type="time" name="endTimeEdit"  id="endTimeInput">

        <label for="taskTypeInput">Task Type</label>
        <select class="form-control" id="taskTypeInput" name="taskTypeInput">
          <option value="Work">Work</option>
          <option value="Education">Education</option>
          <option value="Home">Home</option>
          <option value="Chores">Chores</option>
          <option value="Other">Other</option>
        </select>

        <label for="taskDateInput">Start Date</label>
        <input class="form-control" type="date" name="startDateInput" id="startDateInput">

        <label for="taskDateInput">End Date</label>
        <input class="form-control" type="date" name="endDateInput" id="endDateInput">

        <div class="form-check">
          <label class="form-check-label">
            <input type="radio" class="form-check-input" name="isComplete" id="CompletedRadio1" value="complete">
            Completed
          </label>
        </div>

        <div class="form-check bottomInput">
          <label class="form-check-label">
            <input type="radio" class="form-check-input" name="isComplete" id="CompletedRadio2" value="incomplete">
            incomplete 
          </label>
        </div>

        <input type="submit" value="edit" class="btn btn-primary" id="editSubmitBtn"> 
        <button type="button" class="btn btn-danger" id="cancelEdit">Cancel</button>
      </form>


    </div>
  </div>
</div>
<?php endif;?>

<?php if($_SESSION['current_page'] == 'MultipleProjects'):?>

  <div id="overlay">
    <div id="overlayBlock">
      <h1>Add Project</h1>
      <form action="<?php echo URLROOT;?>/MultipleProjectsController/createProject" method="post">
        <div class="form-group">
          <label for="ProjectNameInput">Project Name</label>
          <input type="text" class="form-control" name="ProjectNameInput" id="ProjectNameInput" >
        </div>
        <div class="form-group">
          <label for="ProjectTypeInput">Project Type</label>
          <input type="text" class="form-control" name="ProjectTypeInput" id="ProjectTypeInput" >
        </div>
        <div class="form-group">
          <label for="ProjectImageInput">Project Image</label>
          <input type="file" class="form-control-file" name="ProjectImageInput" id="ProjectImageInput">
        </div>
        <div class="form-group">
          <label for="ProjectDescription">Description</label>
          <textarea class="form-control" name="ProjectDescription" id="ProjectDescription" rows="5"></textarea>
        </div>
        <div class="form-group">
          <input type="submit" class="btn btn-primary" id="projectSubmitBtn" value="Submit">
          <a class="btn btn-danger" style="color:white;" id="cancelOverlayBtn">Cancel</a>
        </div>
      </form>

    </div>
  </div>


  <div id="confirmationOverlay">
      <div id="confirmationOverlayBlock">
        <h5>Are you sure you want to delete this item? All files inside the project will be deleted as well.</h5>
        <form action="<?php echo URLROOT;?>/MultipleProjectsController/deleteProject" method="post">
          <div class="form-group">
            <input type="hidden" id="deleteId" name="deleteId" >
            <input type="submit" class="btn btn-danger" value="Delete">
            <a class="btn btn-primary" style="color:white;" id="cancelDelete">Cancel</a>
          </div>
        </form>
      </div>
  </div>


  <div id="editNameOverlay">
    <div id="editOverlayBlock">
      <h5>Edit Project Name</h5>
      
        <form action="<?php echo URLROOT;?>/MultipleProjectsController/editProject" method="post">
          <div class="form-group">
            <input type="hidden" id="projectEditId" name="projectEditId">
            <label for="ProjectNameInput">Project Name</label>
            <input type="text" class="form-control" style="margin-bottom: 5px;" name="ProjectNameEdit" id="ProjectNameEdit" >
          </div>
          <div class="form-group">
            <label for="ProjectTypeInput">Project Type</label>
            <input type="text" class="form-control" name="ProjectTypeEdit" id="ProjectTypeEdit" >
          </div>
          <div class="form-group">
            <label for="ProjectImageInput">Project Image</label>
            <p>Current Project Image: <span id="currentProjectImg"></span></p>
            <input type="file" class="form-control-file" name="ProjectImageEdit" id="ProjectImageEdit">
          </div>
          <div class="form-group">
            <label for="ProjectDescription">Description</label>
            <textarea class="form-control" name="ProjectDescriptionEdit" id="ProjectDescriptionEdit" rows="5"></textarea>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <a class="btn btn-danger" style="color:white;" id="cancelEdit"> Cancel </a>
          </div>
        </form>
    
      
    </div>
  </div>

<?php endif;?>

<?php if($_SESSION['current_page'] == 'Groups'): ?>

  <div id="overlay">
    <div id="overlayBlock">
      <h1>Create Group</h1>
      <form action="<?php echo URLROOT;?>/GroupsController/createGroup" method="post">
        <div class="form-group">
          <label for="ProjectNameInput">Group Name</label>
          <input type="text" class="form-control" name="GroupNameInput" id="GroupNameInput" >
        </div>
        <div class="form-group">
          <label for="ProjectDescription">Group Description</label>
          <textarea class="form-control" name="GroupDescription" id="GroupDescription" rows="5"></textarea>
        </div>
        <div class="form-group">
          <input type="submit" class="btn btn-primary" id="projectSubmitBtn" value="Submit">
          <a class="btn btn-danger" style="color:white;" id="cancelOverlayBtn">Cancel</a>
        </div>
      </form>

    </div>
  </div>


  <div id="confirmationOverlay">
      <div id="confirmationOverlayBlock">
        <h5>Are you sure you want to delete this item? All files inside the Group will be deleted as well.</h5>
        <form action="<?php echo URLROOT;?>/GroupsController/deleteGroup" method="post">
          <div class="form-group">
            <input type="hidden" id="deleteGroupId" name="deleteGroupId">
            <input type="submit" class="btn btn-danger" value="Delete">
            <a class="btn btn-primary" style="color:white;" id="cancelDelete">Cancel</a>
          </div>
        </form>
      </div>
  </div>


  <div id="editNameOverlay">
    <div id="editOverlayBlock">
      <h5>Edit Group Name</h5>
        <form action="<?php echo URLROOT;?>/GroupsController/editGroup" method="post">
          <div class="form-group">
            <input type="hidden" id="groupEditId" name="groupEditId">
            <label for="GroupNameEdit">Group Name</label>
            <input type="text" class="form-control" style="margin-bottom: 5px;" name="GroupNameEdit" id="GroupNameEdit" >
          </div>
          <div class="form-group">
            <label for="GroupDescriptionEdit">Group Description</label>
            <textarea class="form-control" name="GroupDescriptionEdit" id="GroupDescriptionEdit" rows="5"></textarea>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <a class="btn btn-danger" style="color:white;" id="cancelEdit"> Cancel </a>
          </div>
        </form>
    
      
    </div>
  </div>

<?php endif; ?>

<?php if($_SESSION['current_page'] == 'IndividualProject'):?>
  
  <div id="confirmationOverlay">
    <div id="createFileOverlayBlock">
      <h5>Create File</h5>
        <form action="<?php echo URLROOT;?>/IndividualProjectController/createFile" method="post">
          <div class="form-group">
            <label for="fileName">File Name</label>
            <input type="hidden" name="projectId" value="<?php echo $data["projectInformation"]->Project_Id ?>">
            <input type="text" class="form-control" style="margin-bottom: 5px;" name="fileName" id="fileName" >
            <?php if(isset($_SESSION['fileErrorData']['file_name_error'])): ?>
              <span class="text-danger"> <?php echo $_SESSION['fileErrorData']['file_name_error'] ;?> </span>
            <?php endif; ?>
          </div>
          <div class="form-group">
            <label for="fileLink">File Link (link your google drive docments here)</label>
            <input type="text" class="form-control" style="margin-bottom: 5px;" name="fileLink" id="fileLink" >
            <?php if(isset($_SESSION['fileErrorData']['file_link_error'])): ?>
              <span class="text-danger"> <?php echo $_SESSION['fileErrorData']['file_link_error'] ;?> </span>
            <?php endif; ?>
          </div>
          <div class="form-group">
            <label for="fileType">File Type</label>
            <select class="form-control" name="fileType" id="fileType">
              <option value="word">Word Document</option>
              <option value="excel">Excel Document</option>
              <option value="powerPoint">PowerPoint</option>
              <option value="pdf">PDF File</option>
              <option value="other">Other</option>
            </select>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <a class="btn btn-danger" style="color:white;" id="cancelCreateFile"> Cancel </a>
          </div>
        </form>
    </div>
  </div>

  <div id="editFileOverlay">
    <div id="editFileOverlayBlock">
      <h5>Edit File Information</h5>
        <form action="<?php echo URLROOT;?>/IndividualProjectController/editFile" method="post">
          <div class="form-group">
            <input type="hidden" id="fileEditId" name="fileEditId">
            <input type="hidden" id="fileEditProjectId" name="projectId" value="<?php echo $data["projectInformation"]->Project_Id ?>">
            <label for="FileNameEdit">File Name</label>
            <input type="text" class="form-control" style="margin-bottom: 5px;" name="FileNameEdit" id="FileNameEdit" >
          </div>
          <div class="form-group">
            <label for="FileLinkEdit">File Link</label>
            <input type="text" class="form-control" style="margin-bottom: 5px;" name="FileLinkEdit" id="FileLinkEdit" >
          </div>
          <div class="form-group">
            <label for="FileTypeEdit">File Type</label>
            <select class="form-control" id="FileTypeEdit" name="FileTypeEdit">
              <option value="word">Word Document</option>
              <option value="excel">Excel Document</option>
              <option value="powerPoint">PowerPoint</option>
              <option value="pdf">PDF File</option>
              <option value="other">Other</option>
            </select>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <a class="btn btn-danger" style="color:white;" id="cancelEditFile"> Cancel </a>
          </div>
        </form>
    </div>
  </div>

  <div id="deleteFileOverlay">
      <div id="deleteFileOverlayBlock">
        <h5>Are you sure you want to delete this File?</h5>
        <form action="<?php echo URLROOT;?>/IndividualProjectController/deleteFile" method="post">
          <div class="form-group">
            <input type="hidden" id="deleteFileId" name="deleteFileId">
            <input type="submit" class="btn btn-danger" value="Delete">
            <a class="btn btn-primary" style="color:white;" id="cancelDeleteFile">Cancel</a>
          </div>
        </form>
      </div>
  </div>
 
  <div id="fileDisplayOverlay">
    <button id="closeOverlayBtn">X</button>
      <div id="fileDisplayOverlayBlock" style="overflow: hidden;">
        <iframe width='100%' height='1000' id="documentDisplayIFrame" ></iframe>
      </div>
  </div>

<?php endif;?>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">