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
 
}
?>