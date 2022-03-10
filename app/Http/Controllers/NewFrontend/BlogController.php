<?php

namespace App\Http\Controllers\NewFrontend;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Helpers\ResourceHelper;
use App\Http\Controllers\Controller;
use App\Models\ResourceCategory;
use App\Models\ResourceGuidance;
use Exception;

class BlogController extends Controller
{
    protected $resource, $helper, $resCategory, $guidance;
    public function __construct(Resource $resource, ResourceHelper $helper, ResourceCategory $resCategory, ResourceGuidance $guidance)
    {
        $this->resource = $resource;
        $this->helper = $helper;
        $this->resCategory = $resCategory;
        $this->guidance = $guidance;
    }

    /**
     * -------------------------------------------------------
     * | Display a listing of the blog.                      |   
     * |                                                     |
     * | @return $catSlug, Request $request                  |
     * -------------------------------------------------------
     */
    public function index($catSlug = null, Request $request)
    {
        try {
            // Get guidance list
            $lists = $this->guidance->whereStatus(1)
                ->whereHas('category', function($q) {
                    $q->whereSlug('blog');
                });
            // Get guidance list with categories
            $lists = $lists->whereHas('guidanceCategory', function($q) use($request) {
                $q->whereStatus(1);
                if($request->cat_slug != 'all') {
                    $q->whereSlug($request->cat_slug);
                }
            });
            $lists = $lists->orderBy('order_seq', 'asc')->with('guidanceCategory')->get();
            // Check if request is AJAX or not
            if($request->ajax()) {
                return view('newfrontend.blog.load_blog', ['blogs' => $lists]);
            }
            // return view
            return view('newfrontend.blog.index', ['blogs' => @$lists, 'catSlug' => @$catSlug]);
        } catch (Exception $e) {
            abort(404);
        }
    }

    /**
     * -------------------------------------------------------
     * | For show blog detail                                |   
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function show($slug)
    {
        try {
            // Get blog
            $blog = $this->guidance->whereStatus(1)->whereSlug($slug)->first();
            // Get latest blogs
            $latestBlog = $this->guidance->where('id', '!=', $blog->id)->whereStatus(1)
                ->whereHas('category', function($q) use($blog) {
                    $q->whereId($blog->resource_category_id);
                })->orderBy('id', 'desc')->with('guidanceCategory')->take(2)->get();
            // retrun view page
            return view('newfrontend.blog.details', ['blog' => $blog, 'latestBlog' => $latestBlog, 'detailType' => 'blogs']);
        } catch (Exception $e) {
            abort(404);
        }
    }
}
