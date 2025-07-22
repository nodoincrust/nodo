<?php
$connection = new MongoClient();
   echo "Connection to database successfully";
   $db = $connection->DMSTree;
   $collection = $db->DocumentMetaData;
   $str = 'Test';
   $search = 'Test';
   $regexval  = new MongoRegex("/'.$str.'/i");
   //$regex = new RegExp(["^",str,"$"].join(""),"i");
   $where = array('$and' => array(
							array("TenantId" => 1),
							array("DocumentInfo.Comments.CommentText" => array('$regex' => new MongoRegex("/$search/i")))
				));
	$searchresult = $collection->find($where);
	foreach($searchresult as $value)
	{
	var_dump($value);
	}
	
    		
?>