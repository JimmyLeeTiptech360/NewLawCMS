<section class="content-header">
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
         $staffs = $user->result('', NULL, 'and user_type_id = 3');
         $agents = $user->result('', NULL, 'and user_type_id = 4');
         $bankers = $user->result('', NULL, 'and user_type_id = 5');
         $developers = $user->result('', NULL, 'and user_type_id = 6');
         $clients = $user->result('', NULL, 'and user_type_id = 7');
         $vendors = $user->result('', NULL, 'and user_type_id = 8');
         
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

         if(($permission & 16)||($file_user->validate_file_user($file_id, $user_id)) and ($user_type_id == 1 or $user_type_id == 2 or $user_type_id == 3))
         {
            $form_key = 1;
         }         
         ?>
   </h1>
</section>
<section class="content">
   <form role="form" id = "master_form">
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
                        echo $file_master->name ?>' />
                  </div>
                  <div class="form-group">
                     <label>Project</label>
                     <select class="form-control select2 select2-hidden-accessible" data-placeholder="Select a project" style="width: 100%;" tabindex="-1" aria-hidden="true" id = 'selected_project' name = 'selected_project'>
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
                     <textarea class="form-control" rows="5" id = 'propertyaddress' name = 'propertyaddress'><?php
                        echo $file_master->propertyaddress ?></textarea>
                  </div>
                   
                  <div class="box box-primary">
                      <div class="box-body">
                  <div class="form-group">
                     <div class ="col-md-10">
                        <label>Purchaser</label>
                        <select class="form-control select2 select2-hidden-accessible" data-placeholder="Select a purchaser" style="width: 100%;" tabindex="-1" aria-hidden="true" id = 'selected_clients' name = 'selected_clients' required>
                           <option disabled selected value>Select a purchaser</option>
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
                     <div class ="col-md-2">
                        </br>
                        <button type="button" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-info btn-flat">
                          New
                        </button>
                     </div>
                  </div>
                   <div class="form-group">
                     <div class ="col-md-10">
                        <label>Vendor</label>
                        <select class="form-control select2 select2-hidden-accessible" data-placeholder="Select a vendor" style="width: 100%;" tabindex="-1" aria-hidden="true" id = 'selected_vendors' name = 'selected_vendors' required>
                           <option disabled selected value>Select a vendor</option>
                           <?php
                              foreach($vendors as $vendor)
                              	{
                              	$sql = 'SELECT * FROM file_user where file_id = ' . $file_id . ' and user_id =' . $vendor['id'] . ';';
                              	$checked = '';
                              	if (mysqli_num_rows($file_user->getPreparedStatement($sql, NULL)) > 0)
                              		{
                              		$checked = ' selected';
                              		}
                              	$str = '<option value="' . $vendor['id'] . '" ' . $checked . ' >' . $vendor['first_name'] . ' ' . $vendor['last_name'] . '</option>';
                              	echo $str;
                              	}
                              ?>
                        </select>
                     </div>
                     <div class ="col-md-2">
                        </br>
                        <button type="button" id="add_vendor_button" data-toggle="modal" data-target="#userModal" class="btn btn-info btn-flat">
                          New
                        </button>
                     </div>
                  </div>
                  </div> 
                   </div>
                   
                  <div class="form-group">
                     <div class="col-md-6">
                        </br>
                        <label>Settled?</label>
                        <input type="checkbox" id = 'is_settled_chk' name = 'is_settled_chk' value = 1
                        <?php
                           if ($file_master->is_settled == 1)
                           	{
                           	echo "checked";
                                }
                           ?> />
                     </div>
                     <div class="col-md-6">
                        <div class="row">
                           <div class="col-md-4">
                              </br>
                              <label>Settlement</label>
                           </div>
                           <div class="col-md-8">
                              </br>
                              <input type="text" class="form-control" id = 'settlement' name = 'settlement' value =
                              <?php
                                 echo $file_master->settlement ?> >
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="box box-primary">
               <div class="box-header with-border">
                  <h3 class="box-title">Project Info</h3>
               </div>
               <div class="box-body">
                   <div class="form-group">
                     <label>Getting Up Date</label>
                     <div class="input-group date">
                        <div class="input-group-addon">
                           <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control pull-right" id = 'opendate' name = 'opendate' value = '<?php
                            if(isset($file_master->opendate))
                            {
                                echo $file_master->opendate;
                            }
                            else
                            {
                                echo date("Y-m-d");
                            }
                            ?>' />
                     </div>
                  </div>
                  <div class="form-group">
                     <label>S&P Date</label>
                     <div class="input-group date">
                        <div class="input-group-addon">
                           <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control pull-right" id = 'snpdate' name = 'snpdate' required value = '<?php
                           echo $file_master->snpdate ?>' />
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="row">
                           <div class="col-md-3">
                                <input type="checkbox" name="usecpdate" id ="usecpdate" value = 1
                                    <?php
                                        if($file_master->use_cpdate ===1)
                                        {
                                            echo "checked";
                                        }
                                    ?>
                                    />
                                    <label> CP Date</label>
                           </div>
                           <div class="col-md-9">
                               <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="date" class="form-control pull-right"  id = 'cpdate' name = 'cpdate' value = '<?php
                                            echo $file_master->cpdate ?>' />
                                </div>
                           </div>
                     </div>
                  </div>                 
                  <div class="form-group">
                     <label>Letter of Instruction Date</label>
                     <div class="input-group date">
                        <div class="input-group-addon">
                           <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control pull-right" id = 'instructiondate' name = 'instructiondate' value =
                        '<?php
                           echo $file_master->instructiondate ?>'
                        />
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
                     <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id = 'status' name = 'status' >
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
                  <div class="form-group">
                        <div class="row">
                           <div class="col-md-4">
                              </br>
                              <label>After Task Duration(Days)</label>
                           </div>
                           <div class="col-md-8">
                              </br>
                              <input type="number" class="form-control" id = 'aftertask_duration' name = 'aftertask_duration' value="0" step="1" <?php
                                 echo $file_master->aftertask_duration ?> />
                           </div>
                        </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-8">
            <div class="box box-primary">
               <div class="box-header with-border">
                  <h3 class="box-title">Personnel Information</h3>
               </div>
               <div class="box-body">
                  <div class="form-group">
                     <label>Agent Name</label>
                     <select class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Select an agent" style="width: 100%;" tabindex="-1" aria-hidden="true" id = 'selected_agents' name = 'selected_agents'>
                       <?php
                        foreach($agents as $agent)
                        	{
                        	$sql = 'SELECT * FROM file_user where file_id = ' . $file_id . ' and user_id =' . $agent['id'] . ';';
                        	$checked = '';
                        	if (mysqli_num_rows($file_user->getPreparedStatement($sql, NULL)) > 0)
                        		{
                        		$checked = ' selected';
                        		}

                        	$str = '<option value="' . $agent['id'] . '" ' . $checked . ' >' . $agent['first_name'] . ' ' . $agent['last_name'] . '</option>';
                        	echo $str;
                        	}
                        ?>
                     </select>
                  </div>
                  <div class="form-group">
                     <label>Banker Name</label>
                     <select class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Select a banker" style="width: 100%;" tabindex="-1" aria-hidden="true" id = 'selected_bankers' name = 'selected_bankers'>
                       <?php
                        foreach($bankers as $banker)
                        	{
                        	$sql = 'SELECT * FROM file_user where file_id = ' . $file_id . ' and user_id =' . $banker['id'] . ';';
                        	$checked = '';
                        	if (mysqli_num_rows($file_user->getPreparedStatement($sql, NULL)) > 0)
                        		{
                        		$checked = ' selected ';
                        		}

                        	$str = '<option value="' . $banker['id'] . '" ' . $checked . ' >' . $banker['first_name'] . ' ' . $banker['last_name'] . '</option>';
                        	echo $str;
                        	}

                        ?>
                     </select>
                  </div>
                  <div class="form-group">
                     <label>Developer Name</label>
                     <select class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Select a developer" style="width: 100%;" tabindex="-1" aria-hidden="true" id = 'selected_developers' name = 'selected_developers'>
                       <?php
                        foreach($developers as $developer)
                        	{
                        	$sql = 'SELECT * FROM file_user where file_id = ' . $file_id . ' and user_id =' . $developer['id'] . ';';
                        	$checked = '';
                        	if (mysqli_num_rows($file_user->getPreparedStatement($sql, NULL)) > 0)
                        		{
                        		$checked = ' selected ';
                        		}

                        	$str = '<option value="' . $developer['id'] . '" ' . $checked . ' >' . $developer['first_name'] . ' ' . $developer['last_name'] . '</option>';
                        	echo $str;
                        	}

                        ?>
                     </select>
                  </div>
                  <div class="form-group">
                     <label>Lawyer Name</label>
                     <select class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Select a lawyer" style="width: 100%;" tabindex="-1" aria-hidden="true" id = 'selected_lawyers' name = 'selected_lawyers'>
                       <?php
                        foreach($lawyers as $lawyer)
                        	{
                        	$sql = 'SELECT * FROM file_user where file_id = ' . $file_id . ' and user_id =' . $lawyer['id'] . ';';
                        	$checked = '';
                        	if (mysqli_num_rows($file_user->getPreparedStatement($sql, NULL)) > 0)
                        		{
                        		$checked = ' selected ';
                        		}

                        	$str = '<option value="' . $lawyer['id'] . '" ' . $checked . ' >' . $lawyer['first_name'] . ' ' . $lawyer['last_name'] . '</option>';
                        	echo $str;
                        	}

                        ?>
                     </select>
                  </div>
                  <div class="form-group">
                     <label>Staff Name</label>
                     <select class="form-control select2 select2-hidden-accessible" data-placeholder="Select a staff" style="width: 100%;" tabindex="-1" aria-hidden="true" id = 'selected_staffs' name = 'selected_staffs'>
                        <option disabled selected value>Select a staff</option>
                          <?php
                           foreach($staffs as $staff)
                           {
                           	$sql = 'SELECT * FROM file_user where file_id = ' . $file_id . ' and user_id =' . $staff['id'] . ';';
                           	$checked = '';
                           	if (mysqli_num_rows($file_user->getPreparedStatement($sql, NULL)) > 0)
                           		{
                           		$checked = ' selected ';
                           		}

                           	$str = '<option value="' . $staff['id'] . '" ' . $checked . ' >' . $staff['first_name'] . ' ' . $staff['last_name'] . '</option>';
                           	echo $str;
                           }
                           ?>
                     </select>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="box box-primary">
               <div class="box-header with-border">
                  <h3 class="box-title">Project References</h3>
               </div>
               <div class="box-body">
                  <div class="form-group">
                     <label>Company's File Reference</label>
                     <input type="text" class="form-control" id = 'companyref' name = 'companyref' value = '<?php
                        echo $file_master->companyref ?>'>
                  </div>
                  <div class="form-group">
                     <label>Developer's File Reference</label>
                     <input type="text" class="form-control" id = 'devref' name = 'devref' value = '<?php
                        echo $file_master->devref ?>'>
                  </div>
                  <div class="form-group">
                     <label>Bank's File Reference</label>
                     <input type="text" class="form-control" id = 'bankref' name = 'bankref' value = '<?php
                        echo $file_master->bankref ?>'>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="box box-primary">
               <div class="box-header with-border">
                  <h3 class="box-title">Fees References</h3>
               </div>
               <div class="box-body">
                  <div class="form-group">
                     <label>Agreed Fees</label>
                     <input type="text" class="form-control" id = 'agreedfees' name = 'agreedfees' value = '<?php
                        echo $file_master->agreedfees ?>' >
                  </div>
                  <div class="form-group">
                     <label>Fees Paid</label>
                     <input type="text" class="form-control" id = 'feespaid' name = 'feespaid' value = '<?php
                        echo $file_master->feespaid ?>'/>
                  </div>
               </div>
            </div>
         </div>
         <div class="flex-container" style="display:flex; flex-wrap: wrap; width:100%;">
             <div style="flex:1; margin:10px;">
              	<input type="button" class="btn btn-primary btn-block" id ="back_button" name ="back_button" value="Back"/>
              </div>
              	<?php
				if($form_key ==1)
                  {
					if( $file_id == -1){

                    echo '<div style="flex:1; margin:10px;">';
                    echo '<input type="button" class="btn btn-danger btn-block" id= "clear_button" name = "clear_button" value="Clear"/>';
                    echo '</div>';}

					echo '<div style="flex:1; margin:10px;">';
                    echo '<input type="button" class="btn btn-success btn-block submit_button" name = "submit_button" value="Save"/>';
                    echo '</div>';
					}
                ?>
          </div>
      <div class="box box-primary">
         <div class="box-header with-border">
            <h3 class="box-title">Project Timeline</h3>
         </div>
         <div class="box-body">
            <div class="col-md-8">
               <div class="form-group">
                  <label>Template Name</label>
                  <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id = "template_select">
                    <?php
                     foreach($templates as $temp)
                     	{
                     	$checked = '';
                     	if (isset($file_master->template_id))
                     		{
                     		if ($file_master->template_id == $temp['id'])
                     			{
                     			$checked = ' selected';
                     			}
                     		}

                     	echo '<option value="' . $temp['id'] . '" ' . $checked . ' >' . $temp['name'] . '</option>';
                     	}
                     ?>
                  </select>
               </div>
            </div>
            <div class="col-md-4" style="margin:1.75em 0 0 0" >
               <button type="button" class="btn btn-success btn-block template_button" id ='template_button'
                  <?php
                     if ($file_id == - 1||$user_type_id === 2||trim($file_master->template_source)==="")
                     {

                     }
                     else
                     {
                         echo 'disabled';
                      }
                    ?>
                  >Load
                </button>
                  <?php
                     if ($file_id != - 1 && trim($file_master->template_source)!=="" && $user_type_id !== 2)
                     {
                         echo "<script type='text/javascript'>
                           document.getElementById('template_button').style.display = 'none';
                         </script>";
                       }
                    ?>
            </div>
         </div>
      </div>
      <div class="box box-primary">
         <div class="box-header with-border">
            <h3 class="box-title">Task Assignment</h3>
         </div>
         <div class="box-body with-border" id = "table_content">
            <?php
               if (isset($file_master->template_source))
               	{
               	echo $file_master->template_source;
               	}
               ?>
         </div>
         <div style='width:100%; align:center;'>
            <input type="button" style="margin:10px 10px 10px 67%; width:33%;" class="btn btn-success submit_button" name = "submit_button" value="Save"/>
         </div>
      </div>
      <input type="hidden" name="file_master" id="file_master" value = 'file_master'/>
      <input type="hidden" name="is_settled" id="is_settled" />
      <input type="hidden" name="use_cpdate" id="use_cpdate" />
      <input type="hidden" name="form_key" id="form_key" value = <?php echo $form_key; ?>/>
      <input type="hidden" name="client_name" id="client_name" />
      <input type="hidden" name="vendor_name" id="vendor_name" />
      <input type="hidden" name="file_user" id="file_user" value = 'file_user'/>
      <input type="hidden" name="user_type_id" id="user_type_id" />
      <input type="hidden" name="user_id" id="user_id" value = <?php
         echo $user_id; ?>>
      <input type="hidden" name="id" id="id" value = '<?php
         if ($file_id <> - 1)
         	{
         	echo $file_id;
        } ?>' />
      <input type="hidden" name="file_id" id="file_id" value = '<?php
         if ($file_id <> - 1)
         	{
         	echo $file_id;
        } ?>' />
      <input type="hidden" name="operation" id="operation" value = '<?php
         if ($file_id == - 1)
         	{
         	echo 'insert';
         	}
           else
         	{
         	echo 'update';
        } ?>' />
      <input type="hidden" name="template_id" id="template_id" />
      <input type="hidden" name="template_source" id="template_source" />
      <input type="hidden" name="file_status" id="file_status" />
      <input type="hidden" name="user_password" id="user_password" value = '<?php echo $user->password; ?>'/>
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
               <label>Status</label>
               <select class="form-control select2 select2-hidden-accessible status_select" style="width: 100%;" id ='status_select' tabindex="-1" aria-hidden="true">
                  <option value='Processing'>Processing</option>
                  <option value='Completed'>Completed</option>
                  <option value='Extend'>Requested To Extend</option>
               </select>
               <br />
               <label>Complete Date</label>
               <input type="date" name="complete_date" id="complete_date" class="form-control disabled" />
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
               <input type="button" class="btn btn-default" data-dismiss="modal" value="Close"/>
            </div>
         </div>
      </form>
   </div>
