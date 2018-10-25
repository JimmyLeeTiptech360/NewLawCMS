<?php
/*
    PHP file to handle ajax request
 * included common operation = "insert", "update","delete","read"
 * custom operation may need to implement manually
 *  */
if(isset($_POST['project'])) {
    if(isset($_POST['operation']))
    {
        include('Project.php');
        $project = new Project(true);
        $response = new stdClass();

        if(isset($_POST['project_name']))
        {
            $project->project_name = $_POST['project_name'];
        }

        if(isset($_POST['description']))
        {
            $project->description = $_POST['description'];
        }

        if($_POST['operation'] == 'insert')
        {
            try
            {
                $project->insert_project();
                $response->message = 'Data successfully inserted!';
            }
            catch (Exception $e)
            {
                $response->message = $e->getMessage();
            }
        }
        else if($_POST['operation'] == 'update')
        {
            if(isset($_POST['id']))
            {
                try
                {
                    $project->id = $_POST['id'];
                    $project->update_project();
                    $response->message = 'Data successfully updated!';
                }
                catch (Exception $e)
                {
                    $response->message = $e->getMessage();
                }
            }
        }
        else if($_POST['operation'] == 'delete')
        {
            if(isset($_POST['id']))
            {
                try
                {
                    $project->delete_project($_POST['id']);
                    $response->message = 'Data successfully deleted!';
                }
                catch (Exception $e)
                {
                    $response->message = $e->getMessage();
                }
            }
        }
        else if($_POST['operation'] == 'read')
        {
           if(isset($_POST['id']))
            {
                echo json_encode($project->get_project_by_Id($_POST['id']));
            }
        }
        else if($_POST['operation'] == 'filter_read_all')
        {
            $data = array();

            $sql ='';

            if($_POST['filter_sql'])
            {
                $sql = $_POST['filter_sql'];
            }

            $rows = $project->result('',NULL,$sql);
            $rowcount = 0;

            foreach($rows as $row)
            {
                $sub_array = array();
                $sub_array[] = $row["id"];
                $sub_array[] = $row["project_name"];
                $sub_array[] = $row["description"];
                $sub_array[] = '<input type="checkbox" class ="modal_checkbox" name="selected_project" value="'.$row['id'].'" id='.$row['id'].'>';
                $data[] = $sub_array;
                $rowcount = $rowcount +1;
            }

            $output = array(
            //"draw"    => intval($_POST["draw"]),
            "recordsTotal"  =>  $rowcount,
            "data"    => $data
            );

           echo json_encode($output);
        }
        else if($_POST['operation'] == 'read_allx')
        {
            $data = array();
            $rows = $project->result();
            $rowcount = 0;

            foreach($rows as $row)
            {
                $sub_array = array();
                $sub_array[] = $row["id"];
                $sub_array[] = $row["project_name"];
                $sub_array[] = $row["description"];
                $sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Update</button>';
                $sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">Delete</button>';
                $data[] = $sub_array;
                $rowcount = $rowcount +1;
            }

            $output = array(
            //"draw"    => intval($_POST["draw"]),
            "recordsTotal"  =>  $rowcount,
            "data"    => $data
            );

           echo json_encode($output);
        }
        else if($_POST['operation'] == 'read_all')
        {
            $data = array();
            $rows = $project->result();
            $rowcount = 0;
            $output = '';

            foreach($rows as $row)
            {
                $sub_array = array();
                $sub_array[] = $row["id"];
                $sub_array[] = $row["project_name"];
                $sub_array[] = $row["description"];
                $sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Update</button>';
                $sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">Delete</button>';
                $data[] = $sub_array;
                $rowcount = $rowcount +1;

                $output = $output .'<tr><td>'.$row['id'].'</td><td>'.$row['project_name'].'</td><td>'.$row['description'].'</td>';
                $output = $output .'<td><button type="button" name="update" id="'. $row['id'].'" class="btn btn-warning btn-xs update">Update</button></td>';
                $output = $output .'<td><button type="button" name="delete" id="'. $row['id'].'" class="btn btn-danger btn-xs delete">Delete</button></td></tr>';
            }

            $response->output = $output;

            echo json_encode($response);
        }

        if($_POST['operation'] == 'insert' or $_POST['operation'] == 'update' or $_POST['operation'] == 'delete')
        {
            echo json_encode($response);
        }
    }
}
else if(isset($_POST['user']))
{
    if(isset($_POST['operation']))
    {
        include_once('User.php');
        $user = new User(true);
        $response = new stdClass();

        if(isset($_POST['user_name']))
        {
            $user->user_name = $_POST['user_name'];
        }

        if(isset($_POST['first_name']))
        {
            $user->first_name = $_POST['first_name'];
        }

        if(isset($_POST['last_name']))
        {
            $user->last_name = $_POST['last_name'];
        }

        if(isset($_POST['contact_no']))
        {
            $user->contact_no = $_POST['contact_no'];
        }

        if(isset($_POST['email']))
        {
            $user->email = $_POST['email'];
        }

        if(isset($_POST['password']))
        {
            $user->password = $_POST['password'];
        }

        if(isset($_POST['user_type_id']))
        {
            $user->user_type_id = $_POST['user_type_id'];
        }

        if(isset($_POST['user_user_type_id']))
        {
            $user->user_type_id = $_POST['user_user_type_id'];
        }

        if(isset($_POST['permission']))
        {
            $user->permission = $_POST['permission'];
        }

        if($_POST['operation'] == 'insert')
        {
            try
            {
                $user->insert_user();
                $response->message = 'Data successfully inserted!';
                $response->status = "200";
            }
            catch (Exception $e)
            {
                $response->message = $e->getMessage();
                $response->status = "404";
            }
        }
        else if($_POST['operation'] == 'update')
        {
            if(isset($_POST['id']))
            {
                try
                {
                    $user->id = $_POST['id'];
                    $user->update_user();
                    $response->message = 'Data successfully updated!';
                }
                catch (Exception $e)
                {
                    $response->message = $e->getMessage();
                }
            }
        }
        else if($_POST['operation'] == 'delete')
        {
            if(isset($_POST['id']))
            {
                try
                {
                    $user->delete_user($_POST['id']);
                    $response->message = 'Data successfully deleted!';
                }
                catch (Exception $e)
                {
                    $response->message = $e->getMessage();
                }
            }
        }
        else if($_POST['operation'] == 'read')
        {
           if(isset($_POST['id']))
            {
                echo json_encode($user->get_user_by_Id($_POST['id']));
            }
        }
        else if($_POST['operation'] == 'read_allx')
        {
            $data = array();
            $rows = $user->result();
            $rowcount = 0;

            foreach($rows as $row)
            {
                $sub_array = array();
                $sub_array[] = $row["id"];
                $sub_array[] = $row["email"];
                $sub_array[] = $row["contact_no"];

                include_once('User_Type.php');
                $user_type = new User_Type(true);
                $current_user_type = $user_type->get_user_type_by_Id($row["user_type_id"])['name'];
                $sub_array[] = $current_user_type;
                $sub_array[] = $row["user_name"];
                $sub_array[] = $row["first_name"];
                $sub_array[] = $row["last_name"];
                $sub_array[] = $row["permission"];
                $sub_array[] = '<td><button type="button" name="view" id="'. $row['id'].'" class="btn btn-info btn-xs view">View</button></td>';
                $sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">Delete</button>';
                $data[] = $sub_array;
                $rowcount = $rowcount +1;
            }

            $output = array(
            "recordsTotal"  =>  $rowcount,
            "data"    => $data
            );

            echo json_encode($output);
        }
        else if($_POST['operation'] == 'read_all')
        {
            $data = array();
            $rows = $user->result();
            $rowcount = 0;
            $output = '';

            foreach($rows as $row)
            {
                $sub_array = array();
                $sub_array[] = $row["id"];
                $sub_array[] = $row["email"];
                $sub_array[] = $row["contact_no"];
                include_once('User_Type.php');
                $user_type = new User_Type(true);
                $current_user_type = $user_type->get_user_type_by_Id($row["user_type_id"])['name'];
                $sub_array[] = $current_user_type;

                $sub_array[] = $row["first_name"];
                $sub_array[] = $row["last_name"];
                $sub_array[] = $row["permission"];
                $sub_array[] = '<td><button type="button" name="view" id="'. $row['id'].'" class="btn btn-info btn-xs view">View</button></td>';
                $sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">Delete</button>';
                $data[] = $sub_array;
                $rowcount = $rowcount +1;

                $output = $output .'<tr><td>'.$row['id'].'</td><td>'.$row['email'].'</td><td>'.$current_user_type.'</td>';
                $output = $output .'<td>'.$row['first_name'].'</td><td>'.$row['last_name'].'</td><td>'.$row["permission"].'</td>';
                $output = $output .'<td><button type="button" name="view" id="'. $row['id'].'" class="btn btn-info btn-xs view">View</button></td>';
                $output = $output .'<td><button type="button" name="delete" id="'. $row['id'].'" class="btn btn-danger btn-xs delete">Delete</button></td></tr>';
            }
            $response->output = $output;

            echo json_encode($response);
        }
        else if($_POST['operation'] == 'retrieve_latest')
        {
            $data = array();
            
            $rows = null;
            
            if(isset($_POST['user_type']))
            {
                if($_POST['user_type']==="7")
                {
                    $rows = $user->result('', NULL, 'and user_type_id = 7');
                }
                else if($_POST['user_type']==="8")
                {
                    $rows = $user->result('', NULL, 'and user_type_id = 8');
                }
            }
                      
            $rowcount = 0;
            $total_row = mysqli_num_rows($rows);

            $output = '<option disabled="" selected="" value="">Select a client</option>';

            foreach($rows as $row)
            {
                $sub_array = array();
                $sub_array[] = $row["id"];
                $sub_array[] = $row["email"];
                $sub_array[] = $row["contact_no"];
                include_once('User_Type.php');
                $user_type = new User_Type(true);
                $current_user_type = $user_type->get_user_type_by_Id($row["user_type_id"])['name'];
                $sub_array[] = $current_user_type;

                $sub_array[] = $row["first_name"];
                $sub_array[] = $row["last_name"];
                $sub_array[] = $row["permission"];
                $data[] = $sub_array;
                $rowcount = $rowcount +1;

                if($total_row == $rowcount)
                {
                    $output = $output .'<option value="'.$row['id'].'" selected>'.$row['first_name']. ' '.$row["last_name"]. '</option>';
                }
                else
                {
                    $output = $output .'<option value="'.$row['id'].'">'.$row['first_name']. ' '.$row["last_name"]. '</option>';
                }
            }
            $response->output = $output;

            echo json_encode($response);
        }

        if($_POST['operation'] == 'insert' or $_POST['operation'] == 'update' or $_POST['operation'] == 'delete')
        {
            echo json_encode($response);
        }
    }
}
else if(isset($_POST['user_project'])) {
    if(isset($_POST['operation']))
    {
        include('User_Project.php');
        $user_project = new User_Project(true);
        $response = new stdClass();

        if(isset($_POST['project_id']))
        {
            $user_project->project_id = $_POST['project_id'];
        }

        if(isset($_POST['user_id']))
        {
            $user_project->user_id = $_POST['user_id'];
        }

        if($_POST['operation'] == 'insert')
        {
            try
            {
                $user_project->insert_user_project();
                $response->message = 'Data successfully inserted!';
            }
            catch (Exception $e)
            {
                $response->message = $e->getMessage();
            }
        }
        else if($_POST['operation'] == 'update')
        {
            if(isset($_POST['id']))
            {
                try
                {
                    $user_project->id = $_POST['id'];
                    $user_project->update_user_project();
                    $response->message = 'Data successfully updated!';
                }
                catch (Exception $e)
                {
                    $response->message = $e->getMessage();
                }
            }
        }
        else if($_POST['operation'] == 'delete')
        {
            if(isset($_POST['id']))
            {
                try
                {
                    $user_project->delete_user_project($_POST['id']);
                    $response->message = 'Data successfully deleted!';
                }
                catch (Exception $e)
                {
                    $response->message = $e->getMessage();
                }
            }
        }
        else if($_POST['operation'] == 'read')
        {
           if(isset($_POST['id']))
            {
                echo json_encode($user_project->get_project_by_Id($_POST['id']));
            }
        }
        else if($_POST['operation'] == 'modal_read_allx')
        {
            $data = array();

            $parameter_array = array();

            array_push($parameter_array, array('and','user_id','=',$user_project->user_id));

            $rows = $user_project->result('i',$parameter_array);

            $rowcount = 0;

            foreach($rows as $row)
            {
                $project = new Project(true);
                $project->set_project_by_Id($row['project_id']);

                $sub_array = array();
                $sub_array[] = $project->id;
                $sub_array[] = $project->project_name;
                $sub_array[] = $project->description;
                $sub_array[] = '<button type="button" name="view" id="'.$project->id.'" class="btn btn-warning btn-xs view">View</button>';
                $sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">Delete</button>';
                $data[] = $sub_array;

                $rowcount = $rowcount +1;
            }

            $output = array(
            "recordsTotal"  =>  $rowcount,
            "data"    => $data
            );

           echo json_encode($output);
        }
        else if($_POST['operation'] == 'modal_read_all')
        {
            $data = array();
            $parameter_array = array();
            array_push($parameter_array, array('and','user_id','=',$user_project->user_id));

            $rows = $user_project->result('i',$parameter_array);
            $rowcount = 0;
            $output = '';

            foreach($rows as $row)
            {
                $project = new Project(true);
                $project->set_project_by_Id($row['project_id']);

                $sub_array = array();
                $sub_array[] = $project->id;
                $sub_array[] = $project->project_name;
                $sub_array[] = $project->description;
                $sub_array[] = '<button type="button" name="view" id="'.$row["id"].'" class="btn btn-warning btn-xs update">View</button>';
                $sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">Delete</button>';
                $data[] = $sub_array;
                $rowcount = $rowcount +1;

                $output = $output .'<tr><td>'.$project->id.'</td><td>'.$project->project_name.'</td><td>'.$project->description.'</td>';
                $output = $output .'<td><button type="button" name="view" id="'. $row['id'].'" class="btn btn-warning btn-xs update">View</button></td>';
                $output = $output .'<td><button type="button" name="delete" id="'. $row['id'].'" class="btn btn-danger btn-xs delete">Delete</button></td></tr>';
            }

            $response->output = $output;

            echo json_encode($response);
        }
        else if($_POST['operation'] == 'read_all')
        {
            $data = array();
            $rows = $user_project->result();
            $rowcount = 0;
            $output = '';

            foreach($rows as $row)
            {
                $sub_array = array();
                $sub_array[] = $row["id"];
                $sub_array[] = $row["project_id"];
                $sub_array[] = $row["user_id"];
                $sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Update</button>';
                $sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">Delete</button>';
                $data[] = $sub_array;
                $rowcount = $rowcount +1;

                $output = $output .'<tr><td>'.$row['id'].'</td><td>'.$row['project_name'].'</td><td>'.$row['description'].'</td>';
                $output = $output .'<td><button type="button" name="update" id="'. $row['id'].'" class="btn btn-warning btn-xs update">Update</button></td>';
                $output = $output .'<td><button type="button" name="delete" id="'. $row['id'].'" class="btn btn-danger btn-xs delete">Delete</button></td></tr>';
            }

            $response->output = $output;

            echo json_encode($response);
        }

        if($_POST['operation'] == 'insert' or $_POST['operation'] == 'update' or $_POST['operation'] == 'delete')
        {
            echo json_encode($response);
        }
    }
}
else if(isset($_POST['template'])) {
    if(isset($_POST['operation']))
    {
        include('template.php');
        $template = new Template(true);
        $response = new stdClass();

        if(isset($_POST['name']))
        {
            $template->name = $_POST['name'];
        }

        if(isset($_POST['description']))
        {
            $template->description = $_POST['description'];
        }

        if(isset($_POST['source']))
        {
            $template->source = $_POST['source'];
        }

        if(isset($_POST['phase_count']))//named as phase_count in other form
        {
            $template->phases = $_POST['phase_count'];
        }

        if(isset($_POST['output_source']))
        {
            $template->output_source = $_POST['output_source'];
        }

        if($_POST['operation'] == 'insert')
        {
           try
           {
                $template->insert_template();
                $response->message = 'Data successfully inserted!';
            }
            catch (Exception $e)
            {
                $response->message = $e->getMessage();
            }
        }
        else if($_POST['operation'] == 'update')
        {
            if(isset($_POST['id']))
            {
                try
                {
                    $template->id = $_POST['id'];
                    $template->update_template();
                    $response->message = 'Data successfully updated!';
                }
                catch (Exception $e)
                {
                    $response->message = $e->getMessage();
                }
            }
        }
        else if($_POST['operation'] == 'delete')
        {
            try
            {
                if(isset($_POST['id']))
                {
                    $template->delete_template($_POST['id']);
                    $response->message = 'Data successfully deleted!';
                }
            }
                catch (Exception $e)
                {
                    $response->message = "Cannot delete this template because it is in-used!";
                }
        }
        else if($_POST['operation'] == 'read')
        {
           if(isset($_POST['id']))
            {
                echo json_encode($template->get_template_by_Id($_POST['id']));
            }
        }
        else if($_POST['operation'] == 'read_all')
        {
            $data = array();
            $rows = $template->result();
            $rowcount = 0;

            foreach($rows as $row)
            {
                $sub_array = array();
                $sub_array[] = $row["id"];
                $sub_array[] = $row["name"];
                $sub_array[] = $row["description"];
                $sub_array[] = '<button type="button" name="view" id="'.$row["id"].'" class="btn btn-warning btn-xs view">View</button>';
                $sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">Delete</button>';
                $data[] = $sub_array;
                $rowcount = $rowcount +1;
            }

            $output = array(
            "recordsTotal"  =>  $rowcount,
            "data"    => $data
            );

           echo json_encode($output);
        }

        if($_POST['operation'] == 'insert' or $_POST['operation'] == 'update' or $_POST['operation'] == 'delete')
        {
            echo json_encode($response);
        }
    }
}
else if(isset($_POST['file_master'])) {
    if(isset($_POST['operation']))
    {
        include('File_Master.php');
        include_once('File_User.php');
        include_once('Audit_Trail.php');
        $file_master = new File_Master(true);
        $response = new stdClass();

        $audit_trail = new Audit_Trail(true);
        $audit_trail->form_type = 'file';

        if(isset($_POST['name']))
        {
            $file_master->name = $_POST['name'];
        }

        if(isset($_POST['project_id']))
        {
            $file_master->project_id = $_POST['project_id'];
        }

        if(isset($_POST['selected_project']))
        {
            $file_master->project_id = $_POST['selected_project'];
        }

        if(isset($_POST['propertyaddress']))
        {
            $file_master->propertyaddress = $_POST['propertyaddress'];
        }

        if(isset($_POST['clientname']))
        {
            $file_master->clientname = $_POST['clientname'];
        }

        if(isset($_POST['client_name']))
        {
            $file_master->clientname = $_POST['client_name'];
        }

        if(isset($_POST['is_settled']))
        {
            $file_master->is_settled = $_POST['is_settled'];
        }

        if(isset($_POST['settlement']))
        {
            $file_master->settlement = $_POST['settlement'];
        }

        if(isset($_POST['snpdate']))
        {
            if($_POST['snpdate'] != '')
            {
                $file_master->snpdate = $_POST['snpdate'];
            }
        }

        if(isset($_POST['cpdate']))
        {
            if($_POST['cpdate'] != '')
            {
                $file_master->cpdate = $_POST['cpdate'];
            }
        }

        if(isset($_POST['opendate']))
        {
            if($_POST['opendate']!= '')
            {
                $file_master->opendate = $_POST['opendate'];
            }
        }

        if(isset($_POST['instructiondate']))
        {
            if($_POST['instructiondate']!='')
            {
                $file_master->instructiondate = $_POST['instructiondate'];
            }
        }

        if(isset($_POST['estimated_date']))
        {
            if($_POST['estimated_date']!= '')
            {
                $file_master->estimated_date = $_POST['estimated_date'];
            }
        }

        if(isset($_POST['file_status']))
        {
            $file_master->status = $_POST['file_status'];
        }

        if(isset($_POST['companyref']))
        {
            $file_master->companyref = $_POST['companyref'];
        }

        if(isset($_POST['devref']))
        {
            $file_master->devref = $_POST['devref'];
        }

        if(isset($_POST['bankref']))
        {
            $file_master->bankref = $_POST['bankref'];
        }

        if(isset($_POST['agreedfees']))
        {
            $file_master->agreedfees = $_POST['agreedfees'];
        }

        if(isset($_POST['feespaid']))
        {
            $file_master->feespaid = $_POST['feespaid'];
        }

        if(isset($_POST['template_id']))
        {
            $file_master->template_id = $_POST['template_id'];
        }

        if(isset($_POST['template_source']))
        {
            $file_master->template_source = $_POST['template_source'];
        }

        if(isset($_POST['aftertask_duration']))
        {
            $file_master->aftertask_duration = $_POST['aftertask_duration'];
        }

        if(isset($_POST['use_cpdate']))
        {
            $file_master->use_cpdate = $_POST['use_cpdate'];
        }

        if($_POST['operation'] == 'insert')
        {
           try
           {
                $file_master->insert_file();
                $response->message = 'Data successfully inserted!';

                $audit_trail->action = 'insert';

                $sql = 'SELECT * FROM file_master order by id desc limit 1;';

                $file_user = new File_User(true);
                $rows = $file_user->getPreparedStatement($sql, NULL);
                $row    = mysqli_fetch_assoc($rows);
                $audit_trail->target_id = $row['id'];
                $audit_trail->user_id = $_POST['user_id'];

                $audit_trail->insert_audit_trail();
            }
            catch (Exception $e)
            {
                $response->message = $e->getMessage();
            }
        }
        else if($_POST['operation'] == 'update')
        {
            if(isset($_POST['id']))
            {
                try
                {
                    $file_master->id = $_POST['id'];
                    $file_master->update_file();
                    $response->message = 'Data successfully updated!';

                    $audit_trail->action = 'update';
                    $audit_trail->target_id = $_POST['id'];
                    $audit_trail->user_id = $_POST['user_id'];
                    $audit_trail->insert_audit_trail();
                }
                catch (Exception $e)
                {
                    $response->message = $e->getMessage();
                }
            }
        }
        else if($_POST['operation'] == 'delete')
        {
            if(isset($_POST['id']))
            {
                try
                {
                    $file_master->delete_project($_POST['id']);
                    $response->message = 'Data successfully deleted!';
                    $audit_trail->action = 'delete';
                    $audit_trail->target_id = $_POST['id'];
                    $audit_trail->user_id = $_POST['user_id'];
                    $audit_trail->insert_audit_trail();

                }
                catch (Exception $e)
                {
                    $response->message = $e->getMessage();
                }
            }
        }
        else if($_POST['operation'] == 'read')
        {
           if(isset($_POST['id']))
            {
                echo json_encode($file_master->get_file_by_Id($_POST['id']));
            }
        }
        else if($_POST['operation'] == 'read_all')
        {
            $data = array();
            $current_user_id = "";

            if(isset($_POST['current_user_id']))
            {
                $current_user_id = $_POST['current_user_id'];
            }

            //$rows = $file_master->result();
            $rows = $file_master->get_file_filter_by_user($current_user_id);
            $rowcount = 0;

			if($rows)
			{
				foreach($rows as $row)
				{
					$sub_array = array();
					$sub_array[] = $row["id"];
					$sub_array[] = $row["name"];
					$sub_array[] = $row["propertyaddress"];
					$sub_array[] = $row["project_name"];
					$sub_array[] = $row["vendor_name"];
					$sub_array[] = $row["purchaser_name"];
					$sub_array[] = $row["phase"];
					$sub_array[] = $row["phase_status"];
					$sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update">View</button>';
					$sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">Delete</button>';

					$data[] = $sub_array;
					$rowcount = $rowcount +1;
				}

				$output = array(
				"recordsTotal"  =>  $rowcount,
				"data"    => $data
				);
				
				echo json_encode($output);
			}
			else
			{
				$output = array(
				"recordsTotal"  =>  0,
				"data"    => null
				);
				
				echo json_encode($output);
			}            
        }

        if($_POST['operation'] == 'insert' or $_POST['operation'] == 'update' or $_POST['operation'] == 'delete')
        {
            echo json_encode($response);
        }
    }
}
else if(isset($_POST['file_user'])) {
    if(isset($_POST['operation']))
    {
        include('File_User.php');
        $file_user = new File_User(true);
        $response = new stdClass();

        if(isset($_POST['file_id']))
        {
            $file_user->file_id = $_POST['file_id'];
        }

        if(isset($_POST['user_type_id']))
        {
            $file_user->user_type_id = $_POST['user_type_id'];
        }

        if(isset($_POST['user_id']))
        {
            $file_user->user_id = $_POST['user_id'];
        }

        if($_POST['operation'] == 'insert')
        {
           try
           {
                $file_user->insert_file_user();
                $response->message = 'Data successfully inserted!'; 
            }
            catch (Exception $e)
            {
                $response->message = $e->getMessage();
            }
        }
        else if($_POST['operation'] == 'update')
        {
            if(isset($_POST['id']))
            {
                try
                {
                    $file_user->id = $_POST['id'];
                    $file_user->update_file_user();
                    $response->message = 'Data successfully updated!';
                }
                catch (Exception $e)
                {
                    $response->message = $e->getMessage();
                }
            }
        }
        else if($_POST['operation'] == 'delete')
        {
            if(isset($_POST['id']))
            {
                try
                {
                    $file_user->delete_file_user($_POST['id']);
                    $response->message = 'Data successfully deleted!';
                }
                catch (Exception $e)
                {
                    $response->message = $e->getMessage();
                }
            }
        }
        else if($_POST['operation'] == 'read')
        {
           if(isset($_POST['id']))
            {
                echo json_encode($file_user->get_file_user_by_Id($_POST['id']));
            }
        }
        else if($_POST['operation'] == 'get_latest_file')
        {
           $sql = 'SELECT * FROM file_master order by id desc limit 1;';
           echo json_encode(mysqli_fetch_assoc($file_user->getPreparedStatement($sql, NULL)));
        }
        else if($_POST['operation'] == 'clear_old_link')
        {
           if(isset($_POST['file_id']))
            {
                $file_user->delete_file_user_by_file($_POST['file_id']);
                $response->message = 'Data successfully deleted!';
            }
        }

        if($_POST['operation'] == 'insert' or $_POST['operation'] == 'update' or $_POST['operation'] == 'delete' or $_POST['operation'] == 'clear_old_link')
        {
            echo json_encode($response);
        }
    }
}
else if(isset($_POST['file_phase'])) {
    if(isset($_POST['operation']))
    {
        include('File_Phase.php');
        $file_phase = new File_Phase(true);
        $response = new stdClass();

        if(isset($_POST['file_id']))
        {
            $file_phase->file_id = $_POST['file_id'];
        }

        if(isset($_POST['phase']))
        {
            $file_phase->phase = $_POST['phase'];
        }

        if(isset($_POST['description']))
        {
            $file_phase->description = $_POST['description'];
        }

        if($_POST['operation'] == 'insert')
        {
           try
           {
                $file_phase->insert_file_phase();
                $response->message = 'Data successfully inserted!';
            }
            catch (Exception $e)
            {
                $response->message = $e->getMessage();
            }
        }
        else if($_POST['operation'] == 'update')
        {
            if(isset($_POST['id']))
            {
                try
                {
                    $file_phase->id = $_POST['id'];
                    $file_phase->update_file_phase();
                    $response->message = 'Data successfully updated!';
                }
                catch (Exception $e)
                {
                    $response->message = $e->getMessage();
                }
            }
        }
        else if($_POST['operation'] == 'delete')
        {
            if(isset($_POST['id']))
            {
                try
                {
                    $file_phase->delete_file_phase($_POST['id']);
                    $response->message = 'Data successfully deleted!';
                }
                catch (Exception $e)
                {
                    $response->message = $e->getMessage();
                }
            }
        }
        else if($_POST['operation'] == 'read')
        {
           if(isset($_POST['id']))
            {
                echo json_encode($file_phase->get_file_phase_by_Id($_POST['id']));
            }
        }
        else if($_POST['operation'] == 'clear_old_phases')
        {
           if(isset($_POST['file_id']))
            {
                $file_phase->delete_file_phases_by_file($_POST['file_id']);
                $response->message = 'phase master successfully deleted!';

                include_once('Phase_Subtask.php');
                $phase_subtask = new Phase_Subtask(true);

                $phase_subtask->delete_phase_subtask_by_file($_POST['file_id']);
                $response->message = 'phase detail successfully deleted!';
            }
        }

        if($_POST['operation'] == 'insert' or $_POST['operation'] == 'update' or $_POST['operation'] == 'delete' or $_POST['operation'] == 'clear_old_phases')
        {
            echo json_encode($response);
        }
    }
}
else if(isset($_POST['phase_subtask'])) {
    if(isset($_POST['operation']))
    {
        include('Phase_Subtask.php');
        $phase_subtask = new Phase_Subtask(true);
        $response = new stdClass();

        if(isset($_POST['file_id']))
        {
            $phase_subtask->file_id = $_POST['file_id'];
        }

        if(isset($_POST['phase']))
        {
            $phase_subtask->phase = $_POST['phase'];
        }

        if(isset($_POST['row_id']))
        {
            $phase_subtask->row_id = $_POST['row_id'];
        }

        if(isset($_POST['description']))
        {
            $phase_subtask->description = $_POST['description'];
        }

        if(isset($_POST['overdue_date']))
        {
            $phase_subtask->overdue_date = $_POST['overdue_date'];
        }

        if(isset($_POST['start_date']))
        {
            $phase_subtask->start_date = $_POST['start_date'];
        }

        if(isset($_POST['target_date']))
        {
            $phase_subtask->target_date = $_POST['target_date'];
        }

        if(isset($_POST['complete_date']))
        {
            $phase_subtask->complete_date = $_POST['complete_date'];
        }

        if(isset($_POST['status']))
        {
            $phase_subtask->status = $_POST['status'];
        }

        if(isset($_POST['remark']))
        {
            $phase_subtask->remark = $_POST['remark'];
        }

        if($_POST['operation'] == 'insert')
        {
            try
            {
                $phase_subtask->insert_phase_subtask();
                $response->message = 'Data successfully inserted!';
            }
            catch (Exception $e)
            {
                $response->message = $e->getMessage();
            }
        }
        else if($_POST['operation'] == 'update')
        {
            if(isset($_POST['id']))
            {
                try
                {
                    $phase_subtask->id = $_POST['id'];
                    $phase_subtask->update_phase_subtask();
                    $response->message = 'Data successfully updated!';
                }
                catch (Exception $e)
                {
                    $response->message = $e->getMessage();
                }
            }
        }
        else if($_POST['operation'] == 'extend')
        {
            if(isset($_POST['id']))
            {
                try
                {
                    $cerl = error_reporting ();
                    error_reporting (0);

                    $phase_subtask->set_phase_subtask_by_Id($_POST['id']);

                    $target_file_id = $phase_subtask->file_id;

                    $phase_subtask->target_date = $_POST['target_date'];
                    $phase_subtask->remark = '';
                    $phase_subtask->status = 'Processing';
                    //$phase_subtask->id = $_POST['id'];
                    $phase_subtask->update_phase_subtask();

                    $selected_phase = $phase_subtask->phase;
                    $selected_row_id = $phase_subtask->row_id;

                    include_once('File_Master.php');

                    $file_master = new File_Master(true);
                    $file_master->set_file_by_Id($target_file_id);

                    $output_source = $file_master->template_source;

                    $document = new DOMDocument();
                    $document->loadHTML(mb_convert_encoding($output_source, 'HTML-ENTITIES', 'UTF-8'));
                    $tables = $document->getElementById('phase_'.$selected_phase);

                    $bodys = $tables->getElementsByTagName('tbody');

                    foreach($bodys as $body)
                    {
                        $trs =  $body->getElementsByTagName('tr');
                        $tr = $trs->item($selected_row_id -1);
                        $td4 = $tr->getElementsByTagName('td')->item(4);
                        $td4->nodeValue = $_POST['target_date'];
                        $td6 = $tr->getElementsByTagName('td')->item(6);
                        $td6->nodeValue = 'Processing';
                        $td7 = $tr->getElementsByTagName('td')->item(7);
                        $td7->nodeValue = '';
                    }

                    $new_template_source = $document->saveHTML();
                    $new_template_source = str_replace('<html>','',$new_template_source);
                    $new_template_source = str_replace('<body>','',$new_template_source);
                    $new_template_source = str_replace('</body>','',$new_template_source);
                    $new_template_source = str_replace('</html>','',$new_template_source);

                    $file_master->template_source = $new_template_source;
                    $file_master->update_file();

                    error_reporting ($cerl);

                    $response->message = 'Data successfully updated!';
                }
                catch (Exception $e)
                {
                    $response->message = $e->getMessage();
                }
            }
        }
        else if($_POST['operation'] == 'delete')
        {
            if(isset($_POST['id']))
            {
                try
                {
                    $phase_subtask->delete_phase_subtask($_POST['id']);
                    $response->message = 'Data successfully deleted!';
                }
                catch (Exception $e)
                {
                    $response->message = $e->getMessage();
                }
            }
        }
        else if($_POST['operation'] == 'read')
        {
           if(isset($_POST['id']))
            {
                echo json_encode($phase_subtask->get_phase_subtask_by_Id($_POST['id']));
            }
        }
        else if($_POST['operation'] == 'clear_old_phases')
        {
           if(isset($_POST['file_id']))
            {
                $phase_subtask->delete_phase_subtask_by_file($_POST['file_id']);
                $response->message = 'Data successfully deleted!';
            }
        }

        if($_POST['operation'] == 'insert' or $_POST['operation'] == 'update' or $_POST['operation'] == 'delete' or $_POST['operation'] == 'extend' or $_POST['operation'] == 'clear_old_phases')
        {
            echo json_encode($response);
        }
    }
}
else if(isset($_POST['summary'])) {
    if(isset($_POST['operation']))
    {
        include_once('File_Master.php');
        include_once('Phase_Subtask.php');
        include_once('File_Phase.php');
        include_once('Template.php');

        $phase_subtask = new Phase_Subtask(true);
        $file_phase = new File_Phase(true);
        $file_master = new File_Master(true);
        $response = new stdClass();
        $file_output = '';
        $project_id = 0;

        if(isset($_POST['project_id']))
        {
            $project_id = $_POST['project_id'];
            $current_user_type = $_POST['current_user_type'];
            $current_user_id = $_POST['current_user_id'];
            $sql = "";

            //$sql = 'select distinct template_id from file_master where project_id = ' .$project_id. ' order by template_id';
            if($current_user_type == "6")
            {
                $sql = "select distinct template_id from file_master where project_id = 1 and id in (";
                $sql = $sql ."select f.id from file_master f ";
                $sql = $sql ."join file_user u on u.file_id = f.id where u.user_id =". $current_user_id .")order by template_id";
            }
            else
            {
                $sql = 'select distinct template_id from file_master where project_id = ' .$project_id. ' order by template_id';
            }

            $templates    = $file_master->getPreparedStatement($sql, NULL);

            $template_count = 1;

            foreach ($templates as $row_template) {
                $content = '';
                $template = new Template(true);
                $template->set_template_by_Id($row_template['template_id']);

                $col_count = $template->phases;

                $table_box = '<div class="box box-primary><div class="box-header with-border"><h3 class="box-title">'. $template->description .'</h3></div><div class="box-body"><div class ="row"><div>';
                $table_box_header = '<div id="table_content" class="col-xs-12"><div class="col-md-12"><table class ="table table-bordered table-striped data_table" id ="table_'. $template_count .'" style="width:100%">';
                $table_header = '<thead><tr><th>No</th><th>File Id</th><th>File No</th>';

                for ($x = 1; $x <= $col_count ; $x++) {
                    $table_header = $table_header.'<th>Phase ' .$x. '</th>';
                }

                $table_header = $table_header.'<th>remark</th></tr></thead>';
                $table_body = '<tbody>';

                $sql="";

                if($current_user_type == "6")
                {
                    $sql = "select f.* from file_master f join file_user u on u.file_id = f.id where u.user_id = " .$current_user_id . " and project_id =".$project_id. ' and template_id ='.$template->id;
                }
                else
                {
                    $sql = 'select * from file_master where project_id = ' .$project_id. ' and template_id ='.$template->id;
                }

                $files    = $file_master->getPreparedStatement($sql, NULL);

                $row_no = 1;

                foreach($files as $file)
                {
                    $content = $content.'<tr><td>'.$row_no.'</td><td>'.$file['id'].'</td><td>'.$file['name'].'</td>';
                    $remark = '';

                    $skip_next = false;
                    for ($phase_count = 1; $phase_count <= $col_count ; $phase_count++)
                    {
                        if($skip_next)
                        {
                            $content = $content . '<td></td>';
                        }
                        else
                        {
                            $phase_sql = 'SELECT *,IF(status = "", "Empty", "") as is_empty FROM phase_subtask where file_id = '.$file['id'].' and phase = '.$phase_count.' and status<>"Completed" order by phase, row_id limit 1';

                            $phase_result   = mysqli_fetch_assoc($file_master->getPreparedStatement($phase_sql, NULL));

                            if(is_null($phase_result))
                            {
                                $content = $content . '<td>Completed</td>';
                            }
                            else
                            {
                                if($phase_result['is_empty'] =='Empty')
                                {
                                    $content = $content . '<td></td>';
                                }
                                else
                                {
                                    $content = $content . '<td>Task '.$phase_result['row_id'].' ' .$phase_result['description']. '</td>';
                                    $remark = $phase_result['remark'];
                                    $skip_next = true;
                                }
                            }
                        }
                    }

                    $content = $content .'<td>'.$remark.'</td></tr>';
                }

                $output = $table_box.$table_box_header.$table_header.$table_body.$content.'</tbody></table></div></div></div></div></div></div>';

                $file_output = $file_output.$output;
                $template_count++;
            }

            $response->output = $file_output;

            echo json_encode($response);
        }
    }
}
else if(isset($_POST['extend'])) {
    if(isset($_POST['operation']))
    {
        include_once('File_Master.php');
        include_once('Phase_Subtask.php');
        include_once('File_Phase.php');
        include_once('Template.php');

        $cerl = error_reporting ();
        error_reporting (0);

        $phase_subtask = new Phase_Subtask(true);
        $file_phase = new File_Phase(true);
        $file_master = new File_Master(true);
        $response = new stdClass();
        $file_output = '';

        $content = '';

        $table_box = '<div class="box box-primary><div class="box-header with-border"><h3 class="box-title">Extend Deadline</h3></div><div class="box-body"><div class ="row"><div>';
        $table_box_header = '<div id="table_content" class="col-xs-12"><div class="col-md-12"><table class ="table table-bordered table-striped data_table" id ="example1" style="width:100%">';
        //$table_header = '<thead><tr><th>ID</th><th>File No</th><th>Project Name</th><th>Status</th><th>Due date</th><th>Remark</th><th>Extend To</th><th>Action</th>';
        $table_header = '<thead><tr><th>ID</th><th>File No</th><th>Project Name</th><th>Status</th><th>Due date</th><th>Remark</th><th>Action</th>';

        $table_header = $table_header.'</thead>';
        $table_body = '<tbody>';

        $sql = 'select file_master.*,project.project_name,project.description,phase_subtask.remark, DateDIFF(curdate(), STR_TO_DATE(target_date, "%Y-%m-%d")) as overdue,phase_subtask.id as task_id  from phase_subtask join file_master on file_master.id = phase_subtask.file_id join project on project.id = project_id  where ((STR_TO_DATE(target_date, "%Y-%m-%d")< curdate() and not isnull(target_date) and target_date <> "")or phase_subtask.status = "Extend") and phase_subtask.status <> "Completed" and (cpdate <> "" and use_cpdate = 1) and phase_subtask.status <> "-";';

        $files    = $file_master->getPreparedStatement($sql, NULL);

        foreach($files as $file)
        {
            $template = new Template(true);
            $template->set_template_by_Id($file['template_id']);
            $col_count = $template->phases;
            $phase_count = 0;

            $content = $content.'<tr class="row_'.$file['task_id'].'"><td>'.$file['id'].'</td><td>'.$file['name'].'</td><td>'.$file['project_name'].'</td>';

            for ($phase_count = 1; $phase_count <= $col_count ; $phase_count++)
            {
                $phase_sql = 'SELECT *,IF(status = "", "Empty", "") as is_empty FROM phase_subtask where file_id = '.$file['id'].' and phase = '.$phase_count.' and status<>"Completed" order by phase, row_id limit 1';

                $phase_result   = mysqli_fetch_assoc($file_master->getPreparedStatement($phase_sql, NULL));

                if(is_null($phase_result))
                {

                }
                else
                {
                    if($phase_result['is_empty'] =='Empty')
                    {

                    }
                    else
                    {
                        $content = $content . '<td>Task '.$phase_result['row_id'].' ' .$phase_result['description']. '</td>';
                        $content = $content . '<td>'.$phase_result['target_date'].'</td>';
                        $content = $content . '<td>'.$phase_result['remark'].'</td>';
                        //extend date $content = $content . '<td></td>';
                        $content = $content . '<td><input type="button" name="extend_task" id="' . $phase_result['id'] . '" class="btn btn-success extend" value="Extend" data-toggle="modal" data-target="#extendModal" /></td>';
                        break;
                    }
                }
            }
        }
    }

    $output = $table_box.$table_box_header.$table_header.$table_body.$content.'</tbody></table></div></div></div></div></div></div>';

    $file_output = $file_output.$output;

    $response->output = $file_output;

    echo json_encode($response);
}
