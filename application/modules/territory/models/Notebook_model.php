<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notebook_model extends CI_Model
{
	private $_table = "carnet_fokontany";
	private $_v_notebook_citizen = "v_notebook_citizen";

	public function __construct(){      
        $this->load->database();
    }

	public function all($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_table);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}
		
		$query = $this->db->get();

		return $query->result();
	}

	public function one($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_table);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}
		
		$query = $this->db->get();

		return  ($query->num_rows() > 0) ? $query->first_row() : false;
	}

	public function citizens($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_v_notebook_citizen);
		
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
}
