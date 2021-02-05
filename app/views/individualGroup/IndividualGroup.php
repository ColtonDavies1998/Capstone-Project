<?php if($data["actualUsersGroup"] == true): ?>
    <?php if(isset($_SESSION['user_id'])): ?>
 
    <?php require APPROOT . '/views/inc/header.php'; ?>

    <?php require APPROOT . '/views/inc/sideNav.php'; ?>


    <style>
        #Dashboard{
            display: block;
        }
        #Admin{
            display: none;
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
            <h1 id="projectHeading" class="h3 mb-0 text-gray-800"><?php echo $data["groupInformation"]->Group_Name;?></h1>
       

            <!-- Content Row -->
            <div class="row">
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4" id="dashboardDisplaySection">
                    <div class="card border-primary shadow h-100 py-2" id="dashboardDisplayInner">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-lg font-weight-bold text-primary text-uppercase mb-1" id="dashboardBtnText">Dashboard</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tasks fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            

            <?php if($data["userOwnsThisGroup"] == true):?>
                <div class="col-xl-3 col-md-6 mb-4" id="adminDisplaySection" >
                    <div class="card shadow h-100 py-2" id="adminDisplayInner">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-lg font-weight-bold text-uppercase mb-1" id="adminBtnText">Admin Section</div>
                                </div>
                                <div class="col-auto">     
                                    <i class="fas fa-unlock fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif;?>
        </div>


        <div id="Dashboard">
            <!-- Content Row -->
            <div class="row">
                    <div class="col-xl-7 col-lg-6">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Tasks</h6>
                                <div class="dropdown no-arrow">                           
                            </div>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body" style="overflow-y:scroll;height: 450px; ">
                            <div class="list-group" >
                                <?php foreach($data['groupTasks'] as $tasks):?>
                                    <?php if($tasks->Task_Completed == 0):?>
                                        <a href="#" class="list-group-item list-group-item-action flex-column align-items-start ">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1"><?php echo $tasks->Task_Name; ?></h5>
                                                <small><b>Start Time: </b><?php echo militaryToCivilianTime($tasks->Task_Start_Time); ?></small> 
                                                <small><b>End Time: </b><?php echo militaryToCivilianTime($tasks->Task_End_Time); ?></small>
                                            </div>
                                            <form action="<?php echo URLROOT;?>/IndividualGroupController/deleteTask" method="post">
                                                <input type="hidden" name="taskId" value="<?php echo $tasks->Task_Id ?>">
                                                <input type="submit" class="mb-1 btn btn-success singleTask" value="Delete" class="text-danger" style="color:#f00;border:0px #000 solid;background-color:#fff;">
                                            </form>
                                            <form action="<?php echo URLROOT;?>/IndividualGroupController/taskComplete" method="post">
                                                <input type="hidden" name="taskId" value="<?php echo $tasks->Task_Id ?>">
                                                <input type="submit" class="mb-1 btn btn-danger singleTask" value="Incomplete">
                                            </form>
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
                            <h6 class="m-0 font-weight-bold text-primary">Create New Task Today</h6>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo URLROOT;?>/IndividualGroupController/createTask" method="post">
                            <div class="form-group">
                                <label for="nameInput">Task Name</label>
                                <input type="hidden" class="form-control" name="idInput" id="idInput" value="<?php echo $data["groupInformation"]->Group_Id;?>">
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

            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Users</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body" style="overflow-y:scroll;height: 450px; ">
                            <div class="list-group" >
                                <?php if(sizeof($data['users']) > 0): ?>
                                    <?php foreach($data['users'] as $user):?>
                                        <?php if($user->User_id != $_SESSION['user_id']):?>
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <?php if($user->Img_Link == null):?>
                                                        <img class="img-profile rounded-circle" src="../img/face.png" style="width: 25%;">
                                                    <?php else:?>
                                                        <!-- Change this for when you allow the user to upload files -->
                                                        <img class="img-profile rounded-circle" src="../img/face.png" style="width: 25%;">
                                                    <?php endif;?>                                            
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <h2 style="padding-top: 25px;"><?php echo $user->User_First_Name . " " .$user->User_Last_Name;?></h2>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <button class="btn btn-primary messageBtn " style="margin-top: 25px;" data-messageMode = "message" data-userId = "<?php echo $user->User_id; ?>">Message</button>
                                                </div>
                                            </div>
                                            <hr>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                <?php else: ?>
                                    <h1>There are no other users in this group</h1>
                                <?php endif;?>

                            </div>
                        </div>
                        <div class="card-footer" >
                            <form action="<?php echo URLROOT;?>/IndividualGroupController/sendMessage" method="post">
                                <div class="row">
                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                        <h6>Send To: </h6>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-10">
                                        <h6 id="usersSelected">Nobody Selected</h6>
                                        <input type="hidden" name="userIdForMessage" id="userIdForMessage" value="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-10 col-md-10 col-sm-10">
                                        <textArea name="messageText" rows="6" class="form-control"></textArea>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-6">
                                        <button class="btn btn-success">Send</button>
                                    </div>
                                </div>        
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                 <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">All Project Tasks</h6>
                            </div>
                        <!-- Card Body -->
                        <div class="card-body" style="overflow-y:scroll;height: 450px; overflow-x: scroll;">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" style="">
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

    
    <div id="Admin">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Users</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body" style="overflow-y:scroll;height: 450px; ">
                            <div class="list-group" >
                                <?php if(sizeof($data['users']) > 0): ?>
                                    <?php foreach($data['users'] as $user):?>
                                        <?php if($user->User_id != $_SESSION['user_id']):?>
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <?php if($user->Img_Link == null):?>
                                                        <img class="img-profile rounded-circle" src="../img/face.png" style="width: 25%;">
                                                    <?php else:?>
                                                        <!-- Change this for when you allow the user to upload files -->
                                                        <img class="img-profile rounded-circle" src="../img/face.png" style="width: 25%;">
                                                    <?php endif;?>                                            
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <h2 style="padding-top: 25px;"><?php echo $user->User_First_Name . " " .$user->User_Last_Name;?></h2>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <button class="btn btn-danger removeButton" style="margin-top: 25px;" data-userId = "<?php echo $user->User_id; ?>">Remove</button>
                                                </div>
                                            </div>
                                            <hr>
                                        <?php endif;?>
                                    <?php endforeach;?>                         
                                <?php else: ?>
                                    <h1>There are no other users in this group</h1>
                                <?php endif;?>
                            </div>
                        </div>               
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Search for Users</h6>
                        </div>
                        <div id="searchCardBody" class="card-body" style="overflow-y:scroll;height: 450px; ">
                            
                        </div>
                        <div class="card-footer" >
                            <div class="row">
                                <div class="col-lg-2 col-md-2 col-sm-2">
                                    <h6>First Name: </h6>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                                    <input id="firstNameField" class="form-control">
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2">
                                    <h6>Last Name: </h6>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                                    <input id="lastNameField" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Group Requests</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body" style="overflow-y:scroll;height: 450px; ">
                            <div class="list-group" >
                                <?php if(sizeof($data['groupRequest']) > 0): ?>
                                    <?php foreach($data['groupRequest'] as $user):?>
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <h2 style="padding-top: 25px;"><?php echo $user->Receiver_Name ?></h2>
                                             </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <form action="<?php echo URLROOT;?>/IndividualGroupController/cancelRequest" method="post">
                                                    <input type="hidden" name="otherUserId" value="<?php echo $user->Receiver_Id;?>">
                                                    <input class="btn btn-outline-danger" style="margin-top: 25px;" type="submit" value="Cancel">
                                                </form>      
                                            </div>
                                        </div>
                                        <hr> 
                                    <?php endforeach;?>                         
                                <?php else: ?>
                                    <h1>There are no other requests for this group</h1>
                                <?php endif;?>
                            </div>
                        </div>     
                    </div>
                </div>
            </div>                        
            

            </div>
        </div>
        <!-- /.container-fluid -->
        <?php require APPROOT . '/views/inc/footer.php'; ?>
        </div>
        <!-- End of Main Content -->

        <?php if($data["userOwnsThisGroup"] == true):?>
            <script>
                document.getElementById("adminDisplaySection").addEventListener("click", function(e){
                document.getElementById("Dashboard").style.display = "none";
                document.getElementById("Admin").style.display = "block";

                document.getElementById("dashboardDisplayInner").classList.remove("border-primary");
                document.getElementById("adminDisplayInner").classList.add("border-primary");

                document.getElementById("dashboardBtnText").classList.remove("text-primary");
                document.getElementById("adminBtnText").classList.add("text-primary");

            });

            </script>

        <?php endif; ?>

        <script>
            let messagingList = [];

            document.getElementById("dashboardDisplaySection").addEventListener("click", function(e){
                document.getElementById("Dashboard").style.display = "block";
                document.getElementById("Admin").style.display = "none";

                document.getElementById("dashboardDisplayInner").classList.add("border-primary");
                document.getElementById("adminDisplayInner").classList.remove("border-primary");

                document.getElementById("dashboardBtnText").classList.add("text-primary");
                document.getElementById("adminBtnText").classList.remove("text-primary");
                
            });
            

            function removeUser(e){  
                $.ajax({url: "<?php echo URLROOT; ?>/IndividualGroupController/removeUserFromGroup", async: false, data: {input: e.target.dataset.userid}, success: function(result){
                    location.reload();
                }});
            }

            function userSelected(e){

                messageButtons = document.getElementsByClassName("messageBtn");
                console.log(messageButtons)
                for(let i = 0; i < messageButtons.length; i++){
                    messageButtons[i].classList.remove("btn-outline-primary");
                    messageButtons[i].classList.add("btn-primary");

                    messageButtons[i].innerText = "Message"
                }

                
                e.target.innerText = "Selected";
                e.target.classList.remove("btn-primary")
                e.target.classList.add("btn-outline-primary")
                console.log(e)


                $.ajax({url: "<?php echo URLROOT; ?>/individualGroupController/getUsersName", async: false, data: {userId: e.target.attributes[3].nodeValue}, success: function(result){
                    console.log(result)

                    document.getElementById("usersSelected").innerText = result
                    document.getElementById("userIdForMessage").value = e.target.attributes[3].nodeValue;

                    
                }})
                
            }

          
            let removeBtns = document.getElementsByClassName("removeButton");
            for(let i = 0; i < removeBtns.length; i++){
                removeBtns[i].addEventListener("click", removeUser);
            }

            let messageButtons = document.getElementsByClassName("messageBtn");
            for(let i = 0; i < messageButtons.length; i++){
                messageButtons[i].addEventListener("click", userSelected);
            }

            window.addEventListener('load', (event) => {
                let messageButtons = document.getElementsByClassName("messageBtn");
                for(let i = 0; i < messageButtons.length; i++){
                    messageButtons[i].addEventListener("click", userSelected);
                }
            });




        document.getElementById("firstNameField").addEventListener("keyup", function(e){
            
            let lastName = document.getElementById("lastNameField").value;

            let body = document.getElementById("searchCardBody");

            while (body.firstChild) {
                body.removeChild(body.lastChild);
            }
         
            //Prevents all accounts from being displayed if the user input is empty
            if(e.target.value.trim() != "" || lastName.trim() != ""){
                    $.ajax({url: "<?php echo URLROOT; ?>/individualGroupController/getUsers", async: false, data: {firstName: e.target.value, lastName: lastName}, success: function(result){
                    
                    let data = JSON.parse(result);
                    
                    let searchBody = document.getElementById("searchCardBody");

                    if(data.length <= 10 ){
                        
                        for(let i = 0; i < data.length; i++){
                            let row = document.createElement("div");
                            row.classList.add("row")

                            let nameSection = document.createElement("div");
                            nameSection.classList.add("col-xl-6")
                            nameSection.classList.add("col-lg-6")
                            nameSection.classList.add("col-md-6")
                            nameSection.classList.add("col-sm-6")

                            let ptag = document.createElement("p");
                            ptag.innerText = data[i].User_First_Name + " " + data[i].User_Last_Name

                            let addButtonSection = document.createElement("div");
                            addButtonSection.classList.add("col-xl-6")
                            addButtonSection.classList.add("col-lg-6")
                            addButtonSection.classList.add("col-md-6")
                            addButtonSection.classList.add("col-sm-6")

                            let form = document.createElement("form");
                            form.setAttribute("action", "<?php echo URLROOT;?>/IndividualGroupController/sendGroupInvite")
                            form.setAttribute("method", "POST")

                            let otherUserIdInput = document.createElement("input");
                            otherUserIdInput.setAttribute("type", "hidden")
                            otherUserIdInput.setAttribute("name", "otherUserId")
                            otherUserIdInput.setAttribute("value", data[i].User_Id)

                            let formSubmitBtn = document.createElement("input");
                            formSubmitBtn.setAttribute("type", "submit")
                            formSubmitBtn.setAttribute("value", "Invite")
                            formSubmitBtn.classList.add("btn")
                            formSubmitBtn.classList.add("btn-primary")
                            

                            form.appendChild(otherUserIdInput);
                            form.appendChild(formSubmitBtn);

                            nameSection.appendChild(ptag);
                            addButtonSection.appendChild(form);
                            row.appendChild(nameSection);
                            row.appendChild(addButtonSection);

                            searchBody.appendChild(row);

                        }

                    }else{
                        for(let i = 0; i < 11; i++){
                            let row = document.createElement("div");
                            row.classList.add("row")

                            let nameSection = document.createElement("div");
                            nameSection.classList.add("col-xl-6")
                            nameSection.classList.add("col-lg-6")
                            nameSection.classList.add("col-md-6")
                            nameSection.classList.add("col-sm-6")

                            let ptag = document.createElement("p");
                            ptag.innerText = data[i].User_First_Name + " " + data[i].User_Last_Name

                            let addButtonSection = document.createElement("div");
                            addButtonSection.classList.add("col-xl-6")
                            addButtonSection.classList.add("col-lg-6")
                            addButtonSection.classList.add("col-md-6")
                            addButtonSection.classList.add("col-sm-6")

                            let form = document.createElement("form");
                            form.setAttribute("action", "<?php echo URLROOT;?>/IndividualGroupController/sendGroupInvite")
                            form.setAttribute("method", "POST")

                            let otherUserIdInput = document.createElement("input");
                            otherUserIdInput.setAttribute("type", "hidden")
                            otherUserIdInput.setAttribute("name", "otherUserId")
                            otherUserIdInput.setAttribute("value", data[i].User_Id)

                            let formSubmitBtn = document.createElement("input");
                            formSubmitBtn.setAttribute("type", "submit")
                            formSubmitBtn.setAttribute("value", "Invite")
                            formSubmitBtn.classList.add("btn")
                            formSubmitBtn.classList.add("btn-primary")
                            

                            form.appendChild(otherUserIdInput);
                            form.appendChild(formSubmitBtn);

                            nameSection.appendChild(ptag);
                            addButtonSection.appendChild(form);
                            row.appendChild(nameSection);
                            row.appendChild(addButtonSection);

                            searchBody.appendChild(row);

                        }

                    }

                }});
            }
        });

        document.getElementById("lastNameField").addEventListener("keyup", function(e){
            let firstName = document.getElementById("firstNameField").value;

            let body = document.getElementById("searchCardBody");

            while (body.firstChild) {
                body.removeChild(body.lastChild);
            }

            //Prevents all accounts from being displayed if the user input is empty
            if(e.target.value.trim() != "" || firstName.trim() != ""){
                $.ajax({url: "<?php echo URLROOT; ?>/individualGroupController/getUsers", async: false, data: {firstName: firstName, lastName: e.target.value}, success: function(result){
                    let data = JSON.parse(result);

                    let searchBody = document.getElementById("searchCardBody");

                    if(data.length <= 10 ){
                        
                        for(let i = 0; i < data.length; i++){
                            let row = document.createElement("div");
                            row.classList.add("row")

                            let nameSection = document.createElement("div");
                            nameSection.classList.add("col-xl-6")
                            nameSection.classList.add("col-lg-6")
                            nameSection.classList.add("col-md-6")
                            nameSection.classList.add("col-sm-6")

                            let ptag = document.createElement("p");
                            ptag.innerText = data[i].User_First_Name + " " + data[i].User_Last_Name

                            let addButtonSection = document.createElement("div");
                            addButtonSection.classList.add("col-xl-6")
                            addButtonSection.classList.add("col-lg-6")
                            addButtonSection.classList.add("col-md-6")
                            addButtonSection.classList.add("col-sm-6")

                            let form = document.createElement("form");
                            form.setAttribute("action", "<?php echo URLROOT;?>/IndividualGroupController/sendGroupInvite")
                            form.setAttribute("method", "POST")

                            let otherUserIdInput = document.createElement("input");
                            otherUserIdInput.setAttribute("type", "hidden")
                            otherUserIdInput.setAttribute("name", "otherUserId")
                            otherUserIdInput.setAttribute("value", data[i].User_Id)

                            let formSubmitBtn = document.createElement("input");
                            formSubmitBtn.setAttribute("type", "submit")
                            formSubmitBtn.setAttribute("value", "Invite")
                            formSubmitBtn.classList.add("btn")
                            formSubmitBtn.classList.add("btn-primary")
                            

                            form.appendChild(otherUserIdInput);
                            form.appendChild(formSubmitBtn);

                            nameSection.appendChild(ptag);
                            addButtonSection.appendChild(form);
                            row.appendChild(nameSection);
                            row.appendChild(addButtonSection);

                            searchBody.appendChild(row);

                        }

                    }else{
                        for(let i = 0; i < 11; i++){
                            let row = document.createElement("div");
                            row.classList.add("row")

                            let nameSection = document.createElement("div");
                            nameSection.classList.add("col-xl-6")
                            nameSection.classList.add("col-lg-6")
                            nameSection.classList.add("col-md-6")
                            nameSection.classList.add("col-sm-6")

                            let ptag = document.createElement("p");
                            ptag.innerText = data[i].User_First_Name + " " + data[i].User_Last_Name

                            let addButtonSection = document.createElement("div");
                            addButtonSection.classList.add("col-xl-6")
                            addButtonSection.classList.add("col-lg-6")
                            addButtonSection.classList.add("col-md-6")
                            addButtonSection.classList.add("col-sm-6")

                            let form = document.createElement("form");
                            form.setAttribute("action", "<?php echo URLROOT;?>/IndividualGroupController/sendGroupInvite")
                            form.setAttribute("method", "POST")

                            let otherUserIdInput = document.createElement("input");
                            otherUserIdInput.setAttribute("type", "hidden")
                            otherUserIdInput.setAttribute("name", "otherUserId")
                            otherUserIdInput.setAttribute("value", data[i].User_Id)

                            let formSubmitBtn = document.createElement("input");
                            formSubmitBtn.setAttribute("type", "submit")
                            formSubmitBtn.setAttribute("value", "Invite")
                            formSubmitBtn.classList.add("btn")
                            formSubmitBtn.classList.add("btn-primary")
                            

                            form.appendChild(otherUserIdInput);
                            form.appendChild(formSubmitBtn);

                            nameSection.appendChild(ptag);
                            addButtonSection.appendChild(form);
                            row.appendChild(nameSection);
                            row.appendChild(addButtonSection);

                            searchBody.appendChild(row);

                        }

                    }
                }});
            }


        })



        
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
           
        $.ajax({url: "<?php echo URLROOT; ?>/IndividualGroupController/getGroupTasks", async: false, success: function(result){
            
             
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
            document.getElementById("confirmationOverlay").style.display = "block";
          }

          //This button hides the delete project overlay
          function cancelDeletion() {
            document.getElementById("confirmationOverlay").style.display = "none";
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
        unset($_SESSION["errorData"]) 
        ?>

    <?php else: ?>
    <?php redirect('userController/login'); ?>
    <?php endif;?>

<?php else: ?>
<h1>This group either does not exist or is not connected to your account</h1>

<?php endif;?>






