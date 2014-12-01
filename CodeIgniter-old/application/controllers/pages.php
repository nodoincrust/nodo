<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pages extends CI_Controller {

	 public function __construct(){
 
        parent::__construct();
    }
	
	public function index($page = 'home')
	{
		/*if ( ! file_exists(APPPATH.'/views/pages/'.$page.'.php'))
		{
			// Whoops, we don't have a page for that!
			show_404();
		}

		$data['title'] = ucfirst($page); // Capitalize the first letter
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		//$this->load->view('templates/footer', $data);*/
            
                $this->load->library("cimongo/cimongo");
		$this->load->model('get_mongodb');
                $g1 = new Get_mongodb();
				$data['result'] = $g1->get_mongodb->getAll();
                                $this->load->view("pages/about",$data);
	}
	
	public function viewDeparttbl()
	{
		//$data['title'] = ucfirst($page); 
		//$this->load->view('templates/header', $data);
		/*$msg['result'] = "controller-view msg";
		$this->load->view('pages/'.$page, $msg);*/
		$this->load->library("cimongo/cimongo");
		$this->load->model('get_mongodb');
				$g1 = new Get_mongodb();
				$data['result'] = $g1->get_mongodb->getAll();
		//$this->load->model('department');
		//$data['result'] = $this->department->getDepartment();
		$this->load->view("pages/about",$data);
	}
	
	/*public function viewDeparttbl()
	{
		$this->load->view("pages/about");
	}*/
}
?>