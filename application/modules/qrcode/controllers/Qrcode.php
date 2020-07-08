<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Qrcode extends CI_Controller//Operator_Controller
{
    private $fokontany_id;

	public function __construct(){
        parent::__construct();
        
        $this->load->model('citizen/citizen_model', 'citizen');
        $this->load->model('aid/aid_model', 'aid');
	}

	public function index_qrcode()
	{
        $numero_carnet = $this->input->get('numero_carnet');
        $citizen = null;
        $aids =  null;

        if(!empty($numero_carnet)){
            $citizen = $this->citizen->get_citizen_certificate(['numero_carnet'=>$numero_carnet]);
            $aids = $this->aid->household_aids(['numero_carnet' => $numero_carnet]);
        }
        $data['citizen'] = $citizen;
        $data['aids'] = $aids;
        
        echo json_encode($data);
	}
}

