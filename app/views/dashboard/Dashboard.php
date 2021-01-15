
<?php if(isset($_SESSION['user_id'])): ?>
 

  <?php require APPROOT . '/views/inc/header.php'; ?>

   <?php require APPROOT . '/views/inc/sideNav.php'; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <style>
        .text-left {
              text-align: left!important;
          }

          .text-center{
              text-align: center;
          }

          #calendar td{
              padding: 1.75rem!important;
              position: relative;
          }

          .button-spacing{
              margin-right: 5%;
          }

          .tableHeading-Spacing{
              margin-top: 1%;
              margin-bottom: 1%;
          }

          .cellNumber{
              top: 0;
              right: 10px;
              position: absolute;
          }

          .buttonCategory-spacing{
              margin-right: 100px;
          }

          th{
              text-align: center!important;
          }

          td{
              height: 110px;
          }

          .green-dash{
              background-color: green;
              width: 70%;
              height: 18px;
              font-size: 13px;
              color: white;
              position: absolute;
          }

          .hiddenDisplay{
              display: none;
          }

          .timeHeaderSpacing{
              width: 30%;
          }

          dl
          {
              width: 200px;
              background: #fff;
              border: 1px solid #000;
          }

          dt, dd
          {
              display: inline;
          }     



          /*Weekly Calender styles */
          table.weeklyCalendar {
              margin-bottom: 0;
          }

          table.weeklyCalendar > thead > tr > th {
              text-align: center;
          }

          table.weeklyCalendar > tbody > tr > td {
              height: 20px;
          }

          table.weeklyCalendar > tbody > tr > td > div {
              padding: 8px;
              height: 40px;
              overflow: hidden;
              display: inline-block;
              vertical-align: middle;
              float: left;
          }

          table.weeklyCalendar > tbody > tr > td.has-events {
              color: white;
              cursor: pointer;
              padding: 0;
              border-radius: 4px;
          }

          table.weeklyCalendar > tbody > tr > td.has-events > div {
              background-color: #08C;
              border-left: 1px solid white;
          }

          table.weeklyCalendar > tbody > tr > td.has-events > div:first-child {
              border-left: 0;
              margin-left: 1px;
          }

          table.weeklyCalendar > tbody > tr > td.has-events > div.practice {
              opacity: 0.7;
          }
          table.weeklyCalendar > tbody > tr > td.conflicts > div > span.title {
              color: red;
          }
          table.weeklyCalendar > tbody > tr > td.max-conflicts > div {
              background-color: red;
              color: white;
          }

          table.weeklyCalendar > tbody > tr > td.has-events > div > span {
              display: block;
              text-align: center;
          }
          table.weeklyCalendar > tbody > tr > td.has-events > div > span a {
              color: white;
          }

          table.weeklyCalendar > tbody > tr > td.has-events > div > span.title {
              font-weight: bold;
          }

          table.table-borderless > thead > tr > th, table.table-borderless > tbody > tr > td {
              border: 0;
          }

          .table tbody tr.hover td, .table tbody tr.hover th {
              background-color: whiteSmoke;
          }

          /* Day Calendar*/
          table.weeklyCalendar {
              margin-bottom: 0;
          }

          table.dailyCalendar > thead > tr > th {
              text-align: center;
          }

          table.dailyCalendar > tbody > tr > td {
              height: 20px;
          }

          table.dailyCalendar > tbody > tr > td > div {
              padding: 8px;
              height: 40px;
              overflow: hidden;
              display: inline-block;
              vertical-align: middle;
              float: left;
          }

          table.dailyCalendar > tbody > tr > td.has-events {
              color: white;
              cursor: pointer;
              padding: 0;
              border-radius: 4px;
          }

          table.dailyCalendar > tbody > tr > td.has-events > div {
              background-color: #08C;
              border-left: 1px solid white;
          }

          table.dailyCalendar > tbody > tr > td.has-events > div:first-child {
              border-left: 0;
              margin-left: 1px;
          }

          table.dailyCalendar > tbody > tr > td.has-events > div.practice {
              opacity: 0.7;
          }
          table.dailyCalendar > tbody > tr > td.conflicts > div > span.title {
              color: red;
          }
          table.dailyCalendar > tbody > tr > td.max-conflicts > div {
              background-color: red;
              color: white;
          }

          table.dailyCalendar > tbody > tr > td.has-events > div > span {
              display: block;
              text-align: center;
          }

          .daySized{
              width: 30%!important;
          }
      </style>

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php require APPROOT . '/views/inc/topNav.php'; ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Date</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo monthConverter();?> </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Daily Task Completion</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div  class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo round($data["taskCompletion"]);?>%</div>
                        </div>
                        <div class="col">
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-info" role="progressbar" id="DailyCompletionProgressBar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Daily Tasks</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $data["taskCount"] ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                  </div>
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
                  <h6 class="m-0 font-weight-bold text-primary">Daily Tasks</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body" style="overflow-y:scroll;height: 450px; ">
                  <div class="list-group" >

                    <?php foreach($data['dailyTasks'] as $tasks):?>
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

            <?php if($_SESSION['Dashboard_Calendar_Display']->Dashboard_Calendar_Display == 1):?>
              <div class="col-xl-5 col-lg-6">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Mini Calendar</h6>              
                  </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="col-sm-3 col-md-4 col-lg-2">
                    <div class="row" id="nxtPrevButtons"></div>
                  </div>
                  <table class="table table-bordered table-responsive-sm" id="calendar"></table>
                </div>
              </div>
            </div>
            <?php endif;?>
            
          </div>

          <!-- Content Row -->
          <div class="row">

            <?php if($_SESSION['Dashboard_Projects_Display']->Dashboard_Projects_Display == 1):?>
              <!-- Content Column -->
              <div class="col-lg-6 mb-4">
                <!-- Project Card Example -->
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Projects</h6>
                  </div>
                  <div class="card-body">
                    <?php if(count($data['projects']) == 0): ?>
                      <h4 class="small font-weight-bold">No Projects have been created </h4>
                    <?php else: ?>
                      <?php foreach($data['projects'] as $project): ?>
                        
                        <h4 class="small font-weight-bold"><?php echo $project->Project_Name; ?> <span class="float-right"><?php echo $project->Project_Completion;?>%</span></h4>
                        <div class="progress mb-4">
                          <div 
                            <?php if($project->Project_Completion >= 0 && $project->Project_Completion <= 20):?>
                              class="progress-bar bg-danger" 
                            <?php elseif($project->Project_Completion >= 21 && $project->Project_Completion <= 41):?>
                              class="progress-bar bg-warning"
                            <?php elseif($project->Project_Completion >= 42 && $project->Project_Completion <= 62):?>
                              class="progress-bar"
                            <?php elseif($project->Project_Completion >= 63 && $project->Project_Completion <= 83):?>
                              class="progress-bar bg-info"
                            <?php else: ?>
                              class="progress-bar bg-success"
                            <?php endif;?>
                          role="progressbar" style="width: <?php echo $project->Project_Completion;?>%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      <?php endforeach;?>
                    <?php endif;?>
                  </div>
                </div>
              </div>
            <?php endif;?>

            

            <div class="col-lg-6 mb-4">

              <!-- Illustrations -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Create New Task</h6>
                </div>
                <div class="card-body">


                  <form action="<?php echo URLROOT;?>/dashboardController/newTask" method="post">
                    <div class="form-group">
                      <label for="nameInput">Task Name</label>
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

              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Create Personal Project</h6>
                </div>
                <div class="card-body">
                  <form action="<?php echo URLROOT;?>/dashboardController/newProject" method="post"> 
                    <div class="form-group">
                      <label for="projectNameInput">Project Name</label>
                      <input type="text" class="form-control" name="projectNameInput" id="projectNameInput"  placeholder="Project Name">
                      <?php if(isset($_SESSION['projectErrorData']['project_name_error'])): ?>
                        <span class="text-danger"> <?php echo $_SESSION['projectErrorData']['project_name_error'] ?> </span>
                      <?php endif; ?>
                    </div>

                    <div class="form-group">
                      <label for="projectTypeInput">Project Type</label>
                      <input type="text" class="form-control" name="projectTypeInput" id="projectTypeInput"  placeholder="Project Type">
                      <?php if(isset($_SESSION['projectErrorData']['project_type_error'])): ?>
                        <span class="text-danger"> <?php echo $_SESSION['projectErrorData']['project_type_error'] ?> </span>
                      <?php endif; ?>
                    </div>

                    <div class="form-group">
                      <label for="projectDescriptionInput">Project Description</label>
                      <textarea class="form-control" id="projectDescriptionInput" name="projectDescriptionInput" rows="5"></textarea>
                      <?php if(isset($_SESSION['projectErrorData']['project_description_error'])): ?>
                        <span class="text-danger"> <?php echo $_SESSION['projectErrorData']['project_description_error'] ?> </span>
                      <?php endif; ?>
                    </div>

                    <input id="formButton"  type="submit" value="Create" class="btn btn-primary" >

                  </form>
                </div>
              </div>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->


      <script>
        window.addEventListener('load', (event) => {

          var http = new XMLHttpRequest();
          var url = '<?php echo URLROOT; ?>/CalendarController/getUsersTasks';
          http.open('POST', url, true);

          //Send the proper header information along with the request
          http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

          http.onreadystatechange = function() {//Call a function when the state changes.
          if(http.readyState == 4 && http.status == 200) { 
            var data = JSON.parse(http.responseText);

            var calendar = new Calendar(data,{
                      tables: {
                          day: false,
                          week: false,
                          month: true
                      },
                      nextPrevButtons:false,
                      jumpTo:false,
                      legend:false,
                      tableButtons:{
                        dayBtn: false,
                        weekBtn: false,
                        monthBtn: false
                      }
                    });

                    calendar.displayCalendar(); 
                     


                  }
              }
              http.send();



          
          tasks = document.getElementsByClassName('singleTask');
          console.log(tasks);

          for(let i = 0; i < tasks.length; i++){
            
            tasks[i].addEventListener("click", (event)=> {
              for(let j = 0; j < event.target.classList.length; j++){
                if(event.target.classList[j].includes("taskId")){
                  var temp = event.target.classList[j].split("-");
                  var taskId = temp[1];
                  console.log(taskId)

                  var http = new XMLHttpRequest();
                  var url = '<?php echo URLROOT; ?>/DashboardController/taskCompleteChange';

                  var params = 'id=' + taskId;
                  http.open('POST', url, true);

                  //Send the proper header information along with the request
                  http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                  http.onreadystatechange = function() {//Call a function when the state changes.
                  }
                  http.send(params);

                  event.target.classList.remove("btn-danger");
                  event.target.classList.add("btn-success");
                  event.target.innerText = "Completed";

                }
              }
            });
          }

        });



        //This section is called on the program load and loads the progress bar
        // uses the completionPercentage as the width
        function move(elem) {
            
            completionPercentage = <?php echo $data["taskCompletion"] ?>; 
            var width = 0;
            var id = setInterval(frame, 0.5);
            function frame() {
              
                if(width < completionPercentage){
                    width++; 
                    elem.style.width = width + '%'; 

                    if(width > 0 &&  width <= 20){
                        elem.style.backgroundColor = "#e74a3b";
                    }
                    else if(width > 20 &&  width <= 40){
                        elem.style.backgroundColor = "#f6c23e";
                    }
                    else if(width > 40 &&  width <= 60){
                        elem.style.backgroundColor = "#4e73df";
                    }
                    else if(width > 60 &&  width <= 80){
                        elem.style.backgroundColor = "#36b9cc";
                    }
                    else{
                        elem.style.backgroundColor = "#1cc88a";
                    }
                }else{
                    clearInterval(id);
                }
            }
        }

        move(document.getElementById("DailyCompletionProgressBar"));
      
      </script>


      <?php require APPROOT . '/views/inc/footer.php'; ?>

      <?php 
      unset($_SESSION["errorData"]);
      unset($_SESSION["projectErrorData"]);
      ?>

<?php else: ?>
    <?php redirect('userController/login'); ?>
<?php endif;?>


