
.<section class="content-header">
   <h1>
      <?php
         echo $PageTitle;
      
         $user_id = $_SESSION['user_id'];
         
         if (isset($_GET['user_id']))
         {
            $user_id = $_GET['user_id'];
         }
         
         $file_id = - 1;
         
         if (isset($_GET['file_id']))
         {
            if ($_GET['file_id'] <> - 1)
            {
         	$file_id = $_GET['file_id'];
            }
         }
         
         $user = new User(true);
         $user->set_user_by_Id($user_id);
         $project = new Project(true);
         $projects = $project->result();
         $lawyers = $user->result('', NULL, 'and user_type_id = 1');
         $staffs = $user->result('', NULL, 'and user_type_id = 3 or user_type_id = 2');
         $agents = $user->result('', NULL, 'and user_type_id = 4');
         $bankers = $user->result('', NULL, 'and user_type_id = 5');
         $developers = $user->result('', NULL, 'and user_type_id = 6');
         $clients = $user->result('', NULL, 'and user_type_id = 7');
         $user_type = new User_Type(true);
         $user_type_str = $user_type->get_user_type_by_Id($user->user_type_id) ['name'];
         $user_type_id = $user_type->get_user_type_by_Id($user->user_type_id) ['id'];
         $permission = $user->permission;
         $template_id = - 1;
         $template = new Template(true);
         $templates = $template->result();
         $file_master = new File_Master(true);
         
         if ($file_id <> - 1)
         {
            $file_master->set_file_by_Id($file_id);
         }
         
         $file_user = new File_User(true);
         
         $form_key= 0;

         if($file_user->validate_file_user($file_id, $user_id))
         {
            $form_key = 1;
         }
         
         ?>
   </h1>
</section>
<section class="content" >
   <form role="form" id = "master_form">
       <fieldset>
      <div class="row">
         <div class="col-md-8">
            <div class="box box-primary">
               <div class="box-header with-border">
                  <h3 class="box-title">Main Info</h3>
               </div>
               <div class="box-body">
                  <div class="form-group">
                     <label>File No</label>
                     <input type="text" class="form-control" id = 'name' name = 'name' value = '<?php
                        echo $file_master->name ?>' disabled/>
                  </div>
                  <div class="form-group">
                     <label>Project</label>
                     <select class="form-control select2 select2-hidden-accessible" data-placeholder="Select a project" style="width: 100%;" tabindex="-1" aria-hidden="true" id = 'selected_project' name = 'selected_project' disabled>
                     <?php
                        foreach($projects as $per_project)
                        	{
                        	$checked = '';
                        	if (isset($file_master->project_id))
                        		{
                        		if ($file_master->project_id == $per_project['id'])
                        			{
                        			$checked = ' selected';
                        			}
                        		}
                        
                        	$str = '<option value="' . $per_project['id'] . '" ' . $checked . ' >' . $per_project['id'] . ' ' . $per_project['project_name'] . '</option>';
                        	echo $str;
                        	}
                        
                        ?>  
                     </select>
                  </div>
                  <div class="form-group">
                     <label>Property Address</label>
                     <textarea class="form-control" rows="5" id = 'propertyaddress' name = 'propertyaddress' disabled><?php
                        echo $file_master->propertyaddress ?></textarea>
                  </div>
                  <div class="form-group">
                     <div class ="col-md-10">
                        <label>Client Name</label>
                        <select class="form-control select2 select2-hidden-accessible" data-placeholder="Select a client" style="width: 100%;" tabindex="-1" aria-hidden="true" id = 'selected_clients' name = 'selected_clients' disabled>
                           <option disabled selected value>Select a client</option>
                           <?php
                              foreach($clients as $client)
                              	{
                              	$sql = 'SELECT * FROM file_user where file_id = ' . $file_id . ' and user_id =' . $client['id'] . ';';
                              	$checked = '';
                              	if (mysqli_num_rows($file_user->getPreparedStatement($sql, NULL)) > 0)
                              		{
                              		$checked = ' selected';
                              		}
                              
                              	$str = '<option value="' . $client['id'] . '" ' . $checked . ' >' . $client['first_name'] . ' ' . $client['last_name'] . '</option>';
                              	echo $str;
                              	}
                              
                              ?>  
                        </select>
                     </div>
                  </div>
               </div>
            </div>
             <div class="box-body">
                 <div class="col-md-5">
                     <button type="button" class="btn btn-primary btn-block" id = 'back_button' name = 'back_button'>Back</button>
                 </div>  
            </div>
         </div>
          
         <div class="col-md-4">
             <fieldset disabled>
            <div class="box box-primary">
               <div class="box-header with-border">
                  <h3 class="box-title">Project Info</h3>
               </div>
               <div class="box-body">
                  <div class="form-group">
                     <label>Open File Date</label>
                     <div class="input-group date">
                        <div class="input-group-addon">
                           <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control pull-right" id = 'opendate' name = 'opendate' value = '<?php
                           echo $file_master->opendate ?>' />
                     </div>
                  </div>
                  <div class="form-group">
                     <label>S&P Date</label>
                     <div class="input-group date">
                        <div class="input-group-addon">
                           <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control pull-right" id = 'snpdate' name = 'snpdate' value = '<?php
                           echo $file_master->snpdate ?>' />
                     </div>
                  </div>
                  <div class="form-group">
                     <label>CP Date</label>
                     <div class="input-group date">
                        <div class="input-group-addon">
                           <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control pull-right" id = 'cpdate' name = 'cpdate' value = '<?php
                           echo $file_master->cpdate ?>' />
                     </div>
                  </div>
                  <div class="form-group">
                     <label>Letter of Instruction Date</label>
                     <div class="input-group date">
                        <div class="input-group-addon">
                           <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control pull-right" id = 'instructiondate' name = 'instructiondate' value = '<?php
                           echo $file_master->instructiondate ?>' />
                     </div>
                  </div>
                  <div class="form-group">
                     <label>Estimate Completion Date</label>
                     <div class="input-group date">
                        <div class="input-group-addon">
                           <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control pull-right" id = 'estimated_date' name = 'estimated_date' value = '<?php
                           echo $file_master->estimated_date ?>' />
                     </div>
                  </div>
                  <div class="form-group">
                     <label>Status</label>
                     <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id = 'status' name = 'status' disabled>
                        <option value ="Open File" <?php
                           if ($file_master->status == "Open File")
                           	{
                           	echo 'selected';
                           	} ?>>Open File</option>
                        <option value ="Closed File" <?php
                           if ($file_master->status == "Closed File")
                           	{
                           	echo 'selected';
                           	} ?>>Closed File</option>
                        <option value ="Canceled" <?php
                           if ($file_master->status == "Canceled")
                           	{
                           	echo 'selected';
                           	} ?>>Canceled</option>
                     </select>
                  </div>
               </div>
            </div>
                 </fieldset>
         </div>
              
      </div>
      <div class="box box-primary">
         <div class="box-header with-border">
            <h3 class="box-title">Task Assignment</h3>
         </div>
         <div class="box-body" id = "table_content">
            <?php
               if (isset($file_master->template_source))
               	{
               	echo $file_master->template_source;
               	}
               
               ?>
         </div>
      </div>
      <input type="hidden" name="file_master" id="file_master" value = 'file_master'/>
      <input type="hidden" name="is_settled" id="is_settled" />
      <input type="hidden" name="form_key" id="form_key" value = <?php echo $form_key; ?>/>
      <input type="hidden" name="client_name" id="client_name" />
      <input type="hidden" name="file_user" id="file_user" value = 'file_user'/>
      <input type="hidden" name="user_type_id" id="user_type_id" />
      <input type="hidden" name="user_id" id="user_id" value = <?php
         echo $user_id; ?>>
      <input type="hidden" name="id" id="id" value = <?php
         if ($file_id <> - 1)
         	{
         	echo $file_id;
         	} ?> >
      <input type="hidden" name="file_id" id="file_id" value = <?php
         if ($file_id <> - 1)
         	{
         	echo $file_id;
         	} ?> >
      <input type="hidden" name="operation" id="operation" value = <?php
         if ($file_id == - 1)
         	{
         	echo 'insert';
         	}
           else
         	{
         	echo 'update';
         	} ?> >
      <input type="hidden" name="template_id" id="template_id" />
      <input type="hidden" name="template_source" id="template_source" />
      <input type="hidden" name="file_status" id="file_status" />
      </fieldset>
   </form>
