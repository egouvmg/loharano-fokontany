<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends SuperAdmin_Controller
{
	public function __construct(){
        parent::__construct();
        
        $this->load->model('user_model', 'user');
        
        //Location Models
		$this->load->model('territory/province_model', 'province');
		$this->load->model('territory/region_model', 'region');
		$this->load->model('territory/district_model', 'district');
		$this->load->model('territory/common_model', 'common');
		$this->load->model('territory/borough_model', 'borough');
        $this->load->model('territory/fokontany_model', 'fokontany');

		$this->load->model('auth/ion_auth_model', 'ion_auth');

        $this->lang->load('user', $this->session->site_lang);
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
		$this->data['title'] = "Ajout d'un Chef d'Arrondissement";

        $this->data['provinces'] = $this->province->get_all();
        $this->data['regions'] = $this->region->get_all(['province_id' => $this->data['provinces'][0]->id]);
        $this->data['districts'] = $this->district->get_all(['region_id' => $this->data['regions'][0]->id]);
		$this->data['commons'] = $this->common->get_all(['district_id' => $this->data['districts'][0]->id]);
		$this->data['boroughs'] = $this->borough->get_all(['common_id' => $this->data['commons'][0]->id]);
		$this->data['fokontanies'] = $this->fokontany->get_all(['borough_id' => $this->data['boroughs'][0]->id]);

        $this->load->view('add_chief', $this->data);
    }

	public function list_user()
	{
		$this->data['title'] = "Liste des opérateurs Fokontany";

        $this->data['provinces'] = $this->province->get_all();
        $this->data['regions'] = $this->region->get_all(['province_id' => $this->data['provinces'][0]->id]);
        $this->data['districts'] = $this->district->get_all(['region_id' => $this->data['regions'][0]->id]);
		$this->data['commons'] = $this->common->get_all(['district_id' => $this->data['districts'][0]->id]);
		$this->data['boroughs'] = $this->borough->get_all(['common_id' => $this->data['commons'][0]->id]);
		$this->data['fokontanies'] = $this->fokontany->get_all(['borough_id' => $this->data['boroughs'][0]->id]);

        $this->load->view('list_user', $this->data);
    }

	public function save_user()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
        }

        $data = $this->input->post();       

        $type_compte = $this->input->post('type_compte');
        $n_firstname = $this->input->post('first_name');
        $n_email = $this->input->post('email');
        $n_password = $this->input->post('password');
        $n_confirm_pwd = $this->input->post('confirm_password');
        $fokontany_id = $this->input->post('fokontany');
        $phone = $this->input->post('phone');
        $address = $this->input->post('address');

        $missing_fields = [];
        
        if(empty($type_compte))
            $missing_fields[] = ['type_compte','Type de compte non défini.'];
        if(empty($n_firstname))
            $missing_fields[] = ['first_name', 'Nom de l\'opérateur obligatoire.'];
        if(empty($n_email))
            $missing_fields[] = ['email', 'Email obligatoire'];
        if(empty($n_password))
            $missing_fields[] = ['password', 'Mot de passe obligatoire'];
        if(empty($address))
            $missing_fields[] = ['address', 'Champs requis'];
        if(empty($phone))
            $missing_fields[] = ['phone', 'Champs requis'];
        if(empty($n_confirm_pwd))
            $missing_fields[] = ['confirm_pwd', 'Veuillez confirmer le mot de passe'];
        if(empty($fokontany_id))
            $missing_fields[] = ['fokontany_id', 'Choisissez un Fokontany'];    

        if(!empty($missing_fields)){
            echo json_encode(['error' => 1, 'missing_fields' => $missing_fields]);
            return false;
        }

        if(strlen($n_password) < 8 || strlen($n_confirm_pwd) < 8){
			$missing_fields[] = ['password', 'La longueur de mote de passe doit être supérieure ou égale à 8'];
			$missing_fields[] = ['confirm_pwd', 'La longueur de mote de passe doit être supérieure ou égale à 8'];

            echo json_encode(['error' => 1, 'missing_fields' => $missing_fields]);
            return false;
		}

        if($n_password != $n_confirm_pwd){
			$missing_fields[] = ['confirm_pwd', 'Confirmation incorrecte.'];
			
            echo json_encode(['error' => 1, 'missing_fields' => $missing_fields]);
			return false;
		}
        
        if(!empty($type_compte)){
            $type_compte = $type_compte=="sefo_kontany"? 3 : 4 ;
            try{
                $user_id = $this->ion_auth->register($n_email, $n_password, $n_email, ['phone' =>$phone, 'address' => $address, 'first_name' => $n_firstname, 'current_pwd' => $n_password], [$type_compte]);
                if($user_id){                   
                    $data = array(
                        'user_id' => $user_id ,
                        'fokontany_id' => $fokontany_id
                    ); 
                    // A appeler depuis le model                    
                    if($this->db->insert("user_fokontany", $data)){
                        echo json_encode(['success'=>1, 'msg'=>'Enregistrement réussi']);
                    }else
                        echo json_encode(['failed' => 1, 'msg' => 'Impossible de créer le compte.']); 
                }else echo json_encode(['failed' => 1, 'msg' => 'Impossible de créer le compte. L\'adresse email est déjà utilisé.']);
            }
            catch(Exception $e){
                echo json_encode(['failed' => 1, 'msg' => 'Impossible de créer le compte.']);
            }           
        }
        else {
            echo json_encode(['failed' => 1, 'msg' => 'Type de compte non défini.']); 
        }
    }

    public function edit_user()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
        }

        $data = $this->input->post();       

        $n_firstname = $this->input->post('first_name');
        $n_email = $this->input->post('email');
        $n_password = $this->input->post('password');
        $old_pwd = $this->input->post('old_pwd');
        $phone = $this->input->post('phone');
        $address = $this->input->post('address');

        $missing_fields = [];
        
        if(empty($n_firstname))
            $missing_fields[] = ['first_name', 'Nom de l\'opérateur obligatoire.'];
        if(empty($n_email))
            $missing_fields[] = ['email', 'Email obligatoire'];
        if(empty($n_password))
            $missing_fields[] = ['password', 'Mot de passe obligatoire'];
        if(empty($address))
            $missing_fields[] = ['address', 'Champs requis'];
        if(empty($phone))
            $missing_fields[] = ['phone', 'Champs requis'];    

        if(!empty($missing_fields)){
            echo json_encode(['error' => 1, 'missing_fields' => $missing_fields]);
            return false;
        }

        if(strlen($n_password) < 8){
			$missing_fields[] = ['password', 'La longueur de mote de passe doit être supérieure ou égale à 8'];

            echo json_encode(['error' => 1, 'missing_fields' => $missing_fields]);
            return false;
		}

        try{
            if($this->ion_auth->change_password($n_email, $old_pwd, $n_password)){
                echo json_encode(['success'=>1, 'msg'=>'Modification réussie']);
            }else echo json_encode(['failed' => 1, 'msg' => 'Impossible de modifier le compte.']);
        }
        catch(Exception $e){
            echo json_encode(['failed' => 1, 'msg' => 'Impossible de créer le compte.']);
        }
    }

	public function save_chief()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
        }

        $data = $this->input->post();       

        $type_compte = $this->input->post('type_compte');
        $n_firstname = $this->input->post('first_name');
        $n_email = $this->input->post('email');
        $n_password = $this->input->post('password');
        $n_confirm_pwd = $this->input->post('confirm_password');
        $borough_id = $this->input->post('borough_id');
        $phone = $this->input->post('phone');
        $address = $this->input->post('address');

        $missing_fields = [];
        
        if(empty($type_compte))
            $missing_fields[] = ['type_compte','Type de compte non défini.'];
        if(empty($n_firstname))
            $missing_fields[] = ['first_name', 'Nom de l\'opérateur obligatoire.'];
        if(empty($n_email))
            $missing_fields[] = ['email', 'Email obligatoire'];
        if(empty($n_password))
            $missing_fields[] = ['password', 'Mot de passe obligatoire'];
        if(empty($n_confirm_pwd))
            $missing_fields[] = ['confirm_pwd', 'Veuillez confirmer le mot de passe'];
        if(empty($borough_id))
            $missing_fields[] = ['borough_id', 'Choisissez une Commune']; 
        if(empty($phone))
            $missing_fields[] = ['phone', 'Champs requis'];
        if(empty($address))
            $missing_fields[] = ['address', 'Champs requis'];     

        if(!empty($missing_fields)){
            echo json_encode(['error' => 1, 'missing_fields' => $missing_fields]);
            return false;
        }

        if(strlen($n_password) < 8 || strlen($n_confirm_pwd) < 8){
			$missing_fields[] = ['password', 'La longueur de mote de passe doit être supérieure ou égale à 8'];
			$missing_fields[] = ['confirm_pwd', 'La longueur de mote de passe doit être supérieure ou égale à 8'];

            echo json_encode(['error' => 1, 'missing_fields' => $missing_fields]);
            return false;
		}

        if($n_password != $n_confirm_pwd){
			$missing_fields[] = ['confirm_pwd', 'Confirmation incorrecte.'];
			
            echo json_encode(['error' => 1, 'missing_fields' => $missing_fields]);
			return false;
		}
        
        if(!empty($type_compte)){
            try{
                $user_id = $this->ion_auth->register($n_email, $n_password, $n_email, ['phone' =>$phone, 'address' => $address, 'first_name' => $n_firstname, 'current_pwd' => $n_password], [$this->config->item('group_chief')]);

                if($user_id){                   
                    $data = array(
                        'user_id' => $user_id ,
                        'borough_id' => $borough_id
                    ); 
                    // A appeler depuis le model                    
                    if($this->db->insert("user_borough", $data)){
                        echo json_encode(['success'=>1, 'msg'=>'Enregistrement réussi']);
                    }else
                        echo json_encode(['failed' => 1, 'msg' => 'Impossible de créer le compte.']); 
                }else echo json_encode(['failed' => 1, 'msg' => 'Impossible de créer le compte. L\'adresse email est déjà utilisé.']);                    
            }
            catch(Exception $e){
                echo json_encode(['failed' => 1, 'msg' => 'Impossible de créer le compte.']);
            }           
        }
        else {
            echo json_encode(['failed' => 1, 'msg' => 'Type de compte non défini.']); 
        }
    }

    /*
     * AJAX Requests
     */

    public function a_users_fokontany()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }

        $fokontany_id = $this->input->get('fokontany_id');

        $users = $this->user->getUsersFokontany(['group_id >=' => $this->config->item('group_operator'), 'fokontany_id' => $fokontany_id]);
        echo json_encode($users);
    }
}

