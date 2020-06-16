<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menage_model extends CI_Model
{
	private $_user = "user";
	private $_v_user_group = "v_user_group";
	private $_v_user_fokontany = "v_user_fokontany";
	private $_v_menage = "carnet_fokontany";
	private $_v_notebook_citizen = "v_notebook_citizen";

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

	public function getMenages($criteria = array()){
		$this->db->select('*');
		$this->db->from($this->_v_notebook_citizen);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}
		$this->db->where(['chef_menage' => TRUE]);
		
		$this->db->order_by('numero_carnet', 'asc');
		
		$query = $this->db->get();		

		return $query->result();
	}

}
