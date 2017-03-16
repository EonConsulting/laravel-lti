<?php

namespace EONConsulting\LaravelLTI\Http\Controllers;


use Illuminate\Http\Request;

class LaunchLTIToolController extends LTIBaseController {

    public function launch(Request $request) {

        $launch_url = $request->get('launch_url', '');
        $key = $request->get('key', '');
        $secret = $request->get('secret', '');

        // query
//        $yt = YourTable::where('launch_url', $launch_url)->first();
//
//        $key = $yt->key;
//        $secret = $yt->secret;

        return laravel_lti()->launch($launch_url, $key, $secret);
    }

}