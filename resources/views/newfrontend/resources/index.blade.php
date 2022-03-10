@extends('newfrontend.layouts.default')

@php
$title = __('admin/resorces.list_title', ['type' => $category->name]);
@endphp

@section('title',@$title)

@section('breadcrumbs', Breadcrumbs::render('resources', $title, route('eresources/index', $type)))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mrgn_bt_30">
            @include('frontend.includes.flashmessages')
            <div class="row">
            <div class="col-md-12">
                <h2 class="page_title def_ttitle">{{ $category->name }}</h2>
                <p class="def_p mrgn_bt_30">{!! nl2br(e($category->content)) !!}</p>
            </div>
            <div class="col-lg-12 mrgn_bt_30">
                <div class="rspnsv_table resource_table">
                    <div id="loader1" class="res_loader">
                        <div class="loader-icon">
                            <div class="circle circ-1"></div>
                            <div class="circle circ-2"></div>
                            <div class="circle circ-3"></div>
                            <div class="circle circ-4"></div>
                        </div>
                    </div>
                    <table class="table-bordered table-striped table-condensed cf">
                        <thead class="cf">
                        <tr>
                            <th>{{__('formname.sno')}}</th>
                            <th>{{__('formname.exam_paper')}}</th>
                            <th class="questn_dwnld">{{__('formname.question_paper')}}</th>
                            <th>{{__('formname.detail_ans')}}</th>
                        </tr>

                        </thead>
                        <tbody id="all_resources">
                            @include('newfrontend.resources.load_resources')
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('pageJs')
<script src="{{ asset('frontend/js/resources/index.js') }}" ></script>
@endsection

