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

if (file_exists('model/entity/File_Master.php')) {
    require_once('model/entity/File_Master.php');
} else {
    require_once('File_Master.php');
}

if (file_exists('model/entity/User_Type.php')) {
    require_once('model/entity/User_Type.php');
} else {
    require_once('User_Type.php');
}

class File_User extends ModelClass
{
    var $id;
    var $file_id;
    var $user_type_id;
    var $user_id;
    var $user_type;
    var $user;
    var $file_master;
    
    //constructor
    function __construct($isNew)
    {
        if (!$isNew) {
            
        }
    }
    
    //get file_user by id
    function get_file_user_by_Id($file_user_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $file_user_id
        ));
        
        $output = $this->result('i', $parameter_array);
        $row    = mysqli_fetch_assoc($output);
        
        return $row;
    }
    
    //get file_user by id
    function validate_file_user($file_id, $user_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'file_id',
            '=',
            $file_id
        ));
        
        array_push($parameter_array, array(
            'and',
            'user_id',
            '=',
            $user_id
        ));
        
        $output = $this->result('ii', $parameter_array);
        //$row    = mysqli_fetch_assoc($output);
        
        //return $row;
        return mysqli_num_rows($output)>0;
    }
    
    function get_parameter_array()
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'file_id',
            $this->file_id
        ));
        array_push($parameter_array, array(
            'user_type_id',
            $this->user_type_id
        ));
        array_push($parameter_array, array(
            'user_id',
            $this->user_id
        ));
        
        return $parameter_array;
    }
    
    //initialize the file_user by id
    function set_file_user_by_Id($file_user_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $file_user_id
        ));
        
        $output = $this->result('i', $parameter_array);
        $row    = mysqli_fetch_assoc($output);
        
        $this->id           = $row['id'];
        $this->file_id      = $row['file_id'];
        $this->user_type_id = $row['user_type_id'];
        $this->user_id      = $row['user_id'];
    }
    
    //get user which associated to this file_user
    function get_user()
    {
        $this->user = new User(true);
        $this->user->set_user_by_Id($this->user_id);
    }
    
    //get user_type which associated to this file_user
    function get_user_type()
    {
        $this->user_type = new User_Type(true);
        $this->user_type->set_user_type_by_Id($this->user_type_id);
    }
    
    //get project which associated to this file_user
    function get_file_master()
    {
        $this->file_master = new File_Master(true);
        $this->file_master->set_file_by_Id($this->file_id);
    }
    
    //insert record into file_user table
    function insert_file_user()
    {
        $parameter_array = $this->get_parameter_array();
        
        parent::insert('iii', $parameter_array);
    }
    
    //update record into file_user table
    function update_file_user()
    {
        $parameter_array = $this->get_parameter_array();
        
        parent::update($this->id, 'iii', $parameter_array);
    }
    
    //delete the file_user based on id
    function delete_file_user($file_user_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $file_user_id
        ));
        
        parent::delete('i', $parameter_array);
    }
    
    //delete the file_user based on file id
    function delete_file_user_by_file($file_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'file_id',
            '=',
            $file_id
        ));
        
        parent::delete('i', $parameter_array);
    }
}