<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller{
 
    public function __construct(){
 
        parent::__construct();
    }
 
  //index of our controller
    function index() {
		$data['title']="Mongo Database connection";
		
			$this->load->library("cimongo/cimongo");
			//$this->load->config('mongo_db');
			//load the mongodb library
			//$this->load->library('mongo_db');
			//connect to mongodb collection named as 'category' using our mongodb library
			//$collection = $this->cimongo->db->selectCollection('users');
              
				$this->load->model('get_mongodb');
				$g1 = new Get_mongodb(); 
				//$data['result'] = $this->get_mongodb->getAll();
				$data['result'] = $g1->get_mongodb->getAll();
			//fetch the record from that collection
			// $data=$collection->find();
			// foreach($result as $document) {  
            //display the records  
				// var_dump($document);
			//    } 
       
			$this->load->view("view_mongodb",$data);
    }
 
    // Add this method to allow file download from the DB response
    public function download_pdf_from_db() {
        // Normally, you would fetch this from the DB, but here we use the static value from your JSON
        $base64 = 'JVBERi0xLjQKJdPr6eEKMSAwIG9iago8PC9UaXRsZSAoQVQzMEsgVGVsbmV0IENvbm5lY3Rpb24gR3VpZGUpCi9DcmVhdG9yIChNb3ppbGxhLzUuMCBcKFdpbmRvd3MgTlQgMTAuMDsgV2luNjQ7IHg2NFwpIEFwcGxlV2ViS...'; // (truncated for brevity)
        $filename = 'AT30K_Telnet_Connection_Guide_0_0.pdf';
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo base64_decode($base64);
        exit;
    }
}
?>