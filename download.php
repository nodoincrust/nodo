<?php
ob_start();
session_start();
include 'session_config.php';

$tenantid = '';
$tenantname = '';
if(isset($_SESSION['usertenant']))
{
   $tenantid = $_SESSION['usertenant'];
}
if(isset($_SESSION['tenantname']))
{
   $tenantname = $_SESSION['tenantname'];
}

$file = $_GET['filenm'];
//$filerevision = $_GET['revision'];

//$filename = explode(".",$file);
//$filenm =$filename[0].'.'.$filename[1];
//$filenm =$filename[0].'_'.$filerevision.'.'.$filename[1];
//str_replace("world","Peter","Hello world!")
$actualtenantnmforfile = str_replace(" ","_",$tenantname);
$filepath = 'DMSTree_clients/'.$actualtenantnmforfile.'_'.$tenantid.'/Documents/'.$file;
//echo $filepath;

//if (file_exists($file)) {
//    header('Content-Description: File Transfer');
//    header('Content-Type: application/octet-stream');
//    header('Content-Disposition: attachment; filename='.basename($file));
//    header('Expires: 0');
//    header('Cache-Control: must-revalidate');
//    header('Pragma: public');
//    header('Content-Length: ' . filesize($file));
//    readfile($file);
//    exit;
//}
if (file_exists($filepath)) {
    //echo $filepath;

//    header('Content-Description: File Transfer');
//    header('Content-Type: application/octet-stream');
//    header('Content-Disposition: attachment; filename=\"'.basename($filepath).'"');
//    header('Content-Transfer-Encoding: binary');
//    header('Expires: 0');
//    header('Cache-Control: must-revalidate');
//    header('Pragma: public');
//    header('Content-Length: ' . filesize($filepath));
//    ob_clean();
//    flush();
//    readfile($filepath);
//    exit;
    //echo "size:".filesize($filepath);
    $contenttype = "application/force-download";
    header("Content-Type: " . $contenttype);
    header("Content-Disposition: attachment; filename=\"" . basename($file) . "\";");
    readfile($filepath);
    exit();
}

?> 