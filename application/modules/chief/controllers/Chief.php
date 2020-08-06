<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Chief extends Chief_Controller
{
    private $borough_id;

	public function __construct(){
        parent::__construct();
        
        $this->load->model('chief_model', 'chief');
        $this->load->model('user/user_model', 'user');
        $this->load->model('territory/notebook_model', 'notebook');
        $this->load->model('citizen/citizen_model', 'citizen');

		$this->load->model('auth/ion_auth_model', 'ion_auth');
        
        //Location Models
		$this->load->model('territory/province_model', 'province');
		$this->load->model('territory/region_model', 'region');
		$this->load->model('territory/district_model', 'district');
		$this->load->model('territory/common_model', 'common');
		$this->load->model('territory/borough_model', 'borough');
        $this->load->model('territory/fokontany_model', 'fokontany');

        $this->lang->load('citizen', $this->session->site_lang);
        
        $user_borough = $this->chief->getUserBorough($this->session->user_id);
        $this->borough_id = (int) $user_borough->borough_id;
        
        $this->lang->load('job', $this->session->site_lang);
        $this->lang->load('nationality', $this->session->site_lang);

        $this->data['info_borough'] = $user_borough;
        $this->data['user_borough'] = ($user_borough) ? $user_borough->borough_name : '...';

        $this->lang->load('user', $this->session->site_lang);

        $this->load->model('job/job_model', 'job');
        $this->load->model('nationality/nationality_model', 'nationality');
        
		$this->data['nationalities'] = $this->nationality->all();
        $this->data['jobs'] = $this->job->all();
	}

	public function index()
	{
        $this->data['title'] = "Tableau de bord";
        
        $this->data['female_ratio'] = 0;
        $this->data['male_ratio'] = 0;
        $this->data['minor_ratio'] = 0;
        $this->data['major_ratio'] = 0;
        $this->data['minor_female'] = 0;
        $this->data['major_female'] = 0;
        $this->data['female_avg_age'] = 0;
        $this->data['male_avg_age'] = 0;
        $this->data['minor_male'] = 0;
        $this->data['major_male'] = 0;

        //Count household/citizen
        $citizen_count = count($this->notebook->citizens(['borough_id' => $this->borough_id]));
        $household_count = $this->notebook->household_sum(['borough_id' => $this->borough_id]);

        $this->data['household_count'] = ($household_count) ? number_format($household_count->household_count, 0, '', ' ') : 0;
        $this->data['citizen_count'] = number_format($citizen_count, 0, '', ' ');

        if($citizen_count){
            $ratio_sexe = $this->citizen->global_ratio_sexe();

            $_minor = 0;
            $_major = 0;
            $_total = 0;

            foreach($ratio_sexe as $value){
                $_total += $value->minor + $value->major;

                if($value->sexe == 0){
                    $this->data['female_ratio'] = number_format(($value->number/$citizen_count)*100, 2, ',', '');
                    $this->data['female_avg_age'] = number_format($value->avg_age, 0, ',', '');
                    $this->data['minor_female'] = number_format($value->minor, 0, ',', ' ');
                    $this->data['major_female'] = number_format($value->major, 0, ',', ' ');

                    $_minor += $value->minor;
                    $_major += $value->major;
                }
                if($value->sexe == 1){
                    $this->data['male_ratio'] =  number_format(($value->number/$citizen_count)*100, 2, ',', '');
                    $this->data['male_avg_age'] = number_format($value->avg_age, 0, ',', '');
                    $this->data['minor_male'] = number_format($value->minor, 0, ',', ' ');
                    $this->data['major_male'] = number_format($value->major, 0, ',', ' ');

                    $_minor += $value->minor;
                    $_major += $value->major;
                }
            }

            if($_total != 0){
                $this->data['minor_ratio'] = number_format(($_minor/$_total)*100, 2, ',', '');
                $this->data['major_ratio'] = number_format(($_major/$_total)*100, 2, ',', '');
            }

        }
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
        
		$this->data['fokontanies'] = $this->fokontany->get_all(['borough_id' => $this->borough_id]);

        $this->load->view('list_household', $this->data);
    }

	public function list_citizens()
	{
        $this->data['title'] = 'Liste des citoyens';
        
		$this->data['fokontanies'] = $this->fokontany->get_all(['borough_id' => $this->borough_id]);

        $this->load->view('list_citizens', $this->data);
    }

	public function list_users()
	{
        $this->data['title'] = "Liste des utilisateurs Fokontany";

        $this->load->view('list_user', $this->data);
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

        $data_updated = [
            'email' => $n_email,
            'first_name' => $n_firstname,
            'phone' => $phone,
            'address' => $address,
            'current_pwd' => $n_password
        ];

        if( $this->user->update($data_updated) ){
            
        
            if($n_password == $old_pwd){
                echo json_encode(['success'=>1, 'msg'=>'Modification terminée.']);
                return TRUE;
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
        else echo json_encode(['failed' => 1, 'msg' => 'Impossible de modifier les coordonnées de l\'utilisateur.']);
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

        $fokontany_id = $this->input->get('fokontany_id');
        $page = $this->input->get('page');
        $size = $this->input->get('size');

        $filters = $this->input->get('filters');

        $criteria = [];
        
        if($filters){
            foreach ($filters as $f) {
                if($f['field'] == 'chef_menage'){
                    $field = "LOWER(full_name) LIKE";
                    $value = '%'.strtolower($f['value']).'%';
                }else{
                    $field = $f['field'].' LIKE';
                    $value = '%'.$f['value'].'%';
                }
                
                $criteria[$field] = $value;
            }
        }
        
        $criteria['fokontany_id'] = $fokontany_id;
        $criteria['chef_menage'] = TRUE;

        $limit = $size;
        $offset = ($page == 1) ? 0 : ($page - 1) * $size;

        $citizens = $this->notebook->citizensPerPage($criteria, $offset, $limit);
        $count_citizen = count($this->notebook->citizens($criteria));

        $data['last_page'] = floor($count_citizen/$limit);
        $data['data'] = $citizens;

        echo json_encode($data);
    }

    public function citizens_list()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }
        $fokontany_id = $this->input->get('fokontany_id');

        $page = $this->input->get('page');
        $size = $this->input->get('size');

        $limit = $size;
        $offset = ($page == 1) ? 0 : ($page - 1) * $size;

        $filters = $this->input->get('filters');

        $criteria = [];
        
        if($filters){
            foreach ($filters as $f) {
                $field = 'LOWER('.$f['field'].') LIKE';
                $value = '%'.strtolower($f['value']).'%';
                
                $criteria[$field] = $value;
            }
        }
        
        $criteria['fokontany_id'] = $fokontany_id;

        $count_citizen = count($this->notebook->citizens($criteria));

        $data['last_page'] = floor($count_citizen/$limit);

        if(empty($criteria)){
            $data['data'] = [];
            echo json_encode($data);
            return TRUE;
        }

        $data['data'] = $this->notebook->citizensPerPage($criteria, $offset, $limit);
        echo json_encode($data);
    }

    public function list_citizen_by_carnet_id()
	{   
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }

        $numero_carnet = $this->input->get('numero_carnet');
        
        if(!empty($numero_carnet)){
            $citizen = $this->citizen->get_citizen(['numero_carnet'=>$numero_carnet]);
        }
        
        echo json_encode($citizen);
    }
}