</div>
<div id="userModal" class="modal fade">
   <div class="modal-dialog">
      <form method="post" id="user_form" enctype="multipart/form-data">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">User</h4>
            </div>
            <div class="modal-body">
               <div>
                  <div class="form-group">
                     <label for="user_type">User Type</label>
                     <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id="user_type">
                        <option value="7">Purchaser</option>
                     </select>
                  </div>
                  <div class="form-group">
                           <label for="user_name">User Name</label>
                           <input type="text" name ='user_name' id="user_name" placeholder="user_name" class="form-control" value ='<?php echo $user->user_name ?>'>
                  </div>
                  <div class="form-group">
                     <label for="first_name">First Name</label>
                     <input type="text" name="first_name" id="first_name" required placeholder="FirstName" class="form-control">
                  </div>
                  <div class="form-group">
                     <label for="last_name">Last Name</label>
                     <input type="text" name="last_name" id="last_name" placeholder="LastName" class="form-control">
                  </div>
                  <div class="form-group">
                     <label for="contact_no">Contact No</label>
                     <input type="text" name="contact_no" id="contact_no" required class="form-control">
                  </div>
                  <div class="form-group">
                     <label for="email">Email Address</label>
                     <input type="email" name="email" id="email" placeholder="someone@example.com" class="form-control">
                  </div>
                  <div class="form-group">
                     <label for="password">Password</label>
                     <div class = "row">
                        <div class = "col-md-9">
                           <input type="text" name="password" id="password" required class="form-control" >
                        </div>
                        <div class = "col-md-1">
                           <input type="button" name="generate_password" id="generate_password" class="btn btn-default" value ="Generate" onClick="generate();">
                        </div>
                        <div class = "col-md-2">
                        </div>
                     </div>
                  </div>
               </div>
               <div>
                  <div class="form-group" style='display: none'>
                     <label>Access Level</label>
                     <div class="checkbox">
                        <label><input type="checkbox" name="accessLV" value="viewFiles" id='view_all_files_box'>View All Files</label>
                     </div>
                     <div class="checkbox">
                        <label><input type="checkbox" name="accessLV" value="viewProject" id='view_project_management_box'>View Project Management</label>
                     </div>
                     <div class="checkbox">
                        <label><input type="checkbox" name="accessLV" value="viewUser" id='view_user_management_box'>View User Management</label>
                     </div>
                     <div class="checkbox">
                        <label><input type="checkbox" name="accessLV" value="editProject" id='edit_project_box'>Edit Project</label>
                     </div>
                     <div class="checkbox">
                        <label><input type="checkbox" name="accessLV" value="editFiles" id='edit_files_box'>Edit Files</label>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <input type="hidden" name="id" id="id" />
                     <input type="hidden" name="operation" id="operation" value = "insert"/>
                     <input type="hidden" name="permission" id="permission" />
                     <input type="hidden" name="user" id="user" value = "user"/>
                     <input type="hidden" name="user_user_type_id" id="user_user_type_id" />
                     <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js"></script>
