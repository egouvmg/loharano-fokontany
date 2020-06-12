<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Nationality_model extends CI_Model
{
	private $_nationality = "nationality";

	public function __construct(){      
        $this->load->database();
    }

	public function all($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_nationality);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}

		$this->db->order_by('id', 'asc');
		
		$query = $this->db->get();

		return $query->result();
	}
}
