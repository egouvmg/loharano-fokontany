<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin extends SuperAdmin_Controller
{
	public function __construct(){
        parent::__construct();
        
        //Location Models
		$this->load->model('territory/province_model', 'province');
		$this->load->model('territory/region_model', 'region');
		$this->load->model('territory/district_model', 'district');
		$this->load->model('territory/common_model', 'common');
		$this->load->model('territory/borough_model', 'borough');
        $this->load->model('territory/fokontany_model', 'fokontany');
        $this->load->model('territory/notebook_model', 'notebook');
        
        $this->load->model('citizen/citizen_model', 'citizen');
        
        $this->load->model('user/user_model', 'user');

        $this->lang->load('user', $this->session->site_lang);
	}

	public function index()
	{
		$this->data['title'] = "Tableau de bords";
        $this->load->view('index', $this->data);
    }

	public function list_citizen()
	{
		$this->data['title'] = "Liste des Citoyens";

        $this->data['provinces'] = $this->province->get_all();
        $this->data['regions'] = $this->region->get_all(['province_id' => $this->data['provinces'][0]->id]);
        $this->data['districts'] = $this->district->get_all(['region_id' => $this->data['regions'][0]->id]);
		$this->data['commons'] = $this->common->get_all(['district_id' => $this->data['districts'][0]->id]);
		$this->data['boroughs'] = $this->borough->get_all(['common_id' => $this->data['commons'][0]->id]);
		$this->data['fokontanies'] = $this->fokontany->get_all(['borough_id' => $this->data['boroughs'][0]->id]);

        $this->data['carnet_id'] = $this->input->get('carnet_id');

        $this->load->view('list_citizen', $this->data);
    }

    public function load_citizen_certificate()
	{
        $this->data['title'] = $this->lang->line('citizen_residence');

        $person_id = $this->input->get('personne');

        $citizen_data = $this->citizen->get_citizen_certificate(['person_id'=>$person_id]);

        $this->data['citizen_data'] = $citizen_data;
		
        $this->load->view('residence_certificat', $this->data);
	}

    /*
     * AJAX Requests
     * */

    public function citizens_list()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }

        $fokontany_id = ($this->input->get('fokontany_id')) ? $this->input->get('fokontany_id') : 0;

        $citizens = $this->notebook->citizens(['fokontany_id' => $fokontany_id]);

        echo json_encode($citizens);
    }

    public function list_citizen_by_carnet_id()
	{        
        $numero_carnet = $this->input->get('numero_carnet');//;"123456789"
        
        if(!empty($numero_carnet)){
            $citizen = $this->citizen->get_citizen(['numero_carnet'=>$numero_carnet]);
        }

        echo json_encode($citizen);
    }
}

