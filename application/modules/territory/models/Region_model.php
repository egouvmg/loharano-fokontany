<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Region_model extends CI_Model
{
	private $_table = "region";
	private $_district = 'district';

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

	public function get_region_district($criteria = array()){
		$this->db->select('region.*');
		$this->db->from($this->_table);
		$this->db->join($this->_district, 'district.region_id = region.id');
		if(!empty($criteria)){
			$this->db->where($criteria);
		}
		$query = $this->db->get();
		return $query->result();
	}

}