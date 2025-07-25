<?php
    ob_start();
    session_start();
    include 'session_timeout.php';
    include 'session_config.php';
    require('CodeIgniter-old/external.php');
    $ci = & get_instance();
    $ci->load->library("cimongo/cimongo");
    $ci->load->model('get_mongodb');
    $g1 = new Get_mongodb();
    
    $tenantid = '';
    $userid  = '';
    if(isset($_SESSION['usertenant']))
    {
        $tenantid = $_SESSION['usertenant'];
    }
    if(isset($_SESSION['userid'])) 
    {
        $userid = $_SESSION['userid'];
    } 
    $currDate = date('Y-m-d H:i:s');
    $currDate = new MongoDate(strtotime($currDate));
    
    $actiontext = '';
    if(isset($_POST['actiontext']))
    {
        $actiontext = $_POST['actiontext'];
    }
    
    $historytrtrack['trackresult'] = $g1->get_mongodb->saveTrackAction($tenantid,$userid,$actiontext,$currDate);
    print_r($historytrtrack['trackresult']);
	
?>