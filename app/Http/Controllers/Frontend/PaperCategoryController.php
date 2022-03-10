<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Review;
use App\Helpers\BlockHelper;
use App\Helpers\OrderHelper;
use App\Helpers\PaperHelper;
use Illuminate\Http\Request;
use App\Helpers\PaperCategoryHelper;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class PaperCategoryController extends Controller
{
    protected $helper,$papeHelper,$orderHelper,$blockHelper;
    public function __construct(PaperCategoryHelper $helper,PaperHelper $papeHelper,OrderHelper $orderHelper,BlockHelper $blockHelper)
    {
        $this->helper = $helper;
        $this->paperHelper = $papeHelper;
        $this->orderHelper = $orderHelper;
        $this->helper->mode = config('constant.frontend');
        $this->blockHelper = $blockHelper;
    }

    /**
     * -------------------------------------------------------
     * | Paper category list page                            |
     * |                                                     |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function index()
    {
        $paperCategories = $this->helper::getPaperCategoryList();
        $paperContent = $this->blockHelper->findBySlug('papers');
        return view('frontend.papers.categories',['paperContent'=>@$paperContent,'paperCategories' => @$paperCategories]);
    }

    /**
     * -------------------------------------------------------
     * | Paper category details page                         |
     * |                                                     |
     * | @param $slug                                        |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function detail($slug)
    {
        $detail = $this->helper->detailByOnlySlug($slug);
        if($detail->status == 0) { // Check if category or it's paper is active or not
            return redirect()->route('papers')->with('error', $detail->title.__('frontend.is_not_active_or_no_longer_available'));
        }
        $subjects = $this->helper->subjects();
        $examTypes = $this->helper->examTypesList();
        $ages = $this->helper->agesList();
        $stages = $this->helper->stageList();
        return view('frontend.papers.detail',['detail' => @$detail,'papers' => @$detail->papers,'subjects' => @$subjects,'examTypes' => @$examTypes,'ages' => @$ages, 'stages'=>@$stages]);
    }

    /**
     * -------------------------------------------------------
     * | Paper search                                        |
     * |                                                     |
     * | @param Request $request                             |
     * | @return Response                                    |
     * -------------------------------------------------------
     */
    public function search(Request $request)
    {
        if ($request->ajax()) {
            $detail = $this->helper->detailById($request->category_id);
            $papers = $this->paperHelper->search($request);
            $paperData = view('frontend.papers.list',['detail' => @$detail, 'papers' => @$papers])->render();
            return response()->json(['paperData'=>@$paperData]);
        }
    }

    /**
     * -------------------------------------------------------
     * | Paper details                                       |
     * |                                                     |
     * | @param $paperCategrySlug,$paperSlug                 |
     * | @return View                                        |
     * -------------------------------------------------------
     */
    public function paperDetails($paperCategorySlug,$paperSlug)
    {
        $categoryDetail = $this->helper->detailByOnlySlug($paperCategorySlug);
        $detail = $this->paperHelper->detailBySlug($paperSlug);
        if($categoryDetail->status == 0) { // Check if category or it's paper is active or not
            return redirect()->route('papers')->with('error', @$categoryDetail->title.__('frontend.is_not_active_or_no_longer_available'));
        } else if ($detail->status == 0) {
            return redirect()->route('paper.detail',['slug' => @$categoryDetail->slug])->with('error', '"'.@$detail->title .'" '.__('frontend.is_not_active_or_no_longer_available'));
        } else {
            $reviews = Review::wherePaperId($detail->id)->whereStatus(1)->paginate(4);
            $papers = $this->paperHelper->getRelatedPapers($categoryDetail->id,$detail->id);
            $checkProductInSession = Cart::whereParentId(Auth::guard('parent')->id())->wherePaperId($detail->id)->get();
            $orderIds = Order::whereParentId(Auth::guard('parent')->id())->pluck('id');
            $orderItems = OrderItem::whereIn('order_id',$orderIds)->wherePaperId($detail->id)->count();
            $flag = true;
            if($orderItems > 0){
                $flag= false;
            }
            if(Auth::guard('student')->user() != null){
                $flag= false;
            }
            return view('frontend.papers.paper_info',['flag'=>@$flag,'categoryDetail' => @$categoryDetail, 'detail' => @$detail,'papers' => @$papers,'checkProductInSession' => @$checkProductInSession,'reviews' => @$reviews]);
        }
    }
}
