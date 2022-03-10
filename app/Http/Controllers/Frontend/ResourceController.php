<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Helpers\ResourceHelper;
use App\Http\Controllers\Controller;
use App\Models\ResourceCategory;
use App\Models\ResourceGuidance;
use Exception;

class ResourceController extends Controller
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
     * | Display a listing of the resource.                  |   
     * |                                                     |
     * | @return \Illuminate\Http\Response                   |
     * -------------------------------------------------------
     */
    public function index($type = null, $catSlug = null,Request $request)
    {
        try {
            /** Get category detail */
            $category = $this->resCategory->whereSlug($type)->first();
            /** Check if type is guidance */
            if($type == 'guidance') {
                $lists = $this->guidance->where('status', 1)
                        ->whereHas('category', function($q) use($type) {
                            $q->whereSlug($type);
                        });
                $lists = $lists->whereHas('guidanceCategory', function($q) use($request) {
                    $q->whereStatus(1);
                    if($request->cat_slug != 'all') {
                        $q->whereSlug($request->cat_slug);
                    }
                });
                $lists = $lists->orderBy('id', 'desc')->with('guidanceCategory')->get();
                if($request->ajax()) {
                    return view('frontend.resources.load_guidance_resources', ['type' => @$type, 'resources' => @$lists]);
                }
                return view('frontend.resources.guidance_index', ['type' => @$type, 'category' => @$category, 'resources' => @$lists, 'catSlug' => @$catSlug]);
            } else {
                $lists = $this->resource->whereHas('category', function($q) use($type) {
                            $q->whereSlug($type);
                        })->orderBy('id', 'desc')->paginate(9);
                if($request->ajax()) {
                    return view('frontend.resources.load_resources', ['type' => @$type, 'resources' => @$lists]);
                }
                return view('frontend.resources.index', ['type' => @$type, 'category' => @$category, 'resources' => @$lists]);
            }
        } catch (Exception $e) {
            abort(404);
        }
    }

    /**
     * -------------------------------------------------------
     * | For download file                                   |   
     * |                                                     |
     * -------------------------------------------------------
     */    
    public function downloadFile($uuid, $filetype)
    {
        return $this->helper->downlaodFile(@$uuid, @$filetype);
    }

    /**
     * -------------------------------------------------------
     * | For show guidance detail                            |   
     * |                                                     |
     * -------------------------------------------------------
     */    
    public function show($slug)
    {
        try {
            $blog = $this->guidance->whereStatus(1)->whereSlug($slug)->first();
            $category = $this->resCategory->whereId($blog->resource_category_id)->first();
            $latestResources = $this->guidance->where('id', '!=', $blog->id)->whereStatus(1)
                    ->whereHas('category', function($q) use($blog) {
                        $q->whereId($blog->resource_category_id);
                    })->orderBy('id', 'desc')->with('guidanceCategory')->take(2)->get();
            return view('frontend.blog.detail', ['blog' => @$blog, 'latestBlog' => @$latestResources, 'detailType' => 'guidance', 'category' => @$category]);
        } catch (Exception $e) {
            abort(404);
        }
    }
}
