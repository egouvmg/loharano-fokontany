<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menage extends SuperAdmin_Controller
{
	public function __construct(){
        parent::__construct();
        
        $this->load->model('menage_model', 'menage');
        
        //Location Models
        $this->load->model('territory/province_model', 'province');
        $this->load->model('territory/region_model', 'region');
        $this->load->model('territory/district_model', 'district');
        $this->load->model('territory/common_model', 'common');
        $this->load->model('territory/borough_model', 'borough');
        $this->load->model('territory/fokontany_model', 'fokontany');

        $this->lang->load('user', $this->session->site_lang);
		
	}

	public function index()
	{
		$this->data['title'] = "Tableau de bord";
        $this->load->view('index', $this->data);
	}

	public function list_menage()
	{
		$this->data['title'] = "Liste des Ménages";

        $this->data['provinces'] = $this->province->get_all();
        $this->data['regions'] = $this->region->get_all(['province_id' => $this->data['provinces'][0]->id]);
        $this->data['districts'] = $this->district->get_all(['region_id' => $this->data['regions'][0]->id]);
		$this->data['commons'] = $this->common->get_all(['district_id' => $this->data['districts'][0]->id]);
		$this->data['boroughs'] = $this->borough->get_all(['common_id' => $this->data['commons'][0]->id]);
        $this->data['fokontanies'] = $this->fokontany->get_all(['borough_id' => $this->data['boroughs'][0]->id]);
        
        $this->data['menu_active'] = 'list_menage';
        $this->data['side_main_menu'] = $this->load->view('superadmin_menu', $this->data, TRUE);

        $this->load->view('list_menage', $this->data);
    }

    /*
     * AJAX Requests
     */

    public function menages_fokontany()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }
        
        $fokontany_id = $this->input->get('fokontany_id');

        $menages = $this->menage->getMenages(['fokontany_id' => $fokontany_id]);
        echo json_encode($menages);
    }
}

