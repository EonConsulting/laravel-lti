<?php
/**
 * Created by PhpStorm.
 * User: jharing10
 * Date: 2017/02/12
 * Time: 12:55 AM
 */

namespace EONConsulting\LaravelLTI\Facades;


use Illuminate\Support\Facades\Facade;

class LaravelLTI extends Facade {

    protected static function getFacadeAccessor() {
        return 'laravel_lti';
    }

}