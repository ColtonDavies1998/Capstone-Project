<?php
/* 
    - The only groups that will be displayed are the groups the user created, there is an empty function in the model
      for when I work on that functionality
*/
  class GroupsController extends Controller {
    public function __construct(){
        $this->groupsModel = $this->model('GroupsModel');
    }

    public function groupsDisplay(){
        $_SESSION['current_page'] = 'Groups';

       

        $data["userCreateGroups"] = $this->groupsModel->getUsersCreatedGroups();
        $data["groups"] = [];

        $otherGroupsIds = $this->groupsModel->getGroupRelation();
        $groups = [];

        


        for($i=0; $i < sizeof($otherGroupsIds); $i++){
            
            array_push($groups, $otherGroupsIds[$i]);
            
        }
        
        
        
        for($i = 0; $i < sizeof($groups); $i++){
            $temp = $this->groupsModel->getGroupInformation($groups[$i]->Group_Id);
            
            array_push($data["groups"], $temp);
        }
        
    

        $this->view('groups/Groups', $data);
    }

    public function createGroup(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //Init Data
            $data = [
            'group_name'=> trim($_POST['GroupNameInput']),
            'group_description'=> trim($_POST['GroupDescription']),
            'group_name_error' => '',
            'group_description_error' => ''
            ];

            //Validate Name
            if(empty($data['group_name'])){
                $data['group_name_error'] = 'Please enter a name for the group';
            }

            if(empty($data['group_name_error'])){
              //Validated
              //Input New Task
    
              if($this->groupsModel->createNewGroup($data)){
                  $groups = $this->groupsModel->getUsersCreatedGroups();
                  $insertedRecords = $this->groupsModel->getGroupRelation();
                  echo "groups: ";
                  var_dump($groups);
                  echo "insertedRecords: ";
                  var_dump($insertedRecords);

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

                  $this->groupsModel->insertGroupRelation($group_id);
                  redirect('GroupsController/groupsDisplay');
                  
              }else{
                  die('Something went Wrong');
              } 
      
    
            }else{
                //Load view with errors
                //$_SESSION['errorData'] = $data;
                echo "error";
                redirect('GroupsController/groupsDisplay');
            }
        }
    }

    public function getGroupInfo(){
        $id =  $_GET['id'];

        $info = $this->groupsModel->getGroupInformation($id);

        echo  json_encode($info);
    }

    public function deleteGroup(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //Init Data
            $groupId = $_POST['deleteGroupId'];

            if($this->groupsModel->deleteGroup($groupId)){
                //flash('task_message', 'Post Removed');

                if($this->groupsModel->deleteGroupConnections($groupId)){
                    redirect('GroupsController/groupsDisplay');
                }else{
                    die('something went wrong');
                }
                
      
            }else{
                die('something went wrong');
            }


        }else{
            redirect('GroupsController/groupsDisplay');
        }
    }

    public function editGroup(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //Init Data
            $data = [
            'group_id'=> trim($_POST['groupEditId']), 
            'group_name'=> trim($_POST['GroupNameEdit']),
            'group_description'=> trim($_POST['GroupDescriptionEdit']),
            'group_name_error' => '',
            'group_description_error' => ''
            ];

            //Validate Name
            if(empty($data['group_name'])){
                $data['group_name_error'] = 'Please enter a name for the group';
            }

            if(empty($data['group_name_error'])){
                //Validated
                //Input New Task
    
                if($this->groupsModel->updateGroupInfo($data)){
                    redirect('GroupsController/groupsDisplay');
                }
            }else{
                die('Something went Wrong');
            } 

        }else{
            redirect('GroupsController/groupsDisplay');
        }
    }
  }