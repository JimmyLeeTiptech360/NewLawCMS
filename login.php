<!DOCTYPE html>
<?php
    include('controller/autoload.php');

    session_start();
?>
<html>
    <head>
    <?php SiteHeader(); ?>
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
                        <input name="login_name" type="number" class="form-control" placeholder="Phone number" maxlength="16" required>
                        <span  class="glyphicon glyphicon-earphone form-control-feedback"></span>
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
				if(isset($_POST['submit']))
                                {
                                    $contact = $_POST['login_name'];
                                    $password = $_POST['password'];

                                    $user = new User(true);
                                    //$user->email = $email;
                                    //$user->password = $password;
                                    $current_user = $user->authenticate_user('ss',$contact,$password);

                                    if(mysqli_num_rows($current_user))
                                    {
                                        $_SESSION['user_id'] = mysqli_fetch_assoc($current_user)['id'];

                                        header('Location: index.php');
                                    }
                                    else{
                                      echo "<script>alert('Incorrect Phone Number or Password! Please enter again.')</script>";
                                    }
				}
			?>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery 3 -->
        <?php ScriptFooter(); ?>
    </body>
    <?php ScriptFooter(); ?>
</html>
