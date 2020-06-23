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

    public function aid_by_household()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }

        $numero_carnet = $this->input->get('numero_carnet');

        if($numero_carnet){
            $aids = $this->aid->household_aids(['numero_carnet' => $numero_carnet]);

            if($aids) echo json_encode($aids);
            else echo json_encode([]);
        }
        else echo json_encode([]);
    }

    public function add_household_aid()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }

        $numero_carnet = $this->input->post('numero_carnet');
        $aid_id = $this->input->post('aid_id');
        $created_on = $this->input->post('created_on');

        if(empty($numero_carnet))
            $missing_fields[] = ['numero_carnet', 'Champs requis'];
        if(empty($aid_id))
            $missing_fields[] = ['aid_id', 'Champs requis'];
        if(empty($created_on))
            $missing_fields[] = ['created_on', 'Champs requis'];    

        if(!empty($missing_fields)){
            echo json_encode(['error' => 1, 'missing_fields' => $missing_fields]);
            return false;
        }

        $data = [
            'numero_carnet' => $numero_carnet,
            'aid_id' => $aid_id,
            'created_on' => $created_on,
        ];

        if($this->aid->save_household_aid($data)) echo json_encode(['success'=>1, 'msg'=>'Enregistrement réussi']);
        else echo json_encode(['error' => 1, 'msg' => 'Impossible d\'enregistrer l\'aide']);
    }
}

