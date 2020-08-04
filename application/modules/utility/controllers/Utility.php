<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Utility extends My_Controller
{
    private $fokontany_id;

	public function __construct(){
        parent::__construct();
        
        $this->load->model('territory/province_model', 'province');
        $this->load->model('territory/region_model', 'region');
        $this->load->model('territory/district_model', 'district');
        $this->load->model('territory/common_model', 'common');
        $this->load->model('territory/borough_model', 'borough');
        $this->load->model('territory/notebook_model', 'notebook');
        $this->load->model('territory/migration_model', 'migration');
        $this->load->model('certificate/certificate_model', 'certificate');
        $this->load->model('register/register_model', 'register');
        $this->load->model('job/job_model', 'job');
        $this->load->model('nationality/nationality_model', 'nationality');
        $this->load->model('citizen/citizen_model', 'citizen');
        $this->load->model('territory/fokontany_model', 'fokontany');
        $this->load->model('user/user_model', 'user');
        $this->load->model('aid/aid_model', 'aid');
	}

    public function history_migration()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
        }

        $id_person = $this->input->get('id_person');

        $histories = $this->migration->all_details(['id_person' => $id_person]);
        
        if($histories) echo json_encode($histories);
        else echo json_encode([]);
    }

    public function history_certificate()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
        }

        $id_person = $this->input->get('id_person');

        $histories = $this->certificate->historiques_certificats(['id_personne' => $id_person]);
        
        if($histories) echo json_encode($histories);
        else echo json_encode([]);
    }

    public function list_citizen_by_carnet_id()
	{   
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }
             
        $numero_carnet = $this->input->get('numero_carnet');
        
        if(!empty($numero_carnet)){
            $citizen = $this->citizen->get_citizen_certificate(['numero_carnet'=>$numero_carnet]);
        }
        
        echo json_encode($citizen);
    }

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
}