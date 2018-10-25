<section class="content-header">
   <h1>
      <?php
         echo $PageTitle;

         $user = new User(true);
         $user_id = $_SESSION['user_id'];
         $user->set_user_by_Id($user_id);

         $user_type = new User_Type(true);
         $user_type_str = $user_type->get_user_type_by_Id($user->user_type_id)['name'];

         $permission = $user->permission;
         $file_master = new File_Master(true);
         ?>
   </h1>
</section>
<section class="content">
    <!-- /.row -->
   <div class="row">
      <div class="col-xs-12">
         <div class="box box-info">
            <div class="box-header">
               <h3 class="box-title"><?php echo 'Total Files'; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <table id="example5" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Company Reference</th>
                        <th>Developer Reference</th>
                        <th>Banker Reference</th>
                        <th class = 'sorting_disabled'>View</th>
                     </tr>
                  </thead>
                  <tbody id='projectData_body'>
                     <?php
                        $rows = $file_master->get_all_file($user);

                        foreach($rows as $row)
                        {
                        ?>
                     <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['companyref'] ?></td>
                        <td><?= $row['devref'] ?></td>
                        <td><?= $row['bankref'] ?></td>
                        <td><button type='button' name='view' id='<?= $row['id']?>' class='btn btn-warning btn-xs view'>View</button></td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
         </div>
         <!-- /.box -->
      </div>
      <!-- /.col -->
   </div>
   <div class="row">
      <div class="col-xs-12">
         <div class="box box-danger">
            <div class="box-header">
               <h3 class="box-title"><?php echo 'Overdue Files'; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <table id="example1" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Company Reference</th>
                        <th>Developer Reference</th>
                        <th>Banker Reference</th>
                        <th class = 'sorting_disabled'>View</th>
                     </tr>
                  </thead>
                  <tbody id='projectData_body'>
                     <?php                       
                        $rows = $file_master->get_overdue_file($user);

                        foreach($rows as $row)
                        {
                        ?>
                     <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['companyref'] ?></td>
                        <td><?= $row['devref'] ?></td>
                        <td><?= $row['bankref'] ?></td>
                        <td><button type='button' name='view' id='<?= $row['id']?>' class='btn btn-warning btn-xs view'>View</button></td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
         </div>
         <!-- /.box -->
      </div>
      <!-- /.col -->
   </div>
    <!-- /.row -->
   <div class="row">
      <div class="col-xs-12">
         <div class="box box-warning">
            <div class="box-header">
               <h3 class="box-title"><?php echo 'Incomplete settlement Files'; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <table id="example3" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Company Reference</th>
                        <th>Developer Reference</th>
                        <th>Banker Reference</th>
                        <th class = 'sorting_disabled'>View</th>
                     </tr>
                  </thead>
                  <tbody id='projectData_body'>
                     <?php
                        $rows = $file_master->get_incomplete_settlement($user);

                        foreach($rows as $row)
                        {
                        ?>
                     <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['companyref'] ?></td>
                        <td><?= $row['devref'] ?></td>
                        <td><?= $row['bankref'] ?></td>
                        <td><button type='button' name='view' id='<?= $row['id']?>' class='btn btn-warning btn-xs view'>View</button></td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
         </div>
         <!-- /.box -->
      </div>
      <!-- /.col -->
   </div>
   <!-- /.row -->
   <div class="row">
      <div class="col-xs-12">
         <div class="box box-warning">
            <div class="box-header">
               <h3 class="box-title"><?php echo 'On-going Files'; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <table id="example2" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Company Reference</th>
                        <th>Developer Reference</th>
                        <th>Banker Reference</th>
                        <th class = 'sorting_disabled'>View</th>
                     </tr>
                  </thead>
                  <tbody id='projectData_body'>
                     <?php
                        $rows = $file_master->get_incomplete_file($user);

                        foreach($rows as $row)
                        {
                        ?>
                     <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['companyref'] ?></td>
                        <td><?= $row['devref'] ?></td>
                        <td><?= $row['bankref'] ?></td>
                        <td><button type='button' name='view' id='<?= $row['id']?>' class='btn btn-warning btn-xs view'>View</button></td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
         </div>
         <!-- /.box -->
      </div>
      <!-- /.col -->
   </div>
   <!-- /.row -->
   <div class="row">
      <div class="col-xs-12">
         <div class="box box-success">
            <div class="box-header">
               <h3 class="box-title"><?php echo 'Completed Files'; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <table id="example4" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Company Reference</th>
                        <th>Developer Reference</th>
                        <th>Banker Reference</th>
                        <th class = 'sorting_disabled'>View</th>
                     </tr>
                  </thead>
                  <tbody id='projectData_body'>
                     <?php
                        $rows = $file_master->get_completed_file($user);

                        foreach($rows as $row)
                        {
                        ?>
                     <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['companyref'] ?></td>
                        <td><?= $row['devref'] ?></td>
                        <td><?= $row['bankref'] ?></td>
                        <td><button type='button' name='view' id='<?= $row['id']?>' class='btn btn-warning btn-xs view'>View</button></td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
         </div>
         <!-- /.box -->
      </div>
      <!-- /.col -->
   </div>
</section>
<script type="text/javascript" language="javascript" >
	$('.table').DataTable({		
		"columnDefs":[
		{
			"targets":[5],
			"orderable":false,
		},
		],
		});

    $(document).ready(function(){
        function relocate(selected_file_id)
        {
            location.href = "index.php?id=file_info&file_id=" + selected_file_id;
        }

        $(document).on('click', '.view', function(){
            var id = $(this).attr("id");

            relocate(id);
        });
    });
</script>
