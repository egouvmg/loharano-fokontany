<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Aidadmin extends SuperAdmin_Controller
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
        $this->load->model('aid/aid_model', 'aid');

        $this->lang->load('user', $this->session->site_lang);
	}

	public function index()
	{
        $this->data['title'] = "Gestion des aides";
        $this->data['menu_active'] = 'manage_aid';
        $this->data['side_main_menu'] = $this->load->view('superadmin_menu', $this->data, TRUE);

        $this->load->view('index', $this->data);
    }

	public function insight()
	{
        $this->data['title'] = "Statistiques des opérations d'aide";
        $this->data['provinces'] = $this->province->get_all();
        $this->data['regions'] = $this->region->get_all(['province_id' => $this->data['provinces'][0]->id]);
        $this->data['districts'] = $this->district->get_all(['region_id' => $this->data['regions'][0]->id]);
		$this->data['commons'] = $this->common->get_all(['district_id' => $this->data['districts'][0]->id]);
		$this->data['boroughs'] = $this->borough->get_all(['common_id' => $this->data['commons'][0]->id]);
        $this->data['fokontanies'] = $this->fokontany->get_all(['borough_id' => $this->data['boroughs'][0]->id]);
        $this->data['menu_active'] = 'insight_aid';
        $this->data['side_main_menu'] = $this->load->view('superadmin_menu', $this->data, TRUE);

        $this->load->view('insight', $this->data);
    }

    /*
     * Ajax
     */
	public function get_insight()
	{
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }

        $fokontany_id = $this->input->get('fokontany_id');

        $insight = $this->aid->insight(['fokontany_id' => $fokontany_id]);
        echo json_encode($insight);
    }

    public function get_household_aid()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }

        $fokontany_id = $this->input->get('fokontany_id');
        $aid_id = $this->input->get('aid_id');
        $page = $this->input->get('page');
        $size = $this->input->get('size');
        $filters = $this->input->get('filters');

        $criteria = [];
        
        if($filters){
            foreach ($filters as $f) {
                $field = "LOWER(".$f['field'].") LIKE";
                $value = '%'.strtolower($f['value']).'%';
                
                $criteria[$field] = $value;
            }
        }
        
        $criteria['fokontany_id'] = $fokontany_id;
        $criteria['aid_id'] = $aid_id;

        $limit = ($size);
        $offset = ($page == 1) ? 0 : ($page - 1) * $size;

        $households = $this->aid->householdChiefAidsPerPage($criteria, $offset, $limit);
        $count_households = count($this->aid->household_chief_aids($criteria));

        $data['last_page'] = ceil($count_households/$limit);
        $data['data'] = $households;
        
        echo json_encode($data);
    }
}

