<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
	private $_user = "user";
	private $_v_user_group = "v_user_group";
	private $_v_user_fokontany = "v_user_fokontany";

	public function __construct(){      
        $this->load->database();
    }

	public function get($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_v_user_group);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}

		$this->db->order_by('group_name', 'asc');
		
		$query = $this->db->get();

		return $query->result();
	}

	public function getUsersFokontany($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_v_user_fokontany);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}

		$this->db->order_by('group_name', 'asc');
		
		$query = $this->db->get();

		return $query->result();
	}

}
