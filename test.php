<html>
<?php
    //require('model/entity/User.php');
    require_once('model/entity/User_Project.php');
    require_once('model/entity/Project.php');
    require_once('model/entity/User.php');
    
    //$test = new User(true);
    
    
    //$test->authenticate_user('ss','othniel.naga@tiptech360.co','user123#');
    
    //echo $test->get_user_by_Id(4)['first_name'];
    
    $parameter_array = array();
        
    //array_push($parameter_array, array('email','lkythemag@ymail.com'));
    //array_push($parameter_array, array('first_name','lky'));
    
    //$test->insert('ss',$parameter_array);
    //$test->email = 'lkythemag@ymail22.com';
    //$test->first_name = 'keroro';
    //$test->insert_user();
        
    //$test->set_user_by_Id(4);
    //echo $test->first_name;
    //$test->email = 'lkythemag@ymail.com';
    //$test->first_name = 'jimmy lky';

    //$test->update_user();
    
    //echo mysqli_num_rows($test->result());
    
    //$test->delete_user(5);
    
    //$test = new User_Project(true);
    
    //$test->set_user_project_by_Id(1);
    //$test->get_project();
    //$test->get_user();
    
    //echo $test->user->first_name;
    //echo $test->get_all();
    
    
    //echo $test->get_all()['id'];
    
    $test = new Project(true);
    
    $parameter_array = array();
    array_push($parameter_array, array('and','Project.id','=','2'));
    
    $output = $test->get_all($parameter_array);
           
    foreach($output as $row)
    {
        printf ("%s (%s)\n", $row["Project_ori_id"], $row["first_name"]);
        
    }

?>
</html>

