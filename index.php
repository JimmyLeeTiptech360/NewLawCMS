<!DOCTYPE html>
<html>
<?php
    include('controller/autoload.php');   
?>
<head><?php SiteHeader(); ?></head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <header class="main-header"><?php BodyHeader(); ?></header>
        <aside class="main-sidebar"><?php BodySidebar(); ?></aside>
        <div class="content-wrapper"><?php PageLoad();?></div>
        <?php SiteFooter(); ?>
        
    </div><?php ScriptFooter(); ?>
</body>
</html>