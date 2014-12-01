<?php
$connection = new MongoClient();
   echo "Connection to database successfully";
   echo "\n";
   // select a database
   $db = $connection->DMSTree;
   //$resultarr = array();
   // select a collection:
    //$collection = $db->usertest;
   $collection = $db->commenttest;
    $searchquery = array("Name" => 'Employee Template');
    $commenttext = $_POST['usercomment'];
    $cursor1['result'] = $collection->find();
    //var_dump($cursor1['result']);
    $index = 0;
    $commentindex  = '' ;
    foreach ($cursor1['result'] as $key) {
        if(array_key_exists("DocumentInfo",$key))
        {
            foreach ($key['DocumentInfo'] as $value) {
                //echo $index;
                //echo $value[$index];
                //if(array_key_exists("comments",$value))
                //{
                    //print_r($value['comments']);
//                    $commentindex = $index;
//                }
//                
//                $index++;
                echo array_search("taglist",array_keys($value));
            }
        }
   }
 /*  if($commentindex != '')
   {
       echo $commentindex;
   }*/
   /* foreach ($cursor['result'] as $value) {
     $resultarr =$value['Userdetail']['comments'];
    }$searchquery*/
  /* foreach( $cursor['result'] as $value)
   {
      // echo $value['Name'];
       $mainarr = $value['Userdetail'];
       foreach ($mainarr as $value1) {
           print_r($value1['comments']);
       }
   }*/
    //print_r($resultarr);
   /* $pusharray = array('$push'=>  array("Userdetail" => array("comments" => array("commentText" =>$commenttext, "comment By" =>"Shubhangi"))));
    $cursor['result'] = $collection->update($searchquery,  $pusharray);*/
    
    //$cursor['result'] = $collection->update(array("Name" => 'Shubhangi'), array('$push' => array('Userdetail.$.comments'=>  array("commentText" =>$commenttext, "comment By" =>"Mahendra"))));
   /* $cursor['result'] = $collection->update(
                                                array("Name" => "Employee Template","DocumentInfo.userid" => "shubhangi_01"),
                                                array('$push' => array('DocumentInfo.comments'=>  array("commentText" =>$commenttext, "comment By" =>"Mahendra")))
                                           );*/
?>