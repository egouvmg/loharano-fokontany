<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth
*
* Author: Ben Edmunds
*		  ben.edmunds@gmail.com
*         @benedmunds
*
* Added Awesomeness: Phil Sturgeon
*
* Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
*
* Created:  10.01.2009
*
* Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
* Original Author name has been kept but that does not mean that the method has not been modified.
*
* Requirements: PHP5 or above
*
*/

class EGMAuth
{
	/**
	 * account status ('not_activated', etc ...)
	 *
	 * @var string
	 **/
	protected $status;

	/**
	 * extra where
	 *
	 * @var array
	 **/
	public $_extra_where = array();

	/**
	 * extra set
	 *
	 * @var array
	 **/
	public $_extra_set = array();

	/**
	 * caching of users and their groups
	 *
	 * @var array
	 **/
	public $_cache_user_in_group;

	/**
	 * __construct
	 *
	 * @author Ben
	 */
	public function __construct()
	{
		$this->load->model('auth/auth_model', 'auth');
		$this->config->load('egmauth', TRUE);
	}

	/**
	 * __get
	 *
	 * Enables the use of CI super-global without having to define an extra variable.
	 *
	 * I can't remember where I first saw this, so thank you if you are the original author. -Militis
	 *
	 * @access	public
	 * @param	$var
	 * @return	mixed
	 */
	public function __get($var)
	{
		return get_instance()->$var;
    }
    
    /**
	 * is_superadmin
	 *
	 **/
	public function is_superadmin($id=false)
	{
		$_group = $this->config->item('superadmin_group', 'egmauth');

		return $this->in_group($_group, $id);
    }
    
	/**
	 * is_admin
	 *
	 **/
	public function is_admin($id=false)
	{
		$_group = $this->config->item('admin_group', 'egmauth');

		return $this->in_group($_group, $id);
    }
    
	/**
	 * is_chief
	 *
	 **/
	public function is_chief($id=false)
	{
		$_group = $this->config->item('chief_group', 'egmauth');

		return $this->in_group($_group, $id);
    }
    
	/**
	 * is_operator
	 *
	 **/
	public function is_operator($id=false)
	{
		$_group = $this->config->item('operator_group', 'egmauth');

		return $this->in_group($_group, $id);
    }
    
	/**
	 * in_group
     * 
	 **/
	public function in_group($check_group, $id)
	{
        $is_in = FALSE;

		$id = ($id) ? $id : (int) $this->session->user_id;
		
		$group_id = $this->auth->group($id);

		if($check_group == $group_id) $is_in = TRUE;
        
        return $is_in;
	}
}
