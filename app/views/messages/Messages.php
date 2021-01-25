<?php if(isset($_SESSION['user_id'])): ?>

<?php require APPROOT . '/views/inc/header.php'; ?>

<!-- Sidebar -->
<?php require APPROOT . '/views/inc/sideNav.php'; ?>
<!-- End of Sidebar -->
<style>
.friendItem:hover{
    background-color:#6c757d!important;
}


/* message styles */

.messageContainer {
  border: 2px solid #dedede;
  background-color: #f1f1f1;
  border-radius: 5px;
  padding: 10px;
  margin: 10px 0;
}

.darker {
  border-color: #ccc;
  background-color: #ddd;
}

.messageContainer::after {
  content: "";
  clear: both;
  display: table;
}

.messageContainer img {
  float: left;
  max-width: 60px;
  width: 100%;
  margin-right: 20px;
  border-radius: 50%;
}

.messageContainer img.right {
  float: right;
  margin-left: 20px;
  margin-right:0;
}

.time-right {
  float: right;
  color: #aaa;
}

.time-left {
  float: left;
  color: #999;
}

</style>
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

        <h1 class="h3 mb-4 text-gray-800">Messages</h1>
        <div class="row">
            <div class="col-xl-4 col-lg-4">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Friends</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body" style="overflow-y:scroll;height: 450px; ">    
                        <?php $count = 0; ?>
                        <?php foreach($data['messagesFrom'] as $connection):?>
                            <div class="list-group">
                                <?php 
                                
                                if($connection->Group_Id == null){
                                    $temp = "user-id-" . $connection->User_Id . " group-id-" . "null";
                                }else{
                                    $temp = "user-id-" . $connection->User_Id . " group-id-"  . $connection->Group_Id;
                                }
                                ?>
                                <a id="<?php echo $temp;?>" class="friend-list-item list-group-item list-group-item-action <?= ($count == 0)? 'active' :  ''; ?>">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4">
                                            <img src="img_girl.jpg" >
                                        </div>
                                        <div class="col-xl-8 col-lg-8">
                                            <h5 style=""><?php echo $connection->First_Name . " " . $connection->Last_Name; ?> <?= ($connection->Group_Id != null)? '(' . $connection->Group_Name  .')' :  ''; ?></h5>
                                        </div>
                                    </div>           
                                </a>
     
                            </div>
                            <?php $count = $count + 1; ?>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>


            <div class="col-xl-8 col-lg-8">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Messages</h6>
                        </div>
                        <!-- Card Body -->
                        <div id="chatCardBody" class="card-body" style="overflow-y:scroll;height: 450px; ">
                            <?php foreach(array_reverse($data['defaultConvo']) as $messages):?> 
                                <?php if($messages->Message_Sent_By_Id == $_SESSION['user_id']):?>
                                    <div class="messageContainer darker">
                                        <h5><?php echo $messages->Sender_Name; ?>:</h5>
                                        <p><?php echo $messages->Message_Info;?></p>
                                        <span class="time-right"><?php echo $messages->Date_Time_Sent ?></span>
                                    </div>
                                <?php else: ?>
                                    <div class="messageContainer">
                                    <h5><?php echo $messages->Sender_Name; ?>:</h5>
                                        <p><?php echo $messages->Message_Info;?></p>
                                        <span class="time-right"><?php echo $messages->Date_Time_Sent ?></span>
                                    </div>
                                <?php endif;?>             
                            <?php endforeach;?>
                        </div>
                        <div class="card-footer" >
                            <div class="row">
                                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                                    <textarea class="form-control" id="msgTextArea" rows="3"></textarea>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
                                    <button id="sendBtn" type="button" class="btn btn-primary btn-lg">Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
  
    window.addEventListener('load', (event) => {
        var friendItems = document.getElementsByClassName("friend-list-item");
       

        var div = document.getElementById("chatCardBody");
        div.scrollTop = div.scrollHeight - div.clientHeight;

        for(let i = 0; i < friendItems.length; i++){
            friendItems[i].addEventListener("click", function(e){
             
                if(e.target.parentNode.parentNode.parentNode.classList.contains('friend-list-item')){
                    let correctNode = e.target.parentNode.parentNode.parentNode;
                  
                    if(!correctNode.classList.contains('active')){
                        const chatCardBodyNode = document.getElementById("chatCardBody");

                        while (chatCardBodyNode.firstChild) {
                            chatCardBodyNode.removeChild(chatCardBodyNode.lastChild);
                        }
                        
                        for(let j = 0; j < friendItems.length; j++){
                            if(friendItems[j].classList.contains('active')){
                                friendItems[j].classList.remove('active')
                            }
                        }
                        correctNode.classList.add('active');

                        let otherUserId = correctNode.getAttribute("id");
                        getMessages(otherUserId)
      
                    }

                }else if(e.target.parentNode.parentNode.classList.contains('card-body')){
                    let correctNode = e.target;
                  
                    if(!correctNode.classList.contains('active')){

                        const chatCardBodyNode = document.getElementById("chatCardBody");

                        while (chatCardBodyNode.firstChild) {
                            chatCardBodyNode.removeChild(chatCardBodyNode.lastChild);
                        }
                        
                        for(let j = 0; j < friendItems.length; j++){
                            if(friendItems[j].classList.contains('active')){
                                friendItems[j].classList.remove('active')
                            }
                        }
                        correctNode.classList.add('active');
                        let otherUserId = correctNode.getAttribute("id");
                        getMessages(otherUserId)
          
                    }
                }else{
                    let correctNode = e.target.parentNode.parentNode;
                   
                    if(!correctNode.classList.contains('active')){

                        const chatCardBodyNode = document.getElementById("chatCardBody");

                        while (chatCardBodyNode.firstChild) {
                            chatCardBodyNode.removeChild(chatCardBodyNode.lastChild);
                        }
                        
                        for(let j = 0; j < friendItems.length; j++){
                            if(friendItems[j].classList.contains('active')){
                                friendItems[j].classList.remove('active')
                            }
                        }
                        correctNode.classList.add('active');
                        let otherUserId = correctNode.getAttribute("id");
                        getMessages(otherUserId)
                        
                        
                    }
                }

                


                function getMessages(otherUserId){
                    let temp = otherUserId.split(" ");
                    

                    let tempUserId = temp[0].split("-");
                    let UserId = tempUserId[2];

                    let tempGroupId = temp[1].split("-");
                    let GroupId = tempGroupId[2]

             

                    
                    $.ajax({url: "<?php echo URLROOT; ?>/MessageController/getMessages", async: false, data: {otherUserId: UserId, groupId: GroupId}, success: function(result){
                        document.getElementById("msgTextArea").value = ""

                        messages = JSON.parse(result)

                        

                        for(let z = 0; z < messages.length; z++){
                            if(messages[z].Message_Sent_By_Id == "<?php echo $_SESSION["user_id"] ?>"){
                                let div = document.createElement("div");
                                div.classList.add("messageContainer");
                                div.classList.add("darker");

                                //NEW
                                let hFiveTag = document.createElement("h5");
                                hFiveTag.innerText = messages[z].Sender_Name + ":";
                                

                                let ptag = document.createElement("p");
                                ptag.innerText = messages[z].Message_Info;

                                let span = document.createElement("span");
                                span.classList.add("time-right")
                                span.innerText = messages[z].Date_Time_Sent;

                                div.appendChild(hFiveTag);
                                div.appendChild(ptag);
                                div.appendChild(span);

                                document.getElementById("chatCardBody").appendChild(div);

                            }else{
                                let div = document.createElement("div");
                                div.classList.add("messageContainer");

                                let hFiveTag = document.createElement("h5");
                                hFiveTag.innerText = messages[z].Sender_Name +":";

                                let ptag = document.createElement("p");
                                ptag.innerText = messages[z].Message_Info;

                                let span = document.createElement("span");
                                span.classList.add("time-right")
                                span.innerText = messages[z].Date_Time_Sent;

                                div.appendChild(hFiveTag);
                                div.appendChild(ptag);
                                div.appendChild(span);

                                document.getElementById("chatCardBody").appendChild(div);

                            }
                         }  

                        var chartCarddiv = document.getElementById("chatCardBody");
                        chartCarddiv.scrollTop = chartCarddiv.scrollHeight - chartCarddiv.clientHeight;           
                  
                    }});


                }

            })
        }





        //Send message functionality
        document.getElementById("sendBtn").addEventListener("click", function(){
            let messageText = document.getElementById("msgTextArea").value;
            messageText = messageText.trim();
            messageText = String(messageText);
            let otherUserId;
            var friends = document.getElementsByClassName("friend-list-item");

            for(let i = 0; i < friends.length; i++){
                if(friends[i].classList.contains("active")){
                    domOtherUserId = friends[i].getAttribute("id");
                    break;
                }
            }

            
            
            let temp = domOtherUserId.split(" ")
            let tempGroupId = temp[1];
            let tempOtherUserId = temp[0];
  

            tempGroupId = tempGroupId.split("-");
            tempOtherUserId = tempOtherUserId.split("-");

            groupId = tempGroupId[2]
            otherUserId = tempOtherUserId[2]


            $.ajax({url: "<?php echo URLROOT; ?>/MessageController/sendNewMessage", async: false, data: {message: messageText, userId: otherUserId, groupId: groupId}, success: function(result){

                document.getElementById("msgTextArea").value = ""

                messages = JSON.parse(result)

           

                let chatCardBody = document.getElementById("chatCardBody");

                while (chatCardBody.firstChild) {
                    chatCardBody.removeChild(chatCardBody.lastChild);
                }
                
                
 
                for(let i = messages.length - 1; i >= 0; i--){
                    let div = document.createElement("div");
                    div.classList.add("messageContainer")
                    if(messages[i].Message_Sent_By_Id == "<?php echo $_SESSION['user_id'];?>"){
                        div.classList.add("darker")
                    }

                    let hFive = document.createElement("h5");
                    hFive.innerText = messages[i].Sender_Name;

                    let ptag = document.createElement("p");
                    ptag.innerText = messages[i].Message_Info;

                    let span = document.createElement("span");
                    span.innerText = messages[i].Date_Time_Sent;
                    span.classList.add("time-right")



                    div.appendChild(hFive)
                    div.appendChild(ptag)
                    div.appendChild(span)

                    chatCardBody.appendChild(div)

                    
                }
           
                

            }});
            
        })


    });
    
    </script>

    <?php require APPROOT . '/views/inc/footer.php'; ?>
    
      <!--====================END OF MY CODE==================-->

  </div>
    <!-- /.container-fluid -->
    
</div>
  <!-- End of Main Content -->




  

 
<?php else: ?>
<?php redirect('userController/login'); ?>
<?php endif;?>