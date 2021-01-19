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
                <div class="col-xl-7 col-lg-6">
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
                            <div class="row">
                                        <div class="col-lg-2 col-md-2 col-sm-2">
                                            <h6>Send To: </h6>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-10">
                                            <h6 id="usersSelected">Nobody Selected</h6>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-10 col-md-10 col-sm-10">
                                            <textArea rows="6" class="form-control"></textArea>
                                        </div>
                                        <div class="col-lg-2 col-md-6 col-sm-6">
                                            <button class="btn btn-success">Send</button>
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
            document.getElementById("adminDisplaySection").addEventListener("click", function(e){
                document.getElementById("Dashboard").style.display = "none";
                document.getElementById("Admin").style.display = "block";

                document.getElementById("dashboardDisplayInner").classList.remove("border-primary");
                document.getElementById("adminDisplayInner").classList.add("border-primary");

                document.getElementById("dashboardBtnText").classList.remove("text-primary");
                document.getElementById("adminBtnText").classList.add("text-primary");

            });

            function removeUser(e){  
                $.ajax({url: "<?php echo URLROOT; ?>/IndividualGroupController/removeUserFromGroup", async: false, data: {input: e.target.dataset.userid}, success: function(result){
                    location.reload();
                }});
            }

            function addUserToMsgList(e){
               
              
                if(e.target.dataset.messagemode == "message"){

                    let userAlreadyInList = false;

                    for(let i = 0; i < messagingList.length; i++){
                        if(messagingList[i].id == e.target.dataset.userid){
                            userAlreadyInList = true;
                            break;
                        }
                    }

                    if(userAlreadyInList == false){
                        let messageObj = {
                            id: e.target.dataset.userid,
                            name: e.target.parentElement.parentElement.childNodes[3].innerText
                        }

                        messagingList[messagingList.length] = messageObj;

                        e.target.classList.remove("btn-primary")
                        e.target.classList.add("btn-outline-primary")

                        e.target.innerText = "Selected"

                        e.target.dataset.messagemode = "selected"

                        let stringDisplay = "";
                        document.getElementById("usersSelected").innerText = "";

                       

                        for(let j = 0; j < messagingList.length; j++){
                            if(j == 0 ){
                                stringDisplay += messagingList[j].name
                            }else if(j == messagingList.length - 1){
                                stringDisplay += ", " + messagingList[j].name
                            }else{
                                stringDisplay += ", " + messagingList[j].name
                            }
                            
                        }
                        document.getElementById("usersSelected").innerText = stringDisplay;

                    }
                    
                }else{
               

                    e.target.dataset.messagemode = "message" 

                    e.target.classList.remove("btn-outline-primary")  
                    e.target.classList.add("btn-primary")

                    e.target.innerText = "Message"

                   
                    let counter = 0;
                    let temp = []

                    for(let i = 0; i < messagingList.length; i++){
                        if(messagingList[i].id != e.target.dataset.userid){
                            temp[counter] =  messagingList[i]
                            counter++;
                        }
                    }

                    
                    messagingList = [];
                    counter = 0;
                    
                    for(let j = 0; j < temp.length; j++){
                        messagingList[counter] = temp[j];
                        counter++;
                    }

                    console.log(messagingList)

                    let stringDisplay = "";
                    document.getElementById("usersSelected").innerText = "";

                    for(let j = 0; j < messagingList.length; j++){
                        if(j == 0 ){
                            stringDisplay += messagingList[j].name
                        }else if(j == messagingList.length - 1){
                            stringDisplay += ", " + messagingList[j].name
                        }else{
                            stringDisplay += ", " + messagingList[j].name
                        }
         
                    }

                    if(messagingList.length == 0){
                        document.getElementById("usersSelected").innerText = "Nobody Selected";
                    }else{
                        document.getElementById("usersSelected").innerText = stringDisplay;
                    }
                    

                }
            }


            let removeBtns = document.getElementsByClassName("removeButton");
            for(let i = 0; i < removeBtns.length; i++){
                removeBtns[i].addEventListener("click", removeUser);
            }

            let messageButtons = document.getElementsByClassName("messageBtn");
            for(let i = 0; i < messageButtons.length; i++){
                messageButtons[i].addEventListener("click", addUserToMsgList);
            }





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






