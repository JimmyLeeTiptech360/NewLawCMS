<?php
if (file_exists('model/entity/ModelClass.php')) {
    require_once('model/entity/ModelClass.php');
} else {
    require_once('ModelClass.php');
}

class Template extends ModelClass
{
    var $id;
    var $name;
    var $description;
    var $source;
    var $phases;
    var $output_source;
    
    //constructor
    function __construct($isNew)
    {
        if (!$isNew) {
            
        }
    }
    
    //get template by id
    function get_template_by_Id($template_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $template_id
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
            'source',
            $this->source
        ));
        array_push($parameter_array, array(
            'phases',
            $this->phases
        ));
        array_push($parameter_array, array(
            'output_source',
            $this->output_source
        ));
        
        return $parameter_array;
    }
    
    //initialize the template by id
    function set_template_by_Id($template_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $template_id
        ));
        
        $output = $this->result('i', $parameter_array);
        $row    = mysqli_fetch_assoc($output);
        
        $this->id            = $row['id'];
        $this->name          = $row['name'];
        $this->description   = $row['description'];
        $this->source        = $row['source'];
        $this->phases        = $row['phases'];
        $this->output_source = $row['output_source'];
    }
    
    //insert record into template table
    function insert_template()
    {
        $parameter_array = $this->get_parameter_array();
        
        parent::insert('sssis', $parameter_array);
    }
    
    //update record into template table
    function update_template()
    {
        $parameter_array = $this->get_parameter_array();
        
        parent::update($this->id, 'sssis', $parameter_array);
    }
    
    //delete the template based on id
    function delete_template($template_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $template_id
        ));
        
        parent::delete('i', $parameter_array);
    }
}
