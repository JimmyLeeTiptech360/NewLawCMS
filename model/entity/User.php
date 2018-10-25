<?php
if (file_exists('model/entity/ModelClass.php')) {
    require_once('model/entity/ModelClass.php');
} else {
    require_once('ModelClass.php');
}

class User extends ModelClass
{
    var $id;
    var $user_name;
    var $first_name;
    var $last_name;
    var $contact_no;
    var $email;
    var $password;
    var $user_type_id;
    var $permission;
    
    //constructor
    function __construct($isNew, $email = '', $password = '')
    {
        if (!$isNew) {
            //authenticate_user($email,$password);
        }
    }
    
    function get_parameter_array()
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'user_name',
            $this->user_name
        ));
        array_push($parameter_array, array(
            'first_name',
            $this->first_name
        ));
        array_push($parameter_array, array(
            'last_name',
            $this->last_name
        ));
        array_push($parameter_array, array(
            'contact_no',
            $this->contact_no
        ));
        array_push($parameter_array, array(
            'email',
            $this->email
        ));
        array_push($parameter_array, array(
            'password',
            $this->password
        ));
        array_push($parameter_array, array(
            'user_type_id',
            $this->user_type_id
        ));
        array_push($parameter_array, array(
            'permission',
            $this->permission
        ));
        
        return $parameter_array;
    }
    
    //validate user 
    function authenticate_user($parameter_types = '', $contact, $password)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            //'email',
            'contact_no',
            '=',
            $contact
        ));
        array_push($parameter_array, array(
            'and',
            'password',
            '=',
            $password
        ));
        
        $output = $this->result($parameter_types, $parameter_array);
        
        //return mysqli_num_rows($output)>0;
        return $output;
    }
    
    //get user by id
    function get_user_by_Id($user_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $user_id
        ));
        
        $output = $this->result('i', $parameter_array);
        $row    = mysqli_fetch_assoc($output);
        
        return $row;
    }
    
    //initialize the user by id
    function set_user_by_Id($user_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $user_id
        ));
        
        $output = $this->result('i', $parameter_array);
        $row    = mysqli_fetch_assoc($output);
        
        $this->id           = $row['id'];
        $this->user_name   = $row['user_name'];
        $this->first_name   = $row['first_name'];
        $this->last_name    = $row['last_name'];
        $this->contact_no   = $row['contact_no'];
        $this->email        = $row['email'];
        $this->password     = $row['password'];
        $this->user_type_id = $row['user_type_id'];
        $this->permission   = $row['permission'];
    }
    
    //insert record into user table
    function insert_user()
    {
        $parameter_array = $this->get_parameter_array();
        
        parent::insert('ssssssii', $parameter_array);
    }
    
    //update record into user table
    function update_user()
    {
        $parameter_array = $this->get_parameter_array();
        
        parent::update($this->id, 'ssssssii', $parameter_array);
    }
    
    //delete the user based on id
    function delete_user($user_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $user_id
        ));
        
        parent::delete('i', $parameter_array);
    }
    
    //get all associated project, $output is a mysqli result set
    function get_all($parameter_array)
    {
        $association_array = array();
        
        array_push($association_array, array(
            'User_Project',
            'Project'
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
