<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin extends SuperAdmin_Controller
{
	public function __construct(){
        parent::__construct();
	}

	public function index()
	{
		$this->data['title'] = "Tableau de bords";
        $this->load->view('index', $this->data);
	}

	public function add_user()
	{
		$this->data['title'] = "Ajout d'un Utilisateur";
        $this->load->view('add_user', $this->data);
	}

	public function add_chief()
	{
		$this->data['title'] = "Ajout d'un Chef fokontany";
        $this->load->view('add_chief', $this->data);
	}
}

