<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <?php 
         $user = new User(true);
         $user_id = $_SESSION['user_id'];
         
         if(isset($user_id))
         {
            $user->set_user_by_Id($user_id);
         
            $user_type = new User_Type(true);
            $user_type_id = $user->user_type_id;
            $user_type_str = $user_type->get_user_type_by_Id($user->user_type_id)['name'];
         
            $permission = $user->permission;
         }
         else 
         {
            echo'<script type="text/javascript">location.href = "login.php";</script>';
         }
         ?>
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="view/img/user.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p>
                <?php echo $user->email; ?>
            </p>
            <a href="#">
                <i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active treeview menu-open">
            <a href="#">
                <i class="fa fa-dashboard"></i> <span>LAW CMS</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
            <?php
                $Menu = array(
                    'Home',
                    'User Management',
                    'File Management',
                    'Template Management',
                    'Task Management',
                    'Project Management',
                    'Summary Report',
                );
                                        
                $MenuLink = array(
                    'home',
                    'user',
                    'file',
                    'template',
                    'task',
                    'project',
                    'report',
                );
                
                if($user_type_id ===6)
                {
                    $Menu = array(
                    'Home',
                    'Summary Report',
                    );
                    
                    $MenuLink = array(
                    'home',
                    'report',
                    );
                }
                
                if($user_type_id ===3||$user_type_id ===1)
                {
                    $Menu = array(
                        'Home',
                        'File Management',
                        'Task Management',
                        'Project Management',
                        'Summary Report',
                    );
                                        
                    $MenuLink = array(
                        'home',
                        'file',
                        'task',
                        'project',
                        'report',
                    );
                }

                if($user_type_id ===4||$user_type_id ===5||$user_type_id ===7||$user_type_id ===8)
                {
                    $Menu = array(
                    'Home',
                    );
                    
                    $MenuLink = array(
                    'home',
                    );
                }

                for($x = 0; $x <= count($Menu) - 1; $x++)
                {
                    if(isset($_GET['id'])){
                        if($_GET['id'] == $MenuLink[$x]){
                            $status = "active";
                        } else {
                            $status = "";
                        }
                    } else {
                        if($MenuLink[$x] == 'home'){
                            $status = "active";
                        } else {
                            $status = "";
                        }
                    }

                    echo '<li class="'. $status . '"><a href="index.php?id=' . $MenuLink[$x] . '"><i class="fa fa-circle-o"></i>' . $Menu[$x] . '</a></li>';
                }
            ?>
            </ul>
        </li>
    </ul>
</section>
<!-- /.sidebar -->