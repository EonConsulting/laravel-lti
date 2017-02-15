<?php
/**
 * Created by PhpStorm.
 * User: jharing10
 * Date: 2017/02/15
 * Time: 10:21 AM
 */

namespace EONConsulting\LaravelLTI\Models;


use Illuminate\Database\Eloquent\Model;

class LTIDomain extends Model {

    protected $table = 'lti_domain';
    protected $fillable = [
        'key_id', 'context_id', 'domain', 'port', 'consumer_key', 'secret', 'json'
    ];

}