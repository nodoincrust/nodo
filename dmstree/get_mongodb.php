<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Get_mongodb extends CI_Model {

	public $name;
	public $project;
	function getAll()
	{
           // $query = $this->cimongo->collfindOne('users');
		   //$query = $this->cimongo->get_where('user', array($field => 'name'));
		   
           // $result = $query->num_rows();
            
            //return $result;
			//$str1 = "connection successfully";
			
			$query = $this->cimongo->get('users');
			$result = $query->result();
			return $result ;
	}
 
}
?>