<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Department extends CI_Model {
public $first_nm ;
public $gender;
public $depart_nm;
//public $userrole[];

	function getDepartment()
	{
		$query = $this->cimongo->get('user');
			$result = $query->result();
			return $result ;
	}
}
?>