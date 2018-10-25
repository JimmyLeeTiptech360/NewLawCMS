<?php
if (file_exists('model/entity/ModelClass.php')) {
    require_once('model/entity/ModelClass.php');
} else {
    require_once('ModelClass.php');
}

class User_Type extends ModelClass
{
    var $id;
    var $name;
    var $description;
    
    //constructor
    function __construct($isNew)
    {
        if (!$isNew) {
            
        }
    }
    
    //get user_type by id
    function get_user_type_by_Id($user_type_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $user_type_id
        ));
        
        $output = $this->result('i', $parameter_array);
        $row    = mysqli_fetch_assoc($output);
        
        return $row;
    }
    
    function get_parameter_array()
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'name',
            $this->name
        ));
        array_push($parameter_array, array(
            'description',
            $this->description
        ));
        
        return $parameter_array;
    }
    
    //initialize the user_type by id
    function set_user_type_by_Id($user_type_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $user_type_id
        ));
        
        $output = $this->result('i', $parameter_array);
        $row    = mysqli_fetch_assoc($output);
        
        $this->id          = $row['id'];
        $this->name        = $row['name'];
        $this->description = $row['description'];
    }
    
    //insert record into user_type table
    function insert_user_type()
    {
        $parameter_array = $this->get_parameter_array();
        
        parent::insert('ss', $parameter_array);
    }
    
    //update record into user_type table
    function update_user_type()
    {
        $parameter_array = $this->get_parameter_array();
        
        parent::update($this->id, 'ss', $parameter_array);
    }
    
    //delete the user_type based on id
    function delete_user_type($user_type_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $user_type_id
        ));
        
        parent::delete('i', $parameter_array);
    }
}
