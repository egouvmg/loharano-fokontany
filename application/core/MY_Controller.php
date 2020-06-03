<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	public $data;
	
	public function __construct()
	{
		parent::__construct();

		$language = ($this->session->site_lang) ? $this->session->site_lang : $this->config->item('language');
		
		$this->session->set_userdata('site_lang', $language);

		$this->lang->load('auth', $language);
	}
}

/**
 * SuperAdmin Controller
 */
class SuperAdmin_Controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		if(!$this->egmauth->is_superadmin())
			redirect('/', 'refresh');
	}
}

/**
 * Admin Controller
 */
class Admin_Controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		if(!$this->egmauth->is_admin())
			redirect('/', 'refresh');
	}
}

/**
 * Chief Controller
 */
class Chief_Controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		if(!$this->egmauth->is_chief())
			redirect('/', 'refresh');
		
	}
}

/**
 * Operator Controller
 */
class Operator_Controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		if(!$this->egmauth->is_operator())
			redirect('/', 'refresh');
		
	}
}

