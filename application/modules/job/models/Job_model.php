<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Job_model extends CI_Model
{
	private $_job = "job";

	public function __construct(){      
        $this->load->database();
    }

	public function all($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_job);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}

		$this->db->order_by('name', 'asc');
		
		$query = $this->db->get();

		return $query->result();
	}
}
