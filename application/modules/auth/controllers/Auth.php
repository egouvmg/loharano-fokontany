<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {
	public $data;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('auth_model', 'auth');
	}

	// redirect if needed, otherwise display the user list
	public function index()
	{
		if ($this->egmauth->is_superadmin())
		{
			redirect('tableau_de_bords', 'refresh');
		}
		else if ($this->egmauth->is_admin())
		{
			echo 'Admin';
		}
		else if ($this->egmauth->is_chief())
		{
			echo 'Chief';
		}
		else if ($this->egmauth->is_operator())
		{
			redirect('gestion_citoyens', 'refresh');
		}
		else redirect('se_connecter', 'refresh');
	}

	public function login(Type $var = null)
	{
		$this->data['title'] = $this->lang->line('login_heading');

		//validate form input
		$this->form_validation->set_rules('email', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

		if ($this->form_validation->run() == true)
		{
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool) $this->input->post('remember');
			$email = $this->input->post('email');
			$pwd = $this->input->post('password');

			if($this->auth->login($email, $pwd))
				redirect('/', 'refresh');
			else{
				$this->session->set_flashdata('message', 'Erreur de connexion.');
				redirect('se_connecter', 'refresh');
			}
		}
		else
		{
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['identity'] = array('name' => 'email',
				'id'    => 'email',
				'class' => 'form-control',
				'placeholder' => $this->lang->line('index_email_th'),
				'type'  => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['password'] = array('name' => 'password',
				'id'   => 'password',
				'class' => 'form-control',
				'placeholder' => $this->lang->line('login_password_label'),
				'type' => 'password',
			);

			$this->load->view('login', $this->data);
		}
	}	

	// log the user out
	public function logout()
	{
		$this->data['title'] = "Déconnexion encours ...";

		// redirect them to the login page
		$this->session->sess_destroy();
		redirect('se_connecter', 'refresh');
	}

	public function change_language()
	{
		if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
		}
		
		$lang = $this->input->post('lang');

		if($lang){
			$this->session->set_userdata('site_lang',$lang);
			echo json_encode(['success' => 1]);
		}
		else echo json_encode(['error' => 1]);
	}
}
