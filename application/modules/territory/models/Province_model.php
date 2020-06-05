<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Province_model extends CI_Model
{
	private $_table = "province";
	private $_region = 'region';

	public function __construct(){      
        $this->load->database();
    }

	public function get_all($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_table);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}
		
		$query = $this->db->get();

		return $query->result();
	}

	public function get_ids() {
		$this->db->select('id');
		$this->db->from($this->_table);
		
		$query = $this->db->get();

		$this->db->order_by('name', 'asc');

		return $query->result();
	}

	public function get_names() {
		$this->db->select('name');
		$this->db->from($this->_table);
		
		$query = $this->db->get();

		$this->db->order_by('name', 'asc');

		return $query->result();
	}
	public function get_province_region($criteria = array()){
		$this->db->select('province.*');
		$this->db->from($this->_table);
		$this->db->join($this->_region, 'region.province_id = province.id');
		if(!empty($criteria)){
			$this->db->where($criteria);
		}
		$query = $this->db->get();
		return $query->result();
	}

}