<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Certificate_model extends CI_Model
{
	private $_historique_certificat = "historique_certificat";

	public function __construct(){      
        $this->load->database();
    }

	public function historique_certificat($criteria = array()) {
		$this->db->select("id, to_char(date_generation, 'dd/MM/yyyy') as date_generation, motif, id_personne");
		$this->db->from($this->_historique_certificat);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
        }
        
        $this->db->order_by('date_generation', 'desc');
		
		$query = $this->db->get();

		return  ($query->num_rows() > 0) ? $query->first_row() : false;
	}

	public function historiques_certificats($criteria = array()) {
		$this->db->select("id, to_char(date_generation, 'dd/MM/yyyy') as date_generation, motif, id_personne");
		$this->db->from($this->_historique_certificat);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
        }
        
        $this->db->order_by('date_generation', 'desc');
		
		$query = $this->db->get();

		return $query->result();
	}
}
