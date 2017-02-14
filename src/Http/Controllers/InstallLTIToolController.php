<?php
/**
 * Created by PhpStorm.
 * User: jharing10
 * Date: 2017/02/14
 * Time: 10:39 PM
 */

namespace EONConsulting\LaravelLTI\Http\Controllers;


class InstallLTIToolController extends LTIBaseController {

    public function index() {
        return view('eon.laravellti::install');
    }

}