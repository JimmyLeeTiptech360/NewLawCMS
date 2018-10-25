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

         $user->set_user_by_Id($user_id);

         $user_type = new User_Type(true);
         $user_type_str = $user_type->get_user_type_by_Id($user->user_type_id)['name'];

         $permission = $user->permission;

         $template_id = -1;

         $template = new Template(true);
         $operation = 'insert';

         if(isset($_GET['template_id']))
         {
             $template_id = $_GET['template_id'];

             if($template_id <> -1)
             {
                 $template->set_template_by_Id($template_id);
                 $operation = 'update';
             }
         }
         ?>
   </h1>
</section>
<section class="content">
   <div class="row">
      <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
               <h3 class="box-title">
                  <?php echo $SubTitle; ?>
               </h3>
            </div>
            <!-- /.box-header -->
            <div align="middle">
            </div>
            <div class="box-body">
               <div class="row">
                  <form id='template_detail_form'>
                     <div class="col-md-6">
                        <div>
                           <div class="box-body">
                              <label>
                              <?php
                                 if($template_id != -1)
                                 {
                                     echo 'Template ID';
                                 }
                                 else
                                 {
                                     echo 'Create New Template';
                                 }
                                 ?>
                              </label>
                              <p>
                                 <?php
                                    if($template_id != -1)
                                    {
                                        echo $template_id;
                                    }
                                    ?>
                              </p>
                              <div class="form-group">
                                 <label for="name">Name</label>
                                 <input type="text" name='name' id="name" placeholder="Template Name" class="form-control" value='<?php echo $template->name ?>'>
                              </div>
                              <div class="form-group">
                                 <label for="description">Description</label>
                                 <input type="text" name='description' id="description" placeholder="Description" class="form-control" value='<?php echo $template->description ?>'>
                              </div>
                           </div>
                        </div>
                        <input type="button" name="action" class="btn btn-success action" value="Submit" />
                     </div>
                     <input type="hidden" name="id" id="id" value="<?php echo $template->id ?>" />
                     <input type="hidden" name="template" id="template" />
                     <input type="hidden" name="operation" id="operation" value='<?php echo $operation; ?>' />
                     <input type="hidden" name="user_type_id" id="user_type_id" />
                     <input type="hidden" name="source" id="source" />
                     <input type="hidden" name="output_source" id="output_source" />
                     <input type="hidden" name="phase_count" id="phase_count" value=<?php if(isset($template->phases)) { echo $template->phases; } else { echo 0; } ?> />
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-xs-12">
         <div class="box box-primary">
            <div class="box-header with-border">
               <h3 class="box-title">Template Source</h3>
            </div>
            <div class="box-body">
               <div class="row">
                  <div>
                     <div class="col-md-2">
                        <div class="form-group">
                           <label>Phase</label>
                           <input type="number" name='phase_name' min="1" max="100" id="phase_name" placeholder="Phase" class="form-control">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Description</label>
                           <input type="text" name='phase_description' id="phase_description" placeholder="Description" class="form-control">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Follow by</label>
                           <div class="row">
                                <div class="col-md-4"><input type="radio" name="phase_type" class = "date_radio" value="snp"> S&P Date</div>
                                <div class="col-md-4"><input type="radio" class = "date_radio" name="phase_type" value="cp"> CP Date</div>
                                <div class="col-md-4"><input type="radio" class = "date_radio" name="phase_type" value="none" checked> None</div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-2">
                        <label></label>
                        <button type="button" id='add_phase' class="btn btn-success btn-block">Add</button>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div>
                     <div id='table_content' class="col-xs-12">
                        <?php
                           if ($template->source <> null)
                           {
                               echo $template->source;
                           }
                           ?>
                     </div>
                  </div>
               </div>
               <input type="button" name="action" class="btn btn-success action" value="Save" />
            </div>
         </div>
      </div>
   </div>
</section>
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
               <input type="text" name="task_name" id="task_name" class="form-control" />
               <br />
               <label>Enter Overdue Durations(Days)</label>
               <input type="number" name="overdue" min="1" max="100" id="overdue" class="form-control " value="1" />
            </div>
            <div class="modal-footer">
               <input type="hidden" name="phase_id" id="phase_id" />
               <input type="hidden" name="operation" id="operation" />
               <input type="submit" name="push_task" id="action" class="btn btn-success" value="Add Task" />
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
         </div>
      </form>
   </div>
