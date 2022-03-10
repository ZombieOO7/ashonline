<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\OrderHelper;
use App\Models\OrderItem;
use App\Models\Review;
use App\Models\Paper;
use App\Models\Order;
use App\Models\Admin;
use App\Models\BillingAddress;
use Exception;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{

    private $orderHelper;
    public function __construct(OrderHelper $orderHelper)
    {
        $this->helper = $orderHelper;
        $this->helper->mode = config('constant.frontend');
    }

    /**
     * -------------------------------------------------------
     * | Review Feedback                                     |   
     * |                                                     |
     * | @param $uuId                                        |
     * -------------------------------------------------------
     */
    public function feedback($uuid) 
    {
        try {
            $order = $this->helper->orderByUuid($uuid);
            $review = Review::whereOrderId($order->id)->pluck('paper_id')->toArray();
            $billingAddress = BillingAddress::whereOrderId($order->id)->first();
            $orderItems = OrderItem::whereOrderId($order->id)->get(); // whereNotIn('paper_id',$review)
            return view('frontend.review.feedback',['orderItems' => @$orderItems,'order' => @$order,'billingAddress' => @$billingAddress,'review' => @$review]);
        } catch (Exception $e) {
           abort('404');
        }
    }

    /**
     * -------------------------------------------------------
     * | Store user reviews                                  |   
     * |                                                     |
     * | @param Request $request                             |
     * -------------------------------------------------------
     */
    public function store(Request $request) 
    {
        $this->helper->dbStart();
        try {
                $data = [
                    'paper_id' => $request->paper_id,
                    'order_id' => $request->order_id,
                    'rate' => $request->score,
                    'content' => $request->review,
                    'parent_id' => Auth::guard('parent')->id(),
                ];
                $review = new Review;
                $review->fill($data)->save();

                // Update Paper Average Rate
                $this->updatePaperAverageRate($request->paper_id);

                // Send Email To Admin
                $order = Order::whereId($request->order_id)->firstOrFail();
                $this->sendMailToAdmin($order);

                $this->helper->dbEnd();
                // return redirect()->route('review/thank_you');
                return response()->json(['icon' => __('admin_messages.icon_success')]);
        } catch (Exception $e) {
            $this->helper->dbRollBack();
            return response()->json(['msg' => $e->getMessage(), 'icon' => __('admin_messages.icon_info')]);
        }
    }

    /**
     * -------------------------------------------------------
     * | Review Thank You Page                               |   
     * |                                                     |
     * -------------------------------------------------------
     */
    public function thankYou()
    {
        return view('frontend.review.thank_you');
    }

    public function loadMore(Request $request){
        $detail = $this->paperHelper->detailBySlug($request->slug);
        $reviews = Review::wherePaperId($detail->id)->paginate(4);
        if ($request->ajax()) {
            $view = view('frontend.papers.review_list')->with(['reviews' => $reviews])->render();
            return response()->json(['html' => $view]);
        }
    }

    /**
     * -------------------------------------------------------
     * | Send Email To Admin                                 |   
     * |                                                     |
     * | @param $orderId                                     |
     * -------------------------------------------------------
     */
    public function sendMailToAdmin($order)
    {
        try {
            $slug = config('constant.email_template.4');
            $template = $this->helper->emailTamplate($slug);
            $subject = $template->subject;
            $userdata =  Admin::first();
            $view = 'admin.review.admin_email';
            $billingAddress = BillingAddress::whereOrderId($order->id)->firstOrFail();
            $review = Review::whereOrderId($order->id)->get();
            $keywords = [
                '[USER_FULL_NAME]'=> $billingAddress->full_name,
                '[EMAIL]' => $billingAddress->email,
            ];
            $content = str_replace(array_keys($keywords),array_values($keywords), $template->body);
            $this->helper->sendMail($view,['order'=>@$order,'billing_address'=>$billingAddress,'review'=>@$review,'content'=>$content],null,$subject,$userdata);
            return __('frontend.email_sent_check_inbox');
        } catch(Exception $e) {
            return __('frontend.somthing_went_wrong');
        }
    }
     /**
     * -------------------------------------------------------
     * | Order Demo review                                   |
     * |                                                     |
     * | @param questionId                                   |
     * | @return response                                    |
     * -------------------------------------------------------
     */
    public function demo($uuid) 
    {
        $order = Order::whereUuid($uuid)->first();
        $item = @$order->items;
        $billingAddress = BillingAddress::whereOrderId($order->id)->first();
        return view('frontend.review.demo',['order' => @$order,'item' => @$item[0],'billingAddress' => @$billingAddress]);
    }

    /**
     * -------------------------------------------------------
     * | Store first paper review from mail                  |   
     * |                                                     |
     * | @param Request $request                             |
     * -------------------------------------------------------
     */
    public function reviewStore(Request $request) 
    {
        $order = Order::whereUuid($request->order_uuid)->firstOrFail();
        $paper = Paper::whereUuid($request->paper_uuid)->firstOrFail();
        // Check if already submitted
        $review = Review::where('paper_id',$paper->id)
                ->where('order_id',$order->id)
                ->first();
        if ($review) {
            return redirect()->route('feedback',['uuid' => $order->uuid]);
        } else {
            $this->helper->dbStart();
            try {
                if (trim($request->content) != "") {
                    data_set($request,'order_id',$order->id);
                    data_set($request,'paper_id',$paper->id);   
                    $review = new Review;
                    $review->fill($request->all())->save();
                    // Update Paper Average Rate
                    $this->updatePaperAverageRate($paper->id);
                    $this->sendMailToAdmin($order);
                }
                $this->helper->dbEnd();
                return redirect()->route('feedback',['uuid' => @$order->uuid]);
            } catch (Exception $e) {
                $this->helper->dbRollBack();
                abort('404');
            }   
        }
    }

    /**
     * -------------------------------------------------------
     * | Update average of paper                             |   
     * |                                                     |
     * | @param $paperId                                     |
     * -------------------------------------------------------
     */
    public function updatePaperAverageRate($paperId) 
    {
        $query = Review::wherePaperId($paperId);
        $paperReviews = $query->sum('rate');
        $totalPaperReviews = $query->count();
        $rate = 0.00;
        if($totalPaperReviews > 0 ) {
            $rate = $paperReviews / $totalPaperReviews;
        }
        Paper::whereId($paperId)->update(['avg_rate' => $rate]);
    }
}
