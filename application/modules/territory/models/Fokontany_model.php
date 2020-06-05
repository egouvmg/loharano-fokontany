<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Fokontany_model extends CI_Model
{
	private $_table = "fokontany";
	private $_fokontany_register = "fokontany_register";
	private $_inputs = "inputs";
	private $_users = "users";

	private $_common = "common";
	private $_district = 'district';
	private $_region = 'region';

	private $_v_fokontany_register = "v_fokontany_register";
	private $_v_companyFokontanyRegister = "v_companyFokontanyRegister";

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

	public function get_fokontany_register($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_v_fokontany_register);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}
		
		$query = $this->db->get();

		return $query->result();
	}

	public function get_fokontany_register_one($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_fokontany_register);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}
		
		$query = $this->db->get();

		return ($query->num_rows() > 0) ? $query->first_row() : false;
	}

	public function insert_fk_register($data) {
		$this->db->insert($this->_fokontany_register, $data);
		return $this->db->insert_id(); 
	}
	/**
	 * get fokontany by user id
	 */
	public function get_fokontany_user_id(){
		$this->db->select('*');
		$this->db->from($this->_table);

		$this->db->join($this->_inputs, $this->_inputs.'.fokontany_id ='. $this->_table .'.id');
		$this->db->join($this->_users, $this->_users.'.company_id ='. $this->_inputs .'.company_id');
		
		$user = $this->session->user_id;
		
		$this->db->where('users.id', $user);
		
		$query = $this->db->get();
		
		return $query ->result();
	}

	/**
	 * get fokontany by id
	 */
	public function get_fokotany_by_id($id = 0){
		$this->db->select('*');
		$this->db->from($this->_table);

		if(!empty($id)){
			$this->db->where('id', $id);
		}

		$query = $this->db->get();
		
		return $query ->result();
	}

	public function get_all_fokontany_id_in_acompany() {
		$this->db->select('fokontany_id');
		$this->db->from($this->_v_companyFokontanyRegister);
		
		$query = $this->db->get();

		return $query->result();
	}

	public function get_number_of_fokontany(){
		$this->db->select('COUNT(id)  as number_of_fokontany');
		$this->db->from($this->_table);

		$query = $this->db->get();

		return ($query->num_rows() > 0) ? $query->first_row()->number_of_fokontany : false;
	}

	public function get_fokontany_treaty_by_id($id_fokontany = 0){
		$this->db->select('fokontany.name as fokontany_name, common.name as common_name, district.name as district_name, region.name as region_name');
		$this->db->from($this->_table);
		$this->db->join($this->_common, $this->_table.'.common_id = '.$this->_common.'.id');
		$this->db->join($this->_district, $this->_common.'.district_id = '.$this->_district.'.id');
		$this->db->join($this->_region, $this->_district.'.region_id = '.$this->_region.'.id');
		if(!empty($id_fokontany)){
			$this->db->where($this->_table.'.id', $id_fokontany);
		}

		$query = $this->db->get();

		return $query->result();
	}


}
