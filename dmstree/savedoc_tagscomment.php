<?php
ob_start();
session_start();
include 'session_timeout.php';
include 'session_config.php';
$tenantid = '';
$userdepartid = '';
if(isset($_SESSION['userdepartmentid'] ))
{
    $userdepartid = $_SESSION['userdepartmentid'];
}  
if(isset($_SESSION['usertenant'])) {
    $tenantid = $_SESSION['usertenant'];
} 

if(isset($_SESSION['userid']))
{
    $userid = $_SESSION['userid'];
    require('CodeIgniter-old/external.php');
    $ci =& get_instance();
    $ci->load->library("cimongo/cimongo");
		$ci->load->model('get_mongodb');
                $g1 = new Get_mongodb();
    date_default_timezone_set('Asia/Calcutta');            
    $currDate = date('Y-m-d H:i:s');
    $currDate = new MongoDate(strtotime($currDate)); 
    
    if(isset($_POST['actiontype']))
    {
        $actiontype = $_POST['actiontype'];
        $documentname       = strip_tags(trim($_POST['documentname']));
        $documentid         = $_POST['documentid'];
        $documentrevision   = strip_tags(trim($_POST['documentrevision']));
        if($actiontype == 'comment')
        {
                $comment            = strip_tags(trim($_POST['usercomment']));
                $comment_data['result'] =$g1->get_mongodb->savecommentdata($tenantid,$userdepartid,$documentname,$documentrevision,$comment,$userid,$currDate,$documentid);
                print_r($comment_data['result']);
        }  
        if($actiontype == 'tag')
        {
                $taglist            = $_POST['taglistarray'];
                $tag_data['tagresult'] =$g1->get_mongodb->savetagdata($tenantid,$userdepartid,$documentname,$documentrevision,$taglist,$userid,$documentid);
                print_r($tag_data['tagresult']);
               
        }    
    } 
    else if(isset ($_POST['datatype']))
    {
        if($_POST['datatype'] == 'bouquet')
        {
            $bouquetnmarr = '';
            $bouquetdata = $g1->get_mongodb->getBouquetName($tenantid,$userdepartid);
            if($bouquetdata != 0)
            {
               foreach ($bouquetdata as $bouquetvalue) {
               $bouquetnmarr .='<option value="'.$bouquetvalue['BouquetName'].'">'.$bouquetvalue['BouquetName'].'</option>';
                } 
            }
            echo $bouquetnmarr;
        }
        if($_POST['datatype'] == 'bouquetupdate')
        {
            $id = $_POST['id'];
            $bouquetname = (string)$_POST['selectopt'];
            $doc = explode("-",$id);
            $docid = $doc[0];
            $docrevision = $doc[1];
            $bouquetresult = $g1->get_mongodb->updateBouquetData($tenantid,$userdepartid,$docid,$docrevision,$bouquetname);
            echo $bouquetresult;
        }
    }
 else {
     echo "not present";
    }
                
}


?>