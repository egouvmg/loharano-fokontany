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
?>