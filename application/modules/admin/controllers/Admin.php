<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	public function __construct(){
        parent::__construct();

		$this->load->model('admin_model','admin');
	}

	public function index()
	{
        $companies = $this->admin->get_all();
        
		$number_fokontany = $this->fokontany->get_number_of_fokontany();
		$number_fokontany_done = 0;
		$total_fokontany_affected_pending = 0;
		$total_fokontany_remainig_process = 0;
		$number_population = 0;
		$number_population_done = 0;

        $this->data['company_fokontany'] = [];

        if(!empty($companies)){
			$this->data['company_fokontany'] = $this->admin->get_company_fokontany(['company_id' => $companies[0]->company_id]);
			
			foreach($companies as $company){
				$total_fokontany_affected_pending += $this->company->get_number_fokontany($company->company_id);
				$fokontany_id_list = $this->company->get_allIdFokontanyCompany($company->company_id);
				if(!empty($fokontany_id_list)){
					foreach($fokontany_id_list as $value){
                        $number_register_fokontany = $this->company->get_register_fokontany($value->fokontany_id);
                        $number_register_treated_fokontany = $this->company->count_register_treated_fokontany($value->fokontany_id);
				
						$number_people_fokontany = $this->company->get_number_people_fokontany($value->fokontany_id);
						$number_person_treated_fokontany = $this->company->count_person_treated_fokontany($value->fokontany_id);
						$number_population += $number_people_fokontany;
                        $number_population_done += $number_person_treated_fokontany;

						if($number_register_treated_fokontany >= $number_register_fokontany){
							$number_fokontany_done += 1; 
						}
					}
				}
			}
		}
        
        $this->data['provinces'] = $this->province->get_all();
        $this->data['regions'] = $this->region->get_all(['province_id' => $this->data['provinces'][0]->id]);
        $this->data['districts'] = $this->district->get_all(['region_id' => $this->data['regions'][0]->id]);
		$this->data['commons'] = $this->common->get_all(['district_id' => $this->data['districts'][0]->id]);

		$fokontany_list = $this->fokontany->get_all(['common_id' => $this->data['commons'][0]->id]);
		$ftk_company_id_list = $this->fokontany->get_all_fokontany_id_in_acompany();
		$ftk_unavailable_list = array();

		if(!empty($ftk_company_id_list)){
			foreach($ftk_company_id_list as $ftk_comp_id){
				$ftk_unavail = $this->fokontany->get_fokotany_by_id($ftk_comp_id->fokontany_id);
				if(!empty($ftk_unavail))array_push($ftk_unavailable_list, $ftk_unavail[0]);
			}
		}
		$fkt_avilables = $fokontany_list;
		foreach($ftk_unavailable_list as $del_val){
			if (($key = array_search($del_val, $fkt_avilables)) !== false) {
				unset($fkt_avilables[$key]);
			}
		}
		
		$this->data['fokontanies'] = $fokontany_list;
		$this->data['fkt_avilables'] = $fkt_avilables;
        
		if(!empty($companies)){
			$this->data['company_date'] = $this->company->countCompanyFokontanyRegister(['company_id' => $companies[0]->company_id]);

			$this->data['firms_registers'] = $this->load->view('firm_company_item', $this->data, TRUE);
		}

		else
			$this->data['firms_registers'] = 'Traitement encours.';

        $this->data['companies'] = $companies;
        
		$this->data['firm_item'] = $this->load->view('firm_item', $this->data, TRUE);

		$this->data['total_fokontany_affected_pending'] = (int)$total_fokontany_affected_pending - (int)$number_fokontany_done;
		$this->data['total_fokontany_remainig_process'] = (int)$number_fokontany - (int)$number_fokontany_done;
		$this->data['number_fokontany_done'] = $number_fokontany_done;
		$this->data['number_population_pendind'] = $number_population - $number_population_done;
        $this->data['number_population_done'] = $number_population_done;
        
		$this->load->view('index', $this->data);
	}

	public function fokontany_register()
	{

		$this->data['provinces'] = $this->province->get_all();
		$this->data['regions'] = $this->region->get_all(['province_id' => $this->data['provinces'][0]->id]);
		$this->data['districts'] = $this->district->get_all(['region_id' => $this->data['regions'][0]->id]);
		$this->data['commons'] = $this->common->get_all(['district_id' => $this->data['districts'][0]->id]);
		$this->data['fokontanies'] = $this->fokontany->get_all(['common_id' => $this->data['commons'][0]->id]);

		$this->data['fokontany'] = $this->fokontany->get_fokontany_register(['common_id' => $this->data['commons'][0]->id]);

		$this->load->view('fokontany_register', $this->data);
	}

	/*
	 * AJAX
	 */
	public function fokontany_date()
	{
		if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
        }

        $data = $this->input->post();
        $company_id = $this->input->post('company_id');
        $day_done = $this->input->post('day_done');

        if(!empty($data)) {
			$this->data['fr_details'] = $this->company->countCompanyFokontanyRegisterOne($data);
			$this->data['start_company'] = $this->company->get_start_company(['company_id' => $company_id]);
            $this->data['daily_register_fokontany'] = $this->company->total_ddr(['company_id' => $company_id, 'day_done <=' => $day_done]);
            
            foreach($this->data['daily_register_fokontany'] as $key => $drf){
                $_fr = $this->fokontany->get_fokontany_register_one(['fokontany_id' => $drf->fokontany_id]);
                $this->data['daily_register_fokontany'][$key]->t_register = $_fr->nbr_register;
            }

			$firms_registers = $this->load->view('fokotany_date', $this->data, TRUE);

			echo json_encode(['success' => 1, 'html' => $firms_registers]);
        }
        else
        	echo json_encode(['error' => 1, 'msg'=>'Paramètres non définis.']);
 	}

 	public function company_register($value='')
 	{
		if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
        }

        $data = $this->input->post();if(!empty($data)) {
			$this->data['company_date'] = $this->company->countCompanyFokontanyRegister($data);

			echo json_encode(['success' => 1, 'html' => $this->load->view('firm_company_item', $this->data, TRUE)]);
        }
        else
        	echo json_encode(['error' => 1, 'msg'=>'Paramètres non définis.']);
 	}

 	public function get_fk_register()
 	{
		if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
        }

        $data = $this->input->post();if(!empty($data)) {
			$this->data['fokontany'] = $this->fokontany->get_fokontany_register($data);

			echo json_encode(['success' => 1, 'html' => $this->load->view('item_fk_register', $this->data, TRUE)]);
        }
        else
        	echo json_encode(['error' => 1, 'msg'=>'Paramètres non définis.']);
 	}

 	public function save_fk_register()
 	{
		if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
        }

        $province = $this->input->get('province');
        $region = $this->input->get('region');
        $district = $this->input->get('district');
        $common = $this->input->get('common');
        $fokontany = $this->input->get('fokontany');
        $people = $this->input->get('people');
        $register = $this->input->get('register');

        if(empty($province) || empty($region) || empty($district) || empty($common) || empty($fokontany) || empty($people) || empty($register))
        	echo json_encode(['error' => 1, 'msg'=>'Paramètres non définis.']);
        else if($register > $people)
        	echo json_encode(['error' => 1, 'msg'=>'Le nombre de registres ne peut dépasser le nombre de personnes']);
        else{
        	$data = [
        		'fokontany_id' => $fokontany,
        		'people' => $people,
        		'nbr_register' => $register
        	];

        	if($this->fokontany->insert_fk_register($data))
        		echo json_encode(['success'=>1, 'msg' => 'Enregistrement terminé.']);
        	else
        		echo json_encode(['error' => 1, 'msg'=>'Paramètres non définis.']);
        }
 	}

 	public function edit_fk_register()
 	{
		if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
        }
        $fokontany = $this->input->get('fokontany');
        $people = $this->input->get('people');
        $register = $this->input->get('register');
        $n_people = $this->input->get('n_people');
        $n_register = $this->input->get('n_register');

        if(empty($fokontany)){
        	echo json_encode(['error' => 1, 'msg'=>'Paramètres non définis.']);
        	return false;
        }
        else if(empty($people) || empty($register)){
        	if(!is_numeric($people) || !is_numeric($register)){
        		echo json_encode(['error' => 1, 'msg'=>'Paramètres non définis.']);
        		return false;
        	}
        }
        else if($n_register > $n_people){
        	echo json_encode(['error' => 1, 'msg'=>'Le nombre de registres ne peut dépasser le nombre de personnes']);
        	return TRUE;
        }

    	$data = [
    		'fokontany_id' => $fokontany,
    		'people' => $people,
    		'nbr_register' => $register
    	];

    	if($this->fokontany->insert_fk_register($data))
    		echo json_encode(['success'=>1, 'msg' => 'Modification enrgistrée.']);
    	else
    		echo json_encode(['error' => 1, 'msg'=>'Paramètres non définis.']);
 	}

    public function save_company_account()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
        }

        $n_company = $this->input->get('n_company');
        $n_email = $this->input->get('n_email');
        $n_password = $this->input->get('n_password');
        $n_confirm_pwd = $this->input->get('n_confirm_pwd');
        $no_operator = $this->input->get('no_operator');
        $no_email = $this->input->get('no_email');
        $no_password = $this->input->get('no_password');
        $no_confirm_pwd = $this->input->get('no_confirm_pwd');

        $missing_fields = [];
        $short_pwd = [];
        $wrong_pwd = [];

        if(empty($n_company))
            $missing_fields[] = 'n_company';
        if(empty($n_email))
            $missing_fields[] = 'n_email';
        if(empty($n_password))
            $missing_fields[] = 'n_password';
        if(empty($n_confirm_pwd))
            $missing_fields[] = 'n_confirm_pwd';
        if(empty($no_operator))
            $missing_fields[] = 'no_operator';
        if(empty($no_email))
            $missing_fields[] = 'no_email';
        if(empty($no_password))
            $missing_fields[] = 'no_password';
        if(empty($no_confirm_pwd))
            $missing_fields[] = 'no_confirm_pwd';

        if(!empty($missing_fields)){
            echo json_encode(['error' => 1, 'missing_fields' => $missing_fields]);
            return false;
        }

        if(strlen($n_password) < 8)
            $short_pwd[] = 'n_password';
        if(strlen($no_password) < 8)
            $short_pwd[] = 'no_password';

        if(!empty($short_pwd)){
            echo json_encode(['error' => 1, 'short_pwd' => $short_pwd]);
            return false;
        }

        if($n_password != $n_confirm_pwd){
            $wrong_pwd[] = 'n_password';
        }
        if($no_password != $no_confirm_pwd)
            $wrong_pwd[] = 'no_password';

        if(!empty($wrong_pwd)){
            echo json_encode(['error' => 1, 'wrong_pwd' => $wrong_pwd]);
            return false;
        }

        if($this->company->get_all(['LOWER(name)' => strtolower($n_company)])){
            echo json_encode(['error' => 1, 'exist' => 'Le nom de la société existe déjà']);
            return false;
        }

        //Creating company
        $company_id = $this->company->insert(['name' => $n_company, 'email' => $n_email]);

        if($company_id){
            if($this->ion_auth->register($n_email, $n_password, $n_email, ['company_id' => $company_id, 'first_name' => $n_company, 'current_pwd' => $n_password], [3])){
                if($this->ion_auth->register($no_email, $no_password, $no_email, ['company_id' => $company_id, 'first_name' => $no_operator, 'current_pwd' => $no_password], [2])){
                    echo json_encode(['success'=>1, 'msg'=>'Enregistrement réussi']);
                }
                else
                    echo json_encode(['error' => 1, 'msg' => 'Impossible de créer le compte opérateur de la société.']);
            }
            else
                echo json_encode(['error' => 1, 'msg' => 'Impossible de créer le compte société.']);
        }
        else
            echo json_encode(['error' => 1, 'msg' => 'Impossible de créer la société.']);
    }

    public function save_company_fokontany()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
        }

        $data = $this->input->post();
        $company_id = $this->input->post('company_id');
        $fokontany_id = $this->input->post('fokontany_id');
        
        if(!($this->admin->get_number_people_fokontany($fokontany_id))){
            echo json_encode(['error'=>1, 'msg' => 'Ce fokontany ne dispose pas de nombre de registre.']);
        }
        else if(!empty($fokontany_id) || !empty($company_id)){
            if($this->admin->save_company_fokontany($data))
                echo json_encode(['success'=>1, 'msg' => 'Enregistrement terminé.', 'fokontany_id' => $fokontany_id]);
            else
                echo json_encode(['error'=>1, 'msg' => 'Enregistreent impossible.']);
        }
        else
            echo json_encode(['error' => 1, 'msg'=>'Paramètres non définis.']);
    }

    public function get_companyaccount()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
        }

        $company_id = $this->input->post('company_id');

        if(!empty($company_id)){
            $company_account = $this->admin->get_companyaccount(['company_id'=>$company_id]);
            if($company_account){
                $this->data['ca'] = $company_account;
                echo json_encode(['success' => 1, 'form' => $this->load->view('edit_account', $this->data, TRUE)]);
            }
            else
                echo json_encode(['error' => 1, 'msg'=>'Société invalide']);
        }
        else
            echo json_encode(['error' => 1, 'msg'=>'Paramètres non définis.']);
    }

    public function edit_companyaccount()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
        }

        $e_admin_id = $this->input->get('e_admin_id');
        $e_operator_id = $this->input->get('e_operator_id');
        $e_company_id = $this->input->get('e_company_id');
        $e_company = $this->input->get('e_company');
        $e_email = $this->input->get('e_email');
        $e_password = $this->input->get('e_password');
        $e_confirm_pwd = $this->input->get('e_confirm_pwd');
        $eo_operator = $this->input->get('eo_operator');
        $eo_email = $this->input->get('eo_email');
        $eo_password = $this->input->get('eo_password');
        $eo_confirm_pwd = $this->input->get('eo_confirm_pwd');

        $missing_fields = [];
        $short_pwd = [];
        $wrong_pwd = [];

        if(empty($e_company))
            $missing_fields[] = 'e_company';
        if(empty($e_email))
            $missing_fields[] = 'e_email';
        if(empty($e_password))
            $missing_fields[] = 'e_password';
        if(empty($e_confirm_pwd))
            $missing_fields[] = 'e_confirm_pwd';
        if(empty($eo_operator))
            $missing_fields[] = 'eo_operator';
        if(empty($eo_email))
            $missing_fields[] = 'eo_email';
        if(empty($eo_password))
            $missing_fields[] = 'eo_password';
        if(empty($eo_confirm_pwd))
            $missing_fields[] = 'eo_confirm_pwd';

        if(!empty($missing_fields)){
            echo json_encode(['error' => 1, 'missing_fields' => $missing_fields]);
            return false;
        }

        if(strlen($e_password) < 8)
            $short_pwd[] = 'e_password';
        if(strlen($eo_password) < 8)
            $short_pwd[] = 'eo_password';

        if(!empty($short_pwd)){
            echo json_encode(['error' => 1, 'short_pwd' => $short_pwd]);
            return false;
        }
        
        if($this->company->get_all(['LOWER(name)' => strtolower($e_company), 'id != '=> $e_company_id])){
            echo json_encode(['error' => 1, 'exist' => 'Le nom de la société existe déjà']);
            return false;
        }
        
        if($this->company->get_all(['email' => $e_email, 'id != '=> $e_company_id])){
            echo json_encode(['error' => 1, 'exist' => 'L\'adresse email existe déjà']);
            return false;
        }

        if($this->ion_auth->reset_password($e_email, $e_password)){
            if($this->ion_auth->reset_password($eo_email, $eo_password)){
                $_data = [
                    [
                        'id' => $e_admin_id,
                        'first_name' => $e_company,
                        'email' => $e_email,
                        'current_pwd' => $e_password
                    ],
                    [
                        'id' => $e_operator_id,
                        'first_name' => $eo_operator,
                        'email' => $eo_email,
                        'current_pwd' => $eo_password
                    ]
                ];
                if($this->admin->edit_user('id', $_data))
                    echo json_encode(['success' => 1, 'msg' => 'Modification terminée.']);
                else
                    echo json_encode(['error' => 1, 'msg' => 'Impossible d\'apporter une modification aux compte de la société.']);
            }       
            else
                echo json_encode(['error' => 1, 'msg' => 'Impossible d\'apporter une modification au compte opérateur de la société.']);
        }
        else
            echo json_encode(['error' => 1, 'msg' => 'Impossible d\'apporter une modification au compte administrateur de la société.']);
    }

    public function delete_company_fokontany()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
        }

        $data = $this->input->get();
        $company_id = $this->input->get('company_id');
        $fokontany_id = $this->input->get('fokontany_id');

        if(!empty($fokontany_id) || !empty($company_id)){
            if($this->admin->delete($data))
                echo json_encode(['success'=>1, 'msg' => 'Enregistrement terminé.','fokontany_id'=>$fokontany_id]);
            else
                echo json_encode(['error'=>1, 'msg' => 'Enregistreent impossible.']);
        }
        else
            echo json_encode(['error' => 1, 'msg'=>'Paramètres non définis.']);
    }

    public function get_company_register()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
        }

        $company_id = $this->input->post('company_id');

        if(!empty($fokontany_id) || !empty($company_id)){
            $companyregister = $this->admin->get_company_fokontany(['company_id' => $company_id]);

            $this->data['company_fokontany'] = $companyregister;
            $company_fokontany = $this->load->view('company_register', $this->data, TRUE);
            echo json_encode(['success'=>1, 'companyregister' => $company_fokontany]);
        }
        else
            echo json_encode(['error' => 1, 'msg'=>'Paramètres non définis.']);
    }
    
    public function tracking_attachement()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
        }

        $company_id = $this->input->post('company_id');

        if($company_id){
            $_done_company = $this->company->get_done_company(['company_id' => $company_id]);
            $_start_company = $this->company->get_start_company(['company_id' => $company_id]);
            $avg_company = $this->admin->avg_company(['company_id' => $company_id]);

            $this->data['done_company'] = $_done_company;
            $this->data['start_company'] = $_start_company;

            $this->data['avg_company'] = $avg_company;

            echo json_encode(['success'=>1, 'tracking'=>$this->load->view('tracking_attachement', $this->data, TRUE)]);
        }
        else
            echo json_encode(['error' => 1, 'msg' => 'Impossible de charger le suivi de saisies. Société non fournie.']);
    }
    
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

				if($this->person->update($data, $person_id))
					echo json_encode(['success' => 1]);
				else echo json_encode(['error' => 1, 'msg' => 'Modification impossible.']);
			}
		}
		else echo json_encode(['error' => 1, 'msg' => 'Aucune donnée à enregistrer.']);
	}

	public function get_all_fokontanyTreaty(){
		if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
		}

		$companies = $this->admin->get_all();
		$fokontany_treaty = array();

		if(!empty($companies)){
			foreach($companies as $company){
				$fokontany_id_list = $this->company->get_allIdFokontanyCompany($company->company_id);
				if(!empty($fokontany_id_list)){
					foreach($fokontany_id_list as $value){
                        $number_register_fokontany = $this->company->get_register_fokontany($value->fokontany_id);
                        $number_register_treated_fokontany = $this->company->count_register_treated_fokontany($value->fokontany_id);
                        
                        if($number_register_treated_fokontany >= $number_register_fokontany){
							$ftk_treaty = $this->fokontany->get_fokontany_treaty_by_id($value->fokontany_id);
							if(!empty($ftk_treaty))array_push($fokontany_treaty, $ftk_treaty[0]);
						}
					}
				}
			}
		}
		echo json_encode($fokontany_treaty);
	}

	public function get_all_fokontanyNeedTreat(){
		if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
		}
		
		$companies = $this->admin->get_all();
		$fokontany_treaty = array();
		$fokontanyAffected = array();

        if(!empty($companies)){
			foreach($companies as $company){
				$fokontany_id_list = $this->company->get_allIdFokontanyCompany($company->company_id);
				if(!empty($fokontany_id_list)){
					foreach($fokontany_id_list as $value){
                        $number_register_fokontany = $this->company->get_register_fokontany($value->fokontany_id);
                        $number_register_treated_fokontany = $this->company->count_register_treated_fokontany($value->fokontany_id);
                        
                        if($number_register_treated_fokontany < $number_register_fokontany){
							$fkt_affected = $this->fokontany->get_fokontany_treaty_by_id($value->fokontany_id);	
						    if(!empty($fkt_affected))array_push($fokontanyAffected, $fkt_affected[0]);
						}
					}
				}
			}
		}
        
		echo json_encode($fokontanyAffected);
		
	}

    public function get_all_peopleTreaty()
    {
		if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
		}

		$peopleTreaty = $this->person->get_person_treaty();
		echo json_encode($peopleTreaty);
    }
    
    public function get_people_treaty_daily()
    {
		if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
        }
        
        $day = $this->input->get('day');
        $company_id = $this->input->get('company_id');

        if(empty($day) || empty($company_id))
            echo json_encode(['lol']);
        else{

            $users = $this->ion_auth->users($this->config->item('loharano_operator'))->result();
            $key = array_search($company_id, array_column($users, 'company_id'));
            
            $peopleTreaty = $this->person->get_all(['created_on' => $day, 'created_by' => $users[$key]->id]);
            echo json_encode($peopleTreaty);
        }
    }

    //*******************Create operateur/sefo fokontany account **************************/
    public function save_operateur_sefo_account()
    {
        /*if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
        }*/

        $data = $this->input->post();       

        $type_compte = $this->input->post('type_compte');
        $n_firstname = $this->input->post('first_name');
        $n_email = $this->input->post('email');
        $n_password = $this->input->post('password');
        $n_confirm_pwd = $this->input->post('confirm_password');
        $fokontany_id = $this->input->post('fokontany');

        $missing_fields = [];
        $short_pwd = [];
        $wrong_pwd = [];
        
        if(empty($type_compte))
            $missing_fields[] = 'type_compte';
        if(empty($n_firstname))
            $missing_fields[] = 'n_firstname';
        if(empty($n_email))
            $missing_fields[] = 'n_email';
        if(empty($n_password))
            $missing_fields[] = 'n_password';
        if(empty($n_confirm_pwd))
            $missing_fields[] = 'n_confirm_pwd';
        if(empty($fokontany_id))
            $missing_fields[] = 'fokontany_id';    

        if(!empty($missing_fields)){
            echo json_encode(['error' => 1, 'missing_fields' => $missing_fields]);
            return false;
        }

        if(strlen($n_password) < 8)
            $short_pwd[] = 'n_password';
        if(strlen($n_confirm_pwd) < 8)
            $short_pwd[] = 'n_confirm_pwd';

        if(!empty($short_pwd)){
            echo json_encode(['error' => 1, 'short_pwd' => $short_pwd]);
            return false;
        }

        if($n_password != $n_confirm_pwd){
            $wrong_pwd[] = 'n_password';
        }

        if(!empty($wrong_pwd)){
            echo json_encode(['error' => 1, 'wrong_pwd' => $wrong_pwd]);
            return false;
        }
        
        if(!empty($type_compte)){
            $type_compte = $type_compte=="sefo_kontany"? 3 : 4 ;
               try{
                $user_id = $this->ion_auth->register($n_email, $n_password, $n_email, ['first_name' => $n_firstname, 'current_pwd' => $n_password], [$type_compte]);
                if($user_id){                   
                    $data = array(
                        'user_id' => $user_id ,
                        'fokontany_id' => $fokontany_id
                    ); 
                    // A appeler depuis le model                    
                    if($this->db->insert("user_fokontany", $data)){
                        echo json_encode(['success'=>1, 'msg'=>'Enregistrement réussi']);
                    }else
                        echo json_encode(['error' => 1, 'msg' => 'Impossible de créer le compte.']); 
                    }                          
                }
                catch(Exception $e){
                    echo json_encode(['error' => 1, 'msg' => 'Impossible de créer le compte.']);
                }           
        }
    }
}