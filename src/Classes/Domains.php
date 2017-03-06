<?php
/**
 * Created by PhpStorm.
 * User: jharing10
 * Date: 2017/02/15
 * Time: 12:10 PM
 */

namespace EONConsulting\LaravelLTI\Classes;


use EONConsulting\LaravelLTI\Models\LTIDomain;

class Domains {

    static public function listDomains() {
        $domains_obj = LTIDomain::with('context')->with('key')->get();
        $domains = [];

        foreach($domains_obj as $domain) {

            $obj = [
                'title' => ($domain->context) ? $domain->context->title : '',
                'description' => '',
                'launch_url' => $domain->domain,
                'key' => ($domain->key) ? $domain->key->key_key : null,
                'secret' => ($domain->key) ? $domain->key->secret : null,
                'context_id' => $domain->context_id,
                'icon' => ''
            ];

            if($domain->json) {
                $xml = json_decode($domain->json);

                if($xml) {
                    $arr = (array) $xml;

                    if(array_key_exists('bltiicon', $arr) && $arr['bltiicon'] != '') {
                        if($arr['bltiicon'] instanceof \stdClass) {
                            if(!empty((array) $arr['bltiicon']))
                                $obj['icon'] = (array) $arr['bltiicon'];
                        } else {
                            $obj['icon'] = $arr['bltiicon'];
                        }

                    }

                    if(array_key_exists('bltidescription', $arr)) {
                        $obj['description'] = $arr['bltidescription'];
                    }
                }
            }

            $domains[] = $obj;
        }

        return $domains;
    }

}