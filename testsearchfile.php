<?php
   $connection = new MongoClient();
   echo "Connection to database successfully";
   $db = $connection->DMSTree;
   $collection = $db->DocumentMetaData;
   $whercond = array( '$and' => array(
											array("TenantId" => 1),
											array("$or" => array(
																	array("$and" => array(
																							array("_id" => new MongoID("543918eafac1d1fc5100002b")),
																							array("DocumentInfo.RevisionNo":1)
																						)	
																		 ),
				 {"$and":[
							{"_id":{"$id":"5444f12dfac1d19411000029"}},{"DocumentInfo.RevisionNo":1}
						 ]
				 },
				 {"$and":[
							{"_id":{"$id":"54391a10fac1d1ac3e00002f"}},{"DocumentInfo.RevisionNo":"1"}
						  ]
				 },
				 {"$and":[
							{"_id":{"$id":"54391806fac1d1c476000029"}},{"DocumentInfo.RevisionNo":"1"}
						 ]
				 }
			   ]
		},
		{"DepartmentId":1}
	]
]
?>