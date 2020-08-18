<?php
require APPPATH . 'libraries/REST_Controller.php';

class Householdapi extends REST_Controller {
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */

    public function __construct() {
       parent::__construct();
       $this->load->helper('url', 'form');
       $this->load->database();

       $this->load->model('territory/notebook_model', 'notebook');
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */

	public function index_get()
	{
        $last_name = $this->input->get('last_name');
        $first_name = $this->input->get('first_name');
        $birth = $this->input->get('birth');
        $birth_place = $this->input->get('birth_place');
        $cin = $this->input->get('cin');
        $address = $this->input->get('address');
        $fokontany = $this->input->get('fokontany');

        $missing_fields = [];

        if(empty($last_name))
            $missing_fields[] = ['Nom', 'Champs requis'];
        if(empty($first_name))
            $missing_fields[] = ['Date de naissance', 'Champs requis'];
        if(empty($birth))
            $missing_fields[] = ['Lieu de naissance', 'Champs requis'];
        if(empty($birth_place))
            $missing_fields[] = ['Nationalité', 'Champs requis'];
        if(empty($address))
            $missing_fields[] = ['Sexe', 'Champs requis'];
        if(empty($cin))
            $missing_fields[] = ['Numéro CIN', 'Champs requis'];
        if(empty($fokontany))
            $missing_fields[] = ['Fokontany', 'Champs requis'];
        
        if(!empty($missing_fields)){
            $this->response($missing_fields, REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION);
            return false;
        }

        $criteria = [
            'nom' => $last_name,
            'prenoms' => $first_name,
            'date_de_naissance' => $birth,
            'lieu_de_naissance' => $birth_place,
            'cin_personne' => $cin,
            'address_actuelle' => $address,
            'fokontany_id' => $fokontany
        ];
        
        $data = $this->notebook->searchOne($criteria);
        
        if(empty($data)){
            $this->response(['Aucun citoyen correspondant'], REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION);
        }else{
            $this->response($data, REST_Controller::HTTP_OK);
        }
    }
}