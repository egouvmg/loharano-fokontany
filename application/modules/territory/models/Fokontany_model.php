<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Fokontany_model extends CI_Model
{
	private $_table = "fokontany";

	private $_common = "common";
	private $_district = 'district';
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

		$this->db->order_by('name', 'asc');
		
		$query = $this->db->get();

		return $query->result();
	}
}
