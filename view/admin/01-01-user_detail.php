<section class="content-header">
   <h1>
      <?php
         echo $PageTitle;

         $user_id = $_SESSION['user_id'];

         $user = new User(true);

         $user->set_user_by_Id($user_id);

         $permission = $user->permission;

         $form_key= 0;

         if(($permission & 4))
         {
            $form_key = 1;
         }

         if(isset($_GET['user_id']))
         {
             if($user_id != $_GET['user_id'])
             {
                 $user_id = $_GET['user_id'];
                 $user->set_user_by_Id($user_id);
             }
         }

         $user_type = new User_Type(true);
         $user_type_str = $user_type->get_user_type_by_Id($user->user_type_id)['name'];
         $permission = $user->permission;
         ?>
   </h1>
</section>
<section class="content">
   <div class="box box-primary">
      <div class="box-header with-border">
         <h3 class="box-title">Entry</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
         <div class="row">
            <form id ='user_detail_form'>
               <div class="col-md-6">
                  <div>
                     <div class="box-body">
                        <label>Account ID </label>
                        <p><?php echo $user_id?></p>
                        <div class="form-group">
                           <label for="user_type">User Type</label>
                           <select class="form-control select2 select2-hidden-accessible" id ='user_type' style="width: 100%;" tabindex="-1" aria-hidden="true">
                               <option value="1" <?php if ($user->user_type_id ==1){echo "selected";}?>>Lawyer</option>
                              <option value="2" <?php if ($user->user_type_id ==2){echo "selected";}?>>Admin</option>
                              <option value="3" <?php if ($user->user_type_id ==3){echo "selected";}?>>Staff</option>
                              <option value="4" <?php if ($user->user_type_id ==4){echo "selected";}?>>Agent</option>
                              <option value="5" <?php if ($user->user_type_id ==5){echo "selected";}?>>Banker</option>
                              <option value="6" <?php if ($user->user_type_id ==6){echo "selected";}?>>Developer</option>
                              <option value="7" <?php if ($user->user_type_id ==7){echo "selected";}?>>Client</option>
                           </select>
                        </div>
                        <div class="form-group">
                           <label for="user_name">User Name</label>
                           <input type="text" name ='user_name' id="user_name" placeholder="user_name" class="form-control" value ='<?php echo $user->user_name ?>'>
                        </div>
                        <div class="form-group">
                           <label for="first_name">First Name</label>
                           <input type="text" name ='first_name' id="first_name" placeholder="first_name" class="form-control" value ='<?php echo $user->first_name ?>'>
                        </div>
                        <div class="form-group">
                           <label for="last_name">Last Name</label>
                           <input type="text" name='last_name' id="last_name" placeholder="last_name" class="form-control" value ='<?php echo $user->last_name ?>'>
                        </div>
                        <div class="form-group">
                           <label for="contact_no">Contact No</label>
                           <input type="text" name="contact_no" id="contact_no"  class="form-control" value ='<?php echo $user->contact_no ?>'>
                        </div>
                        <div class="form-group">
                           <label for="email">Email Address</label>
                           <input type="email" name="email" id="email" placeholder="someone@example.com" class="form-control" value ='<?php echo $user->email ?>'>
                        </div>
                        <div class="form-group">
                           <label for="password">Password</label>
                           <input type="password" name="password" id="password" class="form-control" value ='<?php echo $user->password ?>'>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div>
                     <div class="form-group">
                        <label>Access Level</label>
                        <div class="checkbox">
                           <label>
                           <input type="checkbox" name="accessLV" value="viewFiles" id='view_all_files_box'
                              <?php
                                 if($permission & 1)
                                 {
                                     echo 'checked';
                                 }
                                 ?>
                              >
                           View All Files
                           </label>
                        </div>
                        <!-- start from here -->
                        <div class="checkbox">
                           <label><input type="checkbox" name="accessLV" value="viewProject" id='view_project_management_box'
                              <?php
                                 if($permission & 2)
                                 {
                                         echo 'checked';
                                 }
                                 ?>
                              >
                           View Project Management
                           </label>
                        </div>
                        <div class="checkbox">
                           <label>
                           <input type="checkbox" name="accessLV" value="viewUser" id='view_user_management_box'
                              <?php
                                 if($permission & 4)
                                 {
                                     echo 'checked';
                                 }
                                 ?>
                              >
                           View User Management
                           </label>
                        </div>
                        <div class="checkbox">
                           <label>
                           <input type="checkbox" name="accessLV" value="editProject" id='edit_project_box'
                              <?php
                                 if($permission & 8)
                                 {
                                     echo 'checked';
                                 }
                                 ?>
                              >
                           Edit Project
                           </label>
                        </div>
                        <div class="checkbox">
                           <label>
                           <input type="checkbox" name="accessLV" value="editFiles" id='edit_files_box'
                              <?php
                                 if($permission & 16)
                                 {
                                     echo 'checked';
                                 }
                                 ?>
                              >
                           Edit Files
                           </label>
                        </div>
                        <button type="button" id ='submit' class="btn btn-primary">Submit</button>
                     </div>
                  </div>
               </div>
               <input type="hidden" name="permission" id="permission" value = '<?php echo $user->permission?>'/>
               <input type="hidden" name="id" id="id" value = "<?php echo $user_id ?>"/>
               <input type="hidden" name="user" id="user" />
               <input type="hidden" name="operation" id="operation" />
               <input type="hidden" name="user_type_id" id="user_type_id" />
               <input type="hidden" name="form_key" id="form_key" value = <?php echo $form_key?> >
            </form>
         </div>
      </div>
      <!-- /.box-body -->
   </div>
   <div class="row">
      <!-- /.col -->
   </div>
   <!-- /.row -->
   <div class="row" style="display: none;">
      <div class="col-md-12">
         <div class="box box-primary">
            <div class="box-header with-border">
               <h3 class="box-title">Project Timeline</h3>
            </div>
            <form role="form">
               <div class="box-body">
                  <div class="form-group">
                     <div align="middle">
                        <button type="button" id="add_project_button" data-toggle="modal" data-target="#projectModal" class="btn btn-info btn-lg">
                        Add
                        </button>
                     </div>
                     <table id="example1" class="table table-bordered table-striped">
                        <thead>
                           <tr>
                              <th>ID</th>
                              <th>Name</th>
                              <th>Description</th>
                              <th class = 'sorting_disabled'>View</th>
                              <th class = 'sorting_disabled'>Delete</th>
                           </tr>
                        </thead>
                        <tbody id='projectData_body'>
                           <?php
                              $projects = new User_Project(true);
                              $parameter_array = array();

                              array_push($parameter_array, array('and','user_id','=',$user_id));

                              $rows = $projects->result('i',$parameter_array);

                              foreach($rows as $row)
                              {
                                  $project = new Project(true);
                                  $project->set_project_by_Id($row['project_id']);
                              ?>
                           <tr>
                              <td><?= $project->id ?></td>
                              <td><?= $project->project_name ?></td>
                              <td><?= $project->description ?></td>
                              <td><button type='button' name='view' id='view<?= $project->id  ?>' class='btn btn-warning btn-xs view'>View</button></td>
                              <td><button type='button' name='delete' id='delete_<?= $row['id'] ?>' class='btn btn-danger btn-xs delete'>Delete</button></td>
                           </tr>
                           <?php } ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</section>
