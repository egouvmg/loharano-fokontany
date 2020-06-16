<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Chief extends Chief_Controller
{
    private $borough_id;

	public function __construct(){
        parent::__construct();
        
        $this->load->model('chief_model', 'chief');
        $this->load->model('user/user_model', 'user');
        $this->load->model('territory/notebook_model', 'notebook');
        
        //Location Models
		$this->load->model('territory/province_model', 'province');
		$this->load->model('territory/region_model', 'region');
		$this->load->model('territory/district_model', 'district');
		$this->load->model('territory/common_model', 'common');
		$this->load->model('territory/borough_model', 'borough');
        $this->load->model('territory/fokontany_model', 'fokontany');

        $this->lang->load('citizen', $this->session->site_lang);
        $this->lang->load('job', $this->session->site_lang);
        $this->lang->load('nationality', $this->session->site_lang);
        
        $user_borough = $this->chief->getUserBorough($this->session->user_id);
        $this->borough_id = (int) $user_borough->borough_id;

        $this->data['info_borough'] = $user_borough;
        $this->data['user_borough'] = ($user_borough) ? $user_borough->borough_name : '...';

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
        
		$this->data['fokontanies'] = $this->fokontany->get_all(['borough_id' => $this->borough_id]);
		
        $this->load->view('add_user', $this->data);
    }

    public function list_households()
    {
        $this->data['title'] = 'Liste des ménages';

        $this->load->view('list_household', $this->data);
    }

	public function list_citizens()
	{
        $this->data['title'] = 'Liste des citoyens';

        $this->load->view('list_citizens', $this->data);
    }

	public function list_users()
	{
        $this->data['title'] = "Liste des utilisateurs Fokontany";

        $this->load->view('list_user', $this->data);
    }

	public function save_user()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
        }

        $data = $this->input->post();       

        $n_firstname = $this->input->post('first_name');
        $n_email = $this->input->post('email');
        $n_password = $this->input->post('password');
        $n_confirm_pwd = $this->input->post('confirm_password');
        $fokontany_id = $this->input->post('fokontany');
        $phone = $this->input->post('phone');
        $address = $this->input->post('address');

        $missing_fields = [];
        $short_pwd = [];
        $wrong_pwd = [];
        
        if(empty($n_firstname))
            $missing_fields[] = ['first_name', 'Nom de l\'opérateur obligatoire.'];
        if(empty($n_email))
            $missing_fields[] = ['email', 'Email obligatoire'];
        if(empty($n_password))
            $missing_fields[] = ['password', 'Mot de passe obligatoire'];
        if(empty($n_confirm_pwd))
            $missing_fields[] = ['confirm_pwd', 'Veuillez confirmer le mot de passe'];
        if(empty($fokontany_id))
            $missing_fields[] = ['fokontany_id', 'Choisissez un Fokontany'];    
        if(empty($phone))
            $missing_fields[] = ['phone', 'Choisissez un Fokontany'];    
        if(empty($address))
            $missing_fields[] = ['address', 'Choisissez un Fokontany'];    

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
        
        try{
            $user_id = $this->ion_auth->register($n_email, $n_password, $n_email, ['phone' =>$phone, 'address' => $address, 'first_name' => $n_firstname, 'current_pwd' => $n_password], [$this->config->item('group_operator')]);
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
            }
            else{
                echo json_encode(['failed' => 1, 'msg' => 'Email déjà utilisé.']); 
            }                        
        }
        catch(Exception $e){
            echo json_encode(['failed' => 1, 'msg' => 'Impossible de créer le compte.']);
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

    public function get_users()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }
        
        $_users = $this->user->getUsersFokontany(['borough_id' => $this->borough_id]);

        $users = ($_users) ? $_users : [];
        
        echo json_encode($users);
    }

    public function households_list()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }

        $data = ['borough_id' => $this->borough_id, 'chef_menage' => TRUE];
        
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

    public function citizens_list()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }

        $citizens = $this->notebook->citizens(['borough_id' => $this->borough_id]);
        echo json_encode($citizens);
    }
}

