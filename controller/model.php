<?php
    function SiteHeader(){
        $site_title = "Dashboard CAP360";
        include('model/components/site_header.php');
    }
    function BodyHeader(){
        $logo_link = "index.php";
        $logo_compact = "360";
        $logo_maximize = "CAP360";
        include('model/components/body_header.php');
    }
    function BodySidebar(){
        include('model/components/body_sidebar.php');
    }
    function ScriptFooter(){
        include('model/components/script_footer.php');
    }
    function SiteFooter(){
        $version = "1.0";
        $copyrighttext = "CAP360";
        include('model/components/site_footer.php');
    }
?>