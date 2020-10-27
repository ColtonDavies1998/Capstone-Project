<?php 
/*
- When uploading an image, the controller for this module does not accept the file the user gives, later on allow the user to upload
the file they want to use and find a place to store it.
*/
class MultipleProjectsController extends Controller { 
    public function __construct(){
        $this->multipleProjectsModel = $this->model('MultipleProjectsModel');
    }

    public function multipleProjects(){
        $_SESSION['current_page'] = 'MultipleProjects';

        $data["projects"] = $this->multipleProjectsModel->getProjects();
        
        $numberOfRows = sizeof($data["projects"]);
        $numberOfRows = ceil($numberOfRows);

        $data["numberOfRows"] = $numberOfRows;

        $this->view('multipleProjects/MultipleProjects', $data);
    }

    public function deleteProject(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
            $projectId = trim($_POST['deleteId']);
    
            
    
            if($this->multipleProjectsModel->deleteProject($projectId)){
              //flash('task_message', 'Post Removed');
              redirect('MultipleProjectsController/multipleProjects');
    
            }else{
              die('something went wrong');
            }
        }else{
            redirect('MultipleProjectsController/multipleProjects');
          }
    }

    public function getProjectInfo(){
        $id =  $_GET['id'];

        $info = $this->multipleProjectsModel->getProjectInformation($id);

        echo  json_encode($info);

    }

    public function editProject(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //Init Data
            $data = [
                'project_id'=> trim($_POST['projectEditId']),
                'project_name'=> trim($_POST['ProjectNameEdit']),
                'project_type'=> trim($_POST['ProjectTypeEdit']),
                'project_img'=> trim($_POST['ProjectImageEdit']),
                'project_Description' => trim($_POST['ProjectDescriptionEdit']),
                'project_name_error' => '',
                'project_type_error' => ''
            ];

            //Validate Name
            if(empty($data['project_name'])){
                $data['project_name_error'] = 'Please enter a name for the project';
            }
            //Validate type
            if(empty($data['project_type'])){
                $data['project_type_error'] = 'Please enter a type for the project';
            }
            

            if(empty($data['project_name_error']) && empty($data['project_type_error'])){
                //Validated
                //Input New Task
                if($this->multipleProjectsModel->editProject($data)){
                    redirect('MultipleProjectsController/multipleProjects');
                }else{
                    die('Something went Wrong');
                } 
            }else{
                //Load view with errors
                //$_SESSION['errorData'] = $data;
                //redirect('MultipleProjectsController/multipleProjects');
            }

        }
    }

    public function createProject(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //Init Data
            $data = [
            'project_name'=> trim($_POST['ProjectNameInput']),
            'project_type'=> trim($_POST['ProjectTypeInput']),
            'project_img'=> trim($_POST['ProjectImageInput']),
            'project_Description' => trim($_POST['ProjectDescription']),
            'project_name_error' => '',
            'project_type_error' => ''
            ];

            //Validate Name
            if(empty($data['project_name'])){
                $data['project_name_error'] = 'Please enter a name for the project';
            }
            //Validate type
            if(empty($data['project_type'])){
                $data['project_type_error'] = 'Please enter a type for the project';
            }
            //validate Img, if image is not given then put default
            if(empty(trim($data['project_img']))){
                $data['project_img'] = "../img/face.png";
            }else{
                //This is the user photo EDIT LATER
                $data['project_img'] = "../img/face.png";
            }

            if(empty($data['project_name_error']) && empty($data['project_type_error'])){
                //Validated

                //Input New Task
                if($this->multipleProjectsModel->createNewProject($data)){
                    redirect('MultipleProjectsController/multipleProjects');
                }else{
                    die('Something went Wrong');
                } 
            }else{
                //Load view with errors
                $_SESSION['errorData'] = $data;
                redirect('MultipleProjectsController/multipleProjects');
            }
        }
    }

}

?>