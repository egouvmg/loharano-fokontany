<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin extends SuperAdmin_Controller
{
	public function __construct(){
        parent::__construct();
        
        //Location Models
		$this->load->model('territory/province_model', 'province');
		$this->load->model('territory/region_model', 'region');
		$this->load->model('territory/district_model', 'district');
		$this->load->model('territory/common_model', 'common');
		$this->load->model('territory/borough_model', 'borough');
        $this->load->model('territory/fokontany_model', 'fokontany');
        $this->load->model('territory/notebook_model', 'notebook');
        $this->load->model('aid/aid_model', 'aid');
        
        $this->load->model('citizen/citizen_model', 'citizen');
        
        $this->load->model('user/user_model', 'user');

        $this->lang->load('user', $this->session->site_lang);
	}

	public function index()
	{
		$this->data['title'] = "Tableau de bord";
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
        
        $this->data['menu_active'] = 'list_citizen';
        $this->data['side_main_menu'] = $this->load->view('superadmin_menu', $this->data, TRUE);

        $this->load->view('list_citizen', $this->data);
    }

    public function load_citizen_certificate()
	{
        $this->data['title'] = $this->lang->line('citizen_residence');

        $person_id = $this->input->get('personne');

        $citizen_data = $this->citizen->get_citizen_certificate(['person_id'=>$person_id]);

        $this->data['citizen_data'] = $citizen_data;
		
        $this->load->view('residence_certificat', $this->data);
    }

    public function manage_aid()
    {
        $this->data['title'] = "Gestion des aides";
        $this->data['menu_active'] = 'manage_aid';
        $this->data['side_main_menu'] = $this->load->view('superadmin_menu', $this->data, TRUE);

        $this->load->view('manage_aid', $this->data);
    }

    /*
     * AJAX Requests
     * */

    public function citizens_list()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }

        $fokontany_id = ($this->input->get('fokontany_id')) ? $this->input->get('fokontany_id') : 0;

        $citizens = $this->notebook->citizens(['fokontany_id' => $fokontany_id]);

        echo json_encode($citizens);
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


    //Migration de données
    public function f45644548()
    {
		function read($csv){
			$file = fopen($csv, 'r');
			while (!feof($file) ) {
                $line[] = fgetcsv($file, 1024,',');
			}
			fclose($file);
			return $line;
		}
		// Définir le chemin d'accès au fichier CSV
		$csv = 'application/migrate/personne.txt';
        $csv = read($csv);

        unset($csv[0]);
        
        $reference = '';
        $household = 0;
        $data_citizens = [];
        
		foreach($csv as $key => $csv_value){

            // [0] => id_personne
            // [1] => fokontany_id
            // [2] => household_head
            // [3] => nom
            // [4] => prenoms
            // [5] => date_de_naissance
            // [6] => lieu_de_naissance
            // [7] => date_delivrance_cin
            // [8] => lieu_delivrance_cin
            // [9] => nationalite
            // [10] => qr_code
            // [11] => numero_carnet
            // [12] => father
            // [13] => mother
            // [14] => father_status
            // [15] => mother_status
            // [16] => job_id
            // [17] => job_status
            // [18] => job_other
            // [19] => phone
            // [20] => nationality_id
            // [21] => cin_personne
            // [22] => sexe
            // [23] => situation_matrimoniale
            // [24] => handicape
            // [25] => address

            $fokontany_id = (int) $csv_value[1];
            $address = $csv_value[25];
            
            $reference = ($csv_value[2]==1) ? $this->createNotebook($address, $fokontany_id) : $reference;

            $tmp_data = [
                'chef_menage' => $csv_value[2],
                'nom' => $csv_value[3],
                'prenoms' => $csv_value[4],
                'date_de_naissance' => $csv_value[5],
                'lieu_de_naissance' => $csv_value[6],
                'nationality_id' => 1,//(empty($csv_value[20])) ? 1 : $csv_value[20],
                'qr_code' => $csv_value[10],
                'numero_carnet' => $reference,
                'father' => $csv_value[12],
                'mother' => $csv_value[13],
                'father_status' => (empty($csv_value[14])) ? 0 : 1,
                'mother_status' => (empty($csv_value[15])) ? 0 : 1,
                'job_id' => ($csv_value[16] == -1 || $csv_value[16] == 0) ? 52 : $csv_value[16],
                'job_status' => $csv_value[17],
                'job_other' => $csv_value[18],
                'phone' => $csv_value[19],
                'sexe' => (empty($csv_value[22])) ? 0 : 1,
                'situation_matrimoniale' => $csv_value[23],
                'handicape' => (empty($csv_value[24])) ? FALSE : TRUE
            ];

            if(!empty($csv_value[21])){
                
                $tmp_data['date_delivrance_cin'] = ($csv_value[7] == 'NULL') ? '01/01/1900': $csv_value[7];
                $tmp_data['lieu_delivrance_cin'] = utf8_encode($csv_value[8]);
                $tmp_data['cin_personne'] = $csv_value[21];
            }
       
            $this->citizen->insert($tmp_data);
        }
    }

    private function createNotebook($address = '', $fokontany_id)
    {
        $reference = dechex($fokontany_id);
        $reference = str_pad($reference, 5, '0', STR_PAD_LEFT);

        //2020 is index 1
        $index_year = (int) date("Y");
        $index_year = $index_year - 2019;

        $reference .= $index_year;
        $reference .= date("ymd");

        $notebooks = $this->notebook->all(['numero_carnet like' => $reference.'%']);

        $index = ($notebooks) ? count($notebooks) + 1 : 1;

        $reference .= str_pad($index, 4, '0', STR_PAD_LEFT); 

        $data = [
            'numero_carnet' => $reference,
            'adresse_actuelle' => $address,
            'id_registre' => $fokontany_id
        ];

        if($this->notebook->insert($data))
            return $reference;
        else return false;
    }

    public function add_aid()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }

        $data = $this->input->post();
        $name = $this->input->post('name');
        $type = $this->input->post('type');
        $description = $this->input->post('description');

        if(empty($name))
            $missing_fields[] = ['name', 'Champs requis'];
        if(empty($type))
            $missing_fields[] = ['type', 'Champs requis'];
        if(empty($description))
            $missing_fields[] = ['description', 'Champs requis'];    

        if(!empty($missing_fields)){
            echo json_encode(['failed' => 1, 'missing_fields' => $missing_fields]);
            return false;
        }

        if($this->aid->insert($data))
            echo json_encode(['success' => 1]);
        else echo json_encode(['error' => 1, 'msg' => 'Impossible d\'enregistrer l\'aide.']);
    }

    public function edit_aid()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }

        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $type = $this->input->post('type');
        $description = $this->input->post('description');

        if(empty($name))
            $missing_fields[] = ['ename', 'Champs requis'];
        if(empty($type))
            $missing_fields[] = ['etype', 'Champs requis'];
        if(empty($description))
            $missing_fields[] = ['edescription', 'Champs requis'];
        if(empty($id))
            $missing_fields[] = ['ename', 'Aide non définie'];
              

        if(!empty($missing_fields)){
            echo json_encode(['failed' => 1, 'missing_fields' => $missing_fields]);
            return false;
        }
        
        $data_update = [
            'id' => $id,
            'name' => $name,
            'type' => $type,
            'description' => $description
        ];

        if($this->aid->update($data_update))
            echo json_encode(['success' => 1]);
        else echo json_encode(['error' => 1, 'msg' => 'Impossible de modifier l\'aide.']);
    }

    public function list_aid()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Tandremo! Voararan\'ny lalana izao atao nao izao.');
        }

        $aids = $this->aid->all();
        if($aids) echo json_encode($aids);
        else echo json_encode([]);
    }
}

