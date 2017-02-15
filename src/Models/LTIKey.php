<?php
/**
 * Created by PhpStorm.
 * User: jharing10
 * Date: 2017/02/15
 * Time: 9:52 AM
 */

namespace EONConsulting\LaravelLTI\Models;


use Illuminate\Database\Eloquent\Model;

class LTIKey extends Model {

    protected $table = 'lti_key';
    protected $primaryKey = 'key_id';
    protected $fillable = [
        'key_sha256', 'key_key', 'secret', 'new_secret', 'ack', 'user_id', 'consumer_profile', 'new_consumer_profile',
        'tool_profile', 'new_tool_profile', 'json', 'settings', 'settings_url', 'entity_version'
    ];

    public function domain() {
        return $this->hasOne(LTIDomain::class, 'key_id', 'key_id');
    }

}