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
        
	$userId =  $_SESSION['userid'];
	$tenantId = $_SESSION['usertenant'];
	$type = $_POST['type'];
        
	date_default_timezone_set('Asia/Calcutta');
	$currDate = date('Y-m-d h:i:s');
	$currDate = new MongoDate(strtotime($currDate));
	$userInfo = $g1->get_mongodb->getUserInfo($userId);
	$userEmailId = $userInfo[0]['LoginInfo']['EmailId'];
	
	if($type == 'standardList')
	{
		$listName = strip_tags(trim($_POST['list_name']));
		//$listDescription = $_POST['list_description'];
		$listType = strip_tags(trim($_POST['select_option']));
		$list = array();
		$list = $_POST['list'];
		$code = array();
		$code = $_POST['code'];
		$listCode = array();
		for($listindex = 0; $listindex < count($list);$listindex++)
		{
			if($code[$listindex] != '' )
			{
				$listCode[] = array("Code" => $code[$codeindex], "Description" => $list[$listindex], "IsActive" => true,
                                                                                                                        "AuditData" => array(
															"DateAdded" => $currDate,
															"AddedBy"   => $userEmailId,
															"DateModified" =>$currDate,
															"ModifiedBy" =>$userEmailId,
															"DeleteFlag" => false
								)); 
			}
			else if($code[$listindex] == '')
			{
				$listCode[] = array("Description" => $list[$listindex], "IsActive" => true,
                                                                                        "AuditData" => array(
                                                                                                            "DateAdded" => $currDate,
                                                                                                            "AddedBy"   => $userEmailId,
                                                                                                            "DateModified" =>$currDate,
                                                                                                            "ModifiedBy" =>$userEmailId,
                                                                                                            "DeleteFlag" => false
                                                                                                            )); 
			}
		}
		$doc = array('ListName'=>$listName,'TenantId'=>$tenantId,'Type'=>$listType,'List'=>$listCode,'AuditData'=>array('DateAdded'=>$currDate,'AddedBy'=>$userEmailId,'DateModified'=>$currDate,'ModifiedBy'=>$userEmailId,'DeleteFlag'=>false));
		//echo $doc;
		$result = $g1->get_mongodb->setStandardListInfo($doc);
	}
	else if($type == "OptionList")
	{
		$id = $_POST['id'];
		$result = $g1->get_mongodb->getStandardListDescription($id);
		$codeArray = array();
		$listArray = array();
		foreach($result[0]['List'] as $key)
		{
			if(!$key['AuditData']['DeleteFlag'])
			{
				if(!empty($key['Code']))
				{
					$codeArray[] = $key['Code'];
					$listArray[] = $key['Description'];
				}
				else 
				{
					$codeArray[] = '';
					$listArray[] = $key['Description'];
				}
			}
		}
		$response['code'] = $codeArray;
		$response['list'] = $listArray;
		echo json_encode($response);
	}
	else if($type == "OptionListUpdate")
	{
		$id = $_POST['id'];
		$list = $_POST['list'];
		$code = $_POST['code'];
		$listIndex = 0;
		$listinfo = $g1->get_mongodb->getStandardListDescription($id);
		foreach($listinfo[0]['List'] as $key)
		{
			if($key['Code'] == $code && $key['Description'] == $list)
			{
				break;
			}
			$listIndex++;
		}
		echo $listIndex;
		$result = $g1->get_mongodb->deleteStandardListDescription($id,$list,$code,$listIndex);
		echo $result;
	}
	else if($type == "OptionListDelete")
	{
		$id = $_POST['id'];
		$result = $g1->get_mongodb->deleteStandardList($id,$currDate,$userEmailId);
		echo $result;
	}
	else if($type == "OptionListUpdateInfo")
	{
		$id = $_POST['id'];
		$codeArray = array();
		$listArray = array();
		$list = array();
		//$doc = array();
		$codeArray = $_POST['code'];
		$listArray = $_POST['list'];
		$name = $_POST['name'];
		$listIndex = 0;
		$listinfo = $g1->get_mongodb->getStandardListDescription($id);
		foreach($listinfo[0]['List'] as $key)
		{
			$listIndex++;
		}
		for($index = 0; $index < sizeof($listArray); $index++)
		{
		
			if($codeArray[$index] == '')
			{
				$doc = array('List'=>array('Description'=>$listArray[$index],'IsActive'=>true,'AuditData'=>array('DateAdded'=>$currDate,
                                                                                                                                'AddedBy'=>$userEmailId,
                                                                                                                                'DateModified'=>$currDate,
                                                                                                                                'ModifiedBy'=>$userEmailId,
                                                                                                                                'DeleteFlag'=>false)));
			}
			else if($codeArray[$index] != '')
			{
				$doc = array('List'=>array('Code'=>$codeArray[$index],'Description'=>$listArray[$index],'IsActive'=>true,'AuditData'=>array('DateAdded'=>$currDate,
                                                                                                                                                            'AddedBy'=>$userEmailId,
                                                                                                                                                            'DateModified'=>$currDate,
                                                                                                                                                            'ModifiedBy'=>$userEmailId,
                                                                                                                                                            'DeleteFlag'=>false)));
			}
			$listIndex++;
			$result = $g1->get_mongodb->updateStandardList($id,$doc);
		}
		$result1 = $g1->get_mongodb->updateStandardListName($id,$name);
		echo $result1;
	}
	else if($type == 'updateTag')
	{
		$newTag = $_POST['new_tag'];
		$oldTag = $_POST['old_tag'];
		if($oldTag != '')
		{
			$tag = $g1->get_mongodb->getTagList($tenantId);
			$index = 0;
			foreach($tag[0]['TagList'] as $key)
			{
				if($oldTag == $key['Tag'])
				{
					break;
				}
				$index++;
			}
			$doc = array('TagList.'.$index.'.Tag'=>$newTag,'TagList.'.$index.'.AuditData.DateModified'=>$currDate,'TagList.'.$index.'.AuditData.ModifiedBy'=>$userEmailId,'TagList.'.$index.'.AuditData.DeleteFlag'=>true);
			$result = $g1->get_mongodb->updateTag($tenantId,$doc);
		}
		else if($oldTag == '')
		{
			$flag = false;
			$tag = $g1->get_mongodb->getTagList($tenantId);
			$index = 0;
			foreach($tag[0]['TagList'] as $key)
			{
				if($newTag == $key['Tag'])
				{
					$flag = true;
					break;
				}
				$index++;
			}
			if($flag)
			{
				$doc = array('TagList.'.$index.'.Tag'=>$newTag,'TagList.'.$index.'.AuditData.DateModified'=>$currDate,'TagList.'.$index.'.AuditData.ModifiedBy'=>$userEmailId,'TagList.'.$index.'.AuditData.DeleteFlag'=>false);
				
				$result = $g1->get_mongodb->updateTag($tenantId,$doc);
			}
			else{
				$doc = array('TagList'=>array('Tag'=>$newTag,'IsActive'=>true,'AuditData'=>array('DateAdded'=>$currDate,
                                                                                                                'AddedBy'=>$userEmailId,
                                                                                                                'DateModified'=>$currDate,
                                                                                                                'ModifiedBy'=>$userEmailId,
                                                                                                                'DeleteFlag'=>false)));
				$result = $g1->get_mongodb->insertTag($tenantId,$doc);
			}
		}
		echo $result;
	}
	else if($type == 'deleteTag')
	{
		$newTag = $_POST['tag'];
		$tag = $g1->get_mongodb->getTagList($tenantId);
		$index = 0;
		foreach($tag[0]['TagList'] as $key)
		{
			if($newTag == $key['Tag'])
			{
				break;
			}
			$index++;
		}
		$doc = array('TagList.'.$index.'.AuditData.DateModified'=>$currDate,'TagList.'.$index.'.AuditData.ModifiedBy'=>$userEmailId,'TagList.'.$index.'.AuditData.DeleteFlag'=>true);
		$result = $g1->get_mongodb->deleteTag($tenantId,$doc);
		echo $result;
		
	}
	else if($type == 'deletePhoto')
	{
		$name = $_POST['name'];
		$photoname = $g1->get_mongodb->getPhotoList($tenantId);
		$index = 0;
		foreach($photoname[0]['Photo'] as $key)
		{
			if($name == $key['FileName'])
			{
				break;
			}
			$index++;
		}
		$doc = array('Photo.'.$index.'.AuditData.DateModified'=>$currDate,'Photo.'.$index.'.AuditData.ModifiedBy'=>$userEmailId,'Photo.'.$index.'.AuditData.DeleteFlag'=>true);
		$result = $g1->get_mongodb->deletePhoto($tenantId,$doc);
		echo $result;
	}
        else if($type == 'findTag')
        {
                $newTag = $_POST['tag'];
		$tag = $g1->get_mongodb->getTagList($tenantId);
                $flag = false;
		foreach($tag[0]['TagList'] as $key)
		{
			if($newTag == $key['Tag'] && $key['IsActive'])
			{
                            $flag = true;
                            break;
			}
		}
                if($flag){
                 echo 'failed';
               }
               else {
                 echo 'success';
             }
        }
?>