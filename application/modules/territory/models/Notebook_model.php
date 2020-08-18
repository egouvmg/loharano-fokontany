<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notebook_model extends CI_Model
{
	private $_table = "carnet_fokontany";
	private $_v_notebook_citizen = "v_notebook_citizen";
	private $_v_household_count = "v_household_count";

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

	public function searchOne($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_v_notebook_citizen);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
			$query = $this->db->get();
	
			return  ($query->num_rows() > 0) ? $query->first_row() : false;
		}
		return false;
	}

	public function citizens($criteria = array(), $order_by = '', $direction = 'ASC') {
		$this->db->select('*');
		$this->db->from($this->_v_notebook_citizen);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}

		if(!empty($order_by)){
			$this->db->order_by($order_by, $direction);
		}
		
		$query = $this->db->get();

		return $query->result();
	}

	public function citizensPerPage($criteria = array(), $offset, $limit = 15, $order = []) {
		$this->db->select('*');
		$this->db->from($this->_v_notebook_citizen);
		
		if(!empty($criteria)) $this->db->where($criteria);
		if(!empty($order)) $this->db->order_by($order[0], $order[1]);
		
		$this->db->limit($limit, $offset);
		
		$query = $this->db->get();

		return $query->result();
	}

	public function citizen($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_v_notebook_citizen);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}
		
		$query = $this->db->get();
		return  ($query->num_rows() > 0) ? $query->first_row() : false;
	}

	public function household_count($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_v_household_count);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}
		
		$query = $this->db->get();

		return  ($query->num_rows() > 0) ? $query->first_row() : false;
	}

	public function household_sum($criteria = array()) {
		$this->db->select('SUM(household_count) AS household_count');
		$this->db->from($this->_v_household_count);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}
		
		$query = $this->db->get();

		return  ($query->num_rows() > 0) ? $query->first_row() : false;
	}

	public function households_count($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_v_household_count);
		
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
