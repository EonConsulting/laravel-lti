<?php
/**
 * Created by PhpStorm.
 * User: jharing10
 * Date: 2017/02/12
 * Time: 1:00 AM
 */

namespace EONConsulting\LaravelLTI\Http\Controllers;

require_once "config.php";

use App\Models\User;
use EONConsulting\LaravelLTI\Models\UserLTILink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Validator\Constraints\Null;
use Tsugi\Config\ConfigInfo;
use Tsugi\Laravel\LTIX;
//PEACE ADDITIONS PASSWORD HASH WITH BCRYPT
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use Tsugi\Util\LTI;

class LTIBaseController extends Controller {

    protected $hasLTI = true;

    public function __construct() {
        if($this->hasLTI) {
            $this->middleware(function ($request, $next) {

                $launch = LTIX::laravelSetup($request, LTIX::ALL);

                if(array_key_exists('user_id', $request->all()) && !UserLTILink::where('lti_user_id', $request->all()['user_id'])->first()) {

                    $user = User::where('email', $request->all()['lis_person_contact_email_primary'])->first();

                    if(!$user) {
                        $user = User::create([
                            'email' => $request->all()['lis_person_contact_email_primary'],
                            'name' => $request->all()['lis_person_name_full'],
                            //UPDATE FROM PEACE NGARA TO CREATE A DEFAULT PASS FROM LAUNCH PARAMS
                            'password' =>  Hash::make('password1234'),
                        ]);
                    }
                    UserLTILink::create([
                        'user_id' => $user->id,
                        'lti_user_id' => $request->all()['user_id'],
                        'context_id' => $request->all()['context_id'],
                        'lis_person_contact_email_primary' => $request->all()['lis_person_contact_email_primary'],
                        'lis_person_name_family' => $request->all()['lis_person_name_family'],
                        'lis_person_name_full' => $request->all()['lis_person_name_full'],
                        'lis_person_name_given' => $request->all()['lis_person_name_given'],
                        'lis_person_sourcedid' => $request->all()['lis_person_sourcedid'],
                        'lis_result_sourcedid' => $request->all()['lis_result_sourcedid'],
                        'roles' => $request->all()['roles']
                    ]);

                    Auth::loginUsingId($user->id);

//                    $role = roles_permissions()->role_exists($request->all()['roles']);
//                    if($role) {
//                        if(!$user->hasRole(-1, $role)) {
//                            $user->giveRole(0, $role);
//                        }
//                    }
                } else if(array_key_exists('user_id', $request->all())) {
                    $user =  UserLTILink::where('lti_user_id', $request->all()['user_id'])->first();
                    if($user) {
                        $user = $user->user;
                        Auth::loginUsingId($user->id);
                    }
                }

                if ($launch->redirect_url) return redirect($launch->redirect_url);
                if ($launch->send_403) return response($launch->error_message, 403);
                ob_start();
                ob_get_clean();

                return $next($request);
            });
        }
    }

}