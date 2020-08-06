<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Aid_model extends CI_Model
{
	private $_table = "aid";
	private $_household_aid = "household_aid";
	private $_carnet_fokontany = "carnet_fokontany";
	private $_personne = "personne";

	private $_v_household_aid = "v_household_aid";
	private $_v_household_chief_aid = "v_household_chief_aid";
	private $_v_insight_aid = "v_insight_aid";

	public function __construct(){      
        $this->load->database();
    }

	public function insert($data) {
		$this->db->insert($this->_table, $data);
		return $this->db->insert_id();
	}

	public function update($data) {
		$id = $data["id"];

		$this->db->where('id', $id);
		unset($data["id"]);
		
		return $this->db->update($this->_table, $data);
	}

	public function save_household_aid($data) {
		return $this->db->insert($this->_household_aid, $data);
	}

	public function one($criteria = array()) {
		$this->db->select("id, name, type, description, to_char(created_on, 'dd/MM/yyyy') as created_on");
		$this->db->from($this->_table);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}
		
		$query = $this->db->get();

		return  ($query->num_rows() > 0) ? $query->first_row() : false;
	}

	public function all($criteria = array()) {
		$this->db->select("id, name, type, description, to_char(created_on, 'dd/MM/yyyy') as created_on");
		$this->db->from($this->_table);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}

		$this->db->order_by('name', 'asc');
		
		$query = $this->db->get();

		return $query->result();
	}

	public function household_aids($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_v_household_aid);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}

		$this->db->order_by('created_on', 'desc');
		
		$query = $this->db->get();

		return $query->result();
	}

	public function household_chief_aids($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_v_household_chief_aid);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}
		
		$query = $this->db->get();

		return $query->result();
	}

	public function householdAidsPerPage($criteria = array(), $offset, $limit = 15) {
		$this->db->select('*');
		$this->db->from($this->_v_household_aid);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}

		$this->db->order_by('numero_carnet', 'asc');
		$this->db->limit($limit, $offset);
		
		$query = $this->db->get();

		return $query->result();
	}
	
	public function householdChiefAidsPerPage($criteria = array(), $offset, $limit = 15) {
		$this->db->select('*');
		$this->db->from($this->_v_household_chief_aid);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}

		$this->db->order_by('chief_name', 'asc');
		$this->db->limit($limit, $offset);
		
		$query = $this->db->get();

		return $query->result();
	}

	public function aids($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_household_aid);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}

		$this->db->order_by('created_on', 'desc');
		
		$query = $this->db->get();

		return $query->result();
	}

	public function insight($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_v_insight_aid);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}

		$this->db->order_by('name', 'asc');
		
		$query = $this->db->get();

		return $query->result();
	}
}
