<!-- 
  TO DO LIST FOR THIS PAGE
    - Fix css font and slider size and position
    - Allow the the user to change their first last name and email and validate
    - Allow the user to change the password and validate
    - Allow the user to update dashboard controlls
    - set up group section, if the user is not a buisness user let them know, if there are no groups let them know else
      display groups
    - display section for statistics
    - error handeling now working and strucutred well for the project and task forms on dahsboard

-->

<?php if(isset($_SESSION['user_id'])): ?>


 <?php require APPROOT . '/views/inc/header.php'; ?>

  <?php require APPROOT . '/views/inc/sideNav.php'; ?>

  <style>
    .switch {
    position: relative;
    display: inline-block;
    width: 90px;
    height: 40px;
    margin: 0 10px;
    }
    .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 34px;
    }

    .switch input {
    display: none;
    }

    .slider:before {
    position: absolute;
    content: "";
    height: 30px;
    width: 30px;
    left: 5px;
    bottom: 5px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50px;
    }

    input:checked + .slider {
    background-color: #ff278c;
    }
    input:checked + .slider:before {
    transform: translateX(50px);
    }

    .DashboardUtilities{
      list-style-type: none;
      font-size: 26px;
    }
  
  </style>

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
           <h1 class="h3 mb-0 text-gray-800">Account</h1>
         </div>



         <!-- Content Row -->

         <div class="row">

           <!-- Area Chart -->
           <div class="col-xl-6 col-lg-6">
             <div class="card shadow mb-4">
               <!-- Card Header - Dropdown -->
               <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                 <h6 class="m-0 font-weight-bold text-primary">Account Info</h6>

               </div>
               <!-- Card Body -->
               <div class="card-body" >
               <form action="<?php echo URLROOT;?>/accountController/changeInfo" method="post">
                    <div class="form-group">
                      <label for="firstName">First Name</label>
                      <input type="text" class="form-control" name="firstName" id="firstName" value="<?php echo $data[0]->User_First_Name;?>">
                    </div>

                    <div class="form-group">
                      <label for="lastName">Last Name</label>
                      <input type="text" class="form-control" name="lastName" id="lastName" value="<?php echo $data[0]->User_Last_Name;?>">
                    </div>


                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="text" class="form-control" name="email" id="email" value="<?php echo $data[0]->Email;?>">
                    </div>

                    <?php if($data[0]->Buisness_User ==="1"): ?>
                      <label for="buisnessUser">Cancel Buisness User Account</label>
                      <input type="checkbox" name="buisnessUser" value="unSub">
                    <?php else: ?>
                      <label for="buisnessUser">Create Buisness User Account</label>
                      <input type="checkbox" name="buisnessUser" value="sub">
                    <?php endif;?>
                    
                    <br>
                    
                    <input id="formButton"  type="submit" value="update" class="btn btn-warning" >
 
                  </form>
               </div>
             </div>
           </div>

           <!-- Pie Chart -->
           <div class="col-xl-6 col-lg-6">
             <div class="card shadow mb-4">
               <!-- Card Header - Dropdown -->
               <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                 <h6 class="m-0 font-weight-bold text-primary">Dashboard Utilities</h6>
               </div>
               <!-- Card Body -->
               <div class="card-body">
                 <ul class="DashboardUtilities">
                    <li>
                        Dashboard Calendar Display
                        <label class="switch">
                            <input id="dashboardCalendar" type="checkbox" <?php echo ($data[0]->Dashboard_Calendar_Display === "1")? 'checked' : ''; ?>/> <span class="slider"></span>
                        </label>
                    </li>
                    <li>
                        Dashboard Project Display
                        <label class="switch">
                            <input id="dashboardProject" type="checkbox" <?php echo ($data[0]->Dashboard_Projects_Display === "1")? 'checked' : ''; ?>/> <span class="slider"></span>
                        </label>
                    </li>
                 </ul>
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
                 <h6 class="m-0 font-weight-bold text-primary">Groups</h6>
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
                 <h6 class="m-0 font-weight-bold text-primary">Change Password</h6>
               </div>
               <div class="card-body">
                 <form action="<?php echo URLROOT;?>/AccountController/changePassword" method="post">
                   <div class="form-group">
                     <label for="oldPassword">Old Password</label>
                     <input type="text" class="form-control" name="oldPassword" id="oldPassword" >
                   </div>

                   <div class="form-group">
                     <label for="newPassword">New Password</label>
                     <input type="text" class="form-control" name="newPassword" id="newPassword"  >
                   </div>

                   <div class="form-group">
                     <label for="confirmNewPassword">Confirm New Password</label>
                     <input type="text" class="form-control" name="confirmNewPassword" id="confirmNewPassword" >
                   </div>

                   <input id="formButton"  type="submit" value="Change" class="btn btn-info" >

                 </form>

               </div>
             </div>

     
           </div>
         </div>

       </div>
       <!-- /.container-fluid -->

     </div>
     <!-- End of Main Content -->

     <?php require APPROOT . '/views/inc/footer.php'; ?>

     <script>
      var dashboardCalendar = document.getElementById("dashboardCalendar");
      dashboardCalendar.addEventListener("change", (event) => {
        var http = new XMLHttpRequest();
        var url = '<?php echo URLROOT; ?>/AccountController/dashboardChange';

        var params = 'id=' + dashboardCalendar.id + '&result=' + dashboardCalendar.checked;
        http.open('POST', url, true);

        //Send the proper header information along with the request
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        http.onreadystatechange = function() {//Call a function when the state changes.
        }
        http.send(params);

      });
      
      var dashboardProject = document.getElementById("dashboardProject");
      dashboardProject.addEventListener("change", (event) => {
        var http = new XMLHttpRequest();
        var url = '<?php echo URLROOT; ?>/AccountController/dashboardChange';

        var params = 'id=' + dashboardProject.id + '&result=' + dashboardProject.checked;
        http.open('POST', url, true);

        //Send the proper header information along with the request
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        http.onreadystatechange = function() {//Call a function when the state changes.
          
        }

        http.send(params);

      });
     </script>

<?php else: ?>
   <?php redirect('userController/login'); ?>
<?php endif;?>
