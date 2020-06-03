<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    if ( ! function_exists('contentEmpty')){
        function contentEmpty($array = []){
            foreach ($array as $key => $value) {
                if(empty($value)) return true;
            }
            return false;
        }
    }
    if ( ! function_exists('contentEmptyNotZero')){
        function contentEmptyNotZero($array = []){
            foreach ($array as $key => $value) {
                if($value != 0)
                    if(empty($value)) return true;
            }
            return false;
        }
    }
?>