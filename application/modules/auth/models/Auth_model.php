<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model
{
	public function login($identity, $password)
	{

		if (empty($identity) || empty($password))
		{
			$this->set_error('login_unsuccessful');
			return FALSE;
		}

		// $options = [
		// 	'cost' => 12,
		// ];

		// $crypted_pwd = password_hash($password, PASSWORD_DEFAULT, $options);

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
}