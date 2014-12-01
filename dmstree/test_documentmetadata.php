<?php
ob_start();
session_start();
include 'session_config.php';

$tenantid = '';
$userdepartid = '';
$tenantname = '';
if(isset($_SESSION['usertenant']))
{
    $tenantid = $_SESSION['usertenant'];
}
if(isset($_SESSION['userdepartmentid'] ))
{
    $userdepartid = $_SESSION['userdepartmentid'];
}  
if(isset($_SESSION['tenantname']))
{
    $tenantname = $_SESSION['tenantname'];
    $tenantname = str_replace(" ","_",$tenantname);
}
 
        require('../CodeIgniter-old/external.php');
        $ci =& get_instance();
        $ci->load->library("cimongo/cimongo");
        $ci->load->model('get_mongodb');
            $g1 = new Get_mongodb();
            
            
       /* $path = 'DMSTree_clients/'.$tenantname.'_'.$tenantid;
        echo $path;
        $directory = $path;
        $bytestotal = 0;
        $path = realpath($path);
        if($path!==false){
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
            $bytestotal += $object->getSize();
        }
        }
        return $bytestotal;*/ 
        
       /* $f = 'C:/wamp/www/dmstree/DMSTree_clients/'.$tenantname.'_'.$tenantid;
        $obj = new COM ( 'scripting.filesystemobject' );
        if ( is_object ( $obj ) )
        {
            $ref = $obj->getfolder ( $f );
            echo 'Directory: ' . $f . ' => Size: ' . $ref->size;
            $obj = null;
        }
        else
        {
            echo 'can not create object';
        }*/

        
$path='DMSTree_clients/'.$tenantname.'_'.$tenantid; 
$ar=getDirectorySize($path); 

echo "<h4>Details for the path : $path</h4>"; 
echo "Total size : ".sizeFormat($ar['size'])."<br>"; 
echo "No. of files : ".$ar['count']."<br>"; 
echo "No. of directories : ".$ar['dircount']."<br>";         
        
        
        
 
			/*$tenantid = 1;
                        $documentdata['result'] = $g1->get_mongodb->getActivePackageSize($tenantid);                    
                        var_dump($documentdata['result']);*/
                        
			/*$documentdata['result'] = $g1->get_mongodb->tenantDocuments($tenantid);
                        foreach ($documentdata as $docvalue) {
                            foreach ($docvalue as $value) {
                                var_dump($value);
                            if(array_key_exists('Comments',$value))
                            {
                                foreach ($value['Comments'] as $svalue) {
                                    var_dump($svalue);
                                }
                            }
                            }
                            
                        }*/
                        
    
			

/*$connection = new MongoClient();
   echo "Connection to database successfully";
   echo "\n";
   // select a database
   $db = $connection->DMSTree;
   
   // select a collection:
    $collection = $db->DocumentMetaData;
    $wheredoc = array("TenantId" => "1");
    $cursor = $collection->find($wheredoc);
    foreach ($cursor as $value) {
     var_dump( $value );
}*/
                        
/*
 echo $ttid;
            $wheredocs = array("TenantId" => $ttid);
            //print_r($wheredocs);
            //$documentsquery =$this->cimongo->get_where($collection ,);
            $documentsquery = $this->cimongo->where($wheredocs)->get('DocumentMetaData');
            $documentsqueryresult = $documentsquery->result_array();
            $documentsquery_row = $documentsquery->num_rows();
            if($documentsquery_row > 0)
                return $documentsqueryresult;
            else {
                return 0;
            }
 */                        
   
?>