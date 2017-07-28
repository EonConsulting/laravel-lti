<?php
/**
 * Created by PhpStorm.
 * User: jharing10 | Peace-N
 * Date: 2017/02/14
 * Time: 10:39 PM
 */

namespace EONConsulting\LaravelLTI\Http\Controllers;


use App\Http\Controllers\Controller;
use EONConsulting\AppStore\Http\Controllers\AppsMetaClass;
use EONConsulting\AppStore\Models\AppCategory;
use EONConsulting\AppStore\Models\LTIDomainMeta;
use EONConsulting\LaravelLTI\Classes\Readers\ImportConfig;
use EONConsulting\LaravelLTI\Http\Requests\StoreLTIToolRequest;
use EONConsulting\LaravelLTI\Models\LTIContext;
use EONConsulting\LaravelLTI\Models\LTIDomain;
use EONConsulting\LaravelLTI\Models\LTIKey;
use Illuminate\Http\Request;

class InstallLTIToolController extends LTIBaseController {

    protected $hasLTI = false;

    static public function index(AppCategory $category) {
        return view('eon.laravellti::install',['categories' => self::allCategories($category)]);
    }


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

    static public function getStatusOfLaunch_URL ($launch_url_found = false) {
        $launch_url = $launch_url_found;
        return $launch_url;
    }

    static public function getStatusOfTitle_URL ($title_status_found = true) {
        $title_status = $title_status_found;
        return $title_status;
    }

    static public function checkRequestHasKey (Request $request) {
        return $request->get('key');
    }

    static public function checkRequestHasSecret(Request $request) {
        return $request->get('secret');
    }

    static public function checkAppInstalled(Request $request, $launch_url) {
        return LTIDomain::where('domain', 'like', $launch_url)->first();
    }

    static public function store(StoreLTIToolRequest $request) {

        $xml = ImportConfig::read_from_dom($request->config_url);

        if(!$xml && !$request->has('launch_url')) {
            session()->flash('error_message', 'Something wen\'t wrong');
            return redirect()->route('eon.laravellti.install');
        }

        $has_key = false;
        $title = '';
        $description = '';
        $launch_url = '';
        $key = '';
        $secret = '';
        $logo_uri = '';
        $privacy_level = '';
        $app_category = '';


        if($xml) {

            if ($xml && array_key_exists('bltidescription', $xml)) {
                $desc = $xml['bltidescription'];
            }

            foreach ($xml as $innerarr) {
                foreach ($innerarr as $key => $value) {
                    if (str_contains($key, 'launch_url')) {
                        $launch_url = $value;
                        InstallLTIToolController::getStatusOfLaunch_URL(true);
                    } else if ($request->has('launch_url')) {
                        $launch_url = $request->get('launch_url');
                        InstallLTIToolController::getStatusOfLaunch_URL(true);
                    }

                    if (str_contains($key, 'title')) {
                        $title = $value;
                        InstallLTIToolController::getStatusOfTitle_URL(true);
                    }else{
                        InstallLTIToolController::getStatusOfTitle_URL(false);
                    }

                    if (str_contains($key, 'description')) {
                        $description = $value;
                    }
                }
            }
        }


        if(!self::checkRequestHasKey($request)) {
            session()->flash('error_message', 'Key field can not be empty.');
            return redirect()->route('eon.laravellti.appstore');
        }

        if(!self::checkRequestHasSecret($request)) {
            session()->flash('error_message', 'Secret field can not be empty.');
            return redirect()->route('eon.laravellti.appstore');
        }

        if(self::checkAppInstalled($request, $launch_url)) {
            session()->flash('error_message', 'A component with that launch URL already exists.');
            return redirect()->route('eon.laravellti.appstore');
        }

        if(self::getStatusOfTitle_URL(false)) {
            $title = $request->get('title', '');
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
        if ($request->has('categories')) {
            $app_category = $request->categories;
        }

        $xmlstr = AppsMetaClass::read_str_from_url($request->config_url);

        $properties = $xmlstr->children()->bltiextensions->lticmproperty;
        if(isset($properties)) {
            if (in_array('public', (array) $properties)) {
                $privacy_level = 'public';
            } elseif (in_array('anonymous', (array) $properties)) {
                $privacy_level = 'anonymous';
            }
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
        $lti_domain->category_id = $app_category;
        $lti_domain->domain = $launch_url;
        $lti_domain->description = $description;
        $lti_domain->port = 80;
        $lti_domain->consumer_key = $key;
        $lti_domain->secret = $secret;
        $lti_domain->json = json_encode($xml);
        $lti_domain->logo_uri = $logo_uri;
        $lti_domain->app_categories = $app_category;

        $lti_domain->save();

        $metaJson[] = [
            'user_id' => $request->user()->id,
            'lti_user_id' => $request->user()->id,
            'app_id' => $context->context_id,
            'lti_version' => 'v1p0',
            'category' => $app_category,
            'privacy_lavey' => $privacy_level,
            'user_agent' => $request->header('User-Agent')
        ];

        $meta_info = new LTIDomainMeta;
        $meta_info->user_id = $request->user()->id;
        $meta_info->lti_user_id = $request->user()->id;
        $meta_info->app_id = $context->context_id;
        $meta_info->lti_version = 'v1p0';
        $meta_info->category = $app_category;
        $meta_info->privacy_level = $privacy_level;
        $meta_info->user_agent = $request->header('User-Agent');
        $meta_info->display_type = '';
        $meta_info->json = json_encode($metaJson);


        $meta_info->save();

        $message = 'The LTI component, ' . $title . ', was installed';

        session()->flash('success_message', $message);
        return redirect()->route('eon.laravellti.appstore');
    }

}
