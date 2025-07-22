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
        $userId = $_SESSION['userid'];
        date_default_timezone_set('Asia/Calcutta');
	$currDate = date('Y-m-d H:i:s');
	$currDate = new MongoDate(strtotime($currDate)); 
        $type = $_POST['type'];
	if(isset($_POST['temp_id']) && isset($_POST['temp_version']))
	{
		$tempId = $_POST['temp_id'];
		$tempRevision = $_POST['temp_version'];
		$doc = $g1->get_mongodb->getDocumentMetadataById($tempId);
		$index = 0;
		foreach($doc[0]['DocumentInfo'] as $key)
		{
			if($key['RevisionNo'] == $tempRevision )
			{
				break;
			}
			$index++;
		}
		$docUpdate = array('DocumentInfo.'.$index.'.CurrentStatus'=>'CheckIn');
		$result = $g1->get_mongodb->updateDocumentMetadata($tempId,$docUpdate);
                echo $result;
	}
        else if($type == 'comments')
        {
            $temp = $_POST['template_id'];
            $temp = explode('-',$temp);
            $comment = $_POST['comments'];
            $documentrevision = $temp[1];
            $id = $temp[0];
            $documentname = $_POST['documentname'];
            $doc = array('DocumentInfo'=>array('Comments'=>array('CommentText'=>$comments,'CommentDate'=>$currDate,'UserId'=>new MongoId($userId))));
            $result = $g1->get_mongodb->setComments($documentname,$documentrevision,$comment, $userId, $currDate,$id);
            echo $result;
        }
        else if($type == 'file')
        {
            $temp = $_POST['template_id'];
            $temparray = explode('-',$temp);
            $documentrevision = $temparray[1];
            $id = $temparray[0];
            $result = $g1->get_mongodb->getFileLocation($id,$documentrevision);
            $filelocation = '';
            foreach($result[0]['DocumentInfo'] as $key)
            {
                if($key['RevisionNo'] == $documentrevision)
                {
                    $filelocation = $key['FileLocation'].'/'.$key['FileName'];
                    break;
                }
                   
            }
            echo $filelocation;
        }
        else if($type == 'getCommments'){
            
            $temp = $_POST['template_id'];
            $temparray = explode('-',$temp);
            $documentRevision = $temparray[1];
            $documentId = $temparray[0];
            $Comments = array();
            $result = $g1->get_mongodb->getDocumentByID($documentId);
            foreach ( $result[0]['DocumentInfo'] as $value) {
                if($value['RevisionNo'] == $documentRevision)
                {
                    foreach ($value['Comments'] as $comment)
                    {
                        $commentText[] =  $comment['CommentText'];
                        $name = $g1->get_mongodb->getUserInfo($comment['UserId']);
                        $commentsName[] = $name[0]['Name'];
                        $commentsDate[] = date('d-M-Y h:i:s',$comment['CommentDate']->sec);
                    }
                    
                }
            }
            $Comments['Text'] = array_reverse($commentText);
            $Comments['User'] = array_reverse($commentsName);
            $Comments['Date'] = array_reverse($commentsDate);
            echo json_encode($Comments);
        }
        else if($type == 'setArchrive'){
            $docid = $_POST['docid'];
            $documentrevision = $_POST['docrev'];
            $result = $g1->get_mongodb->getDocumentByID($docid);
            
            $index = 0;
            foreach ( $result[0]['DocumentInfo'] as $value) {
                if($value['RevisionNo'] == $documentrevision)
                {
                    break;
                }
                $index++;
             }
             print_r($result);
             echo $index;
             $doc = array('DocumentInfo.'.$index.'.IsArchived'=>true);
             $query = $g1->get_mongodb->setDocumentToArchive($docid,$doc);
        }
        
?>