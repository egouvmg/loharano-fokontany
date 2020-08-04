<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Certificate_model extends CI_Model
{
	private $_historique_certificat = "historique_certificat";
	private $_v_insight = "v_insight";

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

	public function nbrCertificats($criteria = array()) {
		$this->db->select("*");
		$this->db->from($this->_v_insight);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
        }
		
		$query = $this->db->get();

		return $query->result();
	}

	public function totalCertificats($criteria = array()) {
		$this->db->select("SUM(nbr_certificate) AS nbr_certificate, ref_certificate, certificate, month_year");
		$this->db->from($this->_v_insight);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
        }
		$this->db->group_by(['ref_certificate', 'certificate', 'month_year']);
		$query = $this->db->get();

		return $query->result();
	}


}
