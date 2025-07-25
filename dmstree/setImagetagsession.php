<?php
    ob_start();
	session_start();
	include 'session_timeout.php';
	include 'session_config.php';
	/*require('CodeIgniter-old/external.php');
    $ci =& get_instance();
    $ci->load->library("cimongo/cimongo");
    $ci->load->model('get_mongodb');
    $g1 = new Get_mongodb();*/
	
        if(isset($_SESSION['imagetags']))
        {
            unset($_SESSION['imagetags']);
        }
        if(isset($_SESSION['documentimageurl']))
        {
            unset($_SESSION['documentimageurl']);
        }
        if(isset($_POST['imagetaglist']))
        {
            $taglist = $_POST['imagetaglist'];
            unset($_SESSION['imagetags']);
            $_SESSION['imagetags'] = $taglist;
        }
        if(isset($_POST['imageurl']))
        {
            $imageurl = $_POST['imageurl'];
            unset($_SESSION['documentimageurl']);
            $_SESSION['documentimageurl'] = $imageurl;
        }
		if(isset($_POST['defaultval']))
        {
            unset($_SESSION['imagetags']);
            unset($_SESSION['documentimageurl']);
        }
	
	/*
	$img = $_POST['imagetaglist'];
	$tag = $_POST['imageurl'];
	$tenantId = $_SESSION['usertenant'];
	$doc = array('TenantId'=>$tenantId,'Physical'=>array('imagetags'=>$img,'documentimageurl'=>$tag));
	echo $result = $g1->get_mongodb->savetemplocation($doc);*/
    //echo $_SESSION['imagetags'];
        
?>