<!-- 
  TO DO LIST FOR THIS PAGE

    - Display a list of tasks where revenue source is,
    - Find something to put in Earnings Overview
    - make the progress bars load up 
    - error handeling now working and strucutred well for the project and task forms on dahsboard

-->

<?php if(isset($_SESSION['user_id'])): ?>
    <?php var_dump($data); ?>
    <?php var_dump($_SESSION);?>

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
                          <div  class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $data["taskCompletion"];?>%</div>
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

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Daily Tasks</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body" style="overflow-y:scroll;height: 300px; ">
                  <div class="list-group" >

                    <?php foreach($data['dailyTasks'] as $tasks):?>
                      <?php if($tasks->Task_Completed == 0):?>
                        <a href="#" class="list-group-item list-group-item-action flex-column align-items-start ">
                        <div class="d-flex w-100 justify-content-between">
                          <h5 class="mb-1"><?php echo $tasks->Task_Name; ?></h5>
                          <small><?php echo $tasks->Task_Start_Time; ?></small> 
                        </div>
                        <p class="mb-1">Add task description later</p>
                        <p class="mb-1 btn btn-danger">Incomplete</p>
                      </a>
                      <?php endif;?>
                    <?php endforeach;?>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <ul></ul>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->
          <div class="row">

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

            <div class="col-lg-6 mb-4">

              <!-- Illustrations -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Create New Task Today</h6>
                </div>
                <div class="card-body">


                  <form action="<?php echo URLROOT;?>/dashboardController/newTask" method="post">
                    <div class="form-group">
                      <label for="nameInput">Task Name</label>
                      <input type="text" class="form-control" name="nameInput" id="nameInput"  placeholder="Enter Name">
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
                    </div>

                    <div class="form-group">
                      <label for="startTimeInput">Start Time</label>
                      <input type="time" class="form-control" name="startTimeInput" id="startTimeInput" >
                    </div>

                    <div class="form-group">
                      <label for="endTimeInput">End Time</label>
                      <input type="time" class="form-control" name="endTimeInput" id="endTimeInput"  >
                    </div>

                    <div class="form-group">
                      <label for="startDateInput">Start Date</label>
                      <input type="date" class="form-control" name="startDateInput" id="startDateInput"  >
                    </div>

                    <div class="form-group">
                      <label for="endDateInput">End Date</label>
                      <input type="date" class="form-control" name="endDateInput" id="endDateInput"  >
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
                    </div>

                    <div class="form-group">
                      <label for="projectTypeInput">Project Type</label>
                      <input type="text" class="form-control" name="projectTypeInput" id="projectTypeInput"  placeholder="Project Type">
                    </div>

                    <div class="form-group">
                      <label for="projectDescriptionInput">Project Description</label>
                      <textarea class="form-control" id="projectDescriptionInput" name="projectDescriptionInput" rows="5"></textarea>
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

<?php else: ?>
    <?php redirect('userController/login'); ?>
<?php endif;?>


