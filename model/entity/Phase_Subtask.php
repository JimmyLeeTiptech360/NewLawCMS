<?php
if (file_exists('model/entity/ModelClass.php')) {
    require_once('model/entity/ModelClass.php');
} else {
    require_once('ModelClass.php');
}

if (file_exists('model/entity/File_Phase.php')) {
    require_once('model/entity/File_Phase.php');
} else {
    require_once('File_Phase.php');
}

class Phase_Subtask extends ModelClass
{
    var $id;
    var $file_id;
    var $phase;
    var $row_id;
    var $description;
    var $overdue_date;
    var $start_date;
    var $target_date;
    var $complete_date;
    var $status;
    var $remark;
    
    //constructor
    function __construct($isNew)
    {
        if (!$isNew) {
            
        }
    }
    
    //get phase_subtask by id
    function get_phase_subtask_by_Id($phase_subtask_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $phase_subtask_id
        ));
        
        $output = $this->result('i', $parameter_array);
        $row    = mysqli_fetch_assoc($output);
        
        return $row;
    }
    
    //get overdue file by first latest 10 records
    function get_recent_overdue_file($limit = 0, $user_type_id ="", $user_id = "")
    {
        $limit_clause = '';
        if($limit <> 0)
        {
           $limit_clause = ' limit '.$limit; 
        }
        
        $sql = "";
        
        if($user_type_id != "2")
        {
            $sql = 'select file_master.*,phase_subtask.remark, DateDIFF(curdate(), STR_TO_DATE(target_date, "%Y-%m-%d")) as overdue from phase_subtask join file_master on file_master.id = phase_subtask.file_id join file_user on file_user.file_id = file_master.id where ((STR_TO_DATE(target_date, "%Y-%m-%d")< curdate() and not isnull(target_date) and target_date <> "")or phase_subtask.status = "Extend") and phase_subtask.status <> "Completed" and (cpdate <> "" and use_cpdate = 1) and phase_subtask.status<>"-" and file_user.user_id = '. $user_id .' '. $limit_clause .';';          
        }
        else
        {
            $sql = 'select file_master.*,phase_subtask.remark, DateDIFF(curdate(), STR_TO_DATE(target_date, "%Y-%m-%d")) as overdue from phase_subtask join file_master on file_master.id = phase_subtask.file_id  where ((STR_TO_DATE(target_date, "%Y-%m-%d")< curdate() and not isnull(target_date) and target_date <> "")or phase_subtask.status = "Extend") and phase_subtask.status <> "Completed" and (cpdate <> "" and use_cpdate = 1) and phase_subtask.status<>"-" '. $limit_clause .';';          
        }
 
        $row    = parent::getPreparedStatement($sql, NULL);
        
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
            'row_id',
            $this->row_id
        ));
        array_push($parameter_array, array(
            'description',
            $this->description
        ));
        array_push($parameter_array, array(
            'overdue_date',
            $this->overdue_date
        ));
        array_push($parameter_array, array(
            'complete_date',
            $this->complete_date
        ));
        array_push($parameter_array, array(
            'start_date',
            $this->start_date
        ));
        array_push($parameter_array, array(
            'target_date',
            $this->target_date
        ));
        array_push($parameter_array, array(
            'status',
            $this->status
        ));
        array_push($parameter_array, array(
            'remark',
            $this->remark
        ));
        
        return $parameter_array;
    }
    
    //initialize the phase_subtask by id
    function set_phase_subtask_by_Id($phase_subtask_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $phase_subtask_id
        ));
        
        $output = $this->result('i', $parameter_array);
        $row    = mysqli_fetch_assoc($output);
        
        $this->id            = $row['id'];
        $this->file_id       = $row['file_id'];
        $this->phase         = $row['phase'];
        $this->row_id       = $row['row_id'];
        $this->description   = $row['description'];
        $this->start_date    = $row['start_date'];
        $this->target_date   = $row['target_date'];
        $this->overdue_date  = $row['overdue_date'];
        $this->complete_date = $row['complete_date'];
        $this->status        = $row['status'];
        $this->remark        = $row['remark'];
    }
    
    //insert record into phase_subtask table
    function insert_phase_subtask()
    {
        $parameter_array = $this->get_parameter_array();
        
        parent::insert('iiisssssss', $parameter_array);
    }
    
    //update record into phase_subtask table
    function update_phase_subtask()
    {
        $parameter_array = $this->get_parameter_array();
        
        parent::update($this->id, 'iiisssssss', $parameter_array);
    }
    
    //delete the phase_subtask based on id
    function delete_phase_subtask($phase_subtask_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $phase_subtask_id
        ));
        
        parent::delete('i', $parameter_array);
    }
    
    //delete the sub task based on file id
    function delete_phase_subtask_by_file($file_id)
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
