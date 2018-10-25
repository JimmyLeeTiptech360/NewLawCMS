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

            if(($permission & 2))
            {
                $form_key = 1;
            }

            if(($permission & 8))
            {
                $form_key = $form_key + 2;
            }
        ?>
    </h1>
</section>
<section class="content">
   <div class="row">
      <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
               <h3 class="box-title"><?php echo $SubTitle; ?></h3>
            </div>
            <!-- /.box-header -->
            <div align="middle">
               <button style="background-color: #5cb85c; border-color: #4cae4c;" type="button" id="add_button" data-toggle="modal" data-target="#projectModal" class="btn btn-info btn-lg">
                 <span class="glyphicon glyphicon-plus"></span>
                 Create New Project
               </button>
            </div>
            <div class="box-body">
               <table id="example1" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th class = 'sorting_disabled'>Update</th>
                        <th class = 'sorting_disabled'>Delete</th>
                     </tr>
                  </thead>
                  <tbody id='projectData_body'>
                     <?php
                        $projects = new Project(true);
                        $rows = $projects->result();

                        foreach($rows as $row)
                        {
                        ?>
                     <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['project_name'] ?></td>
                        <td><?= $row['description'] ?></td>
                        <td><button type='button' name='update' id='<?= $row['id']?>' class='btn btn-warning btn-xs update'>Update</button></td>
                        <td><button type='button' name='delete' id='<?= $row['id']?>' class='btn btn-danger btn-xs delete'>Delete</button></td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
   <input type="hidden" name="form_key" id="form_key" value = <?php echo $form_key?> >
</section>
<div id="projectModal" class="modal fade">
   <div class="modal-dialog">
      <form method="post" id="project_form" enctype="multipart/form-data">
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
               <input type="hidden" name="operation" id="operation" />
               <input type="hidden" name="project" id="project" />
               <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
         </div>
      </form>
   </div>
</div>
<script type="text/javascript" language="javascript" >
   $(document).ready(function(){
    $('#add_button').click(function(){
     $('#project_form')[0].reset();
     $('.modal-title').text("Add Project");
     $('#action').val("Add");
     $('#operation').val("insert");
     $('#project').val("project");
    });

    var formKey = $('#form_key').val();

    if( formKey== 0)
    {
        location.href = "index.php?id=home";
    }

    if(formKey < 2)
    {
        var dataTable = $('#example1').DataTable({
            "processing":false,
            "serverSide":false,
            "order":[],
            "ajax":{
            url:"/LawCMS/model/entity/EntityHandler.php",
            data:{project:'project',operation:'read_allx'},
            dataType:"json",
            type:"POST"
            },
            "columnDefs":[
            {
                "visible": false, "targets": [3,4]
            },
            ],
        });
    }
    else
    {
        var dataTable = $('#example1').DataTable({
     "processing":false,
     "serverSide":false,
     "order":[],
     "ajax":{
      url:"/LawCMS/model/entity/EntityHandler.php",
      data:{project:'project',operation:'read_allx'},
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
    }


    $(document).on('submit', '#project_form', function(event){
     event.preventDefault();
     var project_name = $('#project_name').val();
     var description = $('#description').val();

     if(project_name !== '' && description !== '')
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
        $('#project_form')[0].reset();
        $('#projectModal').modal('hide');
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
      data:{id:id, 'operation':'read', 'project':'project'},
      dataType:"json",
      success:function(data)
      {
       $('#projectModal').modal('show');
       $('#project_name').val(data.project_name);
       $('#description').val(data.description);
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
       data:{id:id, project:'project',operation:'delete'},
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

    function refreshTable()
    {
       dataTable.ajax.reload();
    }
   });
</script>
