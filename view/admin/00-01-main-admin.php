<?php
   $file_master = new File_Master(true);

   if(!isset($_SESSION['user_id']))
   {
       echo'<script type="text/javascript">location.href = "login.php";</script>';
   }

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

         $file_user = new File_User(true);

         $form_key= 0;

         //if(($user_type_id == 2) or (($permission & 16) and ($user_type_id == 1)))
         if($user_type_id===2)
         {
            $form_key = 1;
         }
   ?>
<section class="content-header">
   <h1>
     <style>
     .inner{
       color: #000;
     }
     .inner:hover{
       color: #FFF;
     }
     </style>
      <div class="row" >
         <div class="col-lg-1 col-xs-1">

         </div>
         <div class="col-lg-2 col-xs-2">
            <!-- small box -->
            <div class="small-box bg-gray">
               <div class="inner">
                  <h3><?php echo mysqli_num_rows($file_master->get_all_file($user));?></h3>
                  <p>Total Files</p>
               </div>
               <div class="icon">
                  <i class="fa fa-file"></i>
               </div>
               <a href="index.php?id=task" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
         </div>
         <div class="col-lg-2 col-xs-2">
            <!-- small box -->
            <div class="small-box bg-red">
               <div class="inner">
                  <h3><?php echo mysqli_num_rows($file_master->get_overdue_file($user));?></h3>
                  <p>Overdue Files</p>
               </div>
               <div class="icon">
                  <i class="fa fa-file"></i>
               </div>
               <a href="index.php?id=task" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
         </div>
          <div class="col-lg-2 col-xs-2">
            <!-- small box -->
            <div class="small-box bg-orange">
               <div class="inner">
                   <h3><?php echo mysqli_num_rows($file_master->get_incomplete_settlement($user));?></h3>
                  <p>Incomplete Settlement</p>
               </div>
               <div class="icon">
                  <i class="fa fa-file"></i>
               </div>
               <a href="index.php?id=task" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
         </div>
         <div class="col-lg-2 col-xs-2">
            <!-- small box -->
            <div class="small-box bg-blue">
               <div class="inner">
                  <h3><?php echo mysqli_num_rows($file_master->get_incomplete_file($user));?></h3>
                  <p>On going Files</p>
               </div>
               <div class="icon">
                  <i class="fa fa-file"></i>
               </div>
               <a href="index.php?id=task" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
         </div>
         <div class="col-lg-2 col-xs-2">
            <!-- small box -->
            <div class="small-box bg-green">
               <div class="inner">
                  <h3><?php echo mysqli_num_rows($file_master->get_completed_file($user));?></h3>
                  <p>Completed Files</p>
               </div>
               <div class="icon">
                  <i class="fa fa-file"></i>
               </div>
               <a href="index.php?id=task" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
         </div>
      </div>
   </h1>
</section>
<section class="content">
   <div class="row">
      <div >
         <div id='calendar'></div>
      </div>
      <div class="col-md-12">
         <div class = 'col-md-7'>
            <div class="box box-primary" style = "min-height: 315px;max-height: 315px">
               <div class="box-header with-border">
                  <h3 class="box-title">Recently Update</h3>
               </div>
               <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>Document Type</th>
                           <th>File ID</th>
                           <th>Time</th>
                           <th>Action</th>
                           <th>Performed By</th>
                           <th>View</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           $audit_trail = new Audit_Trail(true);
                           $rows = $audit_trail->get_recent_audit_trail(5,$user_type_id,$user_id);

                           foreach($rows as $row)
                           {
                           ?>
                        <tr>
                           <td><?= $row['form_type'] ?></td>
                           <td><?= $row['target_id'] ?></td>
                           <td><?= $row['action_date_time'] ?></td>
                           <td><?= $row['action'] ?></td>
                           <td><?= $row['user_id'] ?></td>
                           <td><button type="button" name="view" class="btn btn-warning btn-xs view" onclick="window.location.href='index.php?id=file_info&file_id=<?php echo $row['target_id'];?>'">View</button></td>
                        </tr>
                        <?php } ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <div class = 'col-md-5'>
            <div class="box box-danger" style = "min-height: 315px;max-height: 315px">
               <div class="box-header with-border">
                  <h3 class="box-title" style="color:#FF0000;">Attention !</h3>
               </div>
               <div class="box-body">
                  <table id="example3" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>File ID</th>
                           <th>File Reference No</th>
                           <th>Overdue(days)</th>
                           <th>Remark</th>
                           <th>View</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           $phase_subtask = new Phase_Subtask(true);
                           $rows = $phase_subtask->get_recent_overdue_file(4,$user_type_id,$user_id);

                           foreach($rows as $row)
                           {
                           ?>
                        <tr>
                           <td><?= $row['id'] ?></td>
                           <td><?= $row['name'] ?></td>
                           <td>
                              <?php
                                 if($row['overdue'] > 0)
                                 {
                                    echo $row['overdue'];
                                 }
                                 else
                                 {
                                     echo 'Extend';
                                 }
                                 ?>
                           </td>
                           <td><?= $row['remark'] ?></td>
                           <td><button type="button" name="view" class="btn btn-warning btn-xs view" onclick="window.location.href='index.php?id=file_info&file_id=<?php echo $row['id'];?>'">View</button></td>
                        </tr>
                        <?php } ?>
                     </tbody>
                  </table>
               </div>
               <div class="box-footer">
               <?php
                if($form_key ==1)
                {
                    echo '<a href="index.php?id=extend" class="small-box-footer" style="margin-left:10px;">Manage All <i class="fa fa-arrow-circle-right"></i></a>';
                }
               ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<script type="text/javascript" language="javascript" >
   $(document).ready(function() {

       $('#example1').dataTable({
          "bFilter": false,
          "bDestroy": true,
          'paging': false,
          'searching': false,
          'ordering': false,
          'bInfo': false,
      });

      $('#example3').dataTable({
          "bFilter": false,
          "bDestroy": true,
          'paging': false,
          'searching': false,
          'ordering': false,
          'bInfo': false,
      });
    });
</script>
