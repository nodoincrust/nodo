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
$tenantid = '';  
$departmentid = '';
if(isset($_SESSION['usertenant']))
{
    $tenantid = $_SESSION['usertenant'];
}
if($_SESSION['userdepartmentid'])
{
    $departmentid = $_SESSION['userdepartmentid'];
}
$stdtype = '';
if(isset($_POST['stdcntrltype'])){$stdtype = $_POST['stdcntrltype'];}
if($stdtype == 'combo')
{
    $comboname = '';
    $type = 'combo';
    $comboresultarr = array();
    $standcomboresult['comboresult'] = $g1->get_mongodb->get_standcombodata($tenantid,$type,$comboname);
    if($standcomboresult['comboresult'] != 0){
        foreach ($standcomboresult['comboresult'] as $stdcombovalue) {
            $comboresultarr[] = $stdcombovalue;
        }
        echo json_encode($comboresultarr);
    }
    else {
     echo 0;
    }
}
if($stdtype == 'combooptions')
{
    $type = 'combooptions';
    $comboname = $_POST['comboname'];
    $combooptionresultarr = array();
    $standcombooptionresult['comboresult'] = $g1->get_mongodb->get_standcombodata($tenantid,$type,$comboname);
    if($standcombooptionresult['comboresult'] != 0){
        foreach ($standcombooptionresult['comboresult'] as $stdcombooptvalue) {
            $combooptionresultarr[] = $stdcombooptvalue;
        }
        echo json_encode($combooptionresultarr);
    }
    else {
     echo 0;
    }
}   
if($stdtype == 'list')
 {
    $comboname = '';
    $type = 'list';
    $listresultarr = array();
    $standlistresult['comboresult'] = $g1->get_mongodb->get_standcombodata($tenantid,$type,$comboname);
    if($standlistresult['comboresult'] != 0){
        foreach ($standlistresult['comboresult'] as $stdlistvalue) {
            $listresultarr[] = $stdlistvalue;
        }
        echo json_encode($listresultarr);
    }
    else {
     echo 0;
    }
}  
if($stdtype == 'listoptions')
 {
    $comboname = $_POST['comboname'];
    $type = 'listoptions';
    $listoptionresultarr = array();
    $standlistoptionresult['comboresult'] = $g1->get_mongodb->get_standcombodata($tenantid,$type,$comboname);
    if($standlistoptionresult['comboresult'] != 0){
        foreach ($standlistoptionresult['comboresult'] as $stdlistoptionvalue) {
            $listoptionresultarr[] = $stdlistoptionvalue;
        }
        echo json_encode($listoptionresultarr);
    }
    else {
     echo 0;
    }
}  
?>