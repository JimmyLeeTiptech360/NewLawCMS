<?php
   require_once('model/core/AutoloadModel.php');
   echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>';
   echo '<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>';
   echo '<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>';
   echo '<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css"/>';

   load_model();
   
   require('controller/model.php');
   require('controller/view.php');
   require('controller/database.php');
?>