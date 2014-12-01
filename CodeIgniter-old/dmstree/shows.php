<?php  

class CI_Mongo extends Mongo
{
    var $db;

    function CI_Mongo()
    {   
        // Fetch CodeIgniter instance
        $ci = get_instance();
        // Load Mongo configuration file
        $ci->load->config('mongo');

        // Fetch Mongo server and database configuration
        $server = $ci->config->item('mongo_server');
        $dbname = $ci->config->item('mongo_dbname');

        // Initialise Mongo
        if ($server)
        {
            parent::__construct($server);
        }
        else
        {
            parent::__construct();
        }
        $this->db = $this->$dbname;
    }
}

$config['mongo_host'] = 'localhost';
$config['mongo_port'] = 27017;
$config['mongo_server'] = null;
$config['mongo_dbname'] = 'mydb';
$config['mongo_user'] = '';
$config['mongo_pass'] = '';


$dbhost = $config['mongo_host'];  
$dbname = $config['mongo_dbname'];  
  
// Connect to test database  
$m = new Mongo("mongodb://$dbhost");  
$db = $m->$dbname;

$collection = $db->shows;  
  
// pull a cursor query  
$cursor = $collection->find();  
  
  foreach($cursor as $document) {  
 var_dump($document);  
}  
?>  