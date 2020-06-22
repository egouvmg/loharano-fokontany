<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Citizen_model extends CI_Model
{
	private $_table = "personne";
	private $_v_certificate = "v_certificate";

	public function __construct(){      
        $this->load->database();
    }

	public function get($criteria = array()) {
		$this->db->select('cin_personne, id_personne, nom, prenoms, to_char(date_de_naissance, \'dd/mm/yyyy\') as date_de_naissance	, lieu_de_naissance, date_delivrance_cin, lieu_delivrance_cin, handicape, situation_matrimoniale, qr_code, numero_carnet, father, mother, father_status, mother_status, job_id, job_status, job_other, sexe, phone, nationality_id, passport, passport_date, passport_place, chef_menage');
		$this->db->from($this->_table);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}
		
		$query = $this->db->get();

		return $query->result();
	}

	public function insert($data) {
		$this->db->insert($this->_table, $data);
		return $this->db->insert_id();
	}

	public function update($data) {
		$id_personne = $data["id_personne"];
		$this->db->where('id_personne', $id_personne);
		unset($data["id_personne"]);
		$this->db->update($this->_table, $data);
		return $id_personne;
	}
	
	public function load($data) {
		return $this->db->insert_batch($this->_table, $data);
	}

	public function get_citizen($criteria = array()){
		$this->db->select('cin_personne, id_personne, nom, prenoms, to_char(date_de_naissance, \'dd/mm/yyyy\') as date_de_naissance	, lieu_de_naissance, date_delivrance_cin, lieu_delivrance_cin, handicape, situation_matrimoniale, qr_code, numero_carnet, father, mother, father_status, mother_status, job_id, job_status, job_other, sexe, phone, nationality_id, passport, passport_date, passport_place, chef_menage');
		$this->db->from($this->_table);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}
	
		$this->db->order_by('nom', 'asc');
		
		$query = $this->db->get();
	
		return $query->result();
	}

	public function get_citizen_certificate($criteria = array()){
		$this->db->select('*');
		$this->db->from($this->_v_certificate);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}
	
		$this->db->order_by('nom', 'asc');
		
		$query = $this->db->get();
	
		return $query->result();
	}

}
