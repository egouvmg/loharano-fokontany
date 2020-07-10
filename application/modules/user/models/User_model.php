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

	public function getUserFokontany($id = 0) {
		$this->db->select('*');
		$this->db->from($this->_v_user_fokontany);
		
		$this->db->where(['user_id' => $id]);
		
		$query = $this->db->get();

		return $query->first_row();
	}

	public function update($data) {
		$email = $data["email"];
		$this->db->where('email', $email);

		unset($data["email"]);
		
		return $this->db->update($this->_user, $data);
	}
}
