<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Citizen extends Operator_Controller
{
	public function __construct(){
        parent::__construct();
        
        $this->load->model('menage/menage_model', 'menage');
        
        //Location Models
        $this->load->model('territory/province_model', 'province');
        $this->load->model('territory/region_model', 'region');
        $this->load->model('territory/district_model', 'district');
        $this->load->model('territory/common_model', 'common');
        $this->load->model('territory/borough_model', 'borough');
        
        $this->load->model('citizen_model', 'citizen');
        
        $this->load->model('territory/fokontany_model', 'fokontany');
        $this->load->model('user/user_model', 'user');

        $this->lang->load('citizen', $this->session->site_lang);
		
	}

	public function index_household()
	{
		$this->data['title'] = "Tableau de bords";
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

        $this->load->view('list_menage', $this->data);
    }

	public function index()
	{
        $this->data['title'] = $this->lang->line('dashboard');

        $user_fokontany = $this->user->getUserFokontany($this->session->user_id);

        $this->data['user_fokontany'] = ($user_fokontany) ? $user_fokontany->fokontany_name : '...';

        $this->load->view('index', $this->data);
	}

	public function add_citizen()
	{
		$this->data['title'] = $this->lang->line('add_citizen');

        $user_fokontany = $this->user->getUserFokontany($this->session->user_id);

        $this->data['user_fokontany'] = ($user_fokontany) ? $user_fokontany->fokontany_name : '...';
		
        $this->load->view('add_citizen', $this->data);
	}


}

