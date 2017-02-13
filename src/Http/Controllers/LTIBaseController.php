<?php
/**
 * Created by PhpStorm.
 * User: jharing10
 * Date: 2017/02/12
 * Time: 1:00 AM
 */

namespace EONConsulting\LaravelLTI\Http\Controllers;

require_once "config.php";

use Illuminate\Http\Request;
use Tsugi\Config\ConfigInfo;
use Tsugi\Laravel\LTIX;

use App\Http\Controllers\Controller;
use Tsugi\Util\LTI;

class LTIBaseController extends Controller {

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $launch = LTIX::laravelSetup($request, LTIX::ALL);
            if ( $launch->redirect_url ) return redirect($launch->redirect_url);
            if ( $launch->send_403 ) return response($launch->error_message, 403);
            ob_start();
            ob_get_clean();
            return $next($request);
        });
    }

}