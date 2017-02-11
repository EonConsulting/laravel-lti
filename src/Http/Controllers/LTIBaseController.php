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
use Tsugi\Laravel\LTIX;

use App\Http\Controllers\Controller;

class LTIBaseController extends Controller {

    public function index(Request $request) {
        $launch = LTIX::laravelSetup($request, LTIX::ALL);
        if ( $launch->redirect_url ) return redirect($launch->redirect_url);
        if ( $launch->send_403 ) return response($launch->error_message, 403);
        ob_start();
        echo("<pre>\n");
        echo("\nLaunch:\n");
        var_dump($launch);
        /*
                echo("\nSession:\n");
                var_dump($request->session());
                echo("\nPost:\n");
                var_dump($_POST);
                global $CFG;
                echo("\nCFG:\n");
                var_dump($CFG);
        */
        echo("</pre>\n");
        return ob_get_clean();
    }

}