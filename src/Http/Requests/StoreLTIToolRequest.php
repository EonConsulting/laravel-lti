<?php
/**
 * Created by PhpStorm.
 * User: jharing10
 * Date: 2017/02/14
 * Time: 11:12 PM
 */

namespace EONConsulting\LaravelLTI\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class StoreLTIToolRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'key' => '',
            'secret' => '',
            'title' => 'required_with:launch_url',
            'config_url' => 'required_without:launch_url|url',
            'launch_url' => 'required_without:config_url|url',
        ];
    }
}
