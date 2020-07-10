<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model
{
	private $_audit = "audit";

	public function __construct(){      
        $this->load->database();
    }

	public function login($identity, $password)
	{

		if (empty($identity) || empty($password))
		{
			$this->set_error('login_unsuccessful');
			return FALSE;
		}

		$query = $this->db->select('email, id, password, active, first_name, last_name')
		                  ->where('email', $identity)
		                  ->limit(1)
		    			  ->order_by('id', 'asc')
						  ->get('user');	

		if ($query->num_rows() === 1)
		{
			$user = $query->row();

			if($user->active){
				if(password_verify($password, $user->password)){
					$data = [
						'user_id' => $user->id,
						'user_name' => $user->first_name.' '.$user->last_name,
					];

					$this->session->set_userdata($data);
					
					/**
					 * Audit login
					 *   */
					$this->login_audit();

					return TRUE;
				}
			}
		}

		return FALSE;
	}
	
	public function group($id=0)
	{
		$query = $this->db->select('*')
		                  ->where('user_id', $id)
		                  ->limit(1)
						  ->get('user_group');	

		if ($query->num_rows() === 1)
			return $query->row()->group_id;

		return 0;
	}
	

	/**
	 * Audit login
	 *   */

	public function login_audit() {
		$data = [
			'user' => $this->session->user_id. '-' .$this->session->user_name,
			'action' => 'LOGIN',
			'data' => '',
			'old_data' => ''
		];

		return $this->db->insert($this->_audit, $data);
	}

	public function logout_audit() {
		$data = [
			'user' => $this->session->user_id. '-' .$this->session->user_name,
			'action' => 'LOGOUT',
			'data' => '',
			'old_data' => ''
		];

		return $this->db->insert($this->_audit, $data);
	}
}