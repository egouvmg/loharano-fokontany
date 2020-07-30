<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Household extends Operator_Controller
{
    private $fokontany_id;

	public function __construct(){
        parent::__construct();

        $this->load->model('register/register_model', 'register');
        $this->load->model('citizen/citizen_model', 'citizen');
        $this->load->model('territory/fokontany_model', 'fokontany');
        $this->load->model('territory/notebook_model', 'notebook');
        $this->load->model('user/user_model', 'user');

        $user_fokontany = $this->user->getUserFokontany($this->session->user_id);
        if(isset($user_fokontany))
            $this->fokontany_id = (int) $user_fokontany->fokontany_id;
	}

    public function adding_citizen()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }

        $data = $this->input->post();
        $requireds = ['last_name', 'birth', 'birth_place'];

        if($data){
            $missing_fields = [];

            for ($i=0; $i < 1 ; $i++) {
                $index = $i +1;

                foreach($requireds as $required)
                    if(empty($data[$required][$i])) $missing_fields[] = [$required.$index ,'Champ requis.'];
            }

            for ($i=0; $i < 1 ; $i++) {
                $index = $i +1;

                if($data['nationality_id'][$i] == 1){  
                    $requireds_cin = ['cin', 'cin_date', 'cin_place'];            
                    $cin = [$data['cin'][$i], $data['cin_date'][$i], $data['cin_place'][$i]];
                    
                    if($data['cin'][$i] != '' || $data['cin_date'][$i] != '' || $data['cin_place'][$i] != ''){
                        foreach($requireds_cin as $required)
                            if(empty($data[$required][$i])) $missing_fields[] = [$required.$index ,'Champ requis.'];
                        
                        if($data['cin_date'][$i] != ''){
                            $d1 = new DateTime($data['birth'][$i]);
                            $d2 = new DateTime();

                            $diff = $d2->diff($d1);

                            if($diff->y < 16)
                                $missing_fields[] = ['cin'.$index ,'Le citoyen doit avoir plus de 16 ans pour avoir une CIN.'];
                        }
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

            $notebook = $this->session->add_to;

            if($notebook == FALSE){
                echo json_encode(['failed' => 1, 'msg' => 'Impossible de créer un nouveau carnet.']);
                return FALSE;
            }

            /*
             *  Insertion Personnes
             */

            $citizens_index = [];

            for ($i=0; $i < 1 ; $i++) {
                //Check if is citizen already in database
                $criteria["REPLACE(LOWER(TRIM(nom)), ' ', '') = "] = strtolower(preg_replace("/\s+/", "", $data['last_name'][$i]));
                $criteria["REPLACE(LOWER(TRIM(prenoms)), ' ', '') = "] = strtolower(preg_replace("/\s+/", "", $data['first_name'][$i]));

                $tmp_date = new DateTime($data['birth'][$i]);
                $criteria['date_de_naissance'] = $tmp_date->format('d/m/Y');

                $criteria["REPLACE(LOWER(TRIM(lieu_de_naissance)), ' ', '') = "] = strtolower(preg_replace("/\s+/", "", $data['birth_place'][$i]));
                $criteria["REPLACE(LOWER(TRIM(mother)), ' ', '') = "] = strtolower(preg_replace("/\s+/", "", $data['mother'][$i]));

                $citizen_exist = $this->notebook->searchOne($criteria);

                if($citizen_exist){                
                    echo json_encode(['failed' => 1, 'msg' => 'Le citoyen est déjà enregistré dans le Fokontany '. $citizen_exist->fokontany_name]);
                    return false;
                }

                $criteria = strtolower($data['last_name'][$i]);
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

            $this->session->unset_userdata('add_to');

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
}