</div>
<script type="text/javascript" language="javascript">
   $(document).ready(function() {
       $('.data_table').dataTable({
           "bFilter": false,
           "bDestroy": true,
           'paging': false,
           'searching': false,
           'ordering': false,
           'bInfo': false,
       });



       $(document).on('click', '.insert_task', function(event) {
           var id = $(this).attr("id");
           $('#task_form')[0].reset();
           $('#phase_id').val(id);
       });

       $('#add_phase').click(function() {
           var phaseCount = parseInt($('#phase_count').val()) + 1;

           var phase_name = $('#phase_name').val();
           var description = $('#phase_description').val();
           var date = $("input[name='phase_type']:checked").val();
           var followDate = "";

           if(date== "snp")
           {
               followDate = "Follow S&P date";
           }
           else if(date== "cp")
           {
               followDate = "Follow CP date";
           }

           $('#phase_name').val('');
           $('#phase_description').val('');

           if (phase_name != '')
           {
               phaseCount = phase_name;
           }

           var table = document.createElement("table");
           table.class = 'table table-bordered table-striped data_table';
           table.id = 'phase' + phaseCount;
           var tableScript = '<div class="col-md-10"><table class="table table-bordered table-striped data_table" id="phase_' + phaseCount + '" style="width:100%"><thead><tr><th>Description</th>';
           var tableScript = tableScript + '<th>Overdue Duration(Days)</th><th>Remove</th></tr></thead></table>';

           var buttonScript = '<div class="form-group"><input type="button" name="insert_task" id="' + phaseCount + '" class="btn btn-success insert_task" value="Add Task" data-toggle="modal" data-target="#taskModal"/></div>';
           var buttonScript = buttonScript + '<div class="form-group"><input type="button" name="delete_phase" id="' + phaseCount + '" class="btn btn-danger delete_phase" value="Remove" /></div>';

           $('#phase_count').val(phaseCount);

           //var contentScript = '<div id ="div_' + phaseCount + '" class="box box-primary table_box"><div class="box-header with-border" align = "middle"><h3 class="box-title" align ="middle">Phase ' + phaseCount + ': ' + description + '</h3><div class ="date_box" align ="middle"><div class="col-md-3"></div><div class="col-md-2"><label>Follow</label></div><div class="col-md-1"><input type="radio" name="phase_type" value="snp"> S&P Date</div><div class="col-md-1"><input type="radio" name="phase_type" value="cp"> CP Date</div><div class="col-md-1"><input type="radio" name="phase_type" value="none" checked> None</div></div></div></div><div class="box-body"><div id ="' + phaseCount + '" class = "table_holder">' + tableScript + '</div><div class="col-md-2">' + buttonScript + '</div></div></div></div>';
           //var contentScript = '<div id ="div_' + phaseCount + '" class="box box-primary table_box"><div class="box-header with-border" align = "middle"><h3 class="box-title" align ="middle">Phase ' + phaseCount + ': ' + description + '</h3><div class ="date_box" align ="middle"><div class="col-md-3"></div><div class="col-md-2"><label>Follow</label></div><div class="col-md-1"><input type="radio" name="phase_type_'+ phaseCount +'" class = "date_radio" value="snp"> S&P Date</div><div class="col-md-1"><input type="radio" class = "date_radio" name="phase_type_'+ phaseCount +'" value="cp"> CP Date</div><div class="col-md-1"><input type="radio" class = "date_radio" name="phase_type_'+ phaseCount +'" value="none" checked> None</div></div></div><div class="box-body"><div id ="' + phaseCount + '" class = "table_holder">' + tableScript + '</div><div class="col-md-2">' + buttonScript + '</div></div></div></div>';
           var contentScript = '<div id ="div_' + phaseCount + '" class="box box-primary table_box"><div class="box-header with-border" align = "middle"><h3 class="box-title" align ="middle">Phase ' + phaseCount + ': ' + description + '</h3><div class ="date_box" align ="middle"><div class="col-md-5"></div><div class="col-md-2"><label name  = "lbl_'+ phaseCount +'" class = "lblDate">'+followDate+'</label></div></div></div><div class="box-body"><div id ="' + phaseCount + '" class = "table_holder">' + tableScript + '</div><div class="col-md-2">' + buttonScript + '</div></div></div></div>';

           $('#table_content').append(contentScript);

           $('#phase_' + phaseCount).dataTable({
               columnDefs: [{
                   "targets": 2,
                   "data": null,
                   "defaultContent": "<button class='btn btn-danger remove_row' id = " + phaseCount + ">Remove Row</button>"
               }],
               "bFilter": false,
               "bDestroy": true,
               'paging': false,
               'searching': false,
               'ordering': false,
               'bInfo': false,
           });
       });

       $('.action').click(function() {
           var myForm = document.getElementById('template_detail_form');
           var name = $('#name').val();
           var source = document.getElementById('table_content').innerHTML;
           $('#source').val(source);

           var newSource = '';
           var phaseCount = 1;
           rowcount = 0;

           $('.table_box').each(function() {
               var rowId = 1;
               var div_id = $(this).attr("id");
               var div_class = $(this).attr("class");
               var newSnippet = $(this).clone();

               newSnippet.find('.table_holder').empty();

               var data = $('#phase_' + phaseCount).DataTable().rows().data();
               var rowScript = '';

               data.each(function(value) {
                   rowScript = rowScript + '<tr><td>'+ rowId +'</td><td>' + value[0] + '</td><td>' + value[1] + '</td><td></td><td></td><td></td><td>-</td><td></td><td><button type = "button" class="btn btn-warning update_task row_' + rowcount + '" name = "row_' + rowcount + '" data-toggle="modal" data-target="#taskModal" id = "' + phaseCount + '">edit</button></td></tr>';
                   rowcount ++;
                   rowId ++;
               });

               var tableScript = '<div class="col-md-12"><table class="table table-bordered table-striped data_table" id="phase_' + phaseCount + '" style="width:100%"><thead><tr><th>No</th><th>Description</th>';
               var tableScript = tableScript + '<th>Overdue Duration(Days)</th><th>Start Date</th><th>Target Date</th><th>Complete Date</th><th>Status</th><th>Remark</th><th>Edit</th></tr></thead><tbody>' + rowScript + '</tbody></table>';

               newSnippet.find('.table_holder').append(tableScript);

               newSource = newSource + '<div id = "' + div_id + '" class = "' + div_class + '"> ' + newSnippet.html() +'</div>';
               phaseCount++;
           });

           $('#output_source').val(newSource);

           if (name !== '') {
               $.ajax({
                   url: "/LawCMS/model/entity/EntityHandler.php",
                   method: 'POST',
                   data: new FormData(myForm),
                   dataType: 'json',
                   contentType: false,
                   processData: false,
                   success: function(data) {
                       $('#output_source').val('');
                       alert(data.message);
                   }
               });
           } else {
               alert("Both Fields are Required");
           }
       });

       $(document).on('submit', '#task_form', function(event) {
           event.preventDefault();
           var task_name = $('#task_name').val();
           var overdue = $('#overdue').val();
           var phase_id = $('#phase_id').val();
           var button = "<button class='btn btn-danger remove_row' id = " + phase_id + ">Remove Row</button>";

           if (task_name !== '' && overdue !== 0) {
               var table = $('#phase_' + phase_id).DataTable();
               $('#taskModal').modal('hide');
               table.row.add([task_name, overdue, button]).draw(false);
           } else {
               alert("Both Fields are Required");
           }
       });

       $(document).on('click', '.remove_row', function() {
           var id = $(this).attr("id");

           var table = $('#phase_' + id).DataTable();

           table
               .row($(this).parents('tr'))
               .remove()
               .draw();
       });

       $(document).on('click', '.delete_phase', function() {
           var phase_id = $(this).attr("id");
           if (confirm("Are you sure you want to delete this?")) {
               var phaseCount = parseInt($('#phase_count').val()) - 1;
               $('#phase_count').val(phaseCount);

               $('#div_' + phase_id).remove();
           } else {
               return false;
           }
       });
   });
</script>
