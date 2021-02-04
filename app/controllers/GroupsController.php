<?php
  /* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */

  /**
   * GroupsController
   * 
   * 
   * @package    Controller
   * @author     Colton Davies
   */
  class GroupsController extends Controller {
  /**
    * 
    * This is the constructor for the class, a common theme for most constructors throughout the project
    * is that they just initialize the model that goes with the controller
    *
    */
    public function __construct(){
        $this->groupsModel = $this->model('GroupsModel');
    }

    /**
     * The groupsDisplay method is called when the user is trying to get to the multipleGroupsDisplay page, 
     * what this method does is get all the data required to allow the view to work
     */
    public function groupsDisplay(){
        //current page is set to groups
        $_SESSION['current_page'] = 'Groups';
        //Gets the groups that the user has created 
        $data["userCreateGroups"] = $this->groupsModel->getUsersCreatedGroups();
        //Creates an empty array of groups
        $data["groups"] = [];
        //Gets the group relation records
        $otherGroupsIds = $this->groupsModel->getGroupRelation();
        $groups = [];
        //goes through the other group ids and pushes them into the array
        for($i=0; $i < sizeof($otherGroupsIds); $i++){
            array_push($groups, $otherGroupsIds[$i]);
        }
        //Gets the group info and pushes it to the data do be used on the view
        for($i = 0; $i < sizeof($groups); $i++){
            //get groups information
            $temp = $this->groupsModel->getGroupInformation($groups[$i]->Group_Id);
            array_push($data["groups"], $temp);
        }
        // Go to view
        $this->view('groups/Groups', $data);
    }

    /**
     * The createGroup method is similar to the create task method in terms of how it works,
     * what it does is takes the input from the form and validates it to make sure everything 
     * is ok, if there are no errors then the createGroup method calls the model and creates a 
     * new group if not it returns with the errors
     */
    public function createGroup(){
        //Checks if the request being made is a post request
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //Init Data
            $data = [
            'group_name'=> trim($_POST['GroupNameInput']),
            'group_description'=> trim($_POST['GroupDescription']),
            'group_name_error' => '',
            ];

            //Checks  if the group name is not empty
            if(empty($data['group_name'])){
                $data['group_name_error'] = 'Please enter a name for the group';
            }
            //Checks if the name error is not set if it is not set than its valid
            if(empty($data['group_name_error'])){
              //Validated, calls the model to create the new group and passes the data through
              if($this->groupsModel->createNewGroup($data)){
                  //Gets all the groups for the user that have been created
                  $groups = $this->groupsModel->getUsersCreatedGroups();
                  //Gets the groups the user has not created
                  $insertedRecords = $this->groupsModel->getGroupRelation();
                  //Declares the group_Id
                  $group_id;
                  for($i = 0; $i < sizeof($groups); $i++){
                    $matchFound = false;
                    for($j = 0; $j < sizeof($insertedRecords); $j++){
                        if($groups[$i]->Group_Id == $insertedRecords[$j]->Group_Id){
                            $matchFound = true;
                            break;
                        }
                    }       
                    if($matchFound == false){
                        $group_id = $groups[$i]->Group_Id;
                        echo $group_id;
                        break;
                    }     
                  }
                  //Inserts group relation
                  $this->groupsModel->insertGroupRelation($group_id);
                  //redirects to the groupsDisplay
                  redirect('GroupsController/groupsDisplay');
                  
              }else{
                  //for testing
                  die('Something went Wrong');
              } 
      
    
            }else{
                //Load view with errors
                $_SESSION['errorData'] = $data;
                redirect('GroupsController/groupsDisplay');
            }
        }
    }

    /**
     * the getGroupInfo method gets the information of a specific group by taking the 
     * id and getting the info from the model. This is called using AJax and is used to 
     * populate the edit group functionality form on the front end
     */
    public function getGroupInfo(){
        //gets the id
        $id =  $_GET['id'];
        //calls the model to get the group infromation from the model
        $info = $this->groupsModel->getGroupInformation($id);
        //echos out the  information and encodes it using JSON to encode
        echo  json_encode($info);
    }

    /**
     * the deleteGroup method is for deleting individual groups. There is a form on 
     * the front end that stores an id and then when submitted it checks if the id is 
     * matched to the user and then deletes it.
     */
    public function deleteGroup(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //Init Data
            $groupId = $_POST['deleteGroupId'];
            //checks to make sure the user id is not changed and that the user can only delete groups they created
            $validationCheck = $this->groupsModel->validationCheck($groupId);
            //So if the size is greater than 0 that means they can delete the group
            if(sizeof($validationCheck) > 0){
                //deletes the group
                if($this->groupsModel->deleteGroup($groupId)){
                    //Deletes all the connections to that group
                    if($this->groupsModel->deleteGroupConnections($groupId)){
                        //redirects to the group display
                        redirect('GroupsController/groupsDisplay');
                    }else{
                        //for testing
                        die('something went wrong');
                    }
                }else{
                    //for testing
                    die('something went wrong');
                }
            }else{
                //redirects
                redirect('GroupsController/groupsDisplay');
            }
        }else{
            //redirects
            redirect('GroupsController/groupsDisplay');
        }
    }

    /**
     * The editGroup method is called when the edit form is submitted on the website,
     * this form much like the createGroup method, it checks to validate the information 
     * given and if there are no errors then the group is edited if not then it is returned with errors
     */
    public function editGroup(){
        //Checks if the request is a POST
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //Init Data
            $data = [
            'group_id'=> trim($_POST['groupEditId']), 
            'group_name'=> trim($_POST['GroupNameEdit']),
            'group_description'=> trim($_POST['GroupDescriptionEdit']),
            'group_name_error' => '',
            ];

            //Checks if the group name is empty if it is then set error
            if(empty($data['group_name'])){
                $data['group_name_error'] = 'Please enter a name for the group';
            }
            //Checks for any errors
            if(empty($data['group_name_error'])){
                //Validated
                if($this->groupsModel->updateGroupInfo($data)){
                    //redirects
                    redirect('GroupsController/groupsDisplay');
                }else{
                    //for testing
                    die('Something went Wrong');
                }
            }else{
                //redirects
                $_SESSION['errorEditData'] = $data;
                redirect('GroupsController/groupsDisplay');
            } 

        }else{
            //redirects
            redirect('GroupsController/groupsDisplay');
        }
    }

    /**
     * This function is used when a user wants to leave a group. This only works for groups the user is apart of that they did 
     * not create. This deletes the connection record between the user and the group
     */
    public function leaveGroup(){
        $groupId = $_GET["groupId"];

        $this->groupsModel->deleteGroupUserConnection($groupId);

        redirect('GroupsController/groupsDisplay');
    }
  }