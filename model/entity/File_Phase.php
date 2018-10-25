<?php
if (file_exists('model/entity/ModelClass.php')) {
    require_once('model/entity/ModelClass.php');
} else {
    require_once('ModelClass.php');
}

if (file_exists('model/entity/File_Master.php')) {
    require_once('model/entity/File_Master.php');
} else {
    require_once('File_Master.php');
}

class File_Phase extends ModelClass
{
    var $id;
    var $file_id;
    var $phase;
    var $description;
    var $subtask;
    
    //constructor
    function __construct($isNew)
    {
        if (!$isNew) {
            
        }
    }
    
    //get file_phase by id
    function get_file_phase_by_Id($file_phase_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $file_phase_id
        ));
        
        $output = $this->result('i', $parameter_array);
        $row    = mysqli_fetch_assoc($output);
        
        return $row;
    }
    
    function get_parameter_array()
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'file_id',
            $this->file_id
        ));
        array_push($parameter_array, array(
            'phase',
            $this->phase
        ));
        array_push($parameter_array, array(
            'description',
            $this->description
        ));
        
        return $parameter_array;
    }
    
    //initialize the file_phase by id
    function set_file_phase_by_Id($file_phase_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $file_phase_id
        ));
        
        $output = $this->result('i', $parameter_array);
        $row    = mysqli_fetch_assoc($output);
        
        $this->id          = $row['id'];
        $this->file_id     = $row['file_id'];
        $this->phase       = $row['phase'];
        $this->description = $row['description'];
    }
    
    function get_phase_subtask()
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'phase_id',
            '=',
            $file_phase_id
        ));
        
        $this->subtask = $this->result('i', $parameter_array);
    }
    
    //insert record into file_phase table
    function insert_file_phase()
    {
        $parameter_array = $this->get_parameter_array();
        
        parent::insert('iis', $parameter_array);
    }
    
    //update record into file_phase table
    function update_file_phase()
    {
        $parameter_array = $this->get_parameter_array();
        
        parent::update($this->id, 'iis', $parameter_array);
    }
    
    //delete the file_phase based on id
    function delete_file_phase($file_phase_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $file_phase_id
        ));
        
        parent::delete('i', $parameter_array);
    }
    
    //delete the file_phase based on file id
    function delete_file_phases_by_file($file_id)
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