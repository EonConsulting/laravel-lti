<?php

/**
 * Created by PhpStorm.
 * User: Peace-N
 * Date: 7/27/2017
 * Time: 10:07 AM
 */
namespace EONConsulting\LaravelLTI\Http\Controllers;
use App\Http\Controllers\Controller;
use EONConsulting\AppStore\Models\AppCategory;
use EONConsulting\AppStore\Models\LTIDomainMeta;
use EONConsulting\LaravelLTI\Models\LTIDomain;
use Illuminate\Support\Facades\App;
use Tsugi\Util\LTI;

/**
 * LTI Appstore Tools Categories Controller
 * Class ToolCatsController
 */
class ToolCatsController extends Controller
{
    public function index(AppCategory $category) {
        return view('eon.laravellti::categories', ['categories' => $this->allCategories($category)]);
    }

    public function allCategories($category) {
        return $category->all();
    }

}