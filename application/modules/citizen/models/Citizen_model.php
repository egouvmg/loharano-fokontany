<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Citizen_model extends CI_Model
{
	private $_table = "personne";
	private $_v_certificate = "v_certificate";

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

	public function get_citizen($criteria = array()){
		$this->db->select('*');
		$this->db->from($this->_table);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}
	
		$this->db->order_by('nom', 'asc');
		
		$query = $this->db->get();
	
		return $query->result();
	}

	public function get_citizen_certificate($criteria = array()){
		$this->db->select('*');
		$this->db->from($this->_v_certificate);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}
	
		$this->db->order_by('nom', 'asc');
		
		$query = $this->db->get();
	
		return $query->result();
	}

}