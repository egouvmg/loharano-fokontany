<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Territory_model extends CI_Model
{
	private $_fokontany = "fokontany";
	private $_district = "district";
	private $_common = "common";
	private $_region = "region";
	private $_province = "province";
	

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

	public function get_name_by_fokotany($id= 0) {
		$this->db->select($this->_fokontany.'.name fname,'. $this->_district.'.name dname,'. $this->_common.'.name cname,'.$this->_region.'.name rname,'. $this->_province.'.name pname');
		$this->db->from($this->_fokontany);
		$this->db->join($this->_common, $this->_common.".id = ".$this->_fokontany.".common_id");
		$this->db->join($this->_district, $this->_district.".id = ".$this->_common.".district_id");
		$this->db->join($this->_region, $this->_region.".id = ".$this->_district.".region_id");
		$this->db->join($this->_province, $this->_province.".id = ".$this->_region.".province_id");

		$this->db->where($this->_fokontany.".id", $id);
		
		$query = $this->db->get();

		return  ($query->num_rows() > 0) ? $query->first_row() : false;
	}
}