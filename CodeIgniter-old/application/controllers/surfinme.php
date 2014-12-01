class surfinme extends CI_Controller{
     
    public function __construct()
	{
         parent::__construct();
         //loading  the mongodb library
         $this->load->library('mongo_db');
    }
 
   //index where the controller starts
    public function index() 
	{
        //connect to mongodb collection (i.e., table) named as ‘surfinme_index’
        $collection = $this->mongo_db->db->selectCollection('surfinme_index');
       	//selecting records from the collection - surfinme_index
       	$result=$collection->find();
        foreach($result as $data) 
		{  
          //display the records  
          var_dump($data);
        } 
    }
 
}