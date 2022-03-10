@extends('admin.layouts.default')
@push('inc_css')
<link href="{{ asset('backend/css/components.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
@section('title', __('formname.dashboard.title'))
<div class="m-grid__item m-grid__item--fluid m-wrapper adminDashboard">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center" style="padding-left:15px !important;">
            <div class="mr-auto">
                <h3 class="m-subheader__title " >{{__('formname.dashboard.title')}}</h3>
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--tab">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon m--hide">
                            <i class="la la-gear"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            E-Papers
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-portlet">
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <div class="row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-md-12 col-lg-6 col-xl-3">

                        <!--begin::Total Profit-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.dashboard.today_sold_paper')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                    {{-- All Time Orders --}}
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{@$todaySoldPaper ?? 0}}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-brand" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                    {{-- Orders --}}
                                </span>
                                <span class="m-widget24__number">
                                    {{-- {{@$totalOrderPr}}% --}}
                                </span>
                            </div>
                        </div>

                        <!--end::Total Profit-->
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-3">

                        <!--begin::New Feedbacks-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.dashboard.this_week_sold_paper')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                    {{-- Customer Review --}}
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{@$thisWeekSoldPaper ?? 0}}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-info" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                    {{-- Subscribed Vendors --}}
                                </span>
                                <span class="m-widget24__number">
                                    {{-- {{@$totalSubscribedVendorPr}}% --}}
                                </span>
                            </div>
                        </div>

                        <!--end::New Feedbacks-->
                    </div>

                    <div class="col-md-12 col-lg-6 col-xl-3">

                        <!--begin::New Users-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.dashboard.last_week_sold_paper')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                    {{-- Joined New User --}}
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{@$lastWeekSoldPaper ?? 0}}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-success" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                    {{-- Change --}}
                                </span>
                                <span class="m-widget24__number">
                                    {{-- 90% --}}
                                </span>
                            </div>
                        </div>

                        <!--end::New Users-->
                    </div>

                    <div class="col-md-12 col-lg-6 col-xl-3">

                        <!--begin::New Orders-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.dashboard.this_month_sold_paper')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                    {{-- Fresh Order Amount --}}
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{@$thisMonthSoldPaper ?? 0}}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                    {{-- Subscribed Vendor --}}
                                </span>
                                <span class="m-widget24__number">
                                    {{-- {{@$totalSubscribedVendorPr}}% --}}
                                </span>
                            </div>
                        </div>

                        <!--end::New Orders-->
                    </div>

                </div>
            </div>
        </div>
        <div class="m-portlet ">
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <div class="row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-md-12 col-lg-6 col-xl-3">

                        <!--begin::Total Profit-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.dashboard.last_month_sold_paper')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                    {{-- All Time Orders --}}
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{@$lastMonthSoldPaper ?? 0}}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-brand" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                    {{-- Orders --}}
                                </span>
                                <span class="m-widget24__number">
                                    {{-- {{@$totalOrderPr}}% --}}
                                </span>
                            </div>
                        </div>

                        <!--end::Total Profit-->
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-3">

                        <!--begin::New Feedbacks-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.dashboard.all_time_sold_paper')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                    {{-- Customer Review --}}
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{@$totalSoldPaper ?? 0}}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-info" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                    {{-- Subscribed Vendors --}}
                                </span>
                                <span class="m-widget24__number">
                                    {{-- {{@$totalSubscribedVendorPr}}% --}}
                                </span>
                            </div>
                        </div>

                        <!--end::New Feedbacks-->
                    </div>

                    <div class="col-md-12 col-lg-6 col-xl-3">

                        <!--begin::New Users-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.dashboard.all_time_revenue')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                    {{-- Joined New User --}}
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{config('constant.default_currency_symbol').(@$totalRevenue ?? 0) }}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-success" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                    {{-- Change --}}
                                </span>
                                <span class="m-widget24__number">
                                    {{-- 90% --}}
                                </span>
                            </div>
                        </div>

                        <!--end::New Users-->
                    </div>

                    <div class="col-md-12 col-lg-6 col-xl-3">

                        <!--begin::New Orders-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.dashboard.total_papers')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                    {{-- Fresh Order Amount --}}
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{@$totalPaper ?? 0}}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                    {{-- Subscribed Vendor --}}
                                </span>
                                <span class="m-widget24__number">
                                    {{-- {{@$totalSubscribedVendorPr}}% --}}
                                </span>
                            </div>
                        </div>

                        <!--end::New Orders-->
                    </div>

                </div>
            </div>
        </div>
        <div class="m-portlet m-portlet--tab">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon m--hide">
                            <i class="la la-gear"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            E-Mock
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-portlet ">
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <div class="row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-md-12 col-lg-6 col-xl-3">

                        <!--begin::Total Profit-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.dashboard.today_sold_mock')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                    {{-- All Time Orders --}}
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{@$todaySoldMock ?? 0}}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-brand" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                    {{-- Orders --}}
                                </span>
                                <span class="m-widget24__number">
                                    {{-- {{@$totalOrderPr}}% --}}
                                </span>
                            </div>
                        </div>

                        <!--end::Total Profit-->
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-3">

                        <!--begin::New Feedbacks-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.dashboard.this_week_sold_mock')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                    {{-- Customer Review --}}
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{@$thisWeekSoldMock ?? 0}}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-info" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                    {{-- Subscribed Vendors --}}
                                </span>
                                <span class="m-widget24__number">
                                    {{-- {{@$totalSubscribedVendorPr}}% --}}
                                </span>
                            </div>
                        </div>

                        <!--end::New Feedbacks-->
                    </div>

                    <div class="col-md-12 col-lg-6 col-xl-3">

                        <!--begin::New Users-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.dashboard.last_week_sold_mock')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                    {{-- Joined New User --}}
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{@$lastMonthSoldMock ?? 0}}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-success" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                    {{-- Change --}}
                                </span>
                                <span class="m-widget24__number">
                                    {{-- 90% --}}
                                </span>
                            </div>
                        </div>

                        <!--end::New Users-->   
                    </div>

                    <div class="col-md-12 col-lg-6 col-xl-3">

                        <!--begin::New Orders-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.dashboard.this_month_sold_mock')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                    {{-- Fresh Order Amount --}}
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{@$thisMonthSoldMock ?? 0}}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                    {{-- Subscribed Vendor --}}
                                </span>
                                <span class="m-widget24__number">
                                    {{-- {{@$totalSubscribedVendorPr}}% --}}
                                </span>
                            </div>
                        </div>

                        <!--end::New Orders-->
                    </div>

                </div>
            </div>
        </div>
        <div class="m-portlet ">
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <div class="row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-md-12 col-lg-6 col-xl-3">

                        <!--begin::Total Profit-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.dashboard.last_month_sold_mock')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                    {{-- All Time Orders --}}
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{@$lastMonthSoldMock ?? 0}}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-brand" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                    {{-- Orders --}}
                                </span>
                                <span class="m-widget24__number">
                                    {{-- {{@$totalOrderPr}}% --}}
                                </span>
                            </div>
                        </div>

                        <!--end::Total Profit-->
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-3">

                        <!--begin::New Feedbacks-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.dashboard.all_time_sold_mock')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                    {{-- Customer Review --}}
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{@$totalSoldMock ?? 0}}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-info" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                    {{-- Subscribed Vendors --}}
                                </span>
                                <span class="m-widget24__number">
                                    {{-- {{@$totalSubscribedVendorPr}}% --}}
                                </span>
                            </div>
                        </div>

                        <!--end::New Feedbacks-->
                    </div>

                    <div class="col-md-12 col-lg-6 col-xl-3">

                        <!--begin::New Users-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.dashboard.total_test_attempt')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                    {{-- Joined New User --}}
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{ @$totalAttemptTest ?? 0 }}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-success" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                    {{-- Change --}}
                                </span>
                                <span class="m-widget24__number">
                                    {{-- 90% --}}
                                </span>
                            </div>
                        </div>

                        <!--end::New Users-->
                    </div>

                    <div class="col-md-12 col-lg-6 col-xl-3">

                        <!--begin::New Orders-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.dashboard.total_mocks')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                    {{-- Fresh Order Amount --}}
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{@$totalPaper ?? 0}}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                    {{-- Subscribed Vendor --}}
                                </span>
                                <span class="m-widget24__number">
                                    {{-- {{@$totalSubscribedVendorPr}}% --}}
                                </span>
                            </div>
                        </div>

                        <!--end::New Orders-->
                    </div>

                </div>
            </div>
        </div>
        <div class="m-portlet col-md-6">
            <div class="m-portlet__body m-portlet__body--no-padding">
                <div class="row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-md-12 col-lg-6">

                        <!--begin::Total Profit-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.dashboard.total_parent')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                    {{-- All Time Orders --}}
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{@$totalParents ?? 0}}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-brand" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                    {{-- Orders --}}
                                </span>
                                <span class="m-widget24__number">
                                    {{-- {{@$totalOrderPr}}% --}}
                                </span>
                            </div>
                        </div>

                        <!--end::Total Profit-->
                    </div>
                    <div class="col-md-12 col-lg-6">

                        <!--begin::New Feedbacks-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.dashboard.total_child')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                    {{-- Customer Review --}}
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{@$totalStudents ?? 0}}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-info" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                    {{-- Subscribed Vendors --}}
                                </span>
                                <span class="m-widget24__number">
                                    {{-- {{@$totalSubscribedVendorPr}}% --}}
                                </span>
                            </div>
                        </div>

                        <!--end::New Feedbacks-->
                    </div>
                </div>
            </div>
        </div>
        <div class="m-portlet m-portlet--tab">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon m--hide">
                            <i class="la la-gear"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            {{__('formname.practice')}}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-portlet col-md-12">
            <div class="m-portlet__body m-portlet__body--no-padding">
                <div class="row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-md-12 col-lg-3">
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.yearly_subscription')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{@$thisYearSubscribers ?? 0}}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-brand" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                </span>
                                <span class="m-widget24__number">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-3">
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.monthly_subscription')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{@$thisMonthSubscribers ?? 0}}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-info" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                </span>
                                <span class="m-widget24__number">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-3">
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.weekly_subscription')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{@$thisWeekSubscribers ?? 0}}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-info" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                </span>
                                <span class="m-widget24__number">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-3">
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.today_subscription')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{@$todaySubscriber ?? 0}}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-info" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                </span>
                                <span class="m-widget24__number">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-md-12 col-lg-3">
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.last_year_subscription')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{@$lastYearSubscriber ?? 0}}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-brand" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                </span>
                                <span class="m-widget24__number">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-3">
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.last_month_subscription')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{@$lastMonthSubscriber ?? 0}}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-info" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                </span>
                                <span class="m-widget24__number">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-3">
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.last_week_subscription')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{@$lastWeekSubscriber ?? 0}}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-info" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                </span>
                                <span class="m-widget24__number">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-3">
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    {{__('formname.total_subscribers')}}
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
                                </span>
                                <span class="m-widget24__stats m--font-brand" style="margin-top: -0.43rem !important;">
                                    {{@$totalSubscribers ?? 0}}
                                </span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-info" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
                                </span>
                                <span class="m-widget24__number">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="m-portlet m-portlet--full-height ">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Order Summary
                                </h3>
                            </div>
                            <div class="m-portlet__head-tools ml-5">
                                <select id="category" name="year" class="form-control" style="max-width:200px;">
                                    <option value="">Select Exam Category</option>
                                    @forelse (paperCategory() as $key => $item)
                                    <option value="{{$key}}" >{{$item}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="m-portlet__head-tools ml-5">
                                <select id="subject" name="year" class="form-control" style="max-width:200px;">
                                    <option value="">Select Subject</option>
                                    @forelse (subjectList() as $key => $item)
                                    <option value="{{$key}}">{{$item}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="m-portlet__head-tools ml-5">
                                <select id="year" name="year" class="form-control" style="max-width:200px;">
                                    @forelse(reportYearList() as $key => $year)
                                    <option value="{{$key}}" >{{$year}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="" id="columnchart" style="width: 100%; height: 500px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@stop
@section('inc_script')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="{{asset('backend/js/dashboard.js')}}"></script>
@endsection