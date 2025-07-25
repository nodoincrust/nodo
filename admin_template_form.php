<?php
ob_start();
session_start();
$idletime=1200;//after 20 min the user gets logged out
if (time()-$_SESSION['timestamp']>$idletime){
    session_destroy();
    session_unset();
    header('Location:login.php');
}else{
    $_SESSION['timestamp']=time();
}
include 'session_config.php';
$userdepartid = '';
$usetenantid = '';
$usertenantnm = '';
$useremail = '';
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
$userId = $_SESSION['userid'];
//echo $userId;
 
    require('CodeIgniter-old/external.php');
    $ci =& get_instance();
    $ci->load->library("cimongo/cimongo");
    $ci->load->model('get_mongodb');
    $g1 = new Get_mongodb();
    $userInfo = $g1->get_mongodb->getUserInfo($userId);
    $userEmailId = $userInfo[0]['LoginInfo']['EmailId'];   
    header("X-XSS-Protection: 0");
    $phid = $_POST["template_fromdata"];
    //echo $phid;
    $filename = strip_tags(trim($_POST["form_title"]));
    $file_desc = $_POST["ftitle_description"];
            
   //echo $userdepartid;
    //$fname =  $filename;
    $fname = str_replace(" ","_",$filename);
    $usertenantnm = str_replace(" ","_",$usertenantnm);
            //echo $_POST['domain_temp'];
    if(isset($_POST['domain_temp']))
    {
        if(isset($_POST['subdomain']))
        {
            //echo "In domain";
            
            $domain = $_POST['domain_temp'];
            $subDomain = $_POST['subdomain'];
            $domain = str_replace(" ","_",$domain);
            $subDomain = str_replace(" ", "_",$subDomain);
            $myFile1 = "DMSTree_clients/".$usertenantnm."_".$usetenantid."/Templates/".$domain."/".$subDomain."/".$fname.".html";
            $myFile = "DMSTree_clients/".$usertenantnm."_".$usetenantid."/Templates/".$domain."/".$subDomain;
        }
    }
    else if(!isset($_POST['domain_temp']))
    {
            //echo "out ";
            $myFile1 = "DMSTree_clients/".$usertenantnm."_".$usetenantid."/Templates/".$fname.".html";
            $myFile = "DMSTree_clients/".$usertenantnm."_".$usetenantid."/Templates";
    }
			//echo $myFile1;
    $fh = fopen($myFile1, "w") or die("wrong path");
    $stringData = $phid;
    fwrite($fh, $stringData);
    fclose($fh);

    $currDate = date('Y-m-d H:i:s');
    $currDate = new MongoDate(strtotime($currDate));

    $templatedata['tempresult'] = $g1->get_mongodb->saveTemplate($filename,$myFile,$file_desc,$usetenantid,$userdepartid,$currDate,$userEmailId);

    if($templatedata['tempresult'] == '1' && $usetenantid == -999)
    {
            header('Location: admin_document_template.php?msg =1');
    }
    else if($templatedata['tempresult'] == '1')
            header('Location: dashboard.php');
    else 
            header('Location: login.php');
            
?>

