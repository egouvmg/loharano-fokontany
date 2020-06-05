<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Territory extends MY_Controller
{
	public function __construct(){
		parent::__construct();

		$this->load->model('province_model', 'province');
		$this->load->model('region_model', 'region');
		$this->load->model('district_model', 'district');
		$this->load->model('common_model', 'common');
		$this->load->model('fokontany_model', 'fokontany');
		$this->load->model('territory_model', 'territory');
	}

	public function procince_get_childs(){
		if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
        }

        $id_province = $this->input->post('id');

        if(empty($id_province)){
        	echo json_encode(['error' => 1, 'msg' => 'Province non fourni.']);
        	return true;
        }

        $regions = $this->region->get_all(['province_id' => $id_province]);
    	
    	if(!empty($regions)){
    		$this->data['childs'] = $regions;
    		$childs = $this->load->view('childs_option', $this->data, TRUE);
    		echo json_encode(['success' => 1, 'childs' => $childs, 'first_child' => $regions[0]->id]);		
    	}
    	else
    		echo json_encode(['error' => 1, 'msg' => 'Aucun district correspondant.' ]);
	}

	public function region_get_childs(){
		if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
        }

        $id_region = $this->input->post('id');

        if(empty($id_region)){
        	echo json_encode(['error' => 1, 'msg' => 'Région non fournie.']);
        	return true;
        }

        $districts = $this->district->get_all(['region_id' => $id_region]);
    	
    	if(!empty($districts)){
    		$this->data['childs'] = $districts;
    		$childs = $this->load->view('childs_option', $this->data, TRUE);
    		echo json_encode(['success' => 1, 'childs' => $childs, 'first_child' => $districts[0]->id]);		
    	}
    	else
    		echo json_encode(['error' => 1, 'msg' => 'Aucun district correspondant.' ]);
	}

	public function district_get_childs(){
		if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
        }

        $id_district = $this->input->post('id');

        if(empty($id_district)){
        	echo json_encode(['error' => 1, 'msg' => 'District non fourni.']);
        	return true;
        }

        $commons = $this->common->get_all(['district_id' => $id_district]);
    	
    	if(!empty($commons)){
    		$this->data['childs'] = $commons;
    		$childs = $this->load->view('childs_option', $this->data, TRUE);
    		echo json_encode(['success' => 1, 'childs' => $childs, 'first_child' => $commons[0]->id]);		
    	}
    	else
    		echo json_encode(['error' => 1, 'msg' => 'Aucun commune correspondant.' ]);
	}

	public function common_get_childs(){
		if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
        }

        $id_common = $this->input->post('id');

        if(empty($id_common)){
        	echo json_encode(['error' => 1, 'msg' => 'Commune non fourni.']);
        	return true;
        }

        $fokontanys = $this->fokontany->get_all(['common_id' => $id_common]);
    	
    	if(!empty($fokontanys)){
    		$this->data['childs'] = $fokontanys;
    		$childs = $this->load->view('childs_option', $this->data, TRUE);
    		echo json_encode(['success' => 1, 'childs' => $childs]);		
    	}
    	else
    		echo json_encode(['error' => 1, 'msg' => 'Aucun fokontany correspondant.' ]);
	}

	//get all data by fokontany id
	public function getCommunByFokontanyId(){
		if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
		}

		$fokontany_id = $this->input->post('id');

		if(empty($fokontany_id)){
			echo json_encode(['error' => 1, 'msg' => 'Commune non fourni.']);
        	return true;
		}
		$commons = $this->common->get_common_fokontany(['fokontany.id' => $fokontany_id]);
		if(!empty($commons)){
			$this->data['childs'] = $commons;
			$childs = $this->load->view('childs_input', $this->data, TRUE);
			echo json_encode(['success' => 1, 'childs' => $commons]);
		}
		else{
			echo json_encode(['error' => 1, 'msg' => 'Aucune commune correspondant.' ]);
		}
	}

	public function getDistrictByCommunId(){
		if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
		}

		$common_id = $this->input->post('id');

		if(empty($common_id)){
			echo json_encode(['error' => 1, 'msg' => 'district non fourni.']);
        	return true;
		}
		$district = $this->district->get_district_common(['common.id' => $common_id]);
		if(!empty($district)){
			$this->data['childs'] = $district;
			$childs = $this->load->view('childs_input', $this->data, TRUE);
			echo json_encode(['success' => 1, 'childs' => $district]);
		}
		else{
			echo json_encode(['error' => 1, 'msg' => 'Aucun district correspondant.' ]);
		}
	}

	public function getRegionByDistrictId(){
		if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
		}

		$district_id = $this->input->post('id');

		if(empty($district_id)){
			echo json_encode(['error' => 1, 'msg' => 'district non fourni.']);
        	return true;
		}
		$region = $this->region->get_region_district(['district.id' => $district_id]);
		if(!empty($region)){
			$this->data['childs'] = $region;
			$childs = $this->load->view('childs_input', $this->data, TRUE);
			echo json_encode(['success' => 1, 'childs' => $region]);
		}
		else{
			echo json_encode(['error' => 1, 'msg' => 'Aucun region correspondant.' ]);
		}
	}

	public function getProvinceByRegion(){
		if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
		}

		$region_id = $this->input->post('id');

		if(empty($region_id)){
			echo json_encode(['error' => 1, 'msg' => 'region non fourni.']);
        	return true;
		}
		$province = $this->province->get_province_region(['region.id' => $region_id]);
		if(!empty($province)){
			$this->data['childs'] = $province;
			$childs = $this->load->view('childs_input', $this->data, TRUE);
			echo json_encode(['success' => 1, 'childs' => $province]);
		}
		else{
			echo json_encode(['error' => 1, 'msg' => 'Aucun province correspondant.' ]);
		}
	}

	public function get_fokontany_treaty()
	{
		if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
		}


	}


	public function common_get_avaliable_childs()
	{
		if (!$this->input->is_ajax_request()) {
            exit('Very ianao :O');
		}
		$id_common = $this->input->post('id');

        if(empty($id_common)){
        	echo json_encode(['error' => 1, 'msg' => 'Commune non fourni.']);
        	return true;
        }

		$fokontany_list = $this->fokontany->get_all(['common_id' => $id_common]);
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
    	
    	if(!empty($fkt_avilables)){
    		$this->data['childs'] = $fkt_avilables;
    		$childs = $this->load->view('childs_option', $this->data, TRUE);
    		echo json_encode(['success' => 1, 'childs' => $childs]);		
    	}
    	else
    		echo json_encode(['error' => 1, 'msg' => 'Aucun fokontany correspondant.' ]);
	}
}
