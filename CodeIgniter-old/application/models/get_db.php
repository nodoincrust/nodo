<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Get_db extends CI_Model {
	function getAll()
	{
            $query = $this->db->query("select * from users");
            return $query->result();
	}
 
}
?>