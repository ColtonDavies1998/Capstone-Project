<?php if(isset($_SESSION['user_id'])): ?>

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
   <h1 class="h3 mb-4 text-gray-800">Groups <a class="addProjectBtn" id="addGroupsBtn">+</a></h1>
    <?php $counter = 1;?>
       <?php if(sizeof($data["groups"]) > 0): ?>
        <?php foreach($data["groups"] as $group): ?>
            <?php $trigger = false; ?>
            <?php if($counter == 1):?><div class="row"> <?php endif;?>
                <div class="col-lg-3 col-md-3 col-sm-3 groups" id="group-<?php echo $group->Group_Id; ?>">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <a href="<?php echo URLROOT;?>/IndividualGroupController/individualGroup?groupId=<?php echo $group->Group_Id; ?>" class="m-0 font-weight-bold text-primary headerLink"><?php echo $group->Group_Name; ?></a>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in dropdownClass" aria-labelledby="dropdownMenuLink" x-placement="bottom-end">
                                    <?php foreach($data["userCreateGroups"] as $createdGroup): ?>
                                        <?php if($createdGroup->Group_Id ==  $group->Group_Id): ?>
                                            <?php $trigger = true;?>
                                            <?php break;?>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                    <?php if($trigger == true):?>
                                        <div class="dropdown-header">Options</div>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item groupEditOption" id="group-<?php echo $group->Group_Id; ?>-edit">Edit Name</a>
                                        <a class="dropdown-item groupDeleteOption" id="group-<?php echo $group->Group_Id; ?>-delete">Delete</a>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if($group->Group_Img != null):?>
                                <a href="<?php echo URLROOT;?>/IndividualGroupController/individualGroup?groupId=<?php echo $group->Group_Id; ?>" class="img-wrapper imageLink" style="background-image:url('../img/<?php echo $group->Group_Img; ?>');"></a>
                            <?php else:?>
                                <a href="<?php echo URLROOT;?>/IndividualGroupController/individualGroup?groupId=<?php echo $group->Group_Id; ?>" class="img-wrapper imageLink" style="background-image:url('../img/face.png');"></a>
                            <?php endif;?>
                            
                        </div>
                    </div>
                </div>
            <?php if($counter == 4):?></div> <?php endif;?>
            <?php if($counter == 4):?>
                <?php $counter = 1; ?>
            <?php else: ?>
                <?php $counter++; ?>
            <?php endif;?>
        <?php endforeach;?>
            <?php if($counter != 4):?>
                </div>
            <?php endif;?>
       <?php else:?>
        <h1>You do not have any Groups</h1>
       <?php endif;?>
  
 

   <!-- Content Row -->
 </div>
 <!-- /.container-fluid -->
 <?php require APPROOT . '/views/inc/footer.php'; ?>
</div>
<!-- End of Main Content -->

<script>
    

        //This function is called when the edit button is clicked for a project this displays the overlay
        function displayEditOverlay(e){
            document.getElementById("editNameOverlay").style.display = "block";


            let id = e.target.parentElement.parentElement.parentElement.parentElement.parentElement.id
            let idArray = id.split("-");
            id = idArray[1];

            document.getElementById("groupEditId").value = id;
            
            $.ajax({url: "<?php echo URLROOT; ?>/GroupsController/getGroupInfo?id=" + id, async: false, success: function(result){
                
                let data = JSON.parse(result);
                console.log(data);
                document.getElementById("GroupNameEdit").value = data.Group_Name;
                //document.getElementById("currentProjectImg").innerText = data.Project_Img;
                document.getElementById("GroupDescriptionEdit").value = data.Group_Description;
                
            }}); 
        }
        

        let groupEditOption = document.getElementsByClassName("groupEditOption");
        let groupDeleteOption = document.getElementsByClassName("groupDeleteOption");

        for(let i = 0; i < groupEditOption.length; i++){
            groupEditOption[i].addEventListener('click', displayEditOverlay);
            groupDeleteOption[i].addEventListener('click', removeGroup);
        }

        //This function is called  when the remove project button is clicked
        function removeGroup(e){
            let id = e.target.parentElement.parentElement.parentElement.parentElement.parentElement.id
            let idArray = id.split("-");
            id = idArray[1];

            document.getElementById("deleteGroupId").value = id;
            document.getElementById("confirmationOverlay").style.display = "block";
        }
   </script>




<?php else: ?>
<?php redirect('userController/login'); ?>
<?php endif;?>