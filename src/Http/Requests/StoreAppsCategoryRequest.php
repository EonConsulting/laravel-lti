<?php
/**
 * Created by PhpStorm.
 * User: Peace-N
 * Date: 7/27/2017
 * Time: 3:11 PM
 */

namespace EONConsulting\LaravelLTI\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class StoreAppsCategoryRequest extends FormRequest
{
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
            'title'=>'required|min:2',
            'description'=>'required|min:2',
        ];
    }

}