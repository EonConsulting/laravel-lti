<?php
/**
 * Created by PhpStorm.
 * User: jharing10
 * Date: 2017/02/14
 * Time: 10:47 PM
 */

namespace EONConsulting\LaravelLTI\Classes\Readers;


class ImportConfig {

    static function read_from_url($url = false) {
        // check if a url was provided
        if(!$url)
            return false;

        // get xml from URL
        $xmlstr = file_get_contents($url);

        // get into xml string
        $xmlstr = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xmlstr);

        // create xml object from string
        $xmlobj = simplexml_load_string($xmlstr);

        return $xmlobj;
    }

    static function read_from_str($str = false) {
        // check if a url was provided
        if(!$str)
            return false;

        // get into xml string
        $xmlstr = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $str);

        // create xml object from string
        $xmlobj = simplexml_load_string($xmlstr);

        return $xmlobj;
    }

}