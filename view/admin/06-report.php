<section class="content-header">
   <h1>
      <?php
         echo $PageTitle;

         $user_id = $_SESSION['user_id'];

         if(isset($_GET['user_id']))
         {
             $user_id = $_GET['user_id'];
         }

         $file_id = -1;

         if(isset($_GET['file_id']))
         {
             if($_GET['file_id'] <> -1)
             {
                 $file_id= $_GET['file_id'];
             }
         }

         $user = new User(true);
         $user->set_user_by_Id($user_id);

         $project = new Project(true);
         $projects = $project->get_project_filter_by_user($user_id);

         $user_type = new User_Type(true);
         $user_type_str = $user_type->get_user_type_by_Id($user->user_type_id)['name'];
         $user_type_id = $user_type->get_user_type_by_Id($user->user_type_id) ['id'];

         $permission = $user->permission;

         $template_id = -1;

         $template = new Template(true);

         $templates = $template->result();

         $file_master = new File_Master(true);

         if($file_id <> -1)
         {
             $file_master->set_file_by_Id($file_id);
         }

         $file_user = new File_User(true);
         ?>
   </h1>
</section>
<section class="content">
   <div class="row">
      <div class="col-xs-12">
         <div class="box box-success">
            <div class="box-header">
               <h3 class="box-title"><?php echo $SubTitle; ?></h3>
               <div class='row'>
                  <div class ='col-md-4'>
                     <div class="form-group">
                        <label>Project</label>
                        <select class="form-control select2 select2-hidden-accessible" autofocus data-placeholder="Select a project" style="width: 100%;" tabindex="-1" aria-hidden="true" id = 'selected_project' name = 'selected_project'>
                        <option disabled selected value> -- select a project -- </option>
                            <?php
                           foreach($projects as $per_project)
                           {
                               $checked = '';

                               $str = '<option value="'. $per_project['id'] .'" ' . $checked . ' >' . $per_project['id']. ' '. $per_project['project_name'] . '</option>';
                               echo $str;
                           }
                           ?>
                        </select>
                     </div>
                  </div>
                  <div class ='col-md-4'>
                     </br></br>
                     <label id ='project_description'></label>
                  </div>
                  <div class ='col-md-4'>
                  </div>
               </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table_body_box">

            </div>
            <!-- /.box-body -->
         </div>
         <!-- /.box -->
      </div>
      <!-- /.col -->
   </div>
   <!-- /.row -->
   <?php
      foreach($projects as $per_project)
      {
          $str = '<input type="hidden" name="selected_'.$per_project['id'].'" id="selected_'.$per_project['id'].'" value="'.$per_project['description'].'" >';
          echo $str;
      }
      ?>
   <input type="hidden" name="current_user_id" id="current_user_id" value = <?php echo $user_id?> >
   <input type="hidden" name="current_user_type" id="current_user_type" value = <?php echo $user_type_id?> >
</section>
<script type="text/javascript" language="javascript" >
   $(document).ready(function(){
       $("#selected_project").change(function() {
           var project_id =$( "#selected_project").val();

           var projectDesc = $( "#selected_" + project_id).val();
           var current_user_id = $("#current_user_id").val();
           var current_user_type = $("#current_user_type").val();

           $("#project_description").text(projectDesc);

            $.ajax({
               url:"/LawCMS/model/entity/EntityHandler.php",
               method:"POST",
               data:{'project_id':project_id, 'current_user_id':current_user_id,'current_user_type':current_user_type, 'operation':'read','summary':'summary'},
               dataType:"json",
               success:function(data)
               {
                  $(".table_body_box").html(data.output);

                  $('.data_table').dataTable( {
                    "bFilter": true,
                    "bDestroy": true,
                    'paging': true,
                    'searching': true,
                    'ordering': true,
                    'bInfo': false,
                    'select': true,
                    });
               }

            });
        });
   });
</script>
