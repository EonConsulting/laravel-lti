<?php
/**
 * Created by PhpStorm.
 * User: jharing10
 * Date: 2017/02/12
 * Time: 12:55 AM
 */

namespace EONConsulting\LaravelLTI;


use EONConsulting\LaravelLTI\Classes\Domains;
use EONConsulting\LaravelLTI\Http\Controllers\InstallLTIToolController;
use EONConsulting\LaravelLTI\Http\Controllers\LaunchLTI;

class LaravelLTI {

    public function launch($launch_url = '', $key = '', $secret = '') {
        return LaunchLTI::launch($launch_url, $key, $secret);
    }

    public function launch_tao($launch_url = '') {
        return LaunchLTI::launch($launch_url, 'unisa', '12345');
    }

    public function install() {
        return InstallLTIToolController::index();
    }

    public function get_domains() {
        return Domains::listDomains();
    }

}