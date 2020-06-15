<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Citizen_model extends CI_Model
{
	private $_table = "personne";

	public function __construct(){      
        $this->load->database();
    }

	public function get($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_table);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}
		
		$query = $this->db->get();

		return $query->result();
	}

	public function insert($data) {
		$this->db->insert($this->_table, $data);
		return $this->db->insert_id();
	}

	public function load($data) {
		return $this->db->insert_batch($this->_table, $data);
	}

}
