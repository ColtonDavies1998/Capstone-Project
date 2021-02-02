<!-- 
 - When uploading an image, the controller for this view does not accept the file the user gives, later on allow the user to upload
 the file they want to use and find a place to store it.

 - Also need error handeling for the edit delete and create forms, make sure to add error session variable
-->
<?php if(isset($_SESSION['user_id'])): ?>

    <?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/sideNav.php'; ?>


 <!-- Content Wrapper -->
 <div id="content-wrapper" class="d-flex flex-column">

   <!-- Main Content -->
   <div id="content">

     <!-- Topbar -->
     <?php require APPROOT . '/views/inc/topNav.php'; ?>

     <?php if(isset($_SESSION['errorEditData'])):?>
        <style>
            #editNameOverlay{
                display:block!important;
            }
        </style>
     <?php endif;?>

     <!-- Begin Page Content -->
     <div class="container-fluid">
        
       <!-- Page Heading -->
       <h1 class="h3 mb-4 text-gray-800">Projects <a class="addProjectBtn" id="addProjectBtn">+</a></h1>


       <?php $counter = 1;?>
       <?php if(sizeof($data["projects"]) > 0): ?>
        <?php foreach($data['projects'] as $project): ?>
            <?php if($counter == 1):?><div class="row"> <?php endif;?>
                <div class="col-lg-3 col-md-3 col-sm-3 projects" id="project-<?php echo $project->Project_Id; ?>">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary headerLink">
                                <a href="<?php echo URLROOT; ?>/IndividualProjectController/individualProject?projectId=<?php echo $project->Project_Id; ?>"><?php echo $project->Project_Name; ?></a>
                            </h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in dropdownClass" aria-labelledby="dropdownMenuLink" x-placement="bottom-end">
                                    <div class="dropdown-header">Options</div>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item projectEditOption" id="project-<?php echo $project->Project_Id; ?>-edit">Edit Name</a>
                                    <a class="dropdown-item projectDeleteOption" id="project-<?php echo $project->Project_Id; ?>-delete">Delete</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if($project->Project_Img != null):?>
                                <div class="img-wrapper imageLink" style="background-image:url('../img/<?php echo $project->Project_Img; ?>');"></div>
                            <?php else:?>
                                <div class="img-wrapper imageLink" style="background-image:url('../img/face.png');"></div>
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
        <h1>You do not have any Projects</h2>
       <?php endif;?>
     

       <!-- Content Row -->
       
     </div>
     <!-- /.container-fluid -->
     <?php require APPROOT . '/views/inc/footer.php'; ?>
   </div>
   <?php 
    unset($_SESSION['errorEditData']);
   ?>
   <!-- End of Main Content -->
   

   <script>
    

        //This function is called when the edit button is clicked for a project this displays the overlay
        function displayEditOverlay(e){
            document.getElementById("editNameOverlay").style.display = "block";


            let id = e.target.parentElement.parentElement.parentElement.parentElement.parentElement.id
            let idArray = id.split("-");
            id = idArray[1];

            document.getElementById("projectEditId").value = id;

            $.ajax({url: "<?php echo URLROOT; ?>/MultipleProjectsController/getProjectInfo?id=" + id, async: false, success: function(result){
        
                let data = JSON.parse(result);

                document.getElementById("ProjectNameEdit").value = data.Project_Name;
                document.getElementById("ProjectTypeEdit").value = data.Project_Type;
                document.getElementById("currentProjectImg").innerText = data.Project_Img;
                document.getElementById("ProjectDescriptionEdit").value = data.Project_Description;
                
            }});
        }
        

        let projectEditOption = document.getElementsByClassName("projectEditOption");
        let projectDeleteOption = document.getElementsByClassName("projectDeleteOption");

        for(let i = 0; i < projectEditOption.length; i++){
            projectEditOption[i].addEventListener('click', displayEditOverlay);
            projectDeleteOption[i].addEventListener('click', removeProject);
        }

        //This function is called  when the remove project button is clicked
        function removeProject(e){
            let id = e.target.parentElement.parentElement.parentElement.parentElement.parentElement.id
            let idArray = id.split("-");
            id = idArray[1];

            document.getElementById("deleteId").value = id;
            document.getElementById("confirmationOverlay").style.display = "block";
        }
   </script>


   


<?php else: ?>
    <?php redirect('userController/login'); ?>
<?php endif;?>