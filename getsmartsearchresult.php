<?php
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');
ob_start();
session_start();
include 'session_timeout.php';
include 'session_config.php';
require('CodeIgniter-old/external.php');
        $ci =& get_instance();
        $ci->load->library("cimongo/cimongo");
        $ci->load->model('get_mongodb');
            $g1 = new Get_mongodb();
$searchstr = '';            
    error_log('POST DATA: ' . print_r($_POST, true));
if(isset($_POST['searchstr'])) {$searchstr = $_POST['searchstr'] ;} 
$tenantid  = $_POST['tenantid'];
$departmentid = $_POST['departid'];
// Debug: Log tenantid and departmentid
error_log('tenantid: ' . $tenantid . ' | departmentid: ' . $departmentid);
$tenantid =(int)$tenantid;
$departmentid = (int)$departmentid;

$documentlimit = '';
$datbasetype = '';
$andorarr = '';
$dateoption = '';
$searchdate1 = '';
$datefilter1 = '';
$searchdate2 = '';
$datefilter2 = '';
$filtermongoDate1 = '';
$filtermongoDate2 = '';
$templateid = '';
$findinfilter = array();
$filetypefilter = array();
if(isset($_POST['documentlimit'])) {$documentlimit = $_POST['documentlimit'];}
if(isset($_POST['datbasetype'])){$datbasetype = $_POST['datbasetype'];}
if(isset($_POST['tempid'])) {$templateid = $_POST['tempid'];}
if(isset($_POST['andorarr'])) {$andorarr = $_POST['andorarr'];}
if(isset($_POST['dateoption']))
{ 
    $dateoption = $_POST['dateoption'];
    if(isset($_POST['searchdate1'])){ 
        $searchdate1 = $_POST['searchdate1'];
        if($searchdate1 != ''){
            if($dateoption == 'on_date'){
                $searchdate1_arr = explode("/",$searchdate1);
                if(count($searchdate1_arr) === 3) {
                    $datefilter1 = $searchdate1_arr[2].'-'.$searchdate1_arr[1].'-'.$searchdate1_arr[0].' '.'00:00:00';
                    $filtermongoDate1 = new MongoDate(strtotime($datefilter1));
                    $datefilter2 = $searchdate1_arr[2].'-'.$searchdate1_arr[1].'-'.$searchdate1_arr[0].' '.'11:59:59'; 
                    $filtermongoDate2 = new MongoDate(strtotime($datefilter2));
                } else {
                    $datefilter1 = '';
                    $filtermongoDate1 = null;
                    $datefilter2 = '';
                    $filtermongoDate2 = null;
                }
            }
            else if($dateoption == 'after_date'){
                $searchdate1_arr = explode("/",$searchdate1);
                if(count($searchdate1_arr) === 3) {
                    $datefilter1 = $searchdate1_arr[2].'-'.$searchdate1_arr[1].'-'.$searchdate1_arr[0].' '.'11:59:59';
                    $filtermongoDate1 = new MongoDate(strtotime($datefilter1));
                } else {
                    $datefilter1 = '';
                    $filtermongoDate1 = null;
                }
            }
            else
            {
                $searchdate1_arr = explode("/",$searchdate1);
                if(count($searchdate1_arr) === 3) {
                    $datefilter1 = $searchdate1_arr[2].'-'.$searchdate1_arr[1].'-'.$searchdate1_arr[0].' '.'00:00:00';
                    $filtermongoDate1 = new MongoDate(strtotime($datefilter1)); 
                } else {
                    $datefilter1 = '';
                    $filtermongoDate1 = null;
                }
            }
        }
        else if($searchdate1 == '' && $dateoption == 'in_week')
        {
            $currdate = date('Y-m-d');
            $filtermongoDate1 = new MongoDate(strtotime($currdate));
        }
        else if($searchdate1 == '' && $dateoption == 'in_month')
        {
            $currdate = date('Y-m-d');
            $filtermongoDate1 = new MongoDate(strtotime($currdate));
        }
    }
    if(isset($_POST['searchdate2']))
    { 
        $searchdate2 = $_POST['searchdate2'];
        if($searchdate2 != ''){
            $searchdate2_arr = explode("/",$searchdate2);
            if(count($searchdate2_arr) === 3) {
                $datefilter2 = $searchdate2_arr[2].'-'.$searchdate2_arr[1].'-'.$searchdate2_arr[0].' '.'00:00:00';
                $filtermongoDate2 = new MongoDate(strtotime($datefilter2));
            } else {
                $datefilter2 = '';
                $filtermongoDate2 = null;
            }
        }
        else if($searchdate2 == '' && $dateoption == 'in_week'){
            $weeekstartday = date('Y-m-d',time()+( 1 - date('w'))*24*3600);
            $filtermongoDate2 = new MongoDate(strtotime($weeekstartday));
        }
        else if($searchdate2 == '' && $dateoption == 'in_month'){
            $monthstartday = date('Y-m-01');
            $filtermongoDate2 = new MongoDate(strtotime($monthstartday));
        }
    }
}
if(isset($_POST['findfilter_namearr']))
{
    $findfilter_arr    = $_POST['findfilter_namearr'];
    $findfilter_valarr = $_POST['findfilter_valarr'];
    if(isset($findfilter_arr) && isset($findfilter_valarr) && $findfilter_arr != null && $findfilter_valarr != null){
        $minCount = min(count($findfilter_arr), count($findfilter_valarr));
        for ($i = 0; $i < $minCount; $i++) {
            $findinfilter[] = array("Name" => $findfilter_arr[$i], "Value" => $findfilter_valarr[$i]);
        }
    }
}
if(isset($_POST['fileextarray']))
{
    $filetypefilter = array();
    $fileexttype = $_POST['fileextarray'];
    foreach ($fileexttype as $fileextvalue) {
        $filetypefilter[] = new MongoRegex("/$fileextvalue/i");
    }
}

$searchstrresult = array();
    
     $searchresult = $g1->get_mongodb->search_documents($searchstr,$tenantid,$departmentid,$dateoption,$filtermongoDate1,$filtermongoDate2,$findinfilter,$filetypefilter,$documentlimit,$andorarr,$datbasetype,$templateid); 
     //print_r($searchresult['result']);
     //print_r($searchstr);
// print_r($searchresult);
// die();
     // Debug: Log search result before returning
     // error_log('SEARCH RESULT: ' . print_r($searchresult, true));

      if (!empty($searchresult)) {
          echo json_encode($searchresult);
      } else {
         echo json_encode([]); 
      }
     
header('Content-Type: application/json');
?>