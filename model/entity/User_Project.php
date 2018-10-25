<?php
if (file_exists('model/entity/ModelClass.php')) {
    require_once('model/entity/ModelClass.php');
} else {
    require_once('ModelClass.php');
}

if (file_exists('model/entity/User.php')) {
    require_once('model/entity/User.php');
} else {
    require_once('User.php');
}

if (file_exists('model/entity/Project.php')) {
    require_once('model/entity/Project.php');
} else {
    require_once('Project.php');
}

//require_once('model/entity/User.php');
//require_once('model/entity/Project.php');

class User_Project extends ModelClass
{
    var $id;
    var $user_id;
    var $project_id;
    var $user;
    var $project;
    
    //constructor
    function __construct($isNew)
    {
        if (!$isNew) {
            
        }
    }
    
    //get User_Project by id
    function get_user_project_by_Id($user_project_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $user_project_id
        ));
        
        $output = $this->result('i', $parameter_array);
        $row    = mysqli_fetch_assoc($output);
        
        return $row;
    }
    
    function get_parameter_array()
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'user_id',
            $this->user_id
        ));
        array_push($parameter_array, array(
            'project_id',
            $this->project_id
        ));
        
        return $parameter_array;
    }
    
    //initialize the User_Project by id
    function set_user_project_by_Id($user_project_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $user_project_id
        ));
        
        $output = $this->result('i', $parameter_array);
        $row    = mysqli_fetch_assoc($output);
        
        $this->id         = $row['id'];
        $this->user_id    = $row['user_id'];
        $this->project_id = $row['project_id'];
    }
    
    //get user which associated to this user_project
    function get_user()
    {
        $this->user = new User(true);
        $this->user->set_user_by_Id($this->user_id);
    }
    
    //get project which associated to this user_project
    function get_project()
    {
        $this->project = new Project(true);
        $this->project->set_project_by_Id($this->project_id);
    }
    
    //insert record into User_Project table
    function insert_user_project()
    {
        $parameter_array = $this->get_parameter_array();
        
        parent::insert('ii', $parameter_array);
    }
    
    //update record into User_Project table
    function update_user_project()
    {
        $parameter_array = $this->get_parameter_array();
        
        parent::update($this->id, 'ii', $parameter_array);
    }
    
    //delete the User_Project based on id
    function delete_user_project($user_project_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $user_project_id
        ));
        
        parent::delete('i', $parameter_array);
    }
}
