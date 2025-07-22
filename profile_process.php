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
	
	$isProfileOrPassword = $_POST['txt_case'];
	if($isProfileOrPassword == 'password')
	{
		$password = $_POST['txt_value'];
		$userId = $_SESSION['userid'];
		
		$result = $g1->get_mongodb->getUserInfoPassword($userId,$password);
		echo trim(sizeof($result));
	}
	else if($isProfileOrPassword == 'change')
	{
		$password = $_POST['txt_value'];
		$userId = $_SESSION['userid'];
		$result = $g1->get_mongodb->setUserInfoPassword($userId,$password);
		echo $result;
	}
	else if($isProfileOrPassword == 'profile')
	{
		$name = strip_tags(trim($_POST['txt_name']));
		$contact = strip_tags(trim($_POST['txt_contact']));
		$add1 = strip_tags(trim($_POST['txt_add1']));
		$add2 = strip_tags(trim($_POST['txt_add2']));
		$city = strip_tags(trim($_POST['txt_city']));
		$pincode = strip_tags(trim($_POST['txt_pincode']));
		$state = strip_tags(trim($_POST['txt_state']));
		$country = strip_tags(trim($_POST['txt_country']));
		$userId =  $_SESSION['userid'];
		
		
		$result = $g1->get_mongodb->setUserInfoProfile($userId,$name,$contact);
		$tenantId = $g1->get_mongodb->getUserInfo($userId);
		$id = $tenantId[0]["TenantId"];
		$result1 = $g1->get_mongodb->setTenantInfoProfile($id,$add1,$add2,$city,$pincode,$state,$country);
		echo trim(sizeof($result.$result1));
	}
	
					
?>