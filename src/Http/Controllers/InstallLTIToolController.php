<?php
/**
 * Created by PhpStorm.
 * User: jharing10
 * Date: 2017/02/14
 * Time: 10:39 PM
 */

namespace EONConsulting\LaravelLTI\Http\Controllers;


use App\Http\Controllers\Controller;
use EONConsulting\LaravelLTI\Classes\Readers\ImportConfig;
use EONConsulting\LaravelLTI\Http\Requests\StoreLTIToolRequest;
use EONConsulting\LaravelLTI\Models\LTIContext;
use EONConsulting\LaravelLTI\Models\LTIDomain;
use EONConsulting\LaravelLTI\Models\LTIKey;
use Illuminate\Http\Request;

class InstallLTIToolController extends LTIBaseController {

    protected $hasLTI = false;

    static public function index() {
        return view('eon.laravellti::install');
    }

    static public function store(StoreLTIToolRequest $request) {

        $xml = [];
        $xml = ImportConfig::read_from_url($request->config_url);

        if(!$xml && !$request->has('launch_url')) {
            session()->flash('error_message', 'Something wen\'t wrong');
            return redirect()->route('eon.laravellti.install');
        }

        $arr = (array) $xml;
        $has_key = false;
        $title = '';
        $desc = '';
        $launch_url = '';
        $key = '';
        $secret = '';

        if($arr && array_key_exists('bltititle', $arr)) {
            $title = $arr['bltititle'];
        } else {
            $title = $request->get('title', '');
        }

        if($arr && array_key_exists('bltidescription', $arr)) {
            $desc = $arr['bltidescription'];
        }

        $launch_url_found = false;
        $title_found = false;
        foreach($arr as $key=>$value){
            if(str_contains($key, 'launch_url')){
                $launch_url  = $value;
                $launch_url_found = true;
            }
            if(str_contains($key, 'title')){
                $title  = $value;
                $title_found = true;
            }
            if(str_contains($key, 'description')){
                $desc  = $value;
            }
        }

        if(!$launch_url_found) {
            $launch_url = $request->get('launch_url', '');
        }

        if(!$title_found) {
            $title = $request->get('title', '');
        }

        if(LTIDomain::where('domain', $launch_url)->first()) {
            session()->flash('error_message', 'A component with that launch URL already exists.');
            return redirect()->route('eon.laravellti.appstore');
        }

        if($request->has('key')) {
            $key = $request->key;
            $has_key = true;
        }

        if($request->has('secret')) {
            $secret = $request->secret;
        }

        if($has_key) {
            $lti_key = new LTIKey;
            $lti_key->key_sha256 = lti_sha256($key);
            $lti_key->key_key = $key;
            $lti_key->secret = $secret;
            $lti_key->ack = '';
            $lti_key->user_id = $request->user()->id;
            $lti_key->consumer_profile = '';
            $lti_key->new_consumer_profile = '';
            $lti_key->tool_profile = '';
            $lti_key->new_tool_profile = '';
            $lti_key->json = json_encode($xml);
            $lti_key->settings = '';
            $lti_key->settings_url = '';
            $lti_key->entity_version = 1;

            $lti_key->save();
        }

        $context = new LTIContext;
        $context->context_sha256 = lti_sha256($key);
        $context->context_key = $key;
        $context->key_id = ($has_key) ? $lti_key->key_id : 1;
        $context->title = $title;
        $context->json = json_encode($xml);
        $context->settings = '';
        $context->settings_url = '';
        $context->entity_version = 1;

        $context->save();

        $lti_domain = new LTIDomain;
        $lti_domain->key_id = ($has_key) ? $lti_key->key_id : null;
        $lti_domain->context_id = $context->context_id;
        $lti_domain->domain = $launch_url;
        $lti_domain->port = 80;
        $lti_domain->consumer_key = $key;
        $lti_domain->secret = $secret;
        $lti_domain->json = json_encode($xml);

        $lti_domain->save();

        $message = 'The LTI component, ' . $title . ', was installed';

        session()->flash('success_message', $message);
        return redirect()->route('eon.laravellti.appstore');
    }

}