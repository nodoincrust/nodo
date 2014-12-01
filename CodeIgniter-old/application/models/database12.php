
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	
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
            $collection = $this->mongo_db->db->selectCollection('users');
            //selecting records from the collection - surfinme_index
            $result=$collection->find();
            foreach($result as $data) 
                    {  
            //display the records  
            var_dump($data);
            } 
            $this->load->view("view_mongodb",$data);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
//	public function index()
//	{
//            $this->home();
//            $this->getValues();
//              $this->getMongoValues();
//                $this->load->view('view_home');
//		$this->load->view('welcome_message');
//	}
//        public function home()
//        {
//            $data['title'] = 'Home';
//            $data['val1'] = '2';
//            $data['val2'] = '8';
//
//            $this->load->model("math");
//            $data['addTotal']=  $this->math->add($data['val1'],$data['val2']);
//            $data['subTotal']= $this->math->sub($data['val1'],$data['val2']);
//
//            $this->load->view("view_home",$data);
//        }
//        public function getValues()
//        {
//            $data['title']="Database connection";
//            $this->load->model("get_db");
//            $data['result'] = $this->get_db->getAll();
//            $this->load->view("view_db",$data);
//        }
//        public function getMongoValues()
//        {
//            $this->load->library('Mongo_db');
//            $data['title']="Mongo Database connection";
//            $this->load->model("get_mongodb");
//            $data['result'] = $this->get_db->getAll();
//            $this->load->view("view_mongodb",$data);
//        }
//        
        
        