<?php
    ob_start();
    session_start();
    include 'session_config.php';
    
    require('../CodeIgniter-old/external.php');
    $ci = & get_instance();
    $ci->load->library("cimongo/cimongo");
    $ci->load->model('get_mongodb');
    $g1 = new Get_mongodb();
    
    $tenantid = '';
    $userdepartid = "";
    $revision = '';
    $documentid = '';
    $isPrivate = '';
    if(isset($_SESSION['usertenant']))
    {
        $tenantid = $_SESSION['usertenant'];
    }
    if(isset($_SESSION['userdepartmentid'] ))
    {
        $userdepartid = $_SESSION['userdepartmentid'];
    } 
    if(isset($_POST['revision']))
    {
        $revision = $_POST['revision'];
    }
    if(isset($_POST['filenamecheckout'] ))
    {
        $documentid = $_POST['filenamecheckout'];
    }
    if(isset($_POST['isPrivate'] ))
    {
        $isPrviate = $_POST['isPrivate'];
    }
    
            if($revision != '')
            {
                $updaterev = (int)$revision;
                $updatecheckoutstatus = $g1->get_mongodb->updateSavedocument($tenantid,$userdepartid,$updaterev,$documentid,$isPrviate);
                echo $updatecheckoutstatus;
            }
?>