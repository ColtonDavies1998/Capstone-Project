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

<?php if($_SESSION['current_page'] == 'TaskHistory'):?>
  <script src="<?php echo URLROOT; ?>/js/data.js"></script>

<script src="<?php echo URLROOT; ?>/vendor/PaginationJS/paginationJS.js"></script>

<div id="confirmationOverlay">
  <div id="confirmationOverlayBlock">
    <h5>Are you sure you want to delete this item?</h5>
    <button type="button" class="btn btn-danger" id="confirmedDelete">Delete</button>
    <button type="button" class="btn btn-primary" id="cancelDelete">Cancel</button>
  </div>
</div>

<div id="editTaskNameOverlay">
  <div id="editTaskOverlayBlock">
    <h5>Edit Project Name</h5>
    <div class="form-group">
      <label for="taskNameInput">Project Name</label>
      <input type="text" class="form-control" style="margin-bottom: 5px;" id="taskNameEdit" >

      <label for="startTimeInput">Start Time</label>
      <input class="form-control" type="time"  id="startTimeInput">

      <label for="taskTypeInput">Task Type</label>
      <select class="form-control" id="taskTypeInput">
        <option>Chore</option>
        <option>Education</option>
      </select>

      <label for="taskDateInput">Date</label>
      <input class="form-control" type="date" id="taskDateInput">

      <label for="priorityInput">Priority</label>
      <input class="form-control" type="number" max="10" min="0" step="0.01" id="priorityInput">

      <div class="form-check">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="optionsRadios" id="CompletedRadio1" value="complete">
          Completed
        </label>
      </div>
      <div class="form-check bottomInput">
      <label class="form-check-label">
          <input type="radio" class="form-check-input" name="optionsRadios" id="CompletedRadio2" value="incomplete">
          incomplete 
        </label>
      </div>

      <button type="button" class="btn btn-primary" id="editSubmitBtn">Submit</button>
      <button type="button" class="btn btn-danger" id="cancelEdit">Cancel</button>
    </div>
  </div>
</div>
<?php endif;?>


<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">