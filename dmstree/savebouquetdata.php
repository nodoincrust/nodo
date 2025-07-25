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

if(isset($_POST['tenantid'])) 
{
    $tenantid          = $_POST['tenantid'];
    $tenantid          =(int)$tenantid; 
    if(isset($_POST['bouquetname']))     {$bouquetname       = $_POST['bouquetname']; } else{$bouquetname = '';}
    if(isset($_POST['departid']))        {$departmenid       = $_POST['departid'];   $departmenid= (int)$departmenid; } else{$departmenid = '';}
    if(isset($_POST['bouquetdesc']))     {$bouquetdesc       = $_POST['bouquetdesc']; } else {$bouquetdesc = '';}
    if(isset($_POST['docidarr']))        {$docidarr          = $_POST['docidarr'];    } else {$docidarr = '';}  
    if(isset($_POST['docrevarr']))       {$docrevarr         = $_POST['docrevarr'];   } else {$docrevarr = '';}  
    $bouquetdocarr = array();
    for ($docidindex = 0,$docrevindex = 0; $docidindex < count($docidarr),$docrevindex < count($docrevarr); $docidindex++,$docrevindex++) {
        if($docidarr[$docidindex] != '' && $docrevarr[$docrevindex] != ''){
        $bouquetdocarr[] = array("DocumentId" => new MongoID($docidarr[$docidindex]),"RevisionNo" =>(int)$docrevarr[$docrevindex]);
        }
    }
    
    $documentbouquet['result'] = $g1->get_mongodb->saveBouquetData($bouquetname,$tenantid,$departmenid,$bouquetdesc,$bouquetdocarr);
    echo $documentbouquet['result'];
    //print_r($bouquetdocarr);
    //print_r($bouquetdocarr);
}
?>