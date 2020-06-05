<?php defined('BASEPATH') OR exit('No direct script access allowed');

class District_model extends CI_Model
{
	private $_table = "district";
	private $_common = 'common';
	

	public function __construct(){      
        $this->load->database();
    }

	public function get_all($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_table);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}

		$this->db->order_by('name', 'asc');
		
		$query = $this->db->get();

		return $query->result();
	}

	public function get_district_common($criteria = array()){
		$this->db->select('district.*');
		$this->db->from($this->_table);
		$this->db->join($this->_common, $this->_common.'.district_id = '.$this->_table.'.id');
		if(!empty($criteria)){
			$this->db->where($criteria);
		}
		$query = $this->db->get();
		return $query->result();
	}

}