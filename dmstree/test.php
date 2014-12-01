<?php 
   $connection = new MongoClient();
   echo "Connection to database successfully";
   $db = $connection->DMSTree;
   $collection = $db->DocumentMetaData;
   /*$currDate = date('2014-10-11');
   $currDate = new MongoDate(strtotime(1413804333)); */
   $wherecond12 = array("DocumentName" => "Jellyfish");
   $cursor12 = $collection->find($wherecond12);
   foreach ($cursor12 as $value12) {
     if(array_key_exists("DocumentInfo",$value12))
     {
         foreach ($value12['DocumentInfo'] as $docinfo) {
             print_r($docinfo['UploadDate']->sec);
             echo "<br/>";
             $cuudate = $docinfo['UploadDate']->sec; //'Y-M-d'
         }
     }
    }
   // echo $currDate;
    /*$wherecond = array('$or' => array( array("DocumentInfo.TagList" =>"Customer"),array("DocumentInfo.TagList" => "Company"),array('$and' => array(array("DocumentInfo.UploadDate" => $currDate)))));
    $wherecond1 = array('$and' => array(array("DocumentInfo.UploadDate" => $currDate)));
    $selectcond = array( "DocumentName");*/
    $wherecond = array('$or' => array(
                                        array('$and' => array(
                                                                array("DocumentInfo.FileName" =>"Jellyfish.jpg"),
                                                                array("DocumentInfo.UploadDate" => new MongoDate($cuudate))
                                                            )
                                            ),
                                        array("DocumentInfo.TagList" => "RFP")    
                                     )
                      );
    $cursor = $collection->find($wherecond);
    foreach ($cursor as $value) {
     var_dump( $value );
    }
?>