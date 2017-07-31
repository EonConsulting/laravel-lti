<?php

/**
 * Created by PhpStorm.
 * User: Peace-N
 * Date: 7/27/2017
 * Time: 12:15 PM
 */
namespace EONConsulting\LaravelLTI\Http\Controllers;

use App\Http\Controllers\Controller;
use EONConsulting\AppStore\Models\AppCategory;
use EONConsulting\LaravelLTI\Http\Requests\StoreAppsCategory;
use EONConsulting\LaravelLTI\Http\Requests\StoreAppsCategoryRequest;
use Illuminate\Http\Request;
//use Illuminate\Validation\Validator;

/**
 * Class CreateCatController
 * @package EONConsulting\LaravelLTI\Http\Controllers
 */
class CreateCatController extends Controller
{
    /**
     * Create a New Category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $breadcrumbs = [
            "title" => "App Store Categories",
        ];

        return view('eon.laravellti::createcat', ['breadcrumbs' => $breadcrumbs, 'categories' => $this->allCategories()]);
    }

    /**
     * All Categories
     * @return mixed
     */
    public function allCategories()
    {
        $categories = AppCategory::all();
        return $categories;
    }

    /**
     * New store Request
     * @param StoreAppsCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAppsCategoryRequest $request)
    {
        $this->checkRequestFields($request);

        $title = $request->get('title', '');
        $description = $request->get('description', '');
        $tags = $this->process_tags($request);
        $cat = new AppCategory;

        $cat->title = $title;
        $cat->description = $description;
        $cat->tags = $tags;
        $cat->creator_id = $request->user()->id;

        $cat->save();

        session()->flash('success_message', 'New Category saved.');
        return redirect()->route('eon.laravellti.cats');

    }

    /**
     * CHECK Request Data
     * @param Request $request
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    protected function checkRequestFields(Request $request)
    {


        if ($request->has('title')) {
            session()->flash('error_message', 'Title is Required.');
            return redirect()->route('eon.laravellti.cats');
        }

        if (!$request->has('description')) {
            session()->flash('error_message', 'Description is Required.');
            return redirect()->route('eon.laravellti.cats');
        }

        return true;

    }
    /**
     * @param Request $request
     * @return mixed|string
     */
    public function process_tags(Request $request) {
        $tags = '';
        if($request->has('tags')) {
            $tags = $request->get('tags');
        }

        return $tags;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id) {
        $category = AppCategory::find($id);
        $message = 'The Category, ' . $category->title . ' has been deleted.';
        $category->delete();
        session()->flash('success_message', $message);
        return redirect()->route('eon.laravellti.appstore');
    }
}