<?php
require APPPATH . 'libraries/REST_Controller.php';

class Citizenapi extends REST_Controller {
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */

    public function __construct() {
       parent::__construct();
       $this->load->helper('url', 'form');
       $this->load->database();

       $this->load->model('citizen/citizen_model', 'citizen');
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */

	public function index_get()
	{
        $id = $this->input->get('identity');
        
        if(empty($id)){
            $data = [
                'failed' => 'Paramètres non définis'
            ];
            $this->response($data, REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION);
        }else{
            $data = $this->citizen->one(['id_personne' => $id]);
            $this->response($data, REST_Controller::HTTP_OK);
        }
    }

    /**
     * Get All Data from this method.
     *
     * @return Response
    */

    public function index_post()
    {
        $input = $this->input->post();

        if(empty($input['adresse']) || empty($input['fokontany_id'])){
            $this->response(['Information sur la localisation du ménage incomplète.'], REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION);
            return false;
        }

        $reference_carnet = create_notebook($input['adresse'], $input['fokontany_id']);

        if(empty($reference_carnet)){
            $this->response(['Impossible de créer le carnet du ménage.'], REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION);
            return false;
        }

        $missing_fields = [];

        foreach ($input['citoyens'] as $key => $citoyen) {
            if(empty($citoyen['nom']))
                $missing_fields[] = ['Nom du citoyen n°'.($key+1), 'Champs requis'];
            if(empty($citoyen['date_de_naissance']))
                $missing_fields[] = ['Date de naissance du citoyen n°'.($key+1), 'Champs requis'];
            if(empty($citoyen['lieu_de_naissance']))
                $missing_fields[] = ['Lieu de naissance du citoyen n°'.($key+1), 'Champs requis'];
            if(empty($citoyen['nationality_id']))
                $missing_fields[] = ['Nationalité du citoyen n°'.($key+1), 'Champs requis'];
            if(empty($citoyen['sexe']))
                $missing_fields[] = ['Sexe du citoyen n°'.($key+1), 'Champs requis'];
            
            if(empty($citoyen['cin_personne'])){
                if(!empty($citoyen['date_delivrance_cin']) || !empty($citoyen['lieu_delivrance_cin']))
                    $missing_fields[] = ['Information CIN du citoyen n°'.($key+1), 'Compléter les informations'];
            }
    
            if(empty($citoyen['date_delivrance_cin'])){
                if(!empty($citoyen['cin_personne']) || !empty($citoyen['lieu_delivrance_cin']))
                    $missing_fields[] = ['Information CIN du citoyen n°'.($key+1), 'Compléter les informations'];
            }
    
            if(empty($citoyen['lieu_delivrance_cin'])){
                if(!empty($citoyen['cin_personne']) || !empty($citoyen['date_delivrance_cin']))
                    $missing_fields[] = ['Information CIN du citoyen n°'.($key+1), 'Compléter les informations'];
            }
    
            if(empty($citoyen['cin_personne']) && empty($citoyen['date_delivrance_cin']) && empty($citoyen['lieu_delivrance_cin'])){
                unset($citoyen['cin_personne']);
                unset($citoyen['date_delivrance_cin']);
                unset($citoyen['lieu_delivrance_cin']);
            }
    
            if(empty($citoyen['father_status'])) unset($citoyen['father_status']);
            if(empty($citoyen['mother_status'])) unset($citoyen['mother_status']);
            if(empty($citoyen['job_id'])) unset($citoyen['job_id']);
            if(empty($citoyen['parent_link'])) unset($citoyen['parent_link']);
            
            if(!empty($missing_fields)){
                $this->response($missing_fields, REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION);
                return false;
            }
    
            $id_photo = date('Ymd').''.bin2hex($citoyen['date_de_naissance']).''.bin2hex($citoyen['nom']);
            
            //Uoplad
            $_FILES['filex']['name'] = $_FILES['citoyens']['name'][$key]['id_photo'];
            $_FILES['filex']['type'] = $_FILES['citoyens']['type'][$key]['id_photo'];
            $_FILES['filex']['tmp_name'] = $_FILES['citoyens']['tmp_name'][$key]['id_photo'];
            $_FILES['filex']['error'] = $_FILES['citoyens']['error'][$key]['id_photo'];
            $_FILES['filex']['size'] = $_FILES['citoyens']['size'][$key]['id_photo'];

            $config = array(
                'upload_path' => "assets/img/citizens",
                'allowed_types' => "gif|jpg|png|jpeg",
                'overwrite' => TRUE,
                'file_name' => $id_photo
            );
    
            $this->load->library('upload', $config);
            $this->load->library('image_lib');
    
            if($this->upload->do_upload('filex'))
            {
                $image_data =   $this->upload->data();
    
                $configer =  array(
                  'image_library'   => 'gd2',
                  'source_image'    =>  $image_data['full_path'],
                  'maintain_ratio'  =>  TRUE,
                  'width'           =>  250,
                  'height'          =>  250
                );
                $this->image_lib->clear();
                $this->image_lib->initialize($configer);
                $this->image_lib->resize();
    
                $id_photo .= $this->upload->data('file_ext');
                $citoyen['id_photo'] = $id_photo;
                $citoyen['numero_carnet'] = $reference_carnet;
                if($key==0) $citoyen['chef_menage'] = TRUE;
    
                if($this->citizen->save($citoyen)) $this->response(['Enregistrement du citoyen terminé avec succès.'], REST_Controller::HTTP_OK);
                else $this->response(['Enregistrement du citoyen a échoué.'], REST_Controller::HTTP_BAD_REQUEST);
            }
            else
                $this->response(['Impossible d\'enregistrer la photo du citoyendu citoyen n°'.($key+1).' Erreur : '.$this->upload->display_errors('','')], REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION);
        }
    } 

    /**
     * Get All Data from this method.
     *
     * @return Response
    */

    public function index_put($id)
    {
        $input = $this->put();
        //$this->db->update('items', $input, array('id'=>$id));
        $this->response(['Item updated successfully.'], REST_Controller::HTTP_OK);
    }

    /**
     * Get All Data from this method.
     *
     * @return Response
    */

    public function index_delete($id)
    {
        //$this->db->delete('items', array('id'=>$id));
        $this->response(['Item deleted successfully.'], REST_Controller::HTTP_OK);
    }
}