<?php 
  /* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */

 /**
   * MultipleProjectsModel
   *
   * @author     Colton Davies
   */
class MultipleProjectsModel{
    //create private db variable
    private $db;

    /**
    * This constructor initializes the database and sets it to the private variable we created above. 
    * This is so it can be accessed throughout the class
    */
    public function __construct(){
        $this->db = new Database;
    }

    /**
     * 
     * This method gets all the projects in the users account
     * 
     * @return object
     */
    public function getProjects(){
        $this->db->query('SELECT * FROM projects WHERE User_Id = :userId' );
        //bind
        $this->db->bind(':userId', $_SESSION['user_id']);
        //execute
        $rows = $this->db->resultSet();

        return $rows;
    }

    /**
     * 
     * This method deletes a project from the database that belongs to the user
     * 
     * @param string $id  the projects id
     * 
     * @return boolean
     */
    public function deleteProject($id){
        $this->db->query('DELETE FROM projects WHERE User_Id = :userId && Project_Id = :projectId');
        //bind
        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':projectId', $id);
        //execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 
     * This method when called creates a new project in the database
     * 
     * @param string $data  the data to create a new project
     * 
     * @return boolean
     */
    public function createNewProject($data){
        $this->db->query('INSERT INTO projects (Project_Name, User_Id, Group_Id, Project_Type, Project_Description, Project_Completion, Project_Img) 
        VALUES(:projectName, :userId, :groupId, :projectType, :projectDescription, :projectCompletion, :projectImg)');

        //bind values
        $this->db->bind(':projectName', $data['project_name']);
        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':groupId', null);
        $this->db->bind(':projectType', $data['project_type']);
        $this->db->bind(':projectDescription', $data['project_Description']);
        $this->db->bind(':projectCompletion', 0);
        $this->db->bind(':projectImg', $data['project_img']);
  
        //call execute if you want to insert
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
        
    }

    /**
     * 
     * This method returns the information of a given project
     * 
     * @param string $id  the project id
     * 
     * @return object
     */
    public function getProjectInformation($id){
        $this->db->query('SELECT * FROM projects WHERE Project_Id = :projectId && User_Id = :userId' );
        //bind
        $this->db->bind(':projectId', $id);
        $this->db->bind(':userId', $_SESSION['user_id']);
        //execute
        $row = $this->db->single();

        return $row;
    }

    /**
     * 
     * This method when called updates the information of a given project
     * 
     * @param string $data  the data to edit a proejcts informations
     * 
     * @return boolean
     */
    public function editProject($data){
        $this->db->query('UPDATE projects SET Project_Name = :projectName, Project_Type = :projectType, 
        Project_Description = :projectDescription, Project_Img = :projectImg
        WHERE User_Id = :userId && project_Id = :projectId');

        $this->db->bind(':projectName', $data['project_name']);
        $this->db->bind(':projectType', $data['project_type']);
        $this->db->bind(':projectDescription', $data['project_Description']);
        $this->db->bind(':projectImg', $data['project_img']);
        $this->db->bind(':projectId', $data['project_id']);
        $this->db->bind(':userId', $_SESSION['user_id']);
        
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }

    }


}
?>