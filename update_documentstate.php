<?php
ob_start();
session_start();
include 'session_timeout.php';
include 'session_config.php';
require('CodeIgniter-old/external.php');
$ci =& get_instance();
$ci->load->library("cimongo/cimongo");
		$ci->load->model('get_mongodb');
                $g1 = new Get_mongodb();
$tenantid = ''; 
$departmentid = '';
$docid = '';
$docrev = '';
if(isset($_POST['tenantid']))  { $tenantid = $_POST['tenantid']; $tenantid = (int)$tenantid; }  
if(isset($_POST['departmentid'])) { $departmentid = $_POST['departmentid']; $departmentid = (int)$departmentid; }
if(isset($_POST['docid'])) { $docid = $_POST['docid'];}
if(isset($_POST['docrev'])) { $docrev = $_POST['docrev'];}

$documentstate['docresult'] = $g1->get_mongodb->changedocumentstate($tenantid,$departmentid,$docid,$docrev);
print_r($documentstate['docresult']);
?>