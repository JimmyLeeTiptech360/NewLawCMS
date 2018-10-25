<?php
if (file_exists('model/entity/ModelClass.php')) {
    require_once('model/entity/ModelClass.php');
} else {
    require_once('ModelClass.php');
}

class Audit_Trail extends ModelClass
{
    var $id;
    var $form_type;
    var $target_id;
    var $user_id;
    var $action;
    var $action_date_time;
    
    //constructor
    function __construct($isNew)
    {
        if (!$isNew) {
            
        }
    }
    
    function get_parameter_array()
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'form_type',
            $this->form_type
        ));
        array_push($parameter_array, array(
            'target_id',
            $this->target_id
        ));
        array_push($parameter_array, array(
            'user_id',
            $this->user_id
        ));
        array_push($parameter_array, array(
            'action',
            $this->action
        ));
        
        return $parameter_array;
    }   
    
    //get audit trail by id
    function get_audit_trail_by_Id($log_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $log_id
        ));
        
        $output = $this->result('i', $parameter_array);
        $row    = mysqli_fetch_assoc($output);
        
        return $row;
    }
    
    //get audit trail by first latest 10 records
    function get_recent_audit_trail($limit, $user_type_id ="", $user_id = "")
    {
        $sql = 'select * from audit_trail order by action_date_time desc limit ' .$limit. ';';  
        
        if($user_type_id != "2")
        {
            $sql = 'select * from audit_trail where audit_trail.user_id = '.$user_id.' order by action_date_time desc limit ' .$limit. ';';  
        }
        
        $row    = parent::getPreparedStatement($sql, NULL);
        
        return $row;
    }
    
    //initialize the audit trail by id
    function set_audit_trail_by_Id($log_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $log_id
        ));
        
        $output = $this->result('i', $parameter_array);
        $row    = mysqli_fetch_assoc($output);
        
        $this->id           = $row['id'];
        $this->form_type   = $row['form_type'];
        $this->target_id    = $row['target_id'];
        $this->user_id        = $row['user_id'];
        $this->action     = $row['action'];
        $this->action_date_time     = $row['action_date_time'];
    }
    
    //insert record into audit trail table
    function insert_audit_trail()
    {
        $parameter_array = $this->get_parameter_array();
        
        parent::insert('siis', $parameter_array);
    }
    
    //update record into audit trail table
    function update_audit_trail()
    {
        $parameter_array = $this->get_parameter_array();
        
        parent::update($this->id, 'siis', $parameter_array);
    }
    
    //delete the audit trail based on id
    function delete_audit_trail($log_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $log_id
        ));
        
        parent::delete('i', $parameter_array);
    }   
}
