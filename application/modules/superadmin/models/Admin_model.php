<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model
{
	private $_inputs = "inputs";
	private $_users = "users";
	private $_users_groups = "users_groups";
	private $_company = "company";
	private $_fokontany = "fokontany";
	private $_common = "common";
	private $_district = 'district';
	private $_region = 'region';
	private $_fokontany_register = "fokontany_register";
	private $_person = "person";

	private $_v_companyregister = "v_companyregister";
	private $_v_companyFokontanyRegister = "v_companyFokontanyRegister";
	private $_v_companyaccount = "v_companyaccount";
	private $_v_avg_company = "v_avg_company";

	public function __construct(){      
        $this->load->database();
    }

	public function save_company_fokontany($data) {
		$this->db->insert($this->_inputs, $data);
		return $this->db->insert_id();
	}

	public function avg_company($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_v_avg_company);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}
		
		$query = $this->db->get();

		return  ($query->num_rows() > 0) ? $query->first_row() : false;
	}

	public function get_all($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_v_companyregister);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}

		$this->db->order_by('company_name', 'asc');
		
		$query = $this->db->get();

		return $query->result();
	}

	public function get_companyaccount($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_v_companyaccount);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}
		
		$query = $this->db->get();

		return $query->result();
	}

	public function get_company_fokontany($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_v_companyFokontanyRegister);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}

		$this->db->order_by('fokontany_name', 'asc');
		
		$query = $this->db->get();

		return $query->result();
	}

	public function delete($criteria = array())
	{
		return $this->db->delete($this->_inputs, $criteria);
	}

	
	public function edit_user($criteria = '', $data = array()) {
		return $this->db->update_batch($this->_users, $data, $criteria);
	}

	public function get_number_fokontany($id_company = 0) {
		$this->db->select('COUNT(fokontany_id) as number_fokotany');
		$this->db->from($this->_inputs);

		if(!empty($id_company))
			$this->db->where('company_id', $id_company);
		
		$query = $this->db->get();

		return  ($query->num_rows() > 0) ? $query->first_row()->number_fokotany : false;
	}

	public function get_allIdFokontanyCompany($id_company = 0) {
		$this->db->select('fokontany_id as fokontany_id');
		$this->db->from($this->_inputs);

		if(!empty($id_company))
			$this->db->where('company_id', $id_company);
		
		$query = $this->db->get();

		return $query->result();
	}

	public function get_number_people_fokontany($id_fokontany = 0){
		$this->db->select('people as number_people');
		$this->db->from($this->_fokontany_register);
		if(!empty($id_fokontany)){
			$this->db->where('fokontany_id', $id_fokontany);
		}

		$query = $this->db->get();

		return ($query->num_rows() > 0) ? $query->first_row()->number_people: false;
	} 

	public function count_person_treated_fokontany($id_fokontany = 0){
		$this->db->select('COUNT(id) as number_person');
		$this->db->from($this->_person);
		if(!empty($id_fokontany)){
			$this->db->where('fokontany_id', $id_fokontany);
		}

		$query = $this->db->get();

		return ($query->num_rows() > 0) ? $query->first_row()->number_person: false;
	}

}
