<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Borough_model extends CI_Model
{
	private $_table = "borough";
	private $_fokontany = 'fokontany';

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
	public function get_common_fokontany($criteria = array()){
		$this->db->select('borough.*');
		$this->db->from($this->_table);
		$this->db->join($this->_fokontany, $this->_fokontany.'.borough_id = '.$this->_table.'.id');
		if(!empty($criteria)){
			$this->db->where($criteria);
		}
		$query = $this->db->get();
		return $query->result();
	}

}