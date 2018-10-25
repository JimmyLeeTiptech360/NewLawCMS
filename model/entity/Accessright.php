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

class Accessright extends ModelClass
{
    var $id;
    var $name;
    var $description;
    var $factor;
    //constructor
    function __construct($isNew)
    {
        if (!$isNew) {
        }
    }
    //get accessright by id
    function get_accessright_by_Id($accessright_id)
    {
        $parameter_array = array();
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $accessright_id
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
        array_push($parameter_array, array(
            'factor',
            $this->factor
        ));
        return $parameter_array;
    }
    //initialize the accessright by id
    function set_accessright_by_Id($accessright_id)
    {
        $parameter_array = array();
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $accessright_id
        ));
        $output            = $this->result('i', $parameter_array);
        $row               = mysqli_fetch_assoc($output);
        $this->id          = $row['id'];
        $this->name        = $row['name'];
        $this->description = $row['description'];
        $this->factor      = $row['factor'];
    }
    //insert record into accessright table
    function insert_accessright()
    {
        $parameter_array = $this->get_parameter_array();
        parent::insert('ssi', $parameter_array);
    }
    //update record into accessright table
    function update_accessright()
    {
        $parameter_array = $this->get_parameter_array();
        parent::update($this->id, 'ssi', $parameter_array);
    }
    //delete the accessright based on id
    function delete_accessright($accessright_id)
    {
        $parameter_array = array();
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $accessright_id
        ));
        parent::delete('i', $parameter_array);
    }
}