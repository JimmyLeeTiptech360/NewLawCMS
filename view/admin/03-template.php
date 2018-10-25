<section class="content-header">
   <h1><?php echo $PageTitle; ?></h1>
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
               <button style="background-color: #5cb85c; border-color: #4cae4c;" type="button" id="add_button" data-toggle="modal" data-target="#projectModal" class="btn btn-info btn-lg add">
                 <span class="glyphicon glyphicon-plus"></span>
                 Create New Template
               </button>
            </div>
            <div class="box-body">
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
                        $template = new Template(true);
                        $rows = $template->result();

                        foreach($rows as $row)
                        {
                        ?>
                     <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['description'] ?></td>
                        <td><button type='button' name='view' id='<?= $row['id']?>' class='btn btn-warning btn-xs view'>View</button></td>
                        <td><button type='button' name='delete' id='<?= $row['id']?>' class='btn btn-danger btn-xs delete'>Delete</button></td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</section>
<script type="text/javascript" language="javascript" >
   $(document).ready(function(){
    function relocate(selected_template_id)
    {
        location.href = "index.php?id=template_detail&template_id=" + selected_template_id;
    }

    $('#add_button').click(function(){
     relocate(-1);
    });

    var dataTable = $('#example1').DataTable({
     "processing":false,
     "serverSide":false,
     "order":[],
     "ajax":{
      url:"/LawCMS/model/entity/EntityHandler.php",
      data:{template:'template',operation:'read_all'},
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

     $(document).on('click', '.view', function(){
     var id = $(this).attr("id");

     relocate(id);
    });

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

    $(document).on('click', '.vview', function(){
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
       data:{id:id, template:'template',operation:'delete'},
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
