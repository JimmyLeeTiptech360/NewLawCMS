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
           
         if(($user_type_id == 2) or (($permission & 16) and ($user_type_id == 1)))
         {
            $form_key = 1;
         }
         
         if($user_type_id <4)
         {
             include('view/admin/00-01-main-admin.php');
         }
         else
         {
             include('view/admin/00-02-main-file.php');
         }
   ?>