</section>
<!-- /.content -->
<div id="taskModal" class="modal fade">
   <div class="modal-dialog">
      <form method="post" id="task_form" enctype="multipart/form-data">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Task Info</h4>
            </div>
            <div class="modal-body">
               <label>Enter Task Name</label>
               <input type="text" name="subtask_description" id="subtask_description" class="form-control" disabled />
               <br />
               <label>Enter Overdue Durations(Days)</label>
               <input type="number" name="overdue_date" id="overdue_date" class="form-control " disabled />
               <br />
               <label>Start Date</label>
               <input type="date" name="start_date" id="start_date" class="form-control " />
               <br />
               <label>Target Date</label>
               <input type="date" name="target_date" id="target_date" class="form-control " />
               <br />
               <label>Complete Date</label>
               <input type="date" name="complete_date" id="complete_date" class="form-control " />
               <br />
               <label>Status</label>
               <select class="form-control select2 select2-hidden-accessible status_select" style="width: 100%;" id ='status_select' tabindex="-1" aria-hidden="true">
                  <option value='Processing'>Processing</option>
                  <option value='Completed'>Completed</option>
                  <option value='Extend'>Extend</option>
               </select>
               <br />
               <label>Remark</label>
               <input type="text" name="remark" id="remark" class="form-control " />
               <br />
            </div>
            <div class="modal-footer">     
               <input type="hidden" name="phase_id" id="phase_id" />
               <input type="hidden" name="row_id" id="row_id" />               
               <input type="hidden" name="operation" id="operation" />
               <input type="submit" name="commit_task" id="action" class="btn btn-warning" value="Edit" />
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
         </div>
      </form>
   </div>
</div>
<script type="text/javascript" language="javascript" >     
   $(document).ready(function(){  
       if($('#form_key').val() == 0)
       {
        location.href = "index.php?id=file";
       }
       
       $(".date_radio").prop('disabled', true);
       
       $("#back_button").prop('disabled', false);
    
       $('.data_table').dataTable( {
           "bFilter": false,
           "bDestroy": true,
           'paging': false,
           'searching': false,
           'ordering': false,
           'bInfo': false,
            select: true,   
            "columnDefs":[
            {
                "visible": false, "targets": [8] 
            },
            ],
       }); 
       
       $('#back_button').click(function(){
           location.href = "index.php?id=file";
       });           
   });   
</script>