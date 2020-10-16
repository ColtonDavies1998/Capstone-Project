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

<?php if($_SESSION['current_page'] == 'TaskHistory'):?>
  <script src="<?php echo URLROOT; ?>/js/data.js"></script>

<script src="<?php echo URLROOT; ?>/vendor/PaginationJS/paginationJS.js"></script>

<div id="confirmationOverlay">
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


<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">