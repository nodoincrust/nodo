<?php
$connection = new MongoClient();
   echo "Connection to database successfully";
   echo "\n";
   $db = $connection->DMSTree;
   $collection = $db->commenttest;
    /*$searchquery = array("Name" => 'Employee Template');
    $commenttext = $_POST['usercomment'];*/
   //$commenttext = 'Testing new update';
   $TagName = "Customer";
   $Tagdesp = "Tested by customer";
    //$test = array("commentText" => 'Testing new update',"comment By" => 'Amol');
    $cursor1['result'] = $collection->find();
    var_dump($cursor1);
    $index = 0;
    $commentindex  = '' ;
    foreach ($cursor1['result'] as $key) {
        if(array_key_exists("Name",$key))
        {
            echo $key['Name'];
        }
        if(array_key_exists("DocumentInfo",$key))
        {
            foreach ($key['DocumentInfo'] as $value) {
                //echo $index;
                //echo $value[$index];
                if(array_key_exists("comments",$value))
                {
                    print_r($value['comments']);
                    $commentindex = $index;
                }
                
                $index++;
               // echo array_search("taglist",array_keys($value));
                
            }
            echo "commentindex".$commentindex;
        }
   }
   if($commentindex != ''){
    $pushfield ="DocumentInfo.".$commentindex.".comments";
    $cursor['result'] = $collection->update(
                                                array("Name" => "Employee Template","DocumentInfo.userid" => "shubhangi_01"),
                                                array('$push' => array($pushfield=>  array("commentText" =>$commenttext, "comment By" =>"Mahendra")))
                                           );
       echo "in if part";
   }
 else {
     echo "in else part";
     $setfield ="DocumentInfo.".$commentindex.".comments";
     $newtagarr = array("commentText" =>$TagName, "comment By" =>$Tagdesp);
    $cursor['result'] = $collection->update(
                                                array("Name" => "Employee Template","DocumentInfo.userid" => "shubhangi_02"),
                                                array('$set' => array($setfield =>  array($newtagarr)))
                                           );    
 }
    
    //print_r($resultarr);
   /* $pusharray = array('$push'=>  array("Userdetail" => array("comments" => array("commentText" =>$commenttext, "comment By" =>"Shubhangi"))));
    $cursor['result'] = $collection->update($searchquery,  $pusharray);*/
    
    //$cursor['result'] = $collection->update(array("Name" => 'Shubhangi'), array('$push' => array('Userdetail.$.comments'=>  array("commentText" =>$commenttext, "comment By" =>"Mahendra"))));
   /* $cursor['result'] = $collection->update(
                                                array("Name" => "Employee Template","DocumentInfo.userid" => "shubhangi_01"),
                                                array('$push' => array('DocumentInfo.comments'=>  array("commentText" =>$commenttext, "comment By" =>"Mahendra")))
                                           );*/
?>