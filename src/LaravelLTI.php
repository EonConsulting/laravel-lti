<?php
/**
 * Created by PhpStorm.
 * User: jharing10
 * Date: 2017/02/12
 * Time: 12:55 AM
 */

namespace EONConsulting\LaravelLTI;


use EONConsulting\LaravelLTI\Http\Controllers\InstallLTIToolController;
use EONConsulting\LaravelLTI\Http\Controllers\LaunchLTI;

class LaravelLTI {

    public function launch() {
//        return LaunchLTI::launch();
        return LaunchLTI::launchTao();
    }

    public function install() {
        return InstallLTIToolController::index();
    }

}