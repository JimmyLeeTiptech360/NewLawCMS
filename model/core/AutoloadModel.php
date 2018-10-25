<?php
    function load_model()
    {      
        $dir = dirname('model/entity/User.php');

        $paths = scandir($dir,1);
        $total_count = count($paths); 
   
        //remove .. and . from the array
        unset($paths[$total_count-1]);
        unset($paths[$total_count-2]);
   
        foreach ($paths as $filename) 
        {
            $path = $dir.'/'. $filename;

            if (is_file($path)) 
            {
                require_once $path;
            }
        }
    }
?>

