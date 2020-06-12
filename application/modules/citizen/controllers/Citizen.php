<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Citizen extends Operator_Controller
{
	public function __construct(){
        parent::__construct();
        
        //Location Models
        $this->load->model('territory/province_model', 'province');
        $this->load->model('territory/region_model', 'region');
        $this->load->model('territory/district_model', 'district');
        $this->load->model('territory/common_model', 'common');
        $this->load->model('territory/borough_model', 'borough');

        $this->load->model('job/job_model', 'job');
        $this->load->model('nationality/nationality_model', 'nationality');
        
        $this->load->model('citizen_model', 'citizen');
        
        $this->load->model('territory/fokontany_model', 'fokontany');
        $this->load->model('user/user_model', 'user');

        $this->lang->load('citizen', $this->session->site_lang);
        $this->lang->load('job', $this->session->site_lang);
        $this->lang->load('nationality', $this->session->site_lang);
		
	}

	public function index_household()
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

	public function index()
	{
        $this->data['title'] = $this->lang->line('dashboard');

        $user_fokontany = $this->user->getUserFokontany($this->session->user_id);

        $this->data['user_fokontany'] = ($user_fokontany) ? $user_fokontany->fokontany_name : '...';

        $this->load->view('index', $this->data);
	}

	public function list_citizens()
	{
        $this->data['title'] = $this->lang->line('dashboard');

        $user_fokontany = $this->user->getUserFokontany($this->session->user_id);

        $this->data['user_fokontany'] = ($user_fokontany) ? $user_fokontany->fokontany_name : '...';

        $this->load->view('list_citizen_fk', $this->data);
	}

	public function add_citizen()
	{
        $this->data['title'] = $this->lang->line('add_citizen');
        $this->data['jobs'] = $this->job->all();
        $this->data['nationalities'] = $this->nationality->all();

        $user_fokontany = $this->user->getUserFokontany($this->session->user_id);

        $this->data['user_fokontany'] = ($user_fokontany) ? $user_fokontany->fokontany_name : '...';
		
        $this->load->view('add_citizen', $this->data);
    }

    /*
     * AJAX Requests
     */

    public function citizens_list()
    {
        /*
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }
        */

        $citizens = $this->citizen->get_citizen();
        echo json_encode($citizens);
    }

    public function list_citizen_by_carnet_id()
	{        
        $carnet_id = 2;//$this->input->post('carnet_id');
        
        if(!empty($carnet_id)){
            $citizen = $this->citizen->get_citizen(['numero_carnet'=>$carnet_id]);
        }
        $this->data['title'] = "Liste des Citoyens";

        $this->data['provinces'] = $this->province->get_all();
        $this->data['regions'] = $this->region->get_all(['province_id' => $this->data['provinces'][0]->id]);
        $this->data['districts'] = $this->district->get_all(['region_id' => $this->data['regions'][0]->id]);
		$this->data['commons'] = $this->common->get_all(['district_id' => $this->data['districts'][0]->id]);
		$this->data['boroughs'] = $this->borough->get_all(['common_id' => $this->data['commons'][0]->id]);
        $this->data['fokontanies'] = $this->fokontany->get_all(['borough_id' => $this->data['boroughs'][0]->id]);

        $this->load->view('list_citizen', $this->data);
    }

    /*
     * AJAX
     */
    
    public function save_citizen()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }

        $data = $this->input->post();
        $requireds = ['last_name', 'birth', 'birth_place', 'address'];

        if($data){
            $missing_fields = [];   
            $cin = [$data['cin'], $data['cin_date'], $data['cin_place']];
            $passport = [$data['passport'], $data['passport_date'], $data['passport_place']];

            foreach($requireds as $required)
                if(empty($data[$required])) $missing_fields[] = [$required ,'Champ requis.'];
            
            if($data['nationality_id'] == 1){  
                $requireds_cin = ['cin', 'cin_date', 'cin_place'];      
                
                if($cin != ['', '', '']){
                    foreach($requireds_cin as $required)
                        if(empty($data[$required])) $missing_fields[] = [$required ,'Champ requis.'];
                }
            }else if($data['nationality_id'] > 1){   
                $requireds_passport = ['passport', 'passport_date', 'passport_place'];     
                
                foreach($requireds_passport as $required)
                    if(empty($data[$required])) $missing_fields[] = [$required ,'Champ requis.'];
            }

            if(!empty($missing_fields)){
                echo json_encode(['error' => 1, 'missing_fields' => $missing_fields]);
                return FALSE;
            }

            $data_insert = [
                'nom' => $data['last_name'],
                'prenoms' => $data['first_name'],
                'date_de_naissance' => $data['birth'],
                'lieu_de_naissance' => $data['birth_place'],
                'sexe' => $data['sexe'],
                'situation_matrimoniale' => $data['marital_status'],
                'phone' => $data['phone'],
                'father' => $data['father'],
                'father_status' => $data['father_status'],
                'mother' => $data['mother'],
                'mother_status' => $data['mother_status'],
                'job_id' => $data['job_id'],
                'job_other' => $data['job_other'],
                'job_status' => $data['job_status'],
                'nationality_id' => $data['nationality_id']
            ];

            if ($cin != ['', '', '']){
                $data_insert['cin_peronne'] = $data['cin'];
                $data_insert['date_delivrance_cin'] = $data['cin_date'];
                $data_insert['lieu_delivrance_cin'] = $data['cin'];
            }
            if ($passport != ['', '', '']){
                $data_insert['passport'] = $data['passport'];
                $data_insert['passport_date'] = $data['passport_date'];
                $data_insert['passport_place'] = $data['passport_place'];
            }


            if($this->citizen->insert($data_insert)){
                echo json_encode(['success' => 1, 'msg' => $this->lang->line('success_save')]);
            }else{
                echo json_encode(['error' => 1, 'msg' => $this->lang->line('data_citizen_error')]);
            }
        }
        else{
            echo json_encode(['error' => 1, 'msg' => $this->lang->line('data_citizen_error')]);
        }
    }
    
    /**
     * Load citizen certificate page
     */
    public function load_citizen_certificate()
	{
        $this->data['title'] = $this->lang->line('citizen_residence');
        
        $cin_personne = 123456789123456789;//$this->input->get('carnet_id');

        $citizen_data = $this->citizen->get_citizen(['cin_personne'=>$cin_personne]);

        $this->data['citizen_data'] = $citizen_data;
		
        $this->load->view('citizen_certificat', $this->data);
	}


}

