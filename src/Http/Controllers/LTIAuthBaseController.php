<?php

/**
 * Created by PhpStorm.
 * User: Peace-N
 * Date: 7/12/2017
 * Time: 10:58 AM
 */
namespace EONConsulting\LaravelLTI\Http\Controllers;
require_once "config.php";
use App\Models\User;
use EONConsulting\LaravelLTI\Models\UserLTILink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Validator\Constraints\Null;
use Tsugi\Config\ConfigInfo;
use Tsugi\Laravel\LTIX;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Tsugi\Util\LTI;
class LTIAuthBaseController extends Controller
{
    /**
     * @var bool
     */
    protected $hasAuth = false;
    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected $user;
    /**
     * @var
     */
    protected $params;

    /**
     * LTIAuthBaseController constructor.
     */
    public function __construct() {

        if($this->hasAuth) {
            $this->middleware(function ($request, $next) {
                $this->user = auth()->user();
                //$this->get_session_bag($request);
                $launch = LTIX::laravelauthSetup($request, LTIX::ALL);
                if ($launch->redirect_url) return redirect($launch->redirect_url);
                //if ($launch->send_403) return response($launch->error_message, 403);
                ob_start();
                ob_get_clean();
                return $next($request);
            });
        }
    }

    protected function get_session_bag($request) {

        if($this->user) {
            if ($this->user->lti[0]) {
                //Todo:: Check if session has [lti]
                $this->params = $this->user->lti[0];
            }

            //$request->session()->put('lti', $this->params->toArray());
            //$request->session()->put('lti_post', $this->params->toArray());
            //dd($request->session()->all());
            //$request->session()->put('post_lti', $this->params);
        }

        //return dd($this->user);
//        if($request->session()->get('lti')) {
//            $arrayOBJ = $request->session()->get('lti');
//            if(array_key_exists('key_id', $arrayOBJ) && in_array($this->user->id,$arrayOBJ)) {
//                $params = $this->user->lti[0];
//                $sessionOBJ = $request->session()->push('lti',$params);
//            }
//            print_r($sessionOBJ);
//        }
//
//        return dd($this->user);
    }
}