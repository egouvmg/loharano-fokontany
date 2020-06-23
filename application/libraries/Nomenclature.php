<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Nomenclature
{

    private $fokontany_id;
    /**
	 * __construct
	 *
	 * @author Hardly
	 */
	public function __construct()
	{
		//$this->load->model('auth/auth_model', 'auth');
		//$this->config->load('nomenclature', TRUE);
    }
    
    public function generate_certificat_reference($certificat, $fokontany_id, $lf_value){
        // $_group = $this->config->item('support', 'nomenclature');
        $certificats = $lf_value;
        $this->fokontany_id = $fokontany_id;
        
        $reference = dechex($this->fokontany_id);
        
        $reference = str_pad($reference, 5, '0', STR_PAD_LEFT);

        if($certificat==="residence"){
            $reference .= '1';
        }
        if($certificat==="life"){
            $reference .= '2';
        }
        if($certificat==="support"){
            $reference .= '3';
        }
        if($certificat==="move"){
            $reference .= '4';
        }
        if($certificat==="celibacy"){
            $reference .= '5';
        }
        if($certificat==="behavior"){
            $reference .= '6';
        }

        //2020 is index 1
        $index_year = (int) date("Y");
        $index_year = $index_year - 2019;

        $reference .= $index_year;

        //Ampina date androany
        $reference .= date("ymd");

        //$index = ($certificats) ? count($certificats) + 1 : 1;
        $index = ($certificats) ? $certificats + 1 : 1;

        $reference .= str_pad($index, 4, '0', STR_PAD_LEFT);
     return $reference;   
    }


}