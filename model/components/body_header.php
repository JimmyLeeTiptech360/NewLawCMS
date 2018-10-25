<a href="<?php echo $logo_link; ?>" class="logo">
    <span class="logo-mini"><?php echo $logo_compact; ?></span>
    <span class="logo-lg"><?php echo $logo_maximize; ?></span>
</a>
<?php
    session_start();

    $user = new User(true);
    $user_id = $_SESSION['user_id'];   
    $user->set_user_by_Id($user_id);
    
    $user_type = new User_Type(true);
    $user_type_str = $user_type->get_user_type_by_Id($user->user_type_id)['name'];
    $user_type_id = $user_type->get_user_type_by_Id($user->user_type_id) ['id'];
    $phase_subtask = new Phase_Subtask(true);
    
    $over_count = 0;
    
    if($user_type_id <3)
    {
        $rows = $phase_subtask->get_recent_overdue_file(0,$user_type_id,$user_id);
        $over_count = mysqli_num_rows($rows);
    }   
?>
<nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">           
            <!-- Notifications: style can be found in dropdown.less -->
            <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell-o"></i>
                    <span class="label label-warning">
                        <?php 
                            if($over_count>0)
                            {echo '1';}
                        ?>
                    </span>
                </a>
                <ul class="dropdown-menu">
                    <li class="header">Notification</li>
                    <li>
                        <!-- inner menu: contains the actual data -->
                        <ul class="menu">
                            <li>
                                
                                    <?php
                                        if($over_count>0)
                                        {
                                            echo '<a href="index.php?id=extend">';
                                            echo '<i class="fa fa-warning text-aqua"></i> '.$over_count.' task(s) require your attention!';
                                            echo '</a>';
                                        }
                                    ?>                                  
                            </li>
                        </ul>
                    </li>
                    <li class="footer"><a href="#">View all</a></li>
                </ul>
            </li>
            <!-- Tasks: style can be found in dropdown.less -->
          
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="view/img/user.png" class="user-image" alt="User Image">
                    <span class="hidden-xs"><?php echo $user->first_name . ' ' . $user->last_name;?></span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                        <img src="view/img/user.png" class="img-circle" alt="User Image">

                        <p>
                            <?php echo $user->first_name . ' ' . $user->last_name . ' - '. $user_type_str;?>  
                            <?php echo $user_id;?>  
                            <small><?php echo $user->email?></small>
                        </p>
                    </li>
                    <!-- Menu Body -->
                   
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-right">
                            <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                        </div>
                    </li>
                </ul>
            </li>        
        </ul>
    </div>
</nav>