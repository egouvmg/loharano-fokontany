<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_model extends CI_Model
{
    private $_table = "migration_citizen";
    
    private $_v_migration_citizen = "v_migration_citizen";

	public function __construct(){      
        $this->load->database();
    }

	public function all($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_table);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}

        $this->db->order_by('created_on', 'desc');
		
		$query = $this->db->get();

		return $query->result();
	}

	public function all_details($criteria = array()) {
		$this->db->select('*');
		$this->db->from($this->_v_migration_citizen);
		
		if(!empty($criteria)){
			$this->db->where($criteria);
		}

        $this->db->order_by('date_migration', 'desc');
		
		$query = $this->db->get();

		return $query->result();
	}

	public function insert($data) {
		return $this->db->insert($this->_table, $data);
	}
}
