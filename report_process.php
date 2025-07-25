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
        $day= date('d/m/Y');
        date_default_timezone_set('Asia/Calcutta');
        $currDate = date('Y-m-d h:i:s');
        $currDate = new MongoDate(strtotime($currDate));
        $userId = $_SESSION['userid']; 
        $tenantInfo = $g1->get_mongodb->getUserInfo($userId);
        $tenantId = $tenantInfo[0]['TenantId'];
        $userEmailId = $tenantInfo[0]['LoginInfo']['EmailId'];
	$type = $_POST['type'];
	if ($type == 'save')
	{
		$category = $_POST["category"];
		$title = $_POST["title"];
		$description = $_POST["discription"];
		$comments = $_POST["comments"];
		$result = $g1->get_mongodb->setDefectLog($userEmailId,$category,$title,$description,$comments,$tenantId,$currDate);
		echo trim(sizeof($result));
	}
	else if($type == 'retrieve')
	{
		$id = $_POST['id'];
		$result = $g1->get_mongodb->getReportDetailInfo($id);
		$comments = array();
		$raisedBy = array();
		$status = array();
		$date = array();
                foreach( $result[0]['DefectLogHistory'] as $key)
                {
                        $comments[] = array( $key['RaisedBy']['Comment']);
                        $raisedBy[] = array( $key['RaisedBy']['UserId']);
                        $status[] = array( $key['DefectStatus']);
                        $currdate = $key['RaisedBy']['Date'];
                        date_default_timezone_set('Asia/Calcutta');
                        $date[] = array(date('d-M-Y  h:i',$currdate->sec));
                }
                $response['commentArray'] = $comments;
                $response['raisedArray'] = $raisedBy;
                $response['statusArray'] = $status;
                $response['dateArray'] = $date;
		echo json_encode($response);
	}
        else if($type == 'reply')
        {
            $id = $_POST['id'];
            $comments = $_POST["comments"];
            $status = $_POST["status"];
            $result = $g1->get_mongodb->getReportDetailInfo($id);
            $tenantId = $result[0]['DefectLogHistory'][0]['RaisedBy']['TenantId'];
            $userEmail = $result[0]['DefectLogHistory'][0]['RaisedBy']['UserId'];
            $count = sizeOf($result[0]['DefectLogHistory']);
            $doc = array('DefectLogHistory'=>  array('DefectStatus'=>$status,'RaisedBy'=>  array('TenantId'=>-999,
                                                                                                'UserId'=>$userEmailId,
                                                                                                'Comment'=>$comments,
                                                                                                'Date'=>$currDate),
                                                                                        'RaisedTo'=>array('TenantId'=>$tenantId,
                                                                                                          'UserId'=>$userEmail),
                                                                                        'Sequence'=>$count+1));
            $result = $g1->get_mongodb->updateReportInfo($doc,$id);
            echo $result;
        }
?>