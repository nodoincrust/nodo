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
	$userId = $_SESSION['userid'];
	$tenantId = $_SESSION['usertenant'];
	date_default_timezone_set('Asia/Calcutta');
	$currDate = date('Y-m-d h:i:s');
	$currDate = new MongoDate(strtotime($currDate));
	
	$userInfo = $g1->get_mongodb->getUserInfo($userId);
	$tenantInfo = $g1->get_mongodb->getTenantInfo($tenantId);
	$userEmailId = $userInfo[0]['LoginInfo']['EmailId'];
	$tenantName = $tenantInfo[0]['TenantName'];
	$tenantName = str_replace(" ","_",$tenantName);
	$location = "DMSTree_clients/".$tenantName."_".$tenantId."/Images/";
	if(isset($_FILES["galleryphoto"]["name"]))
	{
		$img = $_FILES["galleryphoto"]["name"];
	}
	else if(isset($_FILES["galleryphoto1"]["name"]))
	{
		$img = $_FILES["galleryphoto1"]["name"];
	}
	echo $_FILES["galleryphoto"]["name"];
	if (file_exists($location.$img))			
	{
		echo "exits";
		$photoname = $g1->get_mongodb->getPhotoList($tenantId);
		$index = 0;
		foreach($photoname[0]['Photo'] as $key)
		{
			if($img == $key['FileName'])
			{
				break;
			}
			$index++;
		}
		$doc = array('Photo.'.$index.'.AuditData.DateModified'=>$currDate,'Photo.'.$index.'.AuditData.ModifiedBy'=>$userEmailId,'Photo.'.$index.'.AuditData.DeleteFlag'=>false);
		$result = $g1->get_mongodb->deletePhoto($tenantId,$doc);
		echo $result;
	}
	else
	{
		echo "not";
		move_uploaded_file($_FILES["galleryphoto"]["tmp_name"],$location. $_FILES["galleryphoto"]["name"]);
		$doc = array('Photo'=>array('FileName'=>$img,'FileLocation'=>$location,'IsActive'=>false,'AuditData'=>array('DateAdded'=>$currDate,
																								'AddedBy'=>$userEmailId,
																								'DateModified'=>$currDate,
																								'ModifiedBy'=>$userEmailId,
																								'DeleteFlag'=>false)));
		echo $result = $g1->get_mongodb->setPhotoGallary($tenantId,$doc);
	}
	
	
?>