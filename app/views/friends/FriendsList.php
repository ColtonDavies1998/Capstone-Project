<?php if(isset($_SESSION['user_id'])): ?>

    <?php require APPROOT . '/views/inc/header.php'; ?>

    <!-- Sidebar -->
    <?php require APPROOT . '/views/inc/sideNav.php'; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php require APPROOT . '/views/inc/topNav.php'; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->

          <!--====================MY CODE==================-->


          <h1 class="h3 mb-4 text-gray-800">Friends List</h1>

          <div class="row">
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Friends</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body" style="overflow-y:scroll;height: 450px; ">
                        <?php foreach($data['friendsList'] as $friends):?>
                            <div class="row">
                                <?php if($friends->PersonOneName != $_SESSION['user_name']): ?>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                        <p><?php echo $friends->PersonOneName; ?></p>
                                    </div>
                                <?php else: ?>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                        <p><?php echo $friends->PersonTwoName; ?></p>
                                    </div>
                                <?php endif;?>
                                
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                            <form action="<?php echo URLROOT;?>/FriendsListController/messageFriend" method="post">
                                                <?php if($friends->PersonOneId != $_SESSION['user_id']): ?>
                                                    <input type="hidden" value="<?php echo $friends->PersonOneId; ?>" name="friendsId">
                                                <?php else: ?>
                                                    <input type="hidden" value="<?php echo $friends->PersonTwoId; ?>" name="friendsId">
                                                <?php endif;?>
                                                
                                                <input type="submit" value="message" class="btn btn-outline-primary">
                                            </form>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                            <form action="<?php echo URLROOT;?>/FriendsListController/removeFriend" method="post">
                                                <input type="hidden" value="<?php echo $friends->FriendConnectionId; ?>" name="friendConnectionId">
                                                <input type="submit" value="remove" class="btn btn-outline-danger">
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>   
                        <?php endforeach;?>
                        
                    </div>
                </div>
             </div>


                <div class="col-xl-6 col-lg-6">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Search for friends</h6>
                            </div>
                            <!-- Card Body -->
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
                    <div class="col-xl-6 col-lg-6">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Friend Requests sent</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body" style="overflow-y:scroll;height: 450px; ">
                                <?php foreach($data['friendRequestsSent'] as $tasks):?>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                            <p><?php echo $tasks->ReceiverName; ?></p>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                            <form action="<?php echo URLROOT;?>/FriendsListController/cancelFriendRequest" method="post">
                                                <input type="hidden" value="<?php echo $tasks->FriendConnectionId; ?>" name="friendConnectionId">
                                                <input type="submit" value="cancel" class="btn btn-outline-danger">
                                            </form>
                                        </div>
                                    </div>
                                 
                                <?php endforeach;?>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Friend Requests </h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body" style="overflow-y:scroll;height: 450px; ">
                            <?php foreach($data['incomingFriendRequests'] as $tasks):?>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                            <p><?php echo $tasks->SenderName; ?></p>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                    <form action="<?php echo URLROOT;?>/FriendsListController/declineFriendRequest" method="post">
                                                        <input type="hidden" value="<?php echo $tasks->FriendConnectionId; ?>" name="friendConnectionId">
                                                        <input type="submit" value="decline" class="btn btn-outline-danger">
                                                    </form>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                    <form action="<?php echo URLROOT;?>/FriendsListController/acceptFriendRequest" method="post">

                                                        <?php if($tasks->SenderId == $_SESSION["user_id"]): ?>
                                                            <input type="hidden" value="<?php echo $tasks->ReceiverId; ?>" name="senderId">
                                                        <?php else:?>
                                                            <input type="hidden" value="<?php echo $tasks->SenderId; ?>" name="senderId">
                                                        <?php endif;?>
                                                        <input type="hidden" value="<?php echo $tasks->FriendConnectionId; ?>" name="friendConnectionId">
                                                        
                                                        <input type="submit" value="accept" class="btn btn-outline-success">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-6 col-lg-6">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">group Requests </h6>
                            </div>
                            <div class="card-body" style="overflow-y:scroll;height: 450px; ">
                            <?php foreach($data['groupRequests'] as $groupRequests):?>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                            <p><?php echo $groupRequests->Group_Name; ?></p>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                    <form action="<?php echo URLROOT;?>/FriendsListController/declineGroupRequest" method="post">
                                                        <input type="hidden" value="<?php echo $groupRequests->Group_Request_Connection_Id; ?>" name="groupConnectionId">
                                                        <input type="submit" value="decline" class="btn btn-outline-danger">
                                                    </form>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                    <form action="<?php echo URLROOT;?>/FriendsListController/acceptGroupRequest" method="post">
                                                        <input type="hidden" value="<?php echo $groupRequests->Group_Request_Connection_Id; ?>" name="groupConnectionId">
                                                        <input type="submit" value="accept" class="btn btn-outline-success">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

    
        </div>


        <?php require APPROOT . '/views/inc/footer.php'; ?>
        
          <!--====================END OF MY CODE==================-->

      </div>
        <!-- /.container-fluid -->
        
    </div>
      <!-- End of Main Content -->


    <script>
        document.getElementById("firstNameField").addEventListener("keyup", function(e){
            
            let lastName = document.getElementById("lastNameField").value;

            let body = document.getElementById("searchCardBody");

            while (body.firstChild) {
                body.removeChild(body.lastChild);
            }
         
            //Prevents all accounts from being displayed if the user input is empty
            if(e.target.value.trim() != "" || lastName.trim() != ""){
                    $.ajax({url: "<?php echo URLROOT; ?>/FriendsListController/getUsers", async: false, data: {firstName: e.target.value, lastName: lastName}, success: function(result){
                    
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
                            form.setAttribute("action", "<?php echo URLROOT;?>/FriendsListController/sendFriendRequest")
                            form.setAttribute("method", "POST")

                            let otherUserIdInput = document.createElement("input");
                            otherUserIdInput.setAttribute("type", "hidden")
                            otherUserIdInput.setAttribute("name", "otherUserId")
                            otherUserIdInput.setAttribute("value", data[i].User_Id)

                            let formSubmitBtn = document.createElement("input");
                            formSubmitBtn.setAttribute("type", "submit")
                            formSubmitBtn.setAttribute("value", "Add")
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
                            form.setAttribute("action", "<?php echo URLROOT;?>/FriendsListController/sendFriendRequest")
                            form.setAttribute("method", "POST")

                            let otherUserIdInput = document.createElement("input");
                            otherUserIdInput.setAttribute("type", "hidden")
                            otherUserIdInput.setAttribute("name", "otherUserId")
                            otherUserIdInput.setAttribute("value", data[i].User_Id)

                            let formSubmitBtn = document.createElement("input");
                            formSubmitBtn.setAttribute("type", "submit")
                            formSubmitBtn.setAttribute("value", "Add")
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
                $.ajax({url: "<?php echo URLROOT; ?>/FriendsListController/getUsers", async: false, data: {firstName: firstName, lastName: e.target.value}, success: function(result){
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
                            form.setAttribute("action", "<?php echo URLROOT;?>/FriendsListController/sendFriendRequest")
                            form.setAttribute("method", "POST")

                            let otherUserIdInput = document.createElement("input");
                            otherUserIdInput.setAttribute("type", "hidden")
                            otherUserIdInput.setAttribute("name", "otherUserId")
                            otherUserIdInput.setAttribute("value", data[i].User_Id)

                            let formSubmitBtn = document.createElement("input");
                            formSubmitBtn.setAttribute("type", "submit")
                            formSubmitBtn.setAttribute("value", "Add")
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
                            form.setAttribute("action", "<?php echo URLROOT;?>/FriendsListController/sendFriendRequest")
                            form.setAttribute("method", "POST")

                            let otherUserIdInput = document.createElement("input");
                            otherUserIdInput.setAttribute("type", "hidden")
                            otherUserIdInput.setAttribute("name", "otherUserId")
                            otherUserIdInput.setAttribute("value", data[i].User_Id)

                            let formSubmitBtn = document.createElement("input");
                            formSubmitBtn.setAttribute("type", "submit")
                            formSubmitBtn.setAttribute("value", "Add")
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

      

     
<?php else: ?>
    <?php redirect('userController/login'); ?>
<?php endif;?>