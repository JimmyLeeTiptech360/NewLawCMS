<?php
    function PageLoad(){
        if(isset($_GET['id'])){
            switch ($_GET['id']){
                case 'home':
                    MainPage();
                    break;
                case 'user':
                    UserPage();
                    break;
                case 'user_detail':
                    UserDetailPage();
                    break;
                case 'file':
                    FilePage();
                    break;
                case 'file_info':
                    FileInfoPage();
                    break;
                case 'template':
                    TempPage();
                    break;
                case 'template_detail':
                    TempDetailPage();
                    break;
                case 'task':
                    TaskPage();
                    break;
                case 'extend':
                    ExtendPage();
                    break;
                case 'project':
                    ProjectPage();
                    break;
                case 'report':
                    ReportPage();
                    break;
                case '';
                    MainPage();
                    break;
                default:
                    MainPage();
                    break;              
            }
        } else {
            $_GET['id'] = 'home';
            MainPage();
        }     
    }

    //00
    function MainPage(){
        $PageTitle = "Home";
        $SubTitle = "Dashboard";
        include('view/admin/00-main.php');       
    }

    // 01
    function UserPage(){
        $PageTitle = "User Management";
        $SubTitle = "Entries";
        include('view/admin/01-user.php');
    }
    
    // 01-01
    function UserDetailPage(){
        $PageTitle = "User Detail";
        $SubTitle = "Profile";
        include('view/admin/01-01-user_detail.php');
    }

    // 02
    function FilePage(){
        $PageTitle = "File Listing";
        $SubTitle = "View All Listing";

        include('view/admin/02-file.php');
    }
    
    // 02-01
    function FileInfoPage(){
        $PageTitle = "File Information";
        $SubTitle = "File Information";
        
        $user_id = $_SESSION['user_id'];
         
        if (isset($_GET['user_id']))
        {
            $user_id = $_GET['user_id'];
        }
        
        $user = new User(true);
        $user_type = new User_Type(true);
        
        $user->set_user_by_Id($user_id);
        
        $user_type_id = $user_type->get_user_type_by_Id($user->user_type_id) ['id'];
        
        if($user_type_id == 1 or $user_type_id == 2 or $user_type_id == 3)
        {
            include('view/admin/02-01-file_info.php');
        }
        else
        {
            include('view/admin/02-02-s_file_info.php');
        }
    }

    // 03
    function TempPage(){
        $PageTitle = "Template Management";
        $SubTitle = "Create a new template";
        include('view/admin/03-template.php');
    }
    
    // 03-01
    function TempDetailPage(){
        $PageTitle = "Template Detail";
        $SubTitle = "Detail";
        include('view/admin/03-01-template_detail.php');
    }

    // 04
    function TaskPage(){
        $PageTitle = "Task Management";
        $SubTitle = "Manage project task";
        include('view/admin/04-task.php');
    }
    
    // 05
    function ProjectPage(){
        $PageTitle = "Project Management";
        $SubTitle = "Manage project";
        include('view/admin/05-project.php');
    }

    // 06
    function ReportPage(){
        $PageTitle = "Report";
        $SubTitle = "Overview";
        include('view/admin/06-report.php');
    }
    
    // 07
    function ExtendPage(){
        $PageTitle = "Task KIV";
        $SubTitle = "Overdue Project";
        include('view/admin/07-extend.php');
    }

    // Others
    function DataTables(){
        $PageTitle = "";
        include('view/admin/tables.php');
    }      
?>