<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Chief_model extends CI_Model
{
	private $_user = "user";
	private $_v_user_group = "v_user_group";
	private $_v_user_borough = "v_user_borough";

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

	public function getUsersBorough($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_v_user_borough);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}
		
		$query = $this->db->get();

		return $query->result();
	}

	public function getUserBorough($id = 0) {
		$this->db->select('*');
		$this->db->from($this->_v_user_borough);
		
		$this->db->where(['user_id' => $id]);
		
		$query = $this->db->get();

		return $query->first_row();
	}

}
