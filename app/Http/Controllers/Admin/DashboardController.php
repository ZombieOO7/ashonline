<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MockTest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Paper;
use App\Models\ParentSubscriber;
use App\Models\ParentSubscriptionInfo;
use App\Models\ParentUser;
use App\Models\Student;
use App\Models\StudentTest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(Paper $paper, OrderItem $orderItem, Order $order, Student $student, ParentUser $parentUser, StudentTest $studentTest, MockTest $mockTest, ParentSubscriptionInfo $parentSubscriberInfo)
    {
        $this->paper = $paper;
        $this->order = $order;
        $this->orderItem = $orderItem;
        $this->student = $student;
        $this->parentUser = $parentUser;
        $this->studentTest = $studentTest;
        $this->mockTest = $mockTest;
        $this->parentSubscriberInfo = $parentSubscriberInfo;
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // total Papers
        $totalPaper = $this->paper->active()->notDeleted()->count();
        $totalMockTest = $this->mockTest->notDeleted()->count();

        // All time total sold paper
        $totalSoldPaper = $this->orderItem::whereHas('paper',function ($q2){
            $q2->active()->notDeleted();
        })->count();
        // All time total Revenue
        $totalRevenue = $this->order->whereHas('items',function($q){
            // $q->whereHas('paper',function($q2){
            //     $q2->active()->notDeleted();
            // });
        })->sum('amount');
        $totalRevenue = ($totalRevenue!=null)?number_format($totalRevenue,2):0;

        // today total sold paper
        $todaySoldPaper = $this->orderItem::whereHas('orders', function ($q) {
            $q->whereDate('created_at', Carbon::today());
        })->whereHas('paper',function ($q2){
            $q2->active()->notDeleted();
        })->count();

        // this week data
        $fromDate = Carbon::now()->startOfWeek();
        $toDate = Carbon::now()->endOfWeek();

        $thisWeekSoldPaper = $this->orderItem::whereHas('orders', function ($q) use ($fromDate, $toDate) {
            $q->whereBetween('created_at', [$fromDate, $toDate]);
        })->whereHas('paper',function ($q2){
            $q2->active()->notDeleted();
        })->count();

        // Last week data
        $lastWeekFromDate = Carbon::now()->startOfWeek()->subWeek();
        $lastWeekToDate = Carbon::now()->endOfWeek()->subWeek();

        $lastWeekSoldPaper = $this->orderItem::whereHas('orders', function ($q) use ($lastWeekFromDate, $lastWeekToDate) {
            $q->whereBetween('created_at', [$lastWeekFromDate, $lastWeekToDate]);
        })->whereHas('paper',function ($q2){
            $q2->active()->notDeleted();
        })->count();

        // this month data
        $currentMonth = date('m');
        $thisMonthSoldPaper = $this->orderItem::whereHas('orders', function ($q) use ($currentMonth) {
            $q->whereMonth('created_at', $currentMonth);
        })->whereHas('paper',function ($q2){
            $q2->active()->notDeleted();
        })->count();

        // last month data
        $lastMonth = Carbon::now()->subMonth()->month;
        $lastMonthSoldPaper = $this->orderItem::whereHas('orders', function ($q) use ($lastMonth) {
            $q->whereMonth('created_at', $lastMonth);
        })->whereHas('paper',function ($q2){
            $q2->active()->notDeleted();
        })->count();

        /* emock data */

        // today sold mock
        $todaySoldMock = $this->orderItem::whereHas('orders', function ($q) {
            $q->whereDate('created_at', Carbon::today());
        })->whereHas('mockTest',function ($q2){
            $q2->notDeleted();
        })->count();

        // this week sold mock
        $thisWeekSoldMock = $this->orderItem::whereHas('orders', function ($q) use ($fromDate, $toDate) {
            $q->whereBetween('created_at', [$fromDate, $toDate]);
        })->whereHas('mockTest',function ($q2){
            $q2->active()->notDeleted();
        })->count();
 
        // last week sold mock
        $lastWeekSoldMock = $this->orderItem::whereHas('orders', function ($q) use ($lastWeekFromDate, $lastWeekToDate) {
            $q->whereBetween('created_at', [$lastWeekFromDate, $lastWeekToDate]);
        })->whereHas('mockTest',function ($q2){
            $q2->active()->notDeleted();
        })->count();

        // this month sold mock
        $thisMonthSoldMock = $this->orderItem::whereHas('orders', function ($q) use ($currentMonth) {
            $q->whereMonth('created_at', $currentMonth);
        })->whereHas('mockTest',function ($q2){
            $q2->active()->notDeleted();
        })->count();

        // last month data
        $lastMonthSoldMock = $this->orderItem::whereHas('orders', function ($q) use ($lastMonth) {
            $q->whereMonth('created_at', $lastMonth);
        })->whereHas('mockTest',function ($q2){
            $q2->active()->notDeleted();
        })->count();

        // All time sold mock
        $totalSoldMock = $this->orderItem::whereHas('mockTest',function ($q2){
            $q2->notDeleted();
        })->count();

        // total student
        $totalStudents = $this->student::count();

        // total parents
        $totalParents = $this->parentUser::count();

        // total attempt test
        $totalAttemptTest = $this->studentTest::whereStatus(2)->count();

        // This year subscription
        $year = date("Y");
        $thisYearSubscribers = $this->parentSubscriberInfo::whereYear('created_at',$year)->count();

        // This month subscription
        $month = date("m");
        $thisMonthSubscribers = $this->parentSubscriberInfo::whereMonth('created_at',$month)->count();

        // This week subscription
        $thisWeekSubscribers = $this->parentSubscriberInfo::whereBetween('created_at',[$fromDate,$toDate])->count();

        // Today subscription
        $today = date('Y-m-d');
        $todaySubscriber = $this->parentSubscriberInfo::whereDate('created_at',$today)->count();

        // Last year subscription
        $lastYear = date("Y",strtotime("-1 year"));
        $lastYearSubscriber = $this->parentSubscriberInfo::whereYear('created_at',$lastYear)->count();

        // Last Month subscription
        $lastMonthSubscriber = $this->parentSubscriberInfo::whereMonth('created_at',$lastMonth)->count();

        // Last Week subscription
        $lastWeekSubscriber = $this->parentSubscriberInfo::whereBetween('created_at',[$lastWeekFromDate,$lastWeekToDate])->count();

        // Total subscription
        $totalSubscribers = $this->parentSubscriberInfo::count();

        return view('admin.dashboard', ['todaySoldMock'=>@$todaySoldMock, 'thisWeekSoldMock'=>@$thisWeekSoldMock, 
            'lastMonthSoldMock' => @$lastMonthSoldMock, 'thisMonthSoldMock' => @$thisMonthSoldMock,
            'lastWeekSoldMock' => @$lastWeekSoldMock, 'totalSoldMock' => @$totalSoldMock,'totalStudents'=>@$totalStudents,
            'totalParents' => @$totalParents, 'totalAttemptTest' => $totalAttemptTest, 'totalMockTest' => @$totalMockTest,
            'totalSoldPaper' => @$totalSoldPaper, 'totalPaper' => @$totalPaper, 'totalRevenue' => @$totalRevenue,
            'todaySoldPaper' => @$todaySoldPaper, 'thisWeekSoldPaper' => @$thisWeekSoldPaper, 'lastWeekSoldPaper' => @$lastWeekSoldPaper,
            'thisMonthSoldPaper' => @$thisMonthSoldPaper, 'lastMonthSoldPaper' => @$lastMonthSoldPaper,'thisYearSubscribers' => @$thisYearSubscribers,
            'thisYearSubscribers' => @$thisYearSubscribers,'thisMonthSubscribers' =>@$thisMonthSubscribers,'todaySubscribers'=> @$todaySubscriber,
            'lastYearSubscriber' => @$lastYearSubscriber, 'lastMonthSubscriber' => @$lastMonthSubscriber,'lastWeekSubscriber' => @$lastWeekSubscriber,
            'totalSubscribers' => @$totalSubscribers
        ]);
    }

    /**
     * Get category chart data
     *
     * @return \Illuminate\Http\Response
     */
    public function chartData(Request $request)
    {
        $monthBooking = [];
        foreach (monthNameList() as $key => $month) {
            $result = $this->orderItem->whereHas('paper', function($q) use($request) {
                $q->active()->notDeleted();
                $q->where('category_id', $request->cat_id);
                if($request->sub_id)
                    $q->where('subject_id', $request->sub_id);
            })->whereHas('order', function($q) use($request, $key) {
                $q->whereYear('created_at', $request->year)->whereMonth('created_at', $key);
            })->count();
            $monthBooking[$month] = $result;
        }
        return @$monthBooking;
    }
}