<script type="text/javascript" language="javascript" >
   function randomPassword(length)
   {
        var chars = "abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890";
        var pass = "";
        for (var x = 0; x < length; x++) {
            var i = Math.floor(Math.random() * chars.length);
            pass += chars.charAt(i);
        }
        return pass;
    }

    function generate() {
        $('#password').val(randomPassword(10));
    }

   function SaveUser(userType, userTypeId, fileId)
   {
       var selectedUsers = $('#selected_'+ userType).val();

       if($.isArray(selectedUsers))
       {
            jQuery.each(selectedUsers, function(val) {
                $.ajax({
                url:"/LawCMS/model/entity/EntityHandler.php",
                method:'POST',
                data:{file_user:'file_user', 'operation':'insert', 'file_id':fileId,'user_type_id': userTypeId,'user_id':selectedUsers[val]},
                dataType : 'json',
                success:function(data)
                {

                }});
            });
        }
        else
        {
            $.ajax({
                url:"/LawCMS/model/entity/EntityHandler.php",
                method:'POST',
                data:{file_user:'file_user', 'operation':'insert', 'file_id':fileId,'user_type_id': userTypeId,'user_id':selectedUsers},
                dataType : 'json',
                success:function(data)
                {
 
                }});
        }
   }

   function ValidatePhase()
   {
       var buttonCount = 0;
       var editable = true;

       $('.table_box').each(
            function()
            {
                var divId = $(this).attr("id");
                var phaseCount = divId.substring(4);
                var data = $('#phase_' + phaseCount).DataTable().rows().data();

                data.each(
                    function(value)
                    {
                        if(editable)
                        {
                            $(".row_"+buttonCount).prop('disabled', false);
                        }
                        else
                        {
                            $(".row_"+buttonCount).prop('disabled', true);
                        }

                        if(value[5]!= '')
                        {
                            editable = true;
                        }
                        else
                        {
                            editable = false;
                        }

                        buttonCount++;
                    }
                );
            }
        );
   }

   function SavePhase(fileId)
   {
       $.ajax({
            url:"/LawCMS/model/entity/EntityHandler.php",
            method:"POST",
            data:{file_id:fileId, file_phase:'file_phase',operation:'clear_old_phases'},
            dataType:"json",
            success:function()
            {
                $('.table_box').each(function() {

                    var newSnippet = $(this).clone();
                    var desc = newSnippet.find('.box-title').html();

                    var divId = $(this).attr("id");

                    var phaseCount = divId.substring(4);

                    $.ajax({
                    url:"/LawCMS/model/entity/EntityHandler.php",
                    method:'POST',
                    data:{file_phase:'file_phase', 'operation':'insert', 'file_id':fileId,'phase': phaseCount,'description':desc},
                    dataType : 'json',
                    success:function()
                    {
                        var data = $('#phase_' + phaseCount).DataTable().rows().data();

                        data.each(function(value)
                        {
                           var rowId = value[0];
                           var description = value[1];
                           var overdueDate = value[2];
                           var startDate = null;
                           var targetDate = null;
                           var completeDate = null;
                           var status = value[6];
                           var remark = value[7]

                           if(value[3]!= '')
                           {
                              startDate = value[3];
                           }

                           if(value[4]!= '')
                           {
                              targetDate = value[4];
                           }

                           if(value[5]!= '')
                           {
                              completeDate = value[5];
                           }

                            $.ajax({
                                url:"/LawCMS/model/entity/EntityHandler.php",
                                method:'POST',
                                data:{phase_subtask:'phase_subtask', 'operation':'insert', 'file_id':fileId,'phase': phaseCount,
                                    'description':description, 'overdue_date':overdueDate, 'start_date':startDate, 'row_id':rowId,
                                    'target_date':targetDate,'complete_date':completeDate, 'status':status, 'remark':remark},
                                dataType : 'json',
                                complete:function()
                                {
                                    if($('#operation').val()==='insert')
                                    {
                                        $('#id').val(fileId);
                                        location.href = "index.php?id=file_info&file_id=" + fileId;
                                    }
                                }
                            });
                        });
                    }});
                });
            }
        });
   }

   $(document).ready(function(){
       if($('#form_key').val() == 0)
       {
        location.href = "index.php?id=file";
       }

       $(".date_radio").prop('disabled', true);

       $('.data_table').dataTable( {
           "bFilter": false,
           "bDestroy": true,
           'paging': false,
           'searching': false,
           'ordering': false,
           'bInfo': false,
            select: true,
       });

       $('#clear_button').click(function(){
           location.href = "index.php?id=file_info&file_id=-1";
       });

       $('#back_button').click(function(){
           location.href = "index.php?id=file";
       });

       $(document).on('submit', '#user_form', function(event){
            event.preventDefault();
            var email = $('#email').val();
            var user_type = $('#user_type').val();

            $('#user_user_type_id').val(user_type);

            var permission = 0;

            if(document.getElementById('view_all_files_box').checked)
            {
                permission = permission + 1;
            }

            if(document.getElementById('view_project_management_box').checked)
            {
                permission = permission + 10;
            }

            if(document.getElementById('view_user_management_box').checked)
            {
                permission = permission + 100;
            }

            if(document.getElementById('edit_project_box').checked)
            {
                permission = permission + 1000;
            }

            if(document.getElementById('edit_files_box').checked)
            {
                permission = permission + 10000;
            }

            var permissionInBinary = permission.toString();
            var permissionInDecimal = parseInt(permissionInBinary,2);
            $('#permission').val(permissionInDecimal);

            if(email !== '')
            {
                $.ajax({
                    url:"/LawCMS/model/entity/EntityHandler.php",
                    method:'POST',
                    data:new FormData(this),
                    dataType : 'json',
                    contentType:false,
                    processData:false,
                    success:function(data)
                    {
                        alert(data.message);

                        if(data.status=="200")
                        {
                            $.ajax({
                                url:"/LawCMS/model/entity/EntityHandler.php",
                                method:"POST",
                                data:{'operation':'retrieve_latest', 'user':'user', 'user_type':user_type},
                                dataType:"json",
                                success:function(data)
                                {                                                
                                    $('#user_form')[0].reset();
                                    $('#userModal').modal('hide');
                            
                                    if(user_type === "7")
                                    {
                                        $('#selected_clients').html(data.output);
                                    }
                                    else
                                    {
                                        $('#selected_vendors').html(data.output);
                                    }
                                }
                            })
                        }                   
                    }
                });
            }
            else
            {
                alert("Both Fields are Required");
            }
        });
        
        $("#cpdate").change(function() {
            $("#usecpdate").prop('checked',true);
        });
        
        $('#usecpdate').change(function() {
            if($(this).is(":checked")) {
                var d = new Date();
                var strDate = moment(d).format('YYYY-MM-DD');

                $("#cpdate").val(strDate);
            }    
            else
            {
                $("#cpdate").val('');
            }
        });
        
        $('#add_button').click(function(){
            $("#user_type option[value='7']").remove();
            $("#user_type option[value='8']").remove();
            $("#user_type").append('<option value="7">Purchaser</option>');
        })
        
        $('#add_vendor_button').click(function(){
            $("#user_type option[value='7']").remove();
            $("#user_type option[value='8']").remove();
            $("#user_type").append('<option value="8">Vendor</option>');
        })             

        $('.submit_button').click(function(){
           var clientName = $('#selected_clients option:selected').text();
           var vendorName = $('#selected_vendors option:selected').text();
           
           if(clientName === "Select a client")
           {
               clientName = "";
           }
           
           if(vendorName === "Select a vendor")
           {
               vendorName = "";
           }
                   
           var fileNo = $('#name').val();

           var newSnippet = $('#table_content').clone().html();

           if(fileNo!=="")
           {
                var myForm = document.getElementById('master_form');

                $('#template_id').val( $('#template_select').val());
                var id = $('#id').val();
                $('#file_status').val($('#status').val());
                var isSettled = $('#is_settled_chk:checked').val();
                var useCPDate = $('#usecpdate:checked').val();
                $('#client_name').val(clientName);
                $('#vendor_name').val(vendorName);
                $('#is_settled').val(isSettled);
                $('#use_cpdate').val(useCPDate);
                $('#template_source').val(newSnippet);
                $.ajax({
                    url:"/LawCMS/model/entity/EntityHandler.php",
                    method:'POST',
                    data:new FormData(myForm),
                    dataType : 'json',
                    contentType:false,
                    processData:false,
                    success:function(data)
                    {
                        $('#template_source').val('');
                        alert(data.message);

                        $.ajax({
                            url:"/LawCMS/model/entity/EntityHandler.php",
                            method:"POST",
                            data:{file_user:'file_user', 'operation':'get_latest_file', },
                            dataType:"json",
                            success:function(data)
                            {
                                if((id != data.id)&&($('#operation').val()!='update'))
                                {
                                    id = data.id;
                                }

                                $.ajax({
                                    url:"/LawCMS/model/entity/EntityHandler.php",
                                    method:"POST",
                                    data:{file_id:id, file_user:'file_user',operation:'clear_old_link'},
                                    dataType:"json",
                                    success:function()
                                    {
                                        SaveUser('vendors',8,id);
                                        SaveUser('clients',7,id);
                                        SaveUser('agents',4,id);
                                        SaveUser('bankers',5,id);
                                        SaveUser('developers',6,id);
                                        SaveUser('lawyers',1,id);
                                        SaveUser('staffs',3,id);
                                    }
                                });

                                SavePhase(id);
                            }
                        });
                    },
                    fail: function(xhr)
                    {
                        alert(xhr.responseText);
                    }
                });
            }
            else if(fileNo==="")
            {
                alert('File No. cannot be empty!');
                $('#name').focus();
            }
       });

       $('#template_button').click(function(){
           var template_id = $('#template_select').val();

           $.ajax({
               url:"/LawCMS/model/entity/EntityHandler.php",
               method:"POST",
               data:{id:template_id, 'operation':'read', 'template':'template',},
               dataType:"json",
               success:function(data)
               {
                   if($("#operation").val() ==="update")
                   {                     
                       var newSnippet = $('#table_content').clone().html();
                       
                       if(newSnippet.trim()!=="")
                       {
                            var response = prompt("Please enter your password to proceed!");
              
                            if($("#user_password").val()!== response)
                            {
                                alert("Wrong password!");
                                
                                return;
                            }
                       }
                   }
                   
                   if($("#opendate").val() === "")
                   {
                       $("#opendate").focus();
                       alert("Getting up date cannot be empty!");

                       return false;
                   }
                   else if((data.output_source.indexOf("Follow S&amp;P date")>0) && $("#snpdate").val() == "")
                   {
                       $("#snpdate").focus();
                       alert("S&P date cannot be empty!");

                       return false;
                   }
                   else if((data.output_source.indexOf("Follow CP date")>0) && $("#cpdate").val() == "")
                   {
                       $("#cpdate").focus();
                       alert("CP date cannot be empty!");

                       return false;
                   }
                   else
                   {
                        $('#table_content').html(data.output_source);
                        $('.data_table').dataTable( {
                            "bFilter": false,
                            "bDestroy": true,
                            'paging': false,
                            'searching': false,
                            'ordering': false,
                            'bInfo': false,
                            select: true,
                        } );

                        var table = $('.data_table').DataTable();
                        table.draw();

                        if(table != null)
                        {
                            var rowCount = 0;
                            var isSnPDateChecked =false;
                            var isCPDateChecked =false;

                            $(".lblDate").each(
                            function(){
                                var thisName = $(this).attr("name");
                                var thisText = $(this).text();
                                var startdate = "";
                                rowCount++;

                                if(thisName ==="lbl_"+rowCount)
                                {
                                    if(thisText==="Follow CP date" && !isCPDateChecked)
                                    {
                                        startdate = $("#cpdate").val();
                                        isCPDateChecked = true;

                                        var table = $('#phase_'+rowCount).DataTable();
                                        var data = table.row($('.row_0').parents('tr')).data();
                                        var currentDate = new Date(startdate);
                                        var newDate = new Date();

                                        newDate.setDate(currentDate.getDate() + parseInt(data[2],10));

                                        data[3] = startdate;
                                        data[4] =  moment(newDate).format('YYYY-MM-DD');
                                        //data[6] = "Processing";

                                        table.row($('.row_0').parents('tr')).data(data).draw();
                                    }
                                    else if(thisText==="Follow S&P date" && !isSnPDateChecked)
                                    {
                                        startdate = $("#snpdate").val();
                                        isSnPDateChecked = true;

                                        var table = $('#phase_'+rowCount).DataTable();
                                        var data = table.row($('.row_0').parents('tr')).data();
                                        var currentDate = new Date(startdate);
                                        var newDate = new Date();

                                        newDate.setDate(currentDate.getDate() + parseInt(data[2],10));

                                        data[3] = startdate;
                                        data[4] =  moment(newDate).format('YYYY-MM-DD');
                                        //data[6] = "Processing";

                                        table.row($('.row_0').parents('tr')).data(data).draw();
                                    }
                                    else if(rowCount===1)
                                    {
                                        startdate = $("#opendate").val();

                                        var table = $('#phase_'+rowCount).DataTable();
                                        var data = table.row($('.row_0').parents('tr')).data();
                                        var currentDate = new Date(startdate);
                                        var newDate = new Date();

                                        newDate.setDate(currentDate.getDate() + parseInt(data[2],10));

                                        data[3] = startdate;
                                        data[4] =  moment(newDate).format('YYYY-MM-DD');
                                        data[6] = "Processing";

                                        table.row($('.row_0').parents('tr')).data(data).draw();
                                    }
                                    else
                                    {
                                        isSnPDateChecked = false;
                                    }
                                }

                                if(isSnPDateChecked && isCPDateChecked)
                                {
                                    return false;
                                }
                            }
                            );

                            ValidatePhase();
                        }
                    }
               }
           });
       });

       $(document).on('submit', '#task_form', function(event){
           event.preventDefault();

           var start_date = $('#start_date').val();
           var target_date = $('#target_date').val();
           var complete_date = $('#complete_date').val();
           var status = $('#status_select').val();
           var remark = $('#remark').val();
           var row_id = $('#row_id').val();
           var phase_id = $('#phase_id').val();
           var aftertask_duration = $('#aftertask_duration').val();

           var table = $('#phase_'+phase_id).DataTable();
           var data = table.row($('.'+row_id).parents('tr')).data();

           data[3] = start_date;
           data[4] = target_date;
           data[5] = complete_date;
           data[6] = status;
           data[7] = remark;

           table.row($('.'+row_id).parents('tr')).data(data).draw();

           if(status === "Completed" && complete_date != "")
           {
                var rowCount = row_id.split("_");
                var newRowCount = (parseInt(rowCount[1], 10)+1);

                if(status === "Completed" && complete_date!=="")
                {
                    var nextData = table.row($('.row_'+newRowCount).parents('tr')).data();
                    var currentDate = new Date(complete_date);
                    var newDate = new Date();

                    newDate.setDate(currentDate.getDate() + parseInt(aftertask_duration,10));

                    if(nextData)
                    {
                        var newTable = $('.row_'+newRowCount).parents('tr').parents('tbody').parents('table').DataTable();

                        if(newTable!== null)
                        {
                            var newData = newTable.row($('.row_'+newRowCount).parents('tr')).data();

                            if(newData!==null)
                            {
                                if(newData[6]==="-")
                                {
                                    var newTargetDate = new Date();

                                    newTargetDate.setDate(newDate.getDate() + parseInt(newData[2],10));

                                    newData[3] = moment(newDate).format('YYYY-MM-DD');
                                    newData[4] = moment(newTargetDate).format('YYYY-MM-DD');
                                    newData[6] = "Processing";
                                }
                                else
                                {

                                }
                            }

                            newTable.row($('.row_'+newRowCount).parents('tr')).data(newData).draw();
                        }
                    }
                }

                $('#taskModal').modal('hide');

                ValidatePhase();
            }
            else if(status === "Completed" && complete_date === "")
            {
                alert("Please insert complete date!");
            }
            else
            {
                $('#taskModal').modal('hide');
            }
       });

       $(document).on('click', '.update_task', function(){
           $('#task_form')[0].reset();
           var id = $(this).attr("id");
           var row_id = $(this).attr("name");

           var table = $('#phase_'+id).DataTable();
           var data = table.row($(this).parents('tr')).data();

           var status = 'Processing';

           if(data[6] != '')
           {
               if(data[6] != '-')
               {
                status = data[6];
               }
           }

           $('#subtask_description').val(data[1]);
           $('#row_id').val(row_id);
           $('#phase_id').val(id);
           $('#overdue_date').val(data[2]);
           $('#start_date').val(data[3]);
           $('#target_date').val(data[4]);
           $('#complete_date').val(data[5]);
           $('#status_select').val(status).change();
           $('#remark').val(data[7]);
           $('#taskModal').modal('show');
       });

       $( ".status_select").change(function()
       {
            $( ".status_select option:selected" ).each(function()
            {
                if($(this).val()==="Completed")
                {
                    $("#complete_date").prop('disabled', false);
                    
                    var d = new Date();
                    var strDate = moment(d).format('YYYY-MM-DD');
                    
                    $("#complete_date").val(strDate);
                }
                else
                {
                    $("#complete_date").val("");
                    $("#complete_date").prop('disabled', true);
                }
            });
       });
   });
</script>
