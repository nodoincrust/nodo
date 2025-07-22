<?php
ob_start();
session_start();
include 'session_config.php';
$userid = '';
if(isset($_SESSION['userid']))
{
    $userid = $_SESSION['userid'];
}
$connection = new MongoClient();
   $db = $connection->DMSTree;
   $collection = $db->DocumentMetaData;
   $currDate = date('Y-m-d H:i:s');
   $currDate = new MongoDate(strtotime($currDate));
   $comment = $_POST['usercomment'];
   $docname = $_POST['documentname'];
   $docrev = $_POST['documentrevision'];
   
   $docrev   = (int)$docrev;
   $docname  = (string)$docname; 
   
   $wherecra = array("DocumentName" => $docname);
   $cursor1['result'] = $collection->find($wherecra);
   $index = 0;
    $commentindex  = '' ;
    foreach ($cursor1['result'] as $key) {
        if(array_key_exists("DocumentInfo",$key))
        {
            foreach ($key['DocumentInfo'] as $value) { 
                if($value['RevisionNo'] == $docrev)
                {
                   $commentindex = $index;
                }
                $index++;
            }
            
        }
   }
    
    $commentindex =(int)$commentindex;
    if($userid != ''){
            $setfield ="DocumentInfo.".$commentindex.".Comments";
            $newtagarr = array("CommentText" =>$comment, "CommentDate" =>$currDate,"UserId" => new MongoID($userid));
            $cursor['result'] = $collection->update(
                                                array("DocumentName" => $docname ,"DocumentInfo.RevisionNo" => $docrev),
                                                array('$set' => array($setfield =>  array($newtagarr)))
                                           );  
            if($cursor['result'])
                echo 1;
            else {
                echo 0;
            }
    }
   //echo "test";
   //echo $comment."--".$docname."--".$docrev."--".$commentindex;
 
    
?>