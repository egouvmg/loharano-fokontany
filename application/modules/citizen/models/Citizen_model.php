<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Citizen_model extends CI_Model
{
	private $_user = "user";
	private $_v_user_group = "v_user_group";
	private $_v_user_fokontany = "v_user_fokontany";
	private $_personne = "personne";

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

	public function get_citizen($criteria = array()){
		$this->db->select('*');
		$this->db->from($this->_personne);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}

		$this->db->order_by('nom', 'asc');
		
		$query = $this->db->get();

		return $query->result();
	}

}
