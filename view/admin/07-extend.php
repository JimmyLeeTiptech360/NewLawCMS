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
         $projects = $project->result();        
         
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
         
         $form_key= 0;
           
         if(($user_type_id == 2) or (($permission & 16) and ($user_type_id == 1)))
         {
            $form_key = 1;
         }
         ?>
   </h1>
</section>
<section class="content">
   <div class="row">
      <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
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
</section>
<div id="extendModal" class="modal fade">
   <div class="modal-dialog">
      <form method="post" id="extend_form" enctype="multipart/form-data">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Extend To</h4>
            </div>
            <div class="modal-body">
               <label>Extend to</label>
               <input type="date" name="extend_date" id="extend_date" class="form-control" />
            </div>
            <div class="modal-footer">
               <input type="hidden" name="row_id" id="row_id" />
               <input type="hidden" name="operation" id="operation" />
               <input type="submit" name="push_extend" id="action" class="btn btn-success" value="Extend" />
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
         </div>
      </form>
   </div>
    <input type="hidden" name="form_key" id="form_key" value = <?php echo $form_key?> >
</div>
<script type="text/javascript" language="javascript" >  
   $(document).ready(function(){  
        var formKey = $('#form_key').val();
    
        if( formKey== 0)
        {     
            location.href = "index.php?id=home";
        } 
    
        $.ajax({
               url:"/LawCMS/model/entity/EntityHandler.php",
               method:"POST",
               data:{'operation':'read','extend':'extend'},
               dataType:"json",
               success:function(data)
               {
                  $(".table_body_box").html(data.output); 
                  
                  $('.data_table').dataTable({
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
        
        $(document).on('submit', '#extend_form', function(event){
           event.preventDefault();
           var extend_date = $('#extend_date').val();         
           var table = $('#example1').DataTable(); 
           var id = $('#row_id').val();
 
           //var data = table.row($('.row_'+ $('#row_id').val())).data();
                             
           //data[6] = extend_date;
           
           //table.row($('.row_'+ $('#row_id').val())).data(data).draw();
           
           $.ajax({
               url:"/LawCMS/model/entity/EntityHandler.php",
               method:'POST',
               data:{phase_subtask:'phase_subtask', 'operation':'extend', 'id':id,'target_date':extend_date},
               dataType : 'json',
               success:function()
               {                        
                  refreshTable();
               },    
               error: function(xhr, status, error){
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                }  
            });
           
           $('#extendModal').modal('hide');  
       });
       
       $(document).on('click', '.extend', function(){
           var id = $(this).attr("id");
           $('#extend_date').val('');
           
           //var table = $('#example1').DataTable();        
           //var data = table.row($(this).parents('tr')).data();    
           
           //if(data[6] != '')
           //{
           //    $('#extend_date').val(data[6]);
           //}
           
           $('#row_id').val(id);   
       });
       
       function refreshTable()
       {   
          $.ajax({
               url:"/LawCMS/model/entity/EntityHandler.php",
               method:"POST",
               data:{'operation':'read','extend':'extend'},
               dataType:"json",
               success:function(data)
               {
                  $(".table_body_box").html(data.output); 
                  
                  $('.data_table').dataTable({
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
       }
   });
</script>