<?php

/**
 * Custom dump function
 */
if (!function_exists('dump')) {

    function dump($value) {
        echo '<pre>';
        var_dump($value);
        echo '</pre>';
    }

}

/**
 * Custom dump and die function
 */
if (!function_exists('dd')) {

    function dd($value) {
        echo '<pre>';
        var_dump($value);
        echo '</pre>';
        die;
    }

}

/**
 * Custom function for check if string has json format
 */

if(!function_exists('is_json')) {

    function is_json($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

}