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

if (file_exists('model/entity/File_Phase.php')) {
    require_once('model/entity/File_Phase.php');
} else {
    require_once('File_Phase.php');
}

if (file_exists('model/entity/Phase_Subtask.php')) {
    require_once('model/entity/Phase_Subtask.php');
} else {
    require_once('Phase_Subtask.php');
}

if (file_exists('model/entity/File_User.php')) {
    require_once('model/entity/File_User.php');
} else {
    require_once('File_User.php');
}

class File_Master extends ModelClass
{
    var $id;
    var $name;
    var $project_id;
    var $propertyaddress;
    var $clientname;
    var $is_settled;
    var $settlement;
    var $snpdate;
    var $cpdate;
    var $opendate;
    var $instructiondate;
    var $estimated_date;
    var $status;
    var $companyref;
    var $devref;
    var $bankref;
    var $agreedfees;
    var $feespaid;
    var $template_id;
    var $template_source;
    var $aftertask_duration;
    var $use_cpdate;
    //var $agent_id;
    //var $banker_id;
    //var $developer_id;
    //var $lawyer_id;
    //var $staff_id;
    
    //constructor
    function __construct($isNew)
    {

        if (!$isNew) {
            
        }
        else 
        {
            $this->aftertask_duration = 0;
        }
    }
    
