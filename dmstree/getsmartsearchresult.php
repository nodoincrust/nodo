<?php
ob_start();
session_start();
include 'session_timeout.php';
include 'session_config.php';
require('../CodeIgniter-old/external.php');
        $ci =& get_instance();
        $ci->load->library("cimongo/cimongo");
        $ci->load->model('get_mongodb');
            $g1 = new Get_mongodb();
$searchstr = '';            
if(isset($_POST['searchstr'])) {$searchstr = $_POST['searchstr'] ;} 
$tenantid  = $_POST['tenantid'];
$departmentid = $_POST['departid'];
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
$findinfilter   = array();
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
                            $searchdate1 = explode("/",$searchdate1);
                            $datefilter1 = $searchdate1[2].'-'.$searchdate1[1].'-'.$searchdate1[0].' '.'00:00:00'; //'11:47:54'
                            $filtermongoDate1 = new MongoDate(strtotime($datefilter1));
                            
                            $datefilter2 = $searchdate1[2].'-'.$searchdate1[1].'-'.$searchdate1[0].' '.'11:59:59'; 
                            $filtermongoDate2 = new MongoDate(strtotime($datefilter2));
                            }
                            else if($dateoption == 'after_date'){
                            $searchdate1 = explode("/",$searchdate1);
                            $datefilter1 = $searchdate1[2].'-'.$searchdate1[1].'-'.$searchdate1[0].' '.'11:59:59'; //'11:47:54'
                            $filtermongoDate1 = new MongoDate(strtotime($datefilter1));
                            }
                            else
                            {
                               $searchdate1 = explode("/",$searchdate1);
                               $datefilter1 = $searchdate1[2].'-'.$searchdate1[1].'-'.$searchdate1[0].' '.'00:00:00'; //'11:47:54'
                               $filtermongoDate1 = new MongoDate(strtotime($datefilter1)); 
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
                            
                                $searchdate2 = explode("/",$searchdate2);
                                $datefilter2 = $searchdate2[2].'-'.$searchdate2[1].'-'.$searchdate2[0].' '.'00:00:00'; //11:25:33
                                $filtermongoDate2 = new MongoDate(strtotime($datefilter2));
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
            for ($findindex = 0, $findvalindex = 0; $findindex < count($findfilter_arr),$findvalindex < count($findfilter_valarr); $findindex++,$findvalindex++) {
                $findinfilter[] = array("Name" => $findfilter_arr[$findindex], "Value" => $findfilter_valarr[$findvalindex]);
            }}
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
    
     $searchresult['result'] = $g1->get_mongodb->search_documents($searchstr,$tenantid,$departmentid,$dateoption,$filtermongoDate1,$filtermongoDate2,$findinfilter,$filetypefilter,$documentlimit,$andorarr,$datbasetype,$templateid); 
     //print_r($searchresult['result']);
     //print_r($searchstr);
      if($searchresult['result'] != 0)
      {
          foreach ($searchresult['result'] as $searchvalue) {
              $searchstrresult[] = $searchvalue;
          }
         echo json_encode($searchstrresult); 
      }
      else {
         echo 0; 
      }
     
?>