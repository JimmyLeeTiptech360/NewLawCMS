<?php
if (file_exists('model/entity/ModelClass.php')) {
    require_once('model/entity/ModelClass.php');
} else {
    require_once('ModelClass.php');
}

if (file_exists('model/entity/File_User.php')) {
    require_once('model/entity/File_User.php');
} else {
    require_once('File_User.php');
}

if (file_exists('model/entity/File_Master.php')) {
    require_once('model/entity/File_Master.php');
} else {
    require_once('File_Master.php');
}

if (file_exists('model/entity/User.php')) {
    require_once('model/entity/User.php');
} else {
    require_once('User.php');
}

class Project extends ModelClass
{
    var $id;
    var $project_name;
    var $description;
    
    //constructor
    function __construct($isNew)
    {
        if (!$isNew) {
            
        }
    }
    
    //get project by id
    function get_project_by_Id($project_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $project_id
        ));
        
        $output = $this->result('i', $parameter_array);
        $row    = mysqli_fetch_assoc($output);
        
        return $row;
    }
    
    function get_parameter_array()
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'project_name',
            $this->project_name
        ));
        array_push($parameter_array, array(
            'description',
            $this->description
        ));
        
        return $parameter_array;
    }
    
    //get file by id and filter by user
    function get_project_filter_by_user($user_id)
    {
        $parameter_array = array();
        
        $user = new User(true);
        $user->set_user_by_Id($user_id);
        
        $sql = '';
        
        if($user->user_type_id == 6)
        {            
            $sql = "select distinct p.* from project p ";
            $sql = $sql . "join file_master f on f.project_id = p.id ";
            $sql = $sql . "join file_user u on u.file_id = f.id ";
            $sql = $sql . "where u.user_id = ".$user_id;                  
        }
        else
        {                     
            $sql = "select distinct p.* from project p ";
        }
        
        $row    = parent::getPreparedStatement($sql, NULL);
        
        return $row;
    }
    
    //initialize the project by id
    function set_project_by_Id($project_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $project_id
        ));
        
        $output = $this->result('i', $parameter_array);
        $row    = mysqli_fetch_assoc($output);
        
        $this->id           = $row['id'];
        $this->project_name = $row['project_name'];
        $this->description  = $row['description'];
    }
    
    //insert record into project table
    function insert_project()
    {
        $parameter_array = $this->get_parameter_array();
        
        parent::insert('ss', $parameter_array);
    }
    
    //update record into project table
    function update_project()
    {
        $parameter_array = $this->get_parameter_array();
        
        parent::update($this->id, 'ss', $parameter_array);
    }
    
    //delete the project based on id
    function delete_project($project_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $project_id
        ));
        
        parent::delete('i', $parameter_array);
    }
    
    //get all associated project, $output is a mysqli result set
    function get_all(array $parameter_array = null)
    {
        $association_array = array();
        
        array_push($association_array, array(
            'User_Project',
            'User'
        ));
        
        if (!isset($parameter_array)) {
            $parameter_array = array();
            array_push($parameter_array, array(
                'and',
                '1',
                '=',
                '1'
            ));
        }
        
        $output = $this->get_association_result($association_array, 'i', $parameter_array);
        
        return $output;
    }
}