    //get file by id
    function get_file_by_Id($file_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $file_id
        ));
        
        $output = $this->result('i', $parameter_array);
        $row    = mysqli_fetch_assoc($output);
        
        return $row;
    }
    
    //get file by id and filter by user
    function get_file_filter_by_user($user_id)
    {
        $parameter_array = array();
        
        $user = new User(true);
        $user->set_user_by_Id($user_id);
        
        $sql = '';
        
        $status_sql = 'IF(file_master.status = "Canceled","Canceled", ';
        $status_sql = $status_sql.'IF((SELECT Count(*) FROM   phase_subtask WHERE  phase_subtask.file_id = file_master.id ';
        $status_sql = $status_sql. 'AND phase_subtask.status <> "-") != (SELECT Count(*) FROM   phase_subtask WHERE ';
        $status_sql = $status_sql. 'phase_subtask.file_id = file_master.id), "Processing", (CASE WHEN Isnull(p.status) THEN "incomplete template" ';
        $status_sql = $status_sql. 'ELSE p.status end ))) AS phase_status ';
        
        //$status_sql = 'if((select count(*)from phase_subtask where phase_subtask.file_id = file_master.id and phase_subtask.status <> "-" )!=';
	//$status_sql = $status_sql.'(select count(*) from phase_subtask where phase_subtask.file_id = file_master.id),"Processing",';
        //$status_sql = $status_sql.'(CASE WHEN isnull(p.status) THEN "Incomplete Template" ELSE p.status END)) as phase_status';
        
        $user_info_sql = 'c.id as purchase_id, c.user_name as purchaser_name, c.project_name, ';
        $user_info_sql = $user_info_sql.'v.id as vendor_id, v.user_name as vendor_name , v.project_name ';
        
        if(($user->permission &1)||$user->user_type_id == 2)
        {            
            $sql = 'select file_master.*,IF(file_master.status = "Canceled",null, Concat(p.phase, ".", p.description)) AS phase, IF(file_master.status = "Canceled",null, p.row_id) AS row_id,  '.$status_sql.', ' .$user_info_sql. '  from file_master ';
            $sql = $sql .'left join (select * from phase_subtask where phase_subtask.id in(  select ';
            $sql = $sql .'(select phase_subtask.id from phase_subtask where phase_subtask.file_id = file_master.id and phase_subtask.status <> "-"  order by phase desc, row_id desc limit 1) ';
            $sql = $sql .'from file_master)) as p on  p.file_id = file_master.id ';    
            $sql = $sql .'left join user_info c on c.file_id = file_master.id and c.user_type_id = 7 '; 
            $sql = $sql .'left join user_info v on v.file_id = file_master.id and v.user_type_id = 8 '; 
        }
        else
        {                          
            if($user->user_type_id == 7)
            {
                $sql = 'select file_master.*,fp.description as phase, p.row_id as row_id, '.$status_sql.', '. $user_info_sql .' from file_master ';
            }
            else 
            {
                $sql = 'select file_master.*,CONCAT(p.phase,".", p.description) as phase, p.row_id as row_id, '.$status_sql.' , ' .$user_info_sql. ' from file_master ';
            }
             
            $sql = $sql . ' left join (select * from phase_subtask where phase_subtask.id in(  select ';
            $sql = $sql .'(select phase_subtask.id from phase_subtask where phase_subtask.file_id = file_master.id and phase_subtask.status <> "-"  order by phase desc, row_id desc limit 1) ';
            $sql = $sql .'from file_master where file_master.id in (select file_user.file_id from file_user where file_user.user_type_id = '. $user->user_type_id .' and file_user.user_id = '.$user->id.')';
            
            if($user->user_type_id == 7||$user->user_type_id == 8)
            {
                $sql = $sql . 'and((select count(*)from phase_subtask where phase_subtask.file_id = file_master.id and phase_subtask.status <> "-" and phase_subtask.status <> "Processing")!=(select count(*)from phase_subtask where phase_subtask.file_id = file_master.id))';              
            }
            
            $sql = $sql .')) as p on  p.file_id = file_master.id ';
            $sql = $sql .'left join user_info c on c.file_id = file_master.id and c.user_type_id = 7 '; 
            $sql = $sql .'left join user_info v on v.file_id = file_master.id and v.user_type_id = 8 '; 
            
            if($user->user_type_id == 7||$user->user_type_id == 8)
            {
                $sql = $sql . 'join file_phase fp on fp.file_id = file_master.id and fp.phase = p.phase';
            }
            
            $sql = $sql. ' where file_master.id in (select file_user.file_id from file_user where file_user.user_type_id = '. $user->user_type_id .' and file_user.user_id = '.$user->id.')';
        }

        //echo $sql;
        
        $row    = parent::getPreparedStatement($sql, NULL);
        
        return $row;
    }
    
    //retrieve all file filtered by user
    function get_all_file($user)
    {
        $sql = '';
        
        if(($user->permission &1)||$user->user_type_id == 2)
        {
            $sql = 'select * from file_master;';        
        }
        else
        {
            $sql = 'select * from file_master where (id in (select file_user.file_id from file_user where file_user.file_id = file_master.id and file_user.user_id = '.$user->id.'));';        
        }
        
        //$row    = mysqli_fetch_assoc(parent::getPreparedStatement($sql, NULL));
        
        $row    = parent::getPreparedStatement($sql, NULL);
        
        return $row;
    }
    
    //retrieve all overdue file
    function get_overdue_file($user)
    {
        $sql = '';
        
        if(($user->permission &1)||$user->user_type_id == 2)
        {
            $sql = 'select * from file_master where id in (select file_id from phase_subtask  where STR_TO_DATE(target_date, "%Y-%m-%d")< curdate() and not isnull(target_date) and target_date <> "" and status <> "Completed") and (cpdate <> "" and use_cpdate = 1);';        
        }
        else
        {
            $sql = 'select * from file_master where (id in (select file_user.file_id from file_user where file_user.file_id = file_master.id and file_user.user_id = 1)) and (id in (select file_id from phase_subtask  where STR_TO_DATE(target_date, "%Y-%m-%d")< curdate() and not isnull(target_date) and target_date <> "" and status <> "Completed") and (cpdate <> "" and use_cpdate = 1));';        
        }
        
        
        //$row    = mysqli_fetch_assoc(parent::getPreparedStatement($sql, NULL));
        
        $row    = parent::getPreparedStatement($sql, NULL);
        
        return $row;
    }
    
    //retrieve all incomplete file
    function get_incomplete_file($user)
    {
        $sql = '';
        
        if(($user->permission &1)||$user->user_type_id == 2)
        {
            $sql = 'select * from file_master where id in (select file_id from phase_subtask  where status <> "Completed") or Length(trim(replace(template_source,"\r\n","")) =0);';        
        }
        else
        {
            $sql = 'select * from file_master where (id in (select file_user.file_id from file_user where file_user.file_id = file_master.id and file_user.user_id = '.$user->id.')) and (id in (select file_id from phase_subtask  where status <> "Completed") or Length(trim(replace(template_source,"\r\n","")) =0);';        
        }
        
        //$row    = mysqli_fetch_assoc(parent::getPreparedStatement($sql, NULL));
        
		//echo $sql;
		
        $row    = parent::getPreparedStatement($sql, NULL);
        
        return $row;
    }
    
    //retrieve all incomplete settlement file
    function get_incomplete_settlement($user)
    {
        $sql = '';        
        
        if(($user->permission &1)||$user->user_type_id == 2)
        {
            $sql = 'select distinct f.* from file_master f where is_settled = 0 or is_settled is null;';        
        }
        else
        {
            $sql = 'select distinct f.* from file_master f where (id in (select file_user.file_id from file_user where file_user.file_id = f.id and file_user.user_id = '.$user->id.')) and (is_settled = 0 or is_settled is null);';        
        }
        
        //$row    = mysqli_fetch_assoc(parent::getPreparedStatement($sql, NULL));
        
        $row    = parent::getPreparedStatement($sql, NULL);
        
        return $row;
    }
    
    //retrieve all completed file
    function get_completed_file($user)
    {
        $sql = '';        
        
        if(($user->permission &1)||$user->user_type_id == 2)
        {
            $sql = 'select distinct f.* from file_master f join phase_subtask p on p.file_id = f.id where f.status = "Closed File" and p.status = "Completed" and f.id not in(select file_id from phase_subtask  where status <> "Completed");';        
        }
        else
        {
            $sql = 'select distinct f.* from file_master f join phase_subtask p on p.file_id = f.id where f.status = "Closed File" and p.status = "Completed" and f.id not in(select file_id from phase_subtask  where status <> "Completed") and (f.id in (select file_user.file_id from file_user where file_user.file_id = f.id and file_user.user_id = '.$user->id.'));';        
        }
        
        //$row    = mysqli_fetch_assoc(parent::getPreparedStatement($sql, NULL));
        
        $row    = parent::getPreparedStatement($sql, NULL);
        
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
            'project_id',
            $this->project_id
        ));
        array_push($parameter_array, array(
            'propertyaddress',
            $this->propertyaddress
        ));
        array_push($parameter_array, array(
            'clientname',
            $this->clientname
        ));
        array_push($parameter_array, array(
            'is_settled',
            $this->is_settled
        ));
        array_push($parameter_array, array(
            'settlement',
            $this->settlement
        ));
        array_push($parameter_array, array(
            'snpdate',
            $this->snpdate
        ));
        array_push($parameter_array, array(
            'cpdate',
            $this->cpdate
        ));
        array_push($parameter_array, array(
            'opendate',
            $this->opendate
        ));
        array_push($parameter_array, array(
            'instructiondate',
            $this->instructiondate
        ));
        array_push($parameter_array, array(
            'estimated_date',
            $this->estimated_date
        ));
        array_push($parameter_array, array(
            'status',
            $this->status
        ));
        array_push($parameter_array, array(
            'companyref',
            $this->companyref
        ));
        array_push($parameter_array, array(
            'devref',
            $this->devref
        ));
        array_push($parameter_array, array(
            'bankref',
            $this->bankref
        ));
        array_push($parameter_array, array(
            'agreedfees',
            $this->agreedfees
        ));
        array_push($parameter_array, array(
            'feespaid',
            $this->feespaid
        ));
        array_push($parameter_array, array(
            'template_id',
            $this->template_id
        ));
        array_push($parameter_array, array(
            'template_source',
            $this->template_source
        ));
        array_push($parameter_array, array(
            'aftertask_duration',
            $this->aftertask_duration
        ));     
        array_push($parameter_array, array(
            'use_cpdate',
            $this->use_cpdate
        )); 
        
        return $parameter_array;
    }
    
    //initialize the file by id
    function set_file_by_Id($file_id)
    {
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $file_id
        ));
        
        $output = $this->result('i', $parameter_array);
        $row    = mysqli_fetch_assoc($output);
        
        $this->id              = $row['id'];
        $this->name            = $row['name'];
        $this->project_id      = $row['project_id'];
        $this->propertyaddress = $row['propertyaddress'];
        $this->clientname      = $row['clientname'];
        $this->is_settled      = $row['is_settled'];
        $this->settlement      = $row['settlement'];
        $this->snpdate         = $row['snpdate'];
        $this->cpdate          = $row['cpdate'];
        $this->opendate        = $row['opendate'];
        $this->instructiondate = $row['instructiondate'];
        $this->estimated_date  = $row['estimated_date'];
        $this->status          = $row['status'];
        $this->companyref      = $row['companyref'];
        $this->devref          = $row['devref'];
        $this->bankref         = $row['bankref'];
        $this->agreedfees      = $row['agreedfees'];
        $this->feespaid        = $row['feespaid'];
        $this->template_id     = $row['template_id'];
        $this->template_source = $row['template_source'];  
        $this->aftertask_duration = $row['aftertask_duration']; 
        $this->use_cpdate      = $row['use_cpdate'];         
    }
    
    //insert record into file table
    function insert_file()
    {
        $parameter_array = $this->get_parameter_array();
        
        parent::insert('sissidsssssssssddisii', $parameter_array);
    }
    
    //update record into file table
    function update_file()
    {
        $parameter_array = $this->get_parameter_array();
        
        parent::update($this->id, 'sissidsssssssssddisii', $parameter_array);
    }
    
    //delete the file based on id
    function delete_project($file_id)
    {
        $file_user = new File_User(true);
        $file_user->delete_file_user_by_file($file_id);
        
        $phase_subtask = new Phase_Subtask(true);
        $phase_subtask->delete_phase_subtask_by_file($file_id);
        
        $file_phase = new File_Phase(true);
        $file_phase->delete_file_phases_by_file($file_id);
        
        $parameter_array = array();
        
        array_push($parameter_array, array(
            'and',
            'id',
            '=',
            $file_id
        ));
        
        parent::delete('i', $parameter_array);
    }
}