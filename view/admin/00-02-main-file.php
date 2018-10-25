<section class="content-header">
    <style>
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
    
    thead input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        }

        /* Style the buttons inside the tab */
        .tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            font-size: 17px;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current tablink class */
        .tab button.active {
            background-color: #ccc;
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
        }
    </style>
   <h1>
      <?php 
         echo $PageTitle; 
         
         $user = new User(true);
         $user_id = $_SESSION['user_id'];
         $user->set_user_by_Id($user_id);
         
         $user_type = new User_Type(true);
         $user_type_str = $user_type->get_user_type_by_Id($user->user_type_id)['name'];
         
         $permission = $user->permission;
         
         $form_key = 0;
         
         if(($permission & 16))
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
               <h3 class="box-title"><?php echo $SubTitle; ?></h3>
            </div>
             <div align="middle">
                <div class="box box-primary">                   
                    <div class="box-header with-border">                     
                    </div>
                    <div class="box-body">
                        <div class="tab">
                            <button class="tablinks" onclick="openFilterTab(event, 'filter_by_value')" id = "filter_by_value_button">Filter by value</button>
                            <button class="tablinks" onclick="openFilterTab(event, 'filter_by_range')">Filter by range</button>
                        </div>  
                        
                        <div id="filter_by_value" class="tabcontent">
                            <div class="row">
                                <div class ="col-sm-2">
                                    <select id = 'selected_target' name = 'selected_target'>
                                            <option value= 0>ID</option>
                                            <option value= 1>File No</option>
                                            <option value= 2>Property Address</option>
                                            <option value= 3>Project Name</option>
                                            <option value= 4>Vendor</option>
                                            <option value= 5>Purchaser </option>
                                            <option value= 6>Phase</option>
                                            <option value= 7>Status</option>
                                    </select>  
                                </div>
                                <div class ="col-sm-2">
                                    <input type="text" id="text_value" name="text_value">   
                                </div>
                                <div class ="col-sm-1">
                                    <div class="row">                                                                    
                                        <button type="button" id ="search_button">Filter</button>
                                        <button type="button" class ="clear_button" id ="clear_button">Clear</button>
                                    </div>
                                </div>
                                <div class ="col-sm-7">                               
                                </div>
                            </div>
                        </div>
                        <div id="filter_by_range" class="tabcontent">
                            <div class="row">
                                <div class ="col-sm-2">
                                    <select id = 'selected_target' name = 'selected_target'>
                                            <option value= 0>ID</option>
                                    </select>  
                                </div>
                                <div class ="col-sm-4">
                                    <div class="row">                                         
                                        <input type="text" id="text_value_min" name="text_value">   
                                        <input type="text" id="text_value_max" name="text_value_max">
                                    </div>
                                </div>
                                <div class ="col-sm-1">
                                    <div class="row">                                                                    
                                        <button type="button" id ="search_button_by_range">Filter</button>
                                        <button type="button" class ="clear_button" id ="clear_button">Clear</button>
                                    </div>
                                </div>
                                <div class ="col-sm-5">                               
                                </div>
                            </div>                          
                        </div>                                             
                    </div>
                </div>              
             </div>
             <?php 
                if($form_key == 1)
                {
                   echo '<div align="middle">
               <button type="button" id="add_button" data-toggle="modal" data-target="#projectModal" class="btn btn-info btn-lg">
               Add
               </button>
            </div>'; 
                }
            ?>                  
            <div class="box-body">
               <table id="example1" class="table table-bordered table-striped" style="width:100%">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>File No</th>
                        <th>Property Address</th>
                        <th>Project Name</th>
                        <th>Vendor</th>
                        <th>Purchaser</th>
                        <th>Phase</th>
                        <th>Status</th>
                        <th class = 'sorting_disabled'>View</th>
                     </tr>
                  </thead>
                  <tbody id='projectData_body'>
                     <?php 
                        $file_master = new File_Master(true);
                        $rows = $file_master->get_file_filter_by_user($user_id);
                            
                        foreach($rows as $row)
                        {
                        ?>
                     <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['propertyaddress'] ?></td>
                        <td><?= $row['project_name'] ?></td>
                        <td><?= $row['vendor_name'] ?></td>
                        <td><?= $row['purchaser_name'] ?></td>                      
                        <td><?= $row['phase'] ?></td>
                        <td><?= $row['phase_status'] ?></td>
                        <td><button type='button' name='update' id='<?= $row['id']?>' class='btn btn-warning btn-xs update'>View</button></td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
         </div>
         <input type="hidden" name="form_key" id="form_key" value = <?php echo $form_key?> >
         <input type="hidden" name="current_user_id" id="current_user_id" value = <?php echo $user_id?> >
      </div>
   </div>
</section>
<script type="text/javascript" language="javascript" >
    function openFilterTab(evt, btnName) 
    {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        
        tablinks = document.getElementsByClassName("tablinks");
        
        for (i = 0; i < tablinks.length; i++) 
        {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
    
        document.getElementById(btnName).style.display = "block";
        evt.currentTarget.className += " active";
    }
    
   $(document).ready(function(){
    function relocate(selected_file_id)
    {
        location.href = "index.php?id=file_info&file_id=" + selected_file_id;
    }      
       
    $('#add_button').click(function(){
     relocate(-1);
    });
    
    var formKey = $('#form_key').val();
    var currentUserId = $('#current_user_id').val();
    
    if(formKey == 1)
    {
        var dataTable = $('#example1').DataTable({
     "processing":false,
     "serverSide":false,
     "order":[],
     "ajax":{
      url:"/LawCMS/model/entity/EntityHandler.php",
      data:{file_master:'file_master', current_user_id:currentUserId, operation:'read_all'},
      dataType:"json",
      type:"POST"
     },
     "columnDefs":[
      {
       "targets":[7, 8],
       "orderable":false,
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
      data:{file_master:'file_master', current_user_id:currentUserId, operation:'read_all'},
      dataType:"json",
      type:"POST"
     },
     "columnDefs":[
      {
      },
     ],
    });
    }
    
    $('#example1 tfoot th').hide();
    
     $(document).on('click', '.update', function(){
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
       data:{id:id, file_master:'file_master',operation:'delete'},
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
        var dataTable = $('#example1').DataTable();
        dataTable.ajax.reload();
    }
   });
</script>