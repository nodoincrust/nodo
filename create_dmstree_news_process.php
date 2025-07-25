<?php
	ob_start();
	session_start();
        include 'session_timeout.php';
	//include 'session_config.php';
	require('CodeIgniter-old/external.php');
	$ci =& get_instance();
	$ci->load->library("cimongo/cimongo");
	$ci->load->model('get_mongodb');
	$g1 = new Get_mongodb();
	$userId =  $_SESSION['userid'];
	$userInfo = $g1->get_mongodb->getUserInfo($userId);
	$userEmailId = $userInfo[0]['LoginInfo']['EmailId'];
	$tenantId = $_SESSION['usertenant'];
	$currDate = date('Y-m-d H:i:s');
	$currDate = new MongoDate(strtotime($currDate));
	$location = 'img/';
	$title = strip_tags(trim($_POST['new_title']));
        $description = strip_tags(trim($_POST['new_description']));
	$img = $_FILES['new_image']['name'];
        $date = strip_tags(trim($_POST['date']));
        $day = explode("/", $date);
        $expiryDate = $day[2].'-'.$day[1].'-'.$day[0];
        $expiryDate = date($expiryDate);
        $expiryDate = new MongoDate(strtotime($expiryDate));
        move_uploaded_file($_FILES["new_image"]["tmp_name"],$location.$img);
        $doc = array("NewsTitle" => $title,"NewsDescription" => $description,'NewsImage' => $img,'ImageLocation' => $location, 'ExpiryDate' => $expiryDate,'AuditData'=> array('DateAdded' => $currDate,
                                                                                                                                                                               'AddedBy' => $userEmailId,
                                                                                                                                                                               'DateModified' => $currDate,
                                                                                                                                                                               'ModifiedBy' => $userEmailId,
                                                                                                                                                                               'DeleteFlag' => false));
        $result = $g1->get_mongodb->setDmstreeNews($doc);
	echo $result;
?>