<!-- Project Modal -->
<div id="projectModal" class="modal fade">
   <div class="modal-dialog">
      <form method="post" id="project_form" enctype="multipart/form-data">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Project</h4>
            </div>
            <div class="modal-body">
               <table id="modal_table" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Selected</th>
                     </tr>
                  </thead>
                  <tbody id='projectData_body'>
                     <?php
                        $projects = new Project(true);
                        $sql = 'and id not in(select project_id from user_project where user_id =' . $user_id . ')';

                        $rows = $projects->result('',NULL,$sql);

                        foreach($rows as $row)
                        {
                        ?>
                     <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['project_name'] ?></td>
                        <td><?= $row['description'] ?></td>
                        <td>
                           <input type="checkbox" class ="modal_checkbox" name="selected_project" value="<?php echo $row['id']?>" id='<?php echo $row['id']?>'>
                        </td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
            <div class="modal-footer">
               <input type="hidden" name="user_id" id="user_id" />
               <input type="hidden" name="modal_operation" id="modal_operation" />
               <input type="hidden" name="user_project" id="user_project" />
               <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
         </div>
      </form>
   </div>
</div>
<!-- Project Info Modal -->
<div id="projectInfoModal" class="modal fade">
   <div class="modal-dialog">
      <form method="post" id="project_info_form" enctype="multipart/form-data">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Project</h4>
            </div>
            <div class="modal-body">
               <label>Enter Project Name</label>
               <input type="text" name="project_name" id="project_name" class="form-control" />
               <br />
               <label>Enter Description</label>
               <input type="text" name="description" id="description" class="form-control" />
            </div>
            <div class="modal-footer">
               <input type="hidden" name="id" id="id" />
               <input type="hidden" name="project" id="project" />
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
         </div>
      </form>
   </div>
</div>
<script type="text/javascript" language="javascript" >
   $(document).ready(function(){
    var user_id = $('#id').val();

    if($('#form_key').val() == 0)
    {
        location.href = "index.php?id=home";
    }

    $('#submit').click(function(){
       var myForm = document.getElementById('user_detail_form');
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
       $('#operation').val('update');
       $('#user').val("user");
       var user_type = $('#user_type').val();
       $('#user_type_id').val(user_type);

       $.ajax({
       url:"/LawCMS/model/entity/EntityHandler.php",
       method:'POST',
       data:new FormData(myForm),
       dataType : 'json',
       contentType:false,
       processData:false,
       success:function(data)
       {
        alert(data.message);
        refreshTable();
       }
      });
    });

      var modalDataTable = $('#modal_table').DataTable({
     "processing":false,
     "serverSide":false,
     "order":[],
     "ajax":{
      url:"/LawCMS/model/entity/EntityHandler.php",
      data:{project:'project',operation:'filter_read_all','filter_sql':'and id not in(select project_id from user_project where user_id =' + user_id + ')'},
      dataType:"json",
      type:"POST"
     },
     "columnDefs":[
      {
       "targets":[3],
       "orderable":false,
      },
     ],
    });

       var projectDataTable = $('#example1').DataTable({
     "processing":false,
     "serverSide":false,
     "order":[],
     "ajax":{
      url:"/LawCMS/model/entity/EntityHandler.php",
      data:{user_project:'user_project',operation:'modal_read_allx','user_id':user_id},
      dataType:"json",
      type:"POST"
     },
     "columnDefs":[
      {
       "targets":[3, 4],
       "orderable":false,
      },
     ],
    });

    $('#add_project_button').click(function(){
     $('#project_form')[0].reset();
     $('.modal-title').text("Add Project");
     $('#action').val("Add");
     $('#operation').val("insert");
     $('#user_project').val("user_project");
    });

    $(document).on('submit', '#project_form', function(event)
    {
      event.preventDefault();

      var allchecked = $( ".modal_checkbox:input:checked" );
      var isSuccess = false;

      var checkedCount = allchecked.length;

      allchecked.each(function()
      {
           var operation = 'insert';
           var user_project = 'user_project';
           var project_id = this.value;

           $.ajax({
               url:"/LawCMS/model/entity/EntityHandler.php",
               method:'POST',
               data:{'operation':operation, 'user_project':user_project, 'project_id':project_id, 'user_id':user_id},
               dataType : 'json',
               success:function(data)
               {
                  alert(data.message);
               },
               complete:function(data)
               {
                   checkedCount = checkedCount -1;

                   if(checkedCount ==0)
                   {
                      refreshTable();
                      $('#projectModal').modal('hide');
                   }
               }
           });
       });

       if(isSuccess)
       {
           alert(data.message);
           $('#project_form')[0].reset();
           $('#projectModal').modal('hide');
           refreshTable();
       }
   });

    $(document).on('click', '.view', function(){
     var id = $(this).attr("id");
     $.ajax({
      url:"/LawCMS/model/entity/EntityHandler.php",
      method:"POST",
      data:{id:id, 'operation':'read', 'project':'project',},
      dataType:"json",
      success:function(data)
      {
       $('#projectInfoModal').modal('show');
       $('#project_name').val(data.project_name);
       $('#description').val(data.description);
       $('.modal-title').text("Project Info");
       $('#id').val(id);
       $('#operation').val("read");
       $('#project').val("project");
      }
     })
    });

    $(document).on('click', '.delete', function(){
     var id = $(this).attr("id");

     if(confirm("Are you sure you want to delete this?"))
     {
      $.ajax({
       url:"/LawCMS/model/entity/EntityHandler.php",
       method:"POST",
       data:{id:id, user_project:'user_project',operation:'delete'},
       dataType:"json",
       success:function(data)
       {
           alert(data.message);
           refreshTable();
           //dataTable.ajax.reload();
       }
      });
     }
     else
     {
      return false;
     }
    });

    function refreshTable()
    {
       $.ajax({
       url:"/LawCMS/model/entity/EntityHandler.php",
       method:"POST",
       data:{user:'user',operation:'read'},
       dataType:"json",
       success:function(data)
       {
           $('#first_name').val(data.first_name);
           $('#last_name').val(data.last_name);
           $('#email').val(data.email);
           $('#password').val(data.password);
           $('#user_type').val(data.user_type);
           $('#id').val(id);
           $('#project').val("project");
       }
      });

      projectDataTable.ajax.reload();
      modalDataTable.ajax.reload();
    }
   });
</script>
