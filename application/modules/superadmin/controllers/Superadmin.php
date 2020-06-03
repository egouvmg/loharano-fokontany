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
}

