<?php
/**
 * Created by PhpStorm.
 * User: jharing10
 * Date: 2017/02/15
 * Time: 10:05 AM
 */

namespace EONConsulting\LaravelLTI\Models;


use Illuminate\Database\Eloquent\Model;

class LTIContext extends Model {

    protected $table = 'lti_context';
    protected $primaryKey = 'context_id';
    protected $fillable = [
        'context_sha256', 'context_key', 'key_id', 'title', 'json', 'settings', 'settings_url', 'entity_version'
    ];

}