<?php
ob_start();
session_start();
include 'session_timeout.php';
include 'session_config.php';
$userdepartid = '';
$usetenantid = '';
$usertenantnm = '';
$useremail = '';
$userid = '';
if(isset($_SESSION['usertenant']))
{
    $usetenantid = $_SESSION['usertenant'];
}
if(isset($_SESSION['tenantname']))
{
    $usertenantnm = $_SESSION['tenantname'];
}
if(isset($_SESSION['userdepartmentid'] ))
{
    $userdepartid = $_SESSION['userdepartmentid'];
} 
if(isset($_SESSION['useremail']))
{
    $useremail = $_SESSION['useremail'];
}
if(isset($_SESSION['userid']))
{
    $userid = $_SESSION['userid'];
}
 
 
require('CodeIgniter-old/external.php');
$ci =& get_instance();
$ci->load->library("cimongo/cimongo");
		$ci->load->model('get_mongodb');
                $g1 = new Get_mongodb();
                
            header("X-XSS-Protection: 0");
            $phid = $_POST["template_fromdata"];
            $filename = strip_tags(trim($_POST["form_title"]));
            $file_desc = $_POST["ftitle_description"];
            $fname = str_replace(" ","_",$filename);
            $usertenantnm = str_replace(" ","_",$usertenantnm);
            $myFile1 = "DMSTree_clients/".$usertenantnm."_".$usetenantid."/Templates/".$fname.".html";
            $myFile = "DMSTree_clients/".$usertenantnm."_".$usetenantid."/Templates";
            $fh = fopen($myFile1, 'w') or die("error");
            $stringData = $phid;
            fwrite($fh, $stringData);
            fclose($fh);
            $currDate = date('Y-m-d H:i:s');
            $currDate = new MongoDate(strtotime($currDate));
            
            $templatedata['tempresult'] = $g1->get_mongodb->saveTemplate($filename,$myFile,$file_desc,$usetenantid,$userdepartid,$currDate,$useremail);
            
            if($templatedata['tempresult'] == '1')
            {
              $currDate = date('Y-m-d H:i:s');
              $currDate = new MongoDate(strtotime($currDate));
              $actiontext = $filename.' Template is created';
              $historytrtrack['trackresult'] = $g1->get_mongodb->saveTrackAction($usetenantid,$userid,$actiontext,$currDate);  
             header('Location: dashboard.php');
            }
            else 
             header('Location: login.php');
            
?>
