<?php
/**
 * Created by PhpStorm.
 * User: jharing10
 * Date: 2017/02/15
 * Time: 5:36 PM
 */

namespace EONConsulting\LaravelLTI\Http\Controllers;


use EONConsulting\LaravelLTI\Models\LTIContext;

class DeleteLTIToolController extends LTIBaseController {

    protected $hasLTI = false;

    public function show($context) {
        $context = LTIContext::find($context);

        $breadcrumbs = [
            'title' => 'App Store',
            'href' => route('eon.laravellti.appstore'),
            'child' => [
                'title' => 'Delete '.$context->title,
            ],
        ];

        return view('eon.laravellti::delete', ['context' => $context, 'breadcrumbs' => $breadcrumbs]);
    }

    public function destroy($context) {
        $context = LTIContext::find($context);

        $message = 'LTI tool, ' . $context->title . ' removed.';


        $context->domain()->delete();
        $context->key()->delete();
        $context->delete();

        session()->flash('success_message', $message);
        return redirect()->route('eon.laravellti.appstore');
    }

}
