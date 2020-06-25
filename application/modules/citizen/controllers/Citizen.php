<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Citizen extends Operator_Controller
{
    private $fokontany_id;

	public function __construct(){
        parent::__construct();
        
        //Location Models
        $this->load->model('territory/province_model', 'province');
        $this->load->model('territory/region_model', 'region');
        $this->load->model('territory/district_model', 'district');
        $this->load->model('territory/common_model', 'common');
        $this->load->model('territory/borough_model', 'borough');
        $this->load->model('territory/notebook_model', 'notebook');

        $this->load->model('register/register_model', 'register');

        $this->load->model('job/job_model', 'job');
        $this->load->model('nationality/nationality_model', 'nationality');
        
        $this->load->model('citizen_model', 'citizen');
        
        $this->load->model('territory/fokontany_model', 'fokontany');
        $this->load->model('user/user_model', 'user');

        $this->lang->load('citizen', $this->session->site_lang);
        $this->lang->load('job', $this->session->site_lang);
        $this->lang->load('nationality', $this->session->site_lang);

        $user_fokontany = $this->user->getUserFokontany($this->session->user_id);
        if(isset($user_fokontany)){
            $this->fokontany_id = (int) $user_fokontany->fokontany_id;

            $this->data['info_fokontany'] = $user_fokontany;
            $this->data['user_fokontany'] = ($user_fokontany) ? $user_fokontany->fokontany_name : '...';
        }
	}

	public function index_household()
	{
		$this->data['title'] = "Tableau de bord";
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

		$this->data['nationalities'] = $this->nationality->all();
        $this->data['jobs'] = $this->job->all();

        //Count household/citizen
        $citizen_count = count($this->notebook->citizens(['fokontany_id' => $this->fokontany_id]));
        $household_count = $this->notebook->household_count(['fokontany_id' => $this->fokontany_id]);

        $this->data['household_count'] = ($household_count) ? number_format($household_count->household_count, 0, '', ' ') : 0;
        $this->data['citizen_count'] = number_format($citizen_count, 0, '', ' ');

        
        //Ration sexe
        $this->data['female_ratio'] = 0;
        $this->data['male_ratio'] = 0;

        if($citizen_count){
            $ratio_sexe = $this->citizen->ratio_sexe(['fokontany_id' => $this->fokontany_id]);
            foreach($ratio_sexe as $value){
                if($value->sexe == 0)
                    $this->data['female_ratio'] = number_format(($value->number/$citizen_count)*100, 2, ',', '');
                if($value->sexe == 1)
                    $this->data['male_ratio'] =  number_format(($value->number/$citizen_count)*100, 2, ',', '');
            }
        }
        
        $this->load->view('index', $this->data);
	}

	public function list_citizens()
	{
        $this->data['title'] = $this->lang->line('list_citizen');

		$this->data['nationalities'] = $this->nationality->all();
        $this->data['jobs'] = $this->job->all();

        $this->load->view('list_citizen_fk', $this->data);
    }
    
    public function list_households()
    {
        $this->data['title'] = 'Liste des ménages';

		$this->data['nationalities'] = $this->nationality->all();
        $this->data['jobs'] = $this->job->all();

        $this->load->view('list_household', $this->data);
    }

    public function add_citizen()
	{
        if($this->session->address && $this->session->household_size){
            $this->data['title'] = $this->lang->line('add_citizens');
            $this->data['jobs'] = $this->job->all();
            $this->data['nationalities'] = $this->nationality->all();

            $tabs_link = '';
            $tabs_content = '';

            for ($i=1; $i <= $this->session->household_size; $i++) {
                $this->data['index'] = $i;
                $tabs_link .= $this->load->view('tab_list', $this->data, TRUE);
                $tabs_content .= $this->load->view('tab_content', $this->data, TRUE);
            }

            $this->data['tabs_link'] = $tabs_link;
            $this->data['tabs_content'] = $tabs_content;
            
            $this->load->view('add_citizen', $this->data);
        }
        else{
            redirect('/', 'refresh');
        }
    }

	public function search_household()
	{
        $this->data['title'] = $this->lang->line('add_citizen');
        $this->load->view('search_household', $this->data);
    }

	public function new_household()
	{
        $this->data['title'] = $this->lang->line('add_citizen');

        $this->data['address'] = ($this->session->address) ? $this->session->address : '';
        $this->data['household_size'] = ($this->session->household_size) ? $this->session->household_size : '';

        $this->load->view('new_household', $this->data);
    }

    public function search_household_in_list(Type $var = null)
    {
        $this->data['title'] = $this->lang->line('add_citizen');
        $this->load->view('search_household_in_list', $this->data);
    }

    public function fokontany_household()
    {
        $this->data['title'] = $this->lang->line('add_citizen');
        $this->data['jobs'] = $this->job->all();
        $this->data['nationalities'] = $this->nationality->all();

        $user_fokontany = $this->user->getUserFokontany($this->session->user_id);

        $this->data['user_fokontany'] = ($user_fokontany) ? $user_fokontany->fokontany_name : '...';
		
        $this->load->view('search_household', $this->data);
    }

    public function insert_citizen()
    {
        if($this->session->address && $this->session->household_size && $this->session->reference){
            $this->data['title'] = $this->lang->line('add_citizen');
            $this->data['jobs'] = $this->job->all();
            $this->data['nationalities'] = $this->nationality->all();

            $tabs_link = '';
            $tabs_content = '';

            for ($i=1; $i <= $this->session->household_size; $i++) {
                $this->data['index'] = $i;
                $tabs_link .= $this->load->view('tab_list', $this->data, TRUE);
                $tabs_content .= $this->load->view('tab_content', $this->data, TRUE);
            }

            $this->data['tabs_link'] = $tabs_link;
            $this->data['tabs_content'] = $tabs_content;
            
            $this->load->view('insert_citizen', $this->data);
        }
        else{
            redirect('/', 'refresh');
        }
    }

    /*
     * CERTIFICATES
     * */
    public function certificate_residence()
    {
        $this->data['title'] = $this->lang->line('creation_certificats');
        $this->data['jobs'] = $this->job->all();

        $this->load->view('residence', $this->data);
    }

    public function generate_residence()
    {
        $this->data['title'] = $this->lang->line('citizen_residence');

        $person_id = $this->input->get('personne');

        $citizen_data = $this->citizen->get_citizen_certificate(['person_id'=>$person_id]);

        $this->data['citizen_data'] = $citizen_data;
		
        $this->load->view('residence_certificat', $this->data);
    }

    /*
     * AJAX Requests
     */
    public function get_notebook()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }

        if($this->input->get('noteboook')){
            $notebook = $this->notebook->one(['numero_carnet' => $this->input->get('noteboook')]);

            if($notebook){
                $data = [
                    'address' => $notebook->adresse_actuelle,
                    'household_size' => 1,
                    'reference' => $notebook->numero_carnet
                ];

                $this->session->set_userdata($data);

                echo json_encode(['success' => 1, 'link' => 'insertion_citoyen']);
            }else  echo json_encode(['error' => 1, 'msg' => 'Impossible de récupérer le ménage']);
        }
        else echo json_encode(['error' => 1, 'msg' => 'Ménage indéfini']);
    }

    public function citizens_list()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }

        $citizens = $this->notebook->citizens(['fokontany_id' => $this->fokontany_id]);
        echo json_encode($citizens);
    }

    public function households_list()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }

        $data = ['fokontany_id' => $this->fokontany_id, 'chef_menage' => TRUE];
        
        if($this->input->get()){
            if($this->input->get('last_name')) $data['nom LIKE'] = '%'.$this->input->get('last_name').'%';
            if($this->input->get('first_name')) $data['prenoms LIKE'] = '%'.$this->input->get('first_name').'%';
            if($this->input->get('birth')) $data['date_de_naissance'] = $this->input->get('birth');
            if($this->input->get('birth_place')) $data['date_de_naissance'] = $this->input->get('birth_place');
            if($this->input->get('father')) $data['father LIKE'] = '%'.$this->input->get('father').'%';
            if($this->input->get('mother')) $data['mother LIKE'] = '%'.$this->input->get('mother').'%';
        }

        $citizens = $this->notebook->citizens($data);
        echo json_encode($citizens);
    }

    public function list_citizen_by_carnet_id()
	{        
        $numero_carnet = $this->input->get('numero_carnet');
        
        if(!empty($numero_carnet)){
            //$citizen = $this->citizen->get_citizen(['numero_carnet'=>$numero_carnet]);
            $citizen = $this->citizen->get_citizen_certificate(['numero_carnet'=>$numero_carnet]);
        }
        
        echo json_encode($citizen);
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
        $requireds = ['last_name', 'birth', 'birth_place'];

        if($data){
            $missing_fields = [];

            for ($i=0; $i < $this->session->household_size ; $i++) {
                $index = $i +1;

                foreach($requireds as $required)
                    if(empty($data[$required][$i])) $missing_fields[] = [$required.$index ,'Champ requis.'];
            }

            for ($i=0; $i < $this->session->household_size ; $i++) {
                $index = $i +1;

                if($data['nationality_id'][$i] == 1){  
                    $requireds_cin = ['cin', 'cin_date', 'cin_place'];            
                    $cin = [$data['cin'][$i], $data['cin_date'][$i], $data['cin_place'][$i]];
                    
                    if($cin != ['', '', '']){
                        foreach($requireds_cin as $required)
                            if(empty($data[$required][$i])) $missing_fields[] = [$required.$index ,'Champ requis.'];
                    }
                }else if($data[$i]['nationality_id'] > 1){   
                    $requireds_passport = ['passport', 'passport_date', 'passport_place'];   
                    $passport = [$data['passport'][$i], $data['passport_date'][$i], $data['passport_place'][$i]];  
                    
                    foreach($requireds_passport as $required)
                        if(empty($data[$required][$i])) $missing_fields[] = [$required.$index ,'Champ requis.'];
                }
            }

            if(!empty($missing_fields)){
                echo json_encode(['error' => 1, 'missing_fields' => $missing_fields]);
                return FALSE;
            }

            /*
             *  Création Carnet Fokontany
             */

            $notebook = $this->createNotebook($this->session->address);

            if($notebook == FALSE){
                echo json_encode(['failed' => 1, 'msg' => 'Impossible de créer un nouveau carnet.']);
                return FALSE;
            }

            /*
             *  Insertion Personnes
             */

            $citizens_index = [];

            for ($i=0; $i < $this->session->household_size ; $i++) {
                $cin = [$data['cin'][$i], $data['cin_date'][$i], $data['cin_place'][$i]];
                $passport = [$data['passport'][$i], $data['passport_date'][$i], $data['passport_place'][$i]];

                $data_tmp = [
                    'nom' => $data['last_name'][$i],
                    'prenoms' => $data['first_name'][$i],
                    'date_de_naissance' => $data['birth'][$i],
                    'lieu_de_naissance' => $data['birth_place'][$i],
                    'sexe' => $data['sexe'][$i],
                    'situation_matrimoniale' => $data['marital_status'][$i],
                    'phone' => $data['phone'][$i],
                    'father' => $data['father'][$i],
                    'father_status' => $data['father_status'][$i],
                    'handicape' => $data['handicape'][$i],
                    'observation' => $data['observation'][$i],
                    'mother' => $data['mother'][$i],
                    'mother_status' => $data['mother_status'][$i],
                    'job_id' => ($data['job_id'][$i]) ? $data['job_id'][$i] : 53,
                    'job_other' => $data['job_other'][$i],
                    'job_status' => $data['job_status'][$i],
                    'nationality_id' => $data['nationality_id'][$i],
                    'numero_carnet' => $notebook
                ];

                if($i == 0) $data_tmp['chef_menage'] = TRUE;
    
                if ($cin != ['', '', '']){
                    $data_tmp['cin_personne'] = $data['cin'][$i];
                    $data_tmp['date_delivrance_cin'] = $data['cin_date'][$i];
                    $data_tmp['lieu_delivrance_cin'] = $data['cin_place'][$i];
                }
                if ($passport != ['', '', '']){
                    $data_tmp['passport'] = $data['passport'][$i];
                    $data_tmp['passport_date'] = $data['passport_date'][$i];
                    $data_tmp['passport_place'] = $data['passport_place'][$i];
                }

                if(!$this->citizen->insert($data_tmp)) $citizens_index[] = $i;
            }

            $this->session->unset_userdata('address');
            $this->session->unset_userdata('household_size');
            $this->session->unset_userdata('locality');

            if(empty($citizens_index)){
                echo json_encode(['success' => 1, 'msg' => $this->lang->line('success_save')]);
            }else{
                echo json_encode(['error' => 1, 'msg' => $this->lang->line('data_citizen_error')]);
            }
        }
        else{
            echo json_encode(['error' => 1, 'msg' => $this->lang->line('data_citizen_error')]);
        }
    }

    public function edit_citizen(Type $var = null)
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }

        $data = $this->input->post();

        $nom = $this->input->post('nom');
        $date_de_naissance = $this->input->post('date_de_naissance');

        $cin_personne = $this->input->post('cin_personne');
        $date_delivrance_cin = $this->input->post('date_delivrance_cin');
        $lieu_delivrance_cin = $this->input->post('lieu_delivrance_cin');
        $passport_place = $this->input->post('passport_place');
        $passport_date = $this->input->post('passport_date');
        $passport = $this->input->post('passport');

        $missing_fields = [];

        if(empty($nom))
            $missing_fields[] = ['nom', 'Champs requis'];
        if(empty($date_de_naissance))
            $missing_fields[] = ['date_de_naissance', 'Champs requis'];

        
        if([$cin_personne, $date_delivrance_cin, $lieu_delivrance_cin] != ['', '', '']){
            if(empty($cin_personne))
                $missing_fields[] = ['cin_personne', 'Champs requis'];
            if(empty($date_delivrance_cin))
                $missing_fields[] =  ['date_delivrance_cin', 'Champs requis'];
            if(empty($lieu_delivrance_cin))
                $missing_fields[] =  ['lieu_delivrance_cin', 'Champs requis'];
        }

        if(!empty($missing_fields)){
            echo json_encode(['failed' => 1, 'missing_fields' => $missing_fields]);
            return false;
        }

        if([$cin_personne, $date_delivrance_cin, $lieu_delivrance_cin] == ['', '', '']){
            unset($data['cin_personne']);
            unset($data['date_delivrance_cin']);
            unset($data['lieu_delivrance_cin']);
        }

        if([$passport_place, $passport_date, $passport] == ['', '', '']){
            unset($data['passport_place']);
            unset($data['passport_date']);
            unset($data['passport']);
        }

        unset($data['adresse_actuelle']);

        if($this->citizen->update($data))
            echo json_encode(['success' => 1, 'msg' => 'Modification réussie']);
        else echo json_encode(['error' => 1, 'msg' => 'Modification impossible']);
    }

    public function insert_in_household()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }

        $data = $this->input->post();
        $requireds = ['last_name', 'birth', 'birth_place'];

        if($data){
            $missing_fields = [];

            for ($i=0; $i < $this->session->household_size ; $i++) {
                $index = $i +1;

                foreach($requireds as $required)
                    if(empty($data[$required][$i])) $missing_fields[] = [$required.$index ,'Champ requis.'];
            }

            for ($i=0; $i < $this->session->household_size ; $i++) {
                $index = $i +1;

                if($data['nationality_id'][$i] == 1){  
                    $requireds_cin = ['cin', 'cin_date', 'cin_place'];            
                    $cin = [$data['cin'][$i], $data['cin_date'][$i], $data['cin_place'][$i]];
                    
                    if($cin != ['', '', '']){
                        foreach($requireds_cin as $required)
                            if(empty($data[$required][$i])) $missing_fields[] = [$required.$index ,'Champ requis.'];
                    }
                }else if($data[$i]['nationality_id'] > 1){   
                    $requireds_passport = ['passport', 'passport_date', 'passport_place'];   
                    $passport = [$data['passport'][$i], $data['passport_date'][$i], $data['passport_place'][$i]];  
                    
                    foreach($requireds_passport as $required)
                        if(empty($data[$required][$i])) $missing_fields[] = [$required.$index ,'Champ requis.'];
                }
            }

            if(!empty($missing_fields)){
                echo json_encode(['error' => 1, 'missing_fields' => $missing_fields]);
                return FALSE;
            }

            /*
             *  Création Carnet Fokontany
             */

            $notebook = $this->createNotebook($this->session->address);

            if($notebook == FALSE){
                echo json_encode(['failed' => 1, 'msg' => 'Impossible de créer un nouveau carnet.']);
                return FALSE;
            }

            /*
             *  Insertion Personnes
             */

            $citizens_index = [];

            for ($i=0; $i < $this->session->household_size ; $i++) {
                $cin = [$data['cin'][$i], $data['cin_date'][$i], $data['cin_place'][$i]];
                $passport = [$data['passport'][$i], $data['passport_date'][$i], $data['passport_place'][$i]];

                $data_tmp = [
                    'nom' => $data['last_name'][$i],
                    'prenoms' => $data['first_name'][$i],
                    'date_de_naissance' => $data['birth'][$i],
                    'lieu_de_naissance' => $data['birth_place'][$i],
                    'sexe' => $data['sexe'][$i],
                    'situation_matrimoniale' => $data['marital_status'][$i],
                    'phone' => $data['phone'][$i],
                    'father' => $data['father'][$i],
                    'father_status' => $data['father_status'][$i],
                    'mother' => $data['mother'][$i],
                    'mother_status' => $data['mother_status'][$i],
                    'job_id' => ($data['job_id'][$i]) ? $data['job_id'][$i] : 53,
                    'job_other' => $data['job_other'][$i],
                    'job_status' => $data['job_status'][$i],
                    'nationality_id' => $data['nationality_id'][$i],
                    'numero_carnet' => $this->session->reference
                ];
    
                if ($cin != ['', '', '']){
                    $data_tmp['cin_personne'] = $data['cin'][$i];
                    $data_tmp['date_delivrance_cin'] = $data['cin_date'][$i];
                    $data_tmp['lieu_delivrance_cin'] = $data['cin_place'][$i];
                }
                if ($passport != ['', '', '']){
                    $data_tmp['passport'] = $data['passport'][$i];
                    $data_tmp['passport_date'] = $data['passport_date'][$i];
                    $data_tmp['passport_place'] = $data['passport_place'][$i];
                }

                if(!$this->citizen->insert($data_tmp)) $citizens_index[] = $i;
            }

            $this->session->unset_userdata('address');
            $this->session->unset_userdata('household_size');
            $this->session->unset_userdata('reference');

            if(empty($citizens_index)){
                echo json_encode(['success' => 1, 'msg' => $this->lang->line('success_save')]);
            }else{
                echo json_encode(['error' => 1, 'msg' => $this->lang->line('data_citizen_error')]);
            }
        }
        else{
            echo json_encode(['error' => 1, 'msg' => $this->lang->line('data_citizen_error')]);
        }
    }

    /*
     * Vérification des inputs Adresse et Taille du ménage
     */

    public function check_household()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }

        $address = $this->input->post('address');
        $locality = $this->input->post('locality');
        $household_size = (int) $this->input->post('household_size');

        $missing_fields = [];
        
        if(empty($locality))
            $missing_fields[] = ['locality', 'Champs requis'];
        if(empty($address))
            $missing_fields[] = ['address', 'Champs requis'];
        if(empty($household_size))
            $missing_fields[] = ['household_size', 'Champs requis'];     

        if(!empty($missing_fields)){
            echo json_encode(['error' => 1, 'missing_fields' => $missing_fields]);
            return false;
        }
        
        $this->session->set_userdata($this->input->post());
        
        echo json_encode(['success' => 1, 'link' => 'ajout_citoyen']);
    }

    /*
     * Private functions
     */

    private function createNotebook($address = '')
    {
        $reference = dechex($this->fokontany_id);
        $reference = str_pad($reference, 5, '0', STR_PAD_LEFT);

        //2020 is index 1
        $index_year = (int) date("Y");
        $index_year = $index_year - 2019;

        $reference .= $index_year;
        $reference .= date("ymd");

        $notebooks = $this->notebook->all(['numero_carnet like' => $reference.'%']);

        $index = ($notebooks) ? count($notebooks) + 1 : 1;

        $reference .= str_pad($index, 4, '0', STR_PAD_LEFT); 

        $data = [
            'numero_carnet' => $reference,
            'adresse_actuelle' => $address,
            'id_registre' => $this->fokontany_id
        ];

        if($this->notebook->insert($data))
            return $reference;
        else return false;
    }

    /**
     * Enregistrement from Certificat
     */
    public function save_citizen_from_certificat()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }

        $data = $this->input->post();
        $requireds = ['last_name', 'birth', 'birth_place'];

        if($data){
            $missing_fields = [];

            for ($i=0; $i < $this->session->household_size ; $i++) {
                $index = $i +1;

                foreach($requireds as $required)
                    if(empty($data[$required][$i])) $missing_fields[] = [$required.$index ,'Champ requis.'];
            }


                if($data['nationality_id'] == 1){  
                    $requireds_cin = ['cin', 'cin_date', 'cin_place'];            
                    $cin = [$data['cin'], $data['cin_date'], $data['cin_place']];
                    
                    if($cin != ['', '', '']){
                        foreach($requireds_cin as $required)
                            if(empty($data[$required][$i])) $missing_fields[] = [$required.$index ,'Champ requis.'];
                    }
                }else if($data['nationality_id'] > 1){   
                    $requireds_passport = ['passport', 'passport_date', 'passport_place'];   
                    $passport = [$data['passport'], $data['passport_date'], $data['passport_place']];  
                    
                    foreach($requireds_passport as $required)
                        if(empty($data[$required][$i])) $missing_fields[] = [$required.$index ,'Champ requis.'];
                }
            

            if(!empty($missing_fields)){
                echo json_encode(['error' => 1, 'missing_fields' => $missing_fields]);
                return FALSE;
            }

            /*
             *  Insertion Personnes
             */

            $citizens_index = [];

            $cin = [$data['cin'][$i], $data['cin_date'][$i], $data['cin_place'][$i]];
            $passport = [$data['passport'][$i], $data['passport_date'][$i], $data['passport_place'][$i]];

            $data_tmp = [];

            if ($cin != ['', '', '']){
                $data_tmp['cin_personne'] = $data['cin'];
                $data_tmp['date_delivrance_cin'] = $data['cin_date'];
                $data_tmp['lieu_delivrance_cin'] = $data['cin_place'];
            }
            if ($passport != ['', '', '']){
                $data_tmp['passport'] = $data['passport'];
                $data_tmp['passport_date'] = $data['passport_date'];
                $data_tmp['passport_place'] = $data['passport_place'];
            }

            $data_personne = $this->fokontany->get_fokotany_by_id((int)$data['fokontany_id']);

            $lf_residence = $data_personne[0]->lf_residence;
            $lf_vie = $data_personne[0]->lf_vie;
            $lf_move = $data_personne[0]->lf_move;
            $lf_support = $data_personne[0]->lf_support;
            $lf_celibacy = $data_personne[0]->lf_celibacy;
            $lf_behavior = $data_personne[0]->lf_behavior;


            if(isset($data['fokontany_id'])){
                $data_tmp['fokontany_id'] = (int)$data['fokontany_id'];
            }
            

            $origin_page = $data['origin_page'];
            if($origin_page==="residence"){
                ++$lf_residence;
                $data_tmp['lf_residence']= $lf_residence;
            }
            if($origin_page==="vie"){++$lf_vie;$data_tmp ['lf_vie']=$lf_vie;}
            if($origin_page==="move"){++$lf_move;$data_tmp['lf_move']= $lf_move;}
            if($origin_page==="support"){++$lf_support;$data_tmp['lf_support']= $lf_support;}
            if($origin_page==="celibacy"){++$lf_celibacy;$data_tmp['lf_celibacy']= $lf_celibacy;}
            if($origin_page==="behavior"){++$lf_behavior;$data_tmp['lf_behavior']= $lf_behavior;}

            
            if(isset($data['for_person'])){
                if(isset($data['numero_carnet'])){
                    $data_tmp['numero_carnet']= $data['numero_carnet'];
                }
                if(isset($data['id_personne'])){
                    $data_tmp['id_personne']= $data['id_personne'];
                }
                if(isset($data['lieu_de_naissance'])){
                    $data_tmp['lieu_de_naissance']= $data['lieu_de_naissance'];
                }
                if(isset($data['last_name'])){
                    $data_tmp['nom']= $data['last_name'];
                }
                if(isset($data['first_name'])){
                    $data_tmp['prenoms']= $data['first_name'];
                }
                if(isset($data['marital_status'])){
                    $data_tmp['situation_matrimoniale']= $data['marital_status'];
                }
                if(isset($data['parent_link'])){
                    $data_tmp['parent_link']= $data['parent_link'];
                }
                if(isset($data['birth'])){
                    $data_tmp['date_de_naissance']= $data['birth'];
                }
                if(isset($data['sexe'])){
                    $data_tmp['sexe']= $data['sexe'];
                }
                /*if(isset($data['handicapped'])){
                    $data_tmp['handicape']= (int)$data['handicapped']===0?false:true;
                }
                if(isset($data['nationality'])){
                    $data_tmp['nationality_id']= $data['nationality'];
                }*/
                if(isset($data['cin'])){
                    $data_tmp['cin_personne']= $data['cin'];
                }
                if(isset($data['cin_date'])){
                    $data_tmp['date_delivrance_cin']= $data['cin_date'];
                }
                if(isset($data['cin_place'])){
                    $data_tmp['lieu_delivrance_cin']= $data['cin_place'];
                }
                if(isset($data['father'])){
                    $data_tmp['father']= $data['father'];
                }
                if(isset($data['father_status'])){
                    $data_tmp['father_status']= $data['father_status'];
                }
                if(isset($data['mother'])){
                    $data_tmp['mother']= $data['mother'];
                }
                if(isset($data['mother_status'])){
                    $data_tmp['mother_status']= $data['mother_status'];
                }
                if(isset($data['phone'])){
                    $data_tmp['phone']= $data['phone'];
                }
                if(isset($data['job'])){
                    $data_tmp['job_id']= $data['job'];
                }
                if(isset($data['job_status'])){
                    $data_tmp['job_status']= $data['job_status'];
                }
               
                $this->citizen->update($data_tmp);  
            }
            else{
                if(!$this->fokontany->update($data_tmp)) {
                    $citizens_index[] = $i;
                }
            }
            if(empty($citizens_index)){
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
     * Load citizen certificate of residence page
     */
    public function load_citizen_certificate()
	{
        $this->load->library('nomenclature');

        $this->data['title'] = $this->lang->line('citizen_residence');

        $str = $this->input->get('id_personne');
        $bigInt = gmp_init($str);
        
        $id_personne = gmp_intval($bigInt);

        $citizen_data = $this->citizen->get_citizen_certificate(['person_id'=>$id_personne]);
        
        $this->data['citizen_data'] = $citizen_data;
        
        $reference = $this->nomenclature->generate_certificat_reference("residence",$this->fokontany_id, $citizen_data[0]->lf_residence);
        
        $this->data['reference'] = $reference;
        $this->data['id_personne'] = $id_personne;
        $this->data['origin_page'] = "residence";
        $this->data['fokontany_id'] = $citizen_data[0]->fokontany_id;
		
        $this->load->view('citizen_certificat', $this->data);
    }
    
    /**
     * Load citizen certificate of life page
     */
    public function certificate_life()
	{
        $this->load->library('nomenclature');

        $this->data['title'] = $this->lang->line('citizen_life');

        $str = $this->input->get('id_personne');
        $bigInt = gmp_init($str);
        $id_personne = gmp_intval($bigInt);

        $citizen_data = $this->citizen->get_citizen_certificate(['person_id'=>$id_personne]);

        $this->data['citizen_data'] = $citizen_data;

        $reference = $this->nomenclature->generate_certificat_reference("life",$this->fokontany_id, $citizen_data[0]->lf_vie);
        
        $this->data['reference'] = $reference;
        $this->data['id_personne'] = $id_personne;
        $this->data['origin_page'] = "vie";
        $this->data['fokontany_id'] = $citizen_data[0]->fokontany_id;
		
        $this->load->view('life_certificat', $this->data);
	}
    
    /**
     * Load citizen certificate of supported page
     */
    public function certificate_supported()
	{
        $this->load->library('nomenclature');

        $this->data['title'] = $this->lang->line('citizen_supported');

        $str = $this->input->get('id_personne');
        $bigInt = gmp_init($str);
        $id_personne = gmp_intval($bigInt);

        $citizen_data = $this->citizen->get_citizen_certificate(['person_id'=>$id_personne]);

        $this->data['citizen_data'] = $citizen_data;

        $reference = $this->nomenclature->generate_certificat_reference("support",$this->fokontany_id, $citizen_data[0]->lf_support);
        
        $this->data['reference'] = $reference;
        $this->data['id_personne'] = $id_personne;
        $this->data['origin_page'] = "support";
        $this->data['fokontany_id'] = $citizen_data[0]->fokontany_id;
		
        $this->load->view('supported_certificat', $this->data);
    }
    
    /**
     * Load citizen certificate of move page
     */
    public function certificate_move()
	{
        $this->load->library('nomenclature');

        $this->data['title'] = $this->lang->line('citizen_move');

        $str = $this->input->get('id_personne');
        $bigInt = gmp_init($str);
        $id_personne = gmp_intval($bigInt);

        $citizen_data = $this->citizen->get_citizen_certificate(['person_id'=>$id_personne]);

        $this->data['citizen_data'] = $citizen_data;

        $reference = $this->nomenclature->generate_certificat_reference("move",$this->fokontany_id, $citizen_data[0]->lf_move);
        
        $this->data['reference'] = $reference;
        $this->data['id_personne'] = $id_personne;
        $this->data['origin_page'] = "move";
        $this->data['fokontany_id'] = $citizen_data[0]->fokontany_id;
		
        $this->load->view('move_certificat', $this->data);
	}
    
    /**
     * Load citizen certificate of celibacy page
     */
    public function certificate_celibat()
	{
        $this->load->library('nomenclature');

        $this->data['title'] = $this->lang->line('citizen_celibacy');

        $str = $this->input->get('id_personne');
        $bigInt = gmp_init($str);
        $id_personne = gmp_intval($bigInt);

        $citizen_data = $this->citizen->get_citizen_certificate(['person_id'=>$id_personne]);

        $this->data['citizen_data'] = $citizen_data;

        $reference = $this->nomenclature->generate_certificat_reference("celibacy",$this->fokontany_id, $citizen_data[0]->lf_celibacy);
        
        $this->data['reference'] = $reference;
        $this->data['id_personne'] = $id_personne;
        $this->data['origin_page'] = "celibacy";
        $this->data['fokontany_id'] = $citizen_data[0]->fokontany_id;

        $this->load->view('celibacy_certificat', $this->data);
	}
    
    /**
     * Load citizen certificate of good behavior page
     */
    public function certificate_behavior()
	{
        $this->load->library('nomenclature');

        $this->data['title'] = $this->lang->line('citizen_good_behavior');

        $str = $this->input->get('id_personne');
        $bigInt = gmp_init($str);
        $id_personne = gmp_intval($bigInt);

        $citizen_data = $this->citizen->get_citizen_certificate(['person_id'=>$id_personne]);

        $this->data['citizen_data'] = $citizen_data;

        $reference = $this->nomenclature->generate_certificat_reference("behavior",$this->fokontany_id, $citizen_data[0]->lf_behavior);
        
        $this->data['reference'] = $reference;
        $this->data['id_personne'] = $id_personne;
        $this->data['origin_page'] = "behavior";
        $this->data['fokontany_id'] = $citizen_data[0]->fokontany_id;
		
        $this->load->view('behavior_certificat', $this->data);
    }

    /**
     * Save modified data from certificate delivery page
     */
	public function check_fields()
	{
        if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
		}

		$data = $this->input->post();
		$person_id = $this->input->post('person_id');
		$missing_fields = [];

		if(!empty($data)){
			if($data['address'] == '') $missing_fields[] = 'address';
			if($data['pdf_file'] == '') $missing_fields[] = 'pdf_file';
			if($data['last_name'] == '') $missing_fields[] = 'last_name';
			if($data['last_name'] == '') $missing_fields[] = 'last_name';
			if($data['birth'] == '') $missing_fields[] = 'birth';
			if($data['birth_place'] == '') $missing_fields[] = 'birth_place';
			if($data['cin'] != ''){
				if($data['cin_place'] == '') $missing_fields[] = 'cin_place';
				if($data['cin_date'] == '') $missing_fields[] = 'cin_date';
            }

			if($data['passport_date'] == "") unset($data['passport_date']);
            
            if($data['nationality'] != "Malgache"){
                $data['cin'] = '';
                $data['cin_date'] = '';
                $data['cin_place'] = '';
            }else{
				$data['passport'] = '';
				unset($data['passport_date']);
				$data['passport_place'] = '';
            }
            if($data['parent_link'] == 'autre')
				$data['parent_link'] = $data['other_pl'];

			if(!empty($missing_fields))
				echo json_encode(['required' => 1, 'missing' => $missing_fields]);
			else{
				unset($data['person_id'], $data['other_pl'], $data['other_job']);

				if($data['cin_date'] == '') unset($data['cin_date']); 

				if($this->citizen->update($data, $person_id))
					echo json_encode(['success' => 1]);
				else echo json_encode(['error' => 1, 'msg' => 'Modification impossible.']);
			}
		}
		else echo json_encode(['error' => 1, 'msg' => 'Aucune donnée à enregistrer.']);
    }
    
    public function generate_certificat_reference(){
        //$reference = dechex($this->fokontany_id);
        $reference = dechex(2);
        
        //$reference = str_pad($reference, 5, '0', STR_PAD_LEFT);
        $reference = str_pad($reference, 5, '0', STR_PAD_LEFT);

        $reference .= '1';

        //2020 is index 1
        $index_year = (int) date("Y");
        $index_year = $index_year - 2019;

        $reference .= $index_year;

        //Ampina date androany
        $reference .= date("ymd");

        // Charger un fichier de configuration des Code des certificats

        //$index = ($certificats) ? count($certificats) + 1 : 1;
        $index = 10;

        $reference .= str_pad($index, 4, '0', STR_PAD_LEFT);
     return $reference;   
    }

    public function speed_search()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
        }
        
        $data = $this->input->get();
        $last_name = $this->input->get('nom');
        $first_name = $this->input->get('prenoms');
        $cin = $this->input->get('cin_personne');

        if($data){
            $criteria = [];
            foreach($data as $key => $value)
                if(!empty($value)) $criteria['LOWER('.$key . ') LIKE '] = '%'.strtolower($value).'%';

            if(empty($criteria)){
                echo json_encode(['success' => 1, 'citizens' => [], 'households' => []]);
                return TRUE;
            }

            $criteria['fokontany_id'] = $this->fokontany_id;
            $citizens = $this->notebook->citizens($criteria);
            
            $criteria['chef_menage'] = TRUE;
            $households = $this->notebook->citizens($criteria);

            if(!empty($citizens) && !empty($households)){
                echo json_encode(['success' => 1, 'citizens' => $citizens, 'households' => $households]);
            }
            else echo json_encode(['success' => 1, 'citizens' => [], 'households' => []]);
        }
        else echo json_encode(['success' => 1, 'citizens' => [], 'households' => []]);
    }

}

