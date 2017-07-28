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
        $breadcrumbs = [
            'title' => 'App Store',
            'href' => route('eon.laravellti.appstore'),
            'child' => [
                'title' => 'Install App',
            ],
        ];

        return view('eon.laravellti::install', ['breadcrumbs' => $breadcrumbs]);
    }

    // Peace Ngara Addition Store a Bool value of false at init()
    static public function getStatusOfLaunch_URL ($launch_url_found = false) {
        $launch_url = $launch_url_found;
        return $launch_url;
    }

    static public function getStatusOfTitle ($title_found = false) {
        $title = $title_found;
        return $title;
    }

    static public function store(StoreLTIToolRequest $request) {

        $xml = [];
        //Returns an array
        $xml = ImportConfig::read_from_dom($request->config_url);
        //dd($xml);

        if(!$xml && !$request->has('launch_url')) {
            session()->flash('error_message', 'Something wen\'t wrong');
            return redirect()->route('eon.laravellti.install');
        }

//        $xml = (array) $xml;
        $has_key = false;
        $title = '';
        $desc = '';
        $launch_url = '';
        $key = '';
        $secret = '';

        if($xml) {
            if ($xml && array_key_exists('bltititle', $xml)) {
                $title = $xml['bltititle'];
            } else {
                $title = $request->get('title', '');
            }

            if ($xml && array_key_exists('bltidescription', $xml)) {
                $desc = $xml['bltidescription'];
            }

//            $launch_url_found  = InstallLTIToolController::getStatusOfLaunch_URL();
//            $title_found = InstallLTIToolController::getStatusOfTitle();
            //        dd($xml);
            foreach ($xml as $innerarr) {
                //Perfom a Second Level Nesting Loop
                foreach ($innerarr as $key => $value) {
                    if (str_contains($key, 'launch_url')) {
                        $launch_url = $value;
                        $launch_url_found = true;
                    } else if (str_contains($key, 'launchurl')) {
                        $launch_url = $value;
                        InstallLTIToolController::getStatusOfLaunch_URL(true);
                    }

                    if (str_contains($key, 'title')) {
                        $title = $value;
                        InstallLTIToolController::getStatusOfLaunch_URL(true);;
                    }

                    if (str_contains($key, 'description')) {
                        $desc = $value;
                    }
                }
            }
        }


        //dd($launch_url);

        //Peace Ngara Additions -> Get Status of launch URL and Title
        // If status is false get launch url

        if(!(InstallLTIToolController::getStatusOfLaunch_URL())) {
            $launch_url = $request->get('launch_url', '');
        }

        if(!(InstallLTIToolController::getStatusOfLaunch_URL())) {
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

        if ($request->has('logo_uri')) {
            $logo_uri = $request->logo_uri;
        }

        if($has_key) {
            $lti_key = new LTIKey;
            $lti_key->key_sha256 = lti_sha256($key);
            $lti_key->key_key = $key;
            $lti_key->secret = $secret;
            $lti_key->ack = '';
            $lti_key->user_id = $request->user()->id;
//            $lti_key->user_id = 1;
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
        $lti_domain->logo_uri = $logo_uri;

        $lti_domain->save();

        $message = 'The LTI component, ' . $title . ', was installed';

        session()->flash('success_message', $message);
        return redirect()->route('eon.laravellti.appstore');
    }

}
