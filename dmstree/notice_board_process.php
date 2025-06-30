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
        
	$userId =  $_SESSION['userid'];
	$tenantId = $_SESSION['usertenant'];
        $tenantInfo = $g1->get_mongodb->getTenantInfo($tenantId);
	$tenantName = $tenantInfo[0]['TenantName'];
	$tenantName = str_replace(" ","_",$tenantName);
	$location = "DMSTree_clients/".$tenantName."_".$tenantId."/Images/";
	
	$img = "";
       	date_default_timezone_set('Asia/Calcutta');
	$currDate = date('Y-m-d h:i:s');
	$currDate = new MongoDate(strtotime($currDate));
        
        if(empty($_FILES["notice_img"]["name"]))
	{
		$category = $_POST['category'];
		$title = $_POST['title'];
		$description = $_POST['description'];
                $expiryDate = $_POST['date'];
                $expiry = explode('/',$expiryDate);
                $date = $expiry[2].'-'.$expiry[1].'-'.$expiry[0];
                $date = date($date);
                $expiryDate = new MongoDate(strtotime($date));
		$result = $g1->get_mongodb->setNoticeInfo($category,$title,$description,$img,$currDate,$expiryDate,$userId,$tenantId);
	}
	else
	{
		$category = $_POST['notice_category'];
		$title = $_POST['notice_title'];
		$description = $_POST['notice_description'];
                $expiryDate = $_POST['date'];
                $expiry = explode('/',$expiryDate);
                $date = $expiry[2].'-'.$expiry[1].'-'.$expiry[0];
                $date = date($date);
                $expiryDate = new MongoDate(strtotime($date));
    		move_uploaded_file($_FILES["notice_img"]["tmp_name"],$location.$_FILES["notice_img"]["name"]);
                $img = $_FILES["notice_img"]["name"];
		$result = $g1->get_mongodb->setNoticeInfo($category,$title,$description,$img,$currDate,$expiryDate,$userId,$tenantId);
	}
	
?>