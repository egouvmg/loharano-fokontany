<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin extends SuperAdmin_Controller
{
	public function __construct(){
		parent::__construct();
		
		$this->load->model('territory/province_model', 'province');
		$this->load->model('territory/region_model', 'region');
		$this->load->model('territory/district_model', 'district');
		$this->load->model('territory/common_model', 'common');
		$this->load->model('territory/borough_model', 'borough');
		$this->load->model('territory/fokontany_model', 'fokontany');

	}

	public function index()
	{
		$this->data['title'] = "Tableau de bords";
        $this->load->view('index', $this->data);
	}

	public function add_user()
	{
		$this->data['title'] = "Ajout d'un Utilisateur";

        $this->data['provinces'] = $this->province->get_all();
        $this->data['regions'] = $this->region->get_all(['province_id' => $this->data['provinces'][0]->id]);
        $this->data['districts'] = $this->district->get_all(['region_id' => $this->data['regions'][0]->id]);
		$this->data['commons'] = $this->common->get_all(['district_id' => $this->data['districts'][0]->id]);
		$this->data['boroughs'] = $this->borough->get_all(['common_id' => $this->data['commons'][0]->id]);
		$this->data['fokontanies'] = $this->fokontany->get_all(['borough_id' => $this->data['boroughs'][0]->id]);
		
        $this->load->view('add_user', $this->data);
	}

	public function add_chief()
	{
		$this->data['title'] = "Ajout d'un Chef fokontany";

        $this->data['provinces'] = $this->province->get_all();
        $this->data['regions'] = $this->region->get_all(['province_id' => $this->data['provinces'][0]->id]);
        $this->data['districts'] = $this->district->get_all(['region_id' => $this->data['regions'][0]->id]);
		$this->data['commons'] = $this->common->get_all(['district_id' => $this->data['districts'][0]->id]);
		$this->data['boroughs'] = $this->borough->get_all(['common_id' => $this->data['commons'][0]->id]);
		$this->data['fokontanies'] = $this->fokontany->get_all(['borough_id' => $this->data['boroughs'][0]->id]);

        $this->load->view('add_chief', $this->data);
	}
}

