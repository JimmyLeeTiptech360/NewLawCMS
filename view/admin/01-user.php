<section class="content-header">
   <h1>
       <?php
            echo $PageTitle;

            $user_id = $_SESSION['user_id'];

            if(isset($_GET['user_id']))
            {
                 $user_id = $_GET['user_id'];
             }

             $user = new User(true);
             //$user_id = $_SESSION['user_id'];
             $user->set_user_by_Id($user_id);

            $user_type = new User_Type(true);
            $user_type_str = $user_type->get_user_type_by_Id($user->user_type_id)['name'];

            $permission = $user->permission;

            $form_key= 0;

            if(($permission & 4))
            {
                $form_key = 1;
            }
        ?>
   </h1>
</section>
<section class="content">
   <div class="box box-primary">
      <div class="box-header with-border">
         <h3 class="box-title"><?php echo $SubTitle; ?></h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
         <div class="row">
            <!-- /.box-header -->
            <div align="middle">
               <button style="background-color: #5cb85c; border-color: #4cae4c;" type="button" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-info btn-lg">
                 <span  class="glyphicon glyphicon-plus"></span>
               Create New User
               </button>
            </div>
            <div class="box-body">
               <table id="example1" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Contact No</th>
                        <th>User Type</th>
                        <th>User Name</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Permission</th>
                        <th>View</th>
                        <th>Delete</th>
                     </tr>
                  </thead>
                  <tbody id='userData_body'>
                     <?php
                        $users = new User(true);
                        $rows = $users->result();

                        foreach($rows as $row)
                        {
                        ?>
                     <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['contact_no'] ?></td>
                        <td>
                           <?php
                              $user_type = new User_Type(true);
                              echo $user_type->get_user_type_by_Id($row['user_type_id'])['name'];
                              ?>
                        </td>
                        <td><?= $row['user_name'] ?></td>
                        <td><?= $row['first_name'] ?></td>
                        <td><?= $row['last_name'] ?></td>
                        <td><?= $row['permission'] ?></td>
                        <td><button type='button' name='view' id='<?= $row['id']?>' class='btn btn-info btn-xs view'>View</button></td>
                        <td><button type='button' name='delete' id='<?= $row['id']?>' class='btn btn-danger btn-xs delete'>Delete</button></td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <input type="hidden" name="form_key" id="form_key" value = <?php echo $form_key?> >
      <!-- /.box-body -->
   </div>
</section>
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
                        <option value="1">Lawyer</option>
                        <option value="2">Admin</option>
                        <option value="3">Staff</option>
                        <option value="4">Agent</option>
                        <option value="5">Banker</option>
                        <option value="6">Developer</option>
                        <option value="7">Purchaser</option>
                        <option value="8">Vendor</option>
                     </select>
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
                     <label for="user">User Name</label>
                     <input type="text" name="user_name" id="user_name" required placeholder="UserName" class="form-control">
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
                                <input type="text" name="password" id="password" required class="form-control">
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
                  <div class="form-group">
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
                     <input type="hidden" name="operation" id="operation" />
                     <input type="hidden" name="permission" id="permission" />
                     <input type="hidden" name="user" id="user" />
                     <input type="hidden" name="user_type_id" id="user_type_id" />
                     <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>
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

   function randomUserName(prefix,length)
   {
        var chars = "1234567890";
        var userName = "";
        for (var x = 0; x < length; x++) {
            var i = Math.floor(Math.random() * chars.length);
            userName += chars.charAt(i);
        }
        return prefix + userName;
    }

    function generate() {
        $('#password').val(randomPassword(10));
    }

    function generateUserName() {
        prefix = $('#user_type option:selected').text();
        $('#user_name').val(randomUserName(prefix,5));
    }

   $(document).ready(function(){
    $('select').on('change', function() {
        generateUserName();
    });

    if($('#form_key').val() == 0)
    {
        location.href = "index.php?id=home";
    }

    function relocate(selected_user_id)
    {
        location.href = "index.php?id=user_detail&user_id=" + selected_user_id;
    }

    $('#add_button').click(function(){
     $('#user_form')[0].reset();
     $('.modal-title').text("Add User");
     $('#action').val("Add");
     $('#operation').val("insert");
     $('#user').val("user");
     generateUserName();
    });

     var dataTable = $('#example1').DataTable({
     "processing":false,
     "serverSide":false,
     "order":[],
     "ajax":{
      url:"/LawCMS/model/entity/EntityHandler.php",
      data:{user:'user',operation:'read_allx'},
      dataType:"json",
      type:"POST"
     },
     "columnDefs":[
      {
       "targets":[8, 9],
       "orderable":false,
      },
     ],
    });

    $(document).on('submit', '#user_form', function(event){
     event.preventDefault();
     var email = $('#email').val();
     var user_type = $('#user_type').val();
     $('#user_type_id').val(user_type);

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
        $('#user_form')[0].reset();
        $('#userModal').modal('hide');
        refreshTable();
       }
      });
     }
     else
     {
      alert("Both Fields are Required");
     }
    });

    $(document).on('click', '.update', function(){
     var id = $(this).attr("id");
     $.ajax({
      url:"/LawCMS/model/entity/EntityHandler.php",
      method:"POST",
      data:{id:id, 'operation':'read', 'user':'user'},
      dataType:"json",
      success:function(data)
      {
       $('#userModal').modal('show');
       $('#first_name').val(data.first_name);
       $('#last_name').val(data.last_name);
       $('#email').val(data.email);
       $('#password').val(data.password);
       $('#user_type').val(data.user_type);
       $('.modal-title').text("Edit User");
       $('#id').val(id);
       $('#action').val("Edit");
       $('#operation').val("update");
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
       data:{id:id, 'operation':'delete', 'user':'user'},
       dataType:"json",
       success:function(data)
       {
           alert(data.message);
           refreshTable();
       }
      });
     }
     else
     {
      return false;
     }
    });

    $(document).on('click', '.view', function(){
     var id = $(this).attr("id");

     relocate(id);
    });

    function refreshTable()
    {
      dataTable.ajax.reload();
    }
   });
</script>
