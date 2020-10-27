<?php 
class MultipleProjectsModel{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getProjects(){
        $this->db->query('SELECT * FROM projects WHERE User_Id = :userId' );

        $this->db->bind(':userId', $_SESSION['user_id']);

        $rows = $this->db->resultSet();

        return $rows;
    }

    public function deleteProject($id){
        $this->db->query('DELETE FROM projects WHERE User_Id = :userId && Project_Id = :projectId');

        $this->db->bind(':userId', $_SESSION['user_id']);
        $this->db->bind(':projectId', $id);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

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

    public function getProjectInformation($id){
        $this->db->query('SELECT * FROM projects WHERE Project_Id = :projectId && User_Id = :userId' );

        $this->db->bind(':projectId', $id);
        $this->db->bind(':userId', $_SESSION['user_id']);

        $row = $this->db->single();

        return $row;
    }

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