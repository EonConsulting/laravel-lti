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
use EONConsulting\LaravelLTI\Models\UserLTILink;

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

    public function get_user_lti_details($user = false, $context_id = false) {
        if(!$user) {
            // user not found
            return false;
        }

        $tool_consumer_instance_guid = 'dev.unisaonline.net';
        $tool_consumer_instance_description = 'EON Consulting';

        $params = [
            'lti_message_type' => 'basic-lti-launch-request',
            'lti_version' => '2.0',
            'resource_link_id' => 'replace-this-with-your-resource-link-id',
            'resource_link_title' => 'replace-this-with-your-resource-link-title',
            'resource_link_description' => 'replace-this-with-your-resource-link-description',
            'user_id' => $user->id,
            'user_image' => 'replace-this-with-your-user-image',
            'roles' => $this->get_user_lti_type($user, $context_id),
            'lis_person_name_given' => $user->name,
            'lis_person_name_family' => $user->name,
            'lis_person_name_full' => $user->name,
            'lis_person_contact_email_primary' => $user->email,
            'context_id' => 'replace-this-with-your-context-id',
            'context_type' => 'replace-this-with-your-context-type',
            'context_title' => 'replace-this-with-your-context-title',
            'context_label' => 'replace-this-with-your-context-label',
            'launch_presentation_locale' => 'en-US',
            'launch_presentation_document_target' => 'iframe',
            'launch_presentation_width' => 320,
            'launch_presentation_height' => 240,
            'launch_presentation_return_url' => 'replace-this-with-your-launch-url',
            'tool_consumer_instance_guid' => $tool_consumer_instance_guid,
            'tool_consumer_instance_name' => 'EON',
            'tool_consumer_instance_description' => $tool_consumer_instance_description,
            'tool_consumer_instance_url' => 'http://unisaonline.net',
            'tool_consumer_instance_contact_email' => 'joshua.harington@eon.co.za'
        ];

        return $params;
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

    public function is_lti($user = false) {
        return $user->hasLtiLinks($user->id);
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
