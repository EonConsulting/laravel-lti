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

    public function get_user_lti_type($user = false, $context_id = false) {
        if(!$user) {
            // user not found
            return false;
        }

        if($context_id == false) {

            $lti = $user->lti;
            if (count($lti) == 0) {
                // no lti links found
                return false;
            }

            $lti = $lti[0];
            $role = $lti->roles;

            return $role;
        } else {
            return $user->hasLtiContext($context_id);
        }
    }

    public function is_learner($user = false, $context_id = false) {
        return $this->is_x($user, $context_id, 'Learner');
    }

    public function is_instructor($user = false, $context_id = false) {
        return $this->is_x($user, $context_id, 'Instructor');
    }

    private function is_x($user = false, $context_id = false, $type = 'Learner') {
        if(!$user) {
            // user not found
            return false;
        }

        if($context_id == false) {
            return $this->get_user_lti_type($user) == $type;
        } else {
            return $this->get_user_lti_type($user, $context_id) == $type;
        }
    }

}