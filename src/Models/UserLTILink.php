<?php

namespace EONConsulting\LaravelLTI\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserLTILink extends Model {
    // Add Default Password
    protected $table = 'users_lti_links';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'lti_user_id', 'context_id', 'lis_person_contact_email_primary', 'lis_person_name_family',
        'lis_person_name_full', 'lis_person_name_given', 'lis_person_sourcedid', 'lis_result_sourcedid', 'roles'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
