<?php 
/* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */

 /**
   * MultipleProjectsController
   * 
   * 
   * @package    Controller
   * @author     Colton Davies
   */
class MultipleProjectsController extends Controller { 

   /**
    * 
    * This is the constructor for the class, a common theme for most constructors throughout the project
    * is that they just initialize the model that goes with the controller
    *
    */
    public function __construct(){
        $this->multipleProjectsModel = $this->model('MultipleProjectsModel');
    }

    /**
     * This is the main method of the class, this is the method is called whenever the user wants to 
     * access the page. This method gets all the data required for the view to load and then loads the view
     */
    public function multipleProjects(){
        //Sets the current page to multipleprojects
        $_SESSION['current_page'] = 'MultipleProjects';
        //Stores the users projects 
        $data["projects"] = $this->multipleProjectsModel->getProjects();
        //Gets the number of rows to display
        $numberOfRows = sizeof($data["projects"]);
        $numberOfRows = ceil($numberOfRows);

        $data["numberOfRows"] = $numberOfRows;
        //load the view
        $this->view('multipleProjects/MultipleProjects', $data);
    }

    /**
     * This method when called deletes a project
     */
    public function deleteProject(){
        //checks if this is a post request
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $projectId = trim($_POST['deleteId']);
            //makes sure the user did not change the HTML on the front end to delete someone elses id
            $validate = $this->multipleProjectsModel->getProjectInformation($projectId);
            //Checks if the record exists
            if(sizeof($validate) > 0){
                if($this->multipleProjectsModel->deleteProject($projectId)){
                    //redirect
                    redirect('MultipleProjectsController/multipleProjects');
          
                  }else{
                    //for testing purposes
                    die('something went wrong');
                  }

            }else{
                //redirect
                redirect('MultipleProjectsController/multipleProjects');
            }
        }else{
            //redirect
            redirect('MultipleProjectsController/multipleProjects');
          }
    }

    /**
     * When this method is called it gets the information for a given project using the project Id
     */
    public function getProjectInfo(){
        $id =  $_GET['id'];
        //gets the projects information
        $info = $this->multipleProjectsModel->getProjectInformation($id);

        echo  json_encode($info);

    }

    /**
     * When this method is called it checks for errors on the edit project form has submittied, if everything is correct
     * then the model is called
     */
    public function editProject(){
        //Checks if the request is a post request
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
                    //For testing purposes
                    die('Something went Wrong');
                } 
            }else{
                //Load view with errors
                $_SESSION['errorEditData'] = $data;
                redirect('MultipleProjectsController/multipleProjects');
            }

        }
    }

    /**
     * This method when contacted creates a project and validates the input of the users
     */
    public function createProject(){
        //check for the type of request
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