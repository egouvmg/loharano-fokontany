<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    if ( ! function_exists('css')){
        function css($file_name){
            return '<link rel="stylesheet" href="'. base_url() . 'assets/css/' . $file_name . '.css">';
        }
    }

    if ( ! function_exists('js')){
        function js($file_name){
            return base_url() . 'assets/js/' . $file_name . '.js';
        }
    }
    if ( ! function_exists('img')){
        function img($file_name){
            return base_url() . 'assets/img/' . $file_name;
        }
    }
    if ( ! function_exists('plugin')){
        function plugin($plugin_name, $folder, $file){
            return base_url() . 'assets/plugins/' . $plugin_name.'/'. $folder .'/' . $file;
        }
    }
    if ( ! function_exists('img_html')){
        function img_html($file_name, $alt = '', $id = '', $class = ''){
            if( empty($class) && empty($id) )
                return '<img src = "' . img($file_name) . '" title= "'. $alt .'" alt= "' . $alt . '" />';
            else if( !empty($class) && empty($id) )
                return '<img src = "' . img($file_name) . '" class= "'. $class .'" title= "'. $alt .'" alt= "' . $alt . '" />';
            else if( empty($class) && !empty($id) )
                return '<img src = "' . img($file_name) . '" id= "'. $id .'" title= "'. $alt .'" alt= "' . $alt . '" />';
            else
                return '<img src = "' . img($file_name) . '" id= "'. $id .'" class= "'. $class .'" title= "'. $alt .'" alt= "' . $alt . '" />';      
        }
    }
    if ( ! function_exists('format_number')){
        function format_number($number){
            return number_format($number,0, ","," ");     
        }
    }
    if ( ! function_exists('parcent_number')){
        function parcent_number($number){
            return number_format($number,3, ","," ");     
        }
    }
    if ( ! function_exists('format_date')){
        function format_date($date){
            return implode("-", array_reverse(explode("/", $date)));     
        }
    }
    if(! function_exists('create_notebook')){
        function create_notebook($address = '', $fokontany_id = 0)
        {
            if(empty($address) && empty($fokontany_id)) return false;

            $CI =& get_instance();
            $CI->load->model('territory/notebook_model', 'notebook');

            $reference = dechex($fokontany_id);
            $reference = str_pad($reference, 5, '0', STR_PAD_LEFT);

            //2020 is index 1
            $index_year = (int) date("Y");
            $index_year = $index_year - 2019;

            $reference .= $index_year;
            $reference .= date("ymd");

            $notebooks = $CI->notebook->all(['numero_carnet like' => $reference.'%']);

            $index = ($notebooks) ? count($notebooks) + 1 : 1;

            $reference .= str_pad($index, 4, '0', STR_PAD_LEFT); 

            $data = [
                'numero_carnet' => $reference,
                'adresse_actuelle' => $address,
                'id_registre' => $fokontany_id
            ];

            if($CI->notebook->insert($data))
                return $reference;
            else return false;
        }
    }
?>