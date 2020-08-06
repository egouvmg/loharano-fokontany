<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Aid extends Operator_Controller
{
    private $fokontany_id;

	public function __construct(){
        parent::__construct();
        
        $this->load->model('aid_model', 'aid');
        
		$this->load->model('territory/province_model', 'province');
		$this->load->model('territory/region_model', 'region');
		$this->load->model('territory/district_model', 'district');
		$this->load->model('territory/common_model', 'common');
		$this->load->model('territory/borough_model', 'borough');
        $this->load->model('territory/fokontany_model', 'fokontany');
        $this->load->model('user/user_model', 'user');

        $this->lang->load('citizen', $this->session->site_lang);
        $this->lang->load('job', $this->session->site_lang);
        $this->lang->load('nationality', $this->session->site_lang);
        $this->lang->load('aid', $this->session->site_lang);

        $user_fokontany = $this->user->getUserFokontany($this->session->user_id);

        if(isset($user_fokontany)){
            $this->fokontany_id = (int) $user_fokontany->fokontany_id;

            $this->data['info_fokontany'] = $user_fokontany;
            $this->data['user_fokontany'] = ($user_fokontany) ? $user_fokontany->fokontany_name : '...';
        }
	}

	public function index()
	{
        $this->data['title'] = $this->lang->line('aid_dashboard');

        $this->data['aids'] = $this->aid->all();
        $this->load->view('index', $this->data);
    }
    
    /*
     * AJAX Requests
     * */

    public function add_household_aid()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }

        $numero_carnet = $this->input->post('numero_carnet');
        $aid_id = $this->input->post('aid_id');
        $aid_type = $this->input->post('aid_type');
        $created_on = $this->input->post('created_on');
        $type = $this->input->post('type');
        $phone = $this->input->post('phone');
        $bank = $this->input->post('bank');
        $rib = $this->input->post('rib');
        $paositra_account = $this->input->post('paositra_account');

        if(empty($numero_carnet))
            $missing_fields[] = ['numero_carnet', 'Champs requis'];
        if(empty($aid_id))
            $missing_fields[] = ['aid_id', 'Champs requis'];
        if(empty($created_on))
            $missing_fields[] = ['created_on', 'Champs requis'];

        if($aid_type == 2){
            if($type < 4)
                if(empty($phone)) $missing_fields[] = ['phone', 'Champs requis'];
            if($type == 4)
                if(empty($rib)) $missing_fields[] = ['rib', 'Champs requis'];
            if($type == 5)
                if(empty($paositra_account)) $missing_fields[] = ['paositra_account', 'Champs requis'];
        }

        if(!empty($missing_fields)){
            echo json_encode(['error' => 1, 'missing_fields' => $missing_fields]);
            return false;
        }

        $data = [
            'numero_carnet' => $numero_carnet,
            'aid_id' => $aid_id,
            'created_on' => $created_on,
            'type' => $type,
        ];

        if($type < 4)
            $data['phone'] = $phone;
        if($type == 4){
            $data['bank'] = $bank;
            $data['rib'] = $rib;
        }
        if($type == 5)
            $data['paositra_account'] = $paositra_account;

        if($this->aid->save_household_aid($data)) echo json_encode(['success'=>1, 'msg'=>'Enregistrement réussi']);
        else echo json_encode(['error' => 1, 'msg' => 'Impossible d\'enregistrer l\'aide']);
    }

    public function type()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }

        $aid_id = $this->input->get('aid_id');


        if(empty($aid_id))
            $missing_fields[] = ['aid', 'Champs requis'];   

        if(!empty($missing_fields)){
            echo json_encode(['error' => 1, 'missing_fields' => $missing_fields]);
            return false;
        }

        $aid = $this->aid->one(['id' => $aid_id]);
        $aid_type = '';

        if($aid){
            if($aid->type == 1) $aid_type = 'Vivres';
            if($aid->type == 2) $aid_type = 'Cash';
        }

        if(empty($aid_type)) echo json_encode(['error' => 1, 'msg' => 'Le type du programme d\'aide est non défini. Impossible de poursuivre le processus.']);
        else echo json_encode(['success' => 1, 'type_name' => $aid_type, 'type' => $aid->type, 'description' => $aid->description]);
    }
}

