<?php
	ob_start();
	session_start();
        $idletime=1200;//after 20 min the user gets logged out
        if (time()-$_SESSION['timestamp']>$idletime){
            session_destroy();
            session_unset();
            header('Location:login.php');
        }else{
            $_SESSION['timestamp']=time();
        }
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
        $type = $_POST['type'];
        
        if( $type == 'select')
        {
            $id = $_POST['id'];
            $result = $g1->get_mongodb->getNews($id);
            $date = $result[0]['ExpiryDate'];
            date_default_timezone_set('Asia/Calcutta');
            $date = $result[0]['ExpiryDate'] = date('d-m-Y', $date->sec);
            echo json_encode($result[0]);
        }
        else if($type == 'delete')
        {
            $id = $_POST['id'];
            $result = $g1->get_mongodb->getNews($id);
            $date = $result[0]['AuditData']['DateAdded'];
            $addedBy = $result[0]['AuditData']['AddedBy'];
            $doc = array('AuditData'=> array('DateAdded' => $date,
                                               'AddedBy' => $addedBy,
                                               'DateModified' => $currDate,
                                               'ModifiedBy' => $userEmailId,
                                               'DeleteFlag' => true));
            $result = $g1->get_mongodb->deleteNews($id,$doc);
            echo $result;
        
        }
?>