<?php
//   $connection = new MongoClient();
//   echo "Connection to database successfully";
//   $db = $connection->DMSTree;
//   $collection = $db->PhotoGallery; //DocumentMetaData; // BouquetData;
//   
//   $photowhere = array("Photo.FileName" =>'Desert.jpg');
//   $cursor12 = $collection->find($photowhere);
//   foreach ($photowhere as $value) {
//    var_dump($value);
//    }
   
  // $wherecond = array("DocumentInfo.FileName" =>  array('$regex' => '.jpg'));
   //$wherecond12 = array("DocumentInfo.TagList" => array( '$in'  => array('Company'))); //Comments.CommentText
   //$wherecond12 = array("DocumentInfo.Comments" => array('$in' => array(array('CommentText' => 'demo test'))));
  // $wherecond12 = array("DocumentInfo.Comments.0.CommentText" =>  array('$regex' => 'Test'));
  // $cursor12 = $collection->find($wherecond12);
   //var_dump($cursor12);
  // foreach ($cursor12 as $value12) {
       //foreach ($value12 as $value23) {
        //   var_dump($value12);
      // }
     
   //}
    
  /* $selectrevdata   = array("DocumentInfo.RevisionNo");
   $whererevdata    = array("TenantId" => 1, "DepartmentId" => 1,"_id" => new MongoID("54391a10fac1d1ac3e00002f"));
   $docrevsionquery = $collection->find($whererevdata,$selectrevdata);
   //$docrevsionquery = $this->cimongo->select($selectrevdata)->order_by(array("DocumentInfo.RevisionNo" => 'DESC'))->limit(1)->where($whererevdata)->get($collection);
   $documentrevisionresult =  $docrevsionquery->result_array();
   var_dump($documentrevisionresult);*/
   
   /*$tenantid = '1';
   $userdepartid = '1';
            $tenantid =(int)$tenantid;
            $userdepartid = (int)$userdepartid;
            if($userdepartid != '')
            {
                $bouquetwherecond = array("TenantId" => $tenantid);//,"DepartmentId" => $userdepartid
            }
            else
            {
                $bouquetwherecond = array("TenantId" => $tenantid);
            }
            $bouquetselectdata = array("BouquetName");
            $bouquetdocquery = $collection->find();
            foreach ($bouquetdocquery as $value) {
                var_dump($value);
            }*/
            
/*$test = $_POST['test'];
echo $test;*/

require('CodeIgniter-old/external.php');
$ci =& get_instance();
$ci->load->library("cimongo/cimongo");
$ci->load->model('get_mongodb');
$g1 = new Get_mongodb();
$documentmetadata = $g1->get_mongodb->test();
print_r($documentmetadata);
?>