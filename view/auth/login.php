<!DOCTYPE html>
<html>
    <head>
        <?php SiteHeader();?>
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="#"><b>Task</b> Management</a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <form action="" method="post" action="login.php">
                    <div class="form-group has-feedback">
                        <input name="email" type="email" class="form-control" placeholder="Email">
                        <span  class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input name="password" type="password" class="form-control" placeholder="Password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button name="submit" type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button> 
						</div
                        <!-- /.col -->
                    </div>
                </form>
            </div>
			<?php
				if(isset($_POST['submit'])){
					$email = $_POST['email'];
					$password = $_POST['password'];
					
					if($email == "admin@cap360.co" && $password == 123456){
						echo "success"; 
						header('Location: index.php');
					}
				}
			?>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery 3 -->
        <?php ScriptFooter(); ?>
    </body>

</html>