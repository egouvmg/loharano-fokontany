<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Citizen extends Operator_Controller//SuperAdmin_Controller
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
        $this->load->view('index', $this->data);
	}

	public function list_citizens()
	{
        $this->data['title'] = $this->lang->line('dashboard');

        $this->load->view('list_citizen_fk', $this->data);
    }
    
    public function list_households()
    {
        $this->data['title'] = 'Liste des ménages';

        $this->load->view('list_household', $this->data);
    }

    public function add_citizen()
	{
        if($this->session->address && $this->session->household_size){
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
        $this->data['title'] = $this->lang->line('title_residence');

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
            $citizen = $this->citizen->get_citizen(['numero_carnet'=>$numero_carnet]);
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

    public function check_household(Type $var = null)
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }

        $address = $this->input->post('address');
        $household_size = (int) $this->input->post('household_size');

        $missing_fields = [];
        
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
        $reference .= date("Ymd");

        $notebooks = $this->notebook->all(['numero_carnet like' => $reference.'%']);

        $index = ($notebooks) ? count($notebooks) + 1 : 1;

        $reference .= str_pad($index, 4, '0', STR_PAD_LEFT); 

        $data = [
            'numero_carnet' => $reference,
            'adresse_actuelle' => $address,
            'id_registre' => 1
        ];

        if($this->notebook->insert($data))
            return $reference;
        else return false;
    }

    /**
     * Enregistrement/Update from Certificat Résidence
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

            $data_tmp = [
                /*'nom' => $data['last_name'],
                'prenoms' => $data['first_name'],
                'date_de_naissance' => $data['birth'],*/
                'id_personne'=> 2,
                'lieu_de_naissance' => $data['lieu_de_naissance']
                /*'sexe' => $data['sexe'],
                'situation_matrimoniale' => $data['marital_status'],
                'phone' => $data['phone'],
                'father' => $data['father'],
                'father_status' => $data['father_status'],
                'mother' => $data['mother'],
                'mother_status' => $data['mother_status'],
                'job_id' => $data['job_id'],
                'job_other' => $data['job_other'],
                'job_status' => $data['job_status'],
                'nationality_id' => $data['nationality_id']*/
            ];

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

            if(!$this->citizen->update($data_tmp)) {
                $citizens_index[] = $i;
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
        $this->data['title'] = $this->lang->line('citizen_residence');

        $str = $this->input->get('id_personne');
        $bigInt = gmp_init($str);
        $id_personne = gmp_intval($bigInt);

        $citizen_data = $this->citizen->get_citizen_certificate(['person_id'=>$id_personne]);

        $this->data['citizen_data'] = $citizen_data;
		
        $this->load->view('citizen_certificat', $this->data);
    }
    
    /**
     * Load citizen certificate of life page
     */
    public function certificate_life()
	{
        $this->data['title'] = $this->lang->line('citizen_life');

        $str = $this->input->get('id_personne');
        $bigInt = gmp_init($str);
        $id_personne = gmp_intval($bigInt);

        $citizen_data = $this->citizen->get_citizen_certificate(['person_id'=>$id_personne]);

        $this->data['citizen_data'] = $citizen_data;
		
        $this->load->view('life_certificat', $this->data);
	}
    
    /**
     * Load citizen certificate of supported page
     */
    public function certificate_supported()
	{
        $this->data['title'] = $this->lang->line('citizen_supported');

        $str = $this->input->get('id_personne');
        $bigInt = gmp_init($str);
        $id_personne = gmp_intval($bigInt);

        $citizen_data = $this->citizen->get_citizen_certificate(['person_id'=>$id_personne]);

        $this->data['citizen_data'] = $citizen_data;
		
        $this->load->view('supported_certificat', $this->data);
    }
    
    /**
     * Load citizen certificate of move page
     */
    public function certificate_move()
	{
        $this->data['title'] = $this->lang->line('citizen_move');

        $str = $this->input->get('id_personne');
        $bigInt = gmp_init($str);
        $id_personne = gmp_intval($bigInt);

        $citizen_data = $this->citizen->get_citizen_certificate(['person_id'=>$id_personne]);

        $this->data['citizen_data'] = $citizen_data;
		
        $this->load->view('move_certificat', $this->data);
	}
    
    /**
     * Load citizen certificate of celibacy page
     */
    public function certificate_celibat()
	{
        $this->data['title'] = $this->lang->line('citizen_celibacy');

        $str = $this->input->get('id_personne');
        $bigInt = gmp_init($str);
        $id_personne = gmp_intval($bigInt);

        $citizen_data = $this->citizen->get_citizen_certificate(['person_id'=>$id_personne]);

        $this->data['citizen_data'] = $citizen_data;
		
        $this->load->view('celibacy_certificat', $this->data);
	}
    
    /**
     * Load citizen certificate of good behavior page
     */
    public function certificate_behavior()
	{
        $this->data['title'] = $this->lang->line('citizen_good_behavior');

        $str = $this->input->get('id_personne');
        $bigInt = gmp_init($str);
        $id_personne = gmp_intval($bigInt);

        $citizen_data = $this->citizen->get_citizen_certificate(['person_id'=>$id_personne]);

        $this->data['citizen_data'] = $citizen_data;
		
        $this->load->view('behavior_certificat', $this->data);
	}
}

