<?php
ob_start();
session_start();
include 'session_config.php';

require('CodeIgniter-old/external.php');
$ci =& get_instance();
$ci->load->library("cimongo/cimongo");
$ci->load->model('get_mongodb');
$g1 = new Get_mongodb();

$userdepartid = '';
$tenantid = '';

if(isset($_SESSION['userdepartmentid'] ))
{
    $userdepartid = $_SESSION['userdepartmentid'];
}  
if(isset($_SESSION['usertenant']))
{
    $tenantid = $_SESSION['usertenant'];
} 

$docid = '';
$docrev = '';
if(isset($_POST['documentid']))
{
$docid = new MongoID($_POST['documentid']);
}
if(isset($_POST['docrev']))
{
$docrev = $_POST['docrev'];
}

$physicalloctags = $g1->get_mongodb->getPhysicalLocationTags($tenantid,$userdepartid,$docid,$docrev);
print_r($physicalloctags);
?>