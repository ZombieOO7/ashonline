@extends('newfrontend.layouts.default')
@section('title',@$examBoard->title)
@section('content')
@php
    $isParent = isParent();
    $routeArray = [
        [
            'title' => __('frontend.emock.title'),
            'route' => route('e-mock'),
        ],
        [
            'title' => @$examBoard->title,
            'route' => route('emock-exam',['slug'=>@$examBoard->slug]),
        ],
    ];
@endphp
@include('newfrontend.includes.breadcrumbs',$routeArray)
<section class="top_link_scn mt-4">
</section>
<section class="mock_list pdng_btm_90">
    <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-md-12 in_ttl">
                            @if(Auth::guard('parent')->user() == null || Auth::guard('parent')->user()['is_tuition_parent'] == 0)
                                <div class="container text-center text-md-center">
                                    @forelse(@$examBoardEveryOne??[] as $key => $board)
                                        <a href="{{ route('emock-exam',['slug'=>@$board->slug]) }}"
                                        class="e-mck-btn @if($board->id == $examBoard->id) active @endif">{{ @$board->title }}</a>
                                    @empty
                                    @endforelse
                                </div>
                            @elseif(Auth::guard('parent')->user()['is_tuition_parent'] == 1)
                                <div class="container text-center text-md-center">
                                    @forelse(@$examBoardBoth??[] as $key => $boards)
                                        <a href="{{ route('emock-exam',['slug'=>@$boards->slug]) }}"
                                        class="e-mck-btn @if($boards->id == $examBoard->id) active @endif">{{ @$boards->title }}</a>
                                    @empty
                                    @endforelse
                                </div>
                            @endif
                            <p class="df_pp">{!! @$examBoard->content !!}</p>
                        </div>
                        <div class="col-md-12">
                            <div class="rspnsv_table scrollble-table" align="center">
                                @if($examBoard->slug =='independent')
                                    @forelse($grades as $gkey => $grade)
                                        <table id='table{{$grade->id}}' class="table-bordered table-striped table-condensed datatable cf" data-url='{{route('get-board-exam-data')}}' data-grade_id='{{@$grade->id}}' data-exam_board_id='{{@$examBoard->id}}'>
                                            <thead class="cf">
                                            <tr>
                                                <th class="img_hd">{{__('formname.mock.image')}}</th>
                                                <th>{{__('formname.mock.exam_name')}}</th>
                                                <th>{{__('formname.mock.date')}}</th>
                                                <th>{{__('formname.duration')}}</th>
                                                <th>{{__('formname.mock.price')}}</th>
                                                @if($isParent==true)
                                                    <th>{{__('formname.mock.action')}}</th>
                                                @endif
                                            </tr>
                                            </thead>
                                            <thead class="cf">
                                            @if($gkey != 0)
                                                <tr class="mid_height">
                                                    <th colspan="6"></th>
                                                </tr>
                                            @endif
                                            <tr class="middle_hdng_rw">
                                                <th colspan="6" align="center">{{$grade->title}}</th>

                                            </tr>

                                            </thead>
                                        </table>
                                    @empty
                                        No Record Found !
                                    @endforelse
                                @elseif($examBoard->slug =='super_selective')
                                    @forelse($grades as $gkey => $grade)
                                        @forelse($grade['schools'] as $skey=> $school)
                                            <table id='table{{$grade->id}}_{{$school->id}}' class="filterTable{{$grade->id}} table-bordered table-striped table-condensed datatable cf" data-url='{{route('get-board-exam-data')}}' data-school_id={{@$school->id}} data-grade_id='{{$grade->id}}' data-exam_board_id='{{$examBoard->id}}'>
                                                @if($skey == 0)
                                                    <thead class="cf">
                                                    <tr>
                                                        <th class="img_hd">{{__('formname.mock.image')}}</th>
                                                        <th>{{__('formname.mock.exam_name')}}</th>
                                                        <th>{{__('formname.mock.date')}}</th>
                                                        <th>{{__('formname.duration')}}</th>
                                                        <th>{{__('formname.mock.price')}}</th>
                                                        @if($isParent==true)
                                                            <th>{{__('formname.mock.action')}}</th>
                                                        @endif
                                                    </tr>
                                                    </thead>
                                                @endif
                                                <thead class="cf">
                                                @if($skey != 0)
                                                    <tr class="mid_height">
                                                        <th colspan="6"></th>
                                                    </tr>
                                                @endif
                                                @if($skey == 0)
                                                    <tr class="middle_hdng_rw">

                                                        <th ></th>
                                                        <th ></th>
                                                        <th colspan="4" align="center">{{$grade->title}}</th>
                                                        <th colspan="2" align="left">
                                                            <div class="filter_drpdn d-flex align-items-center">
                                                                <span>{{__('frontend.emock.filter_by')}}:</span>
                                                                {{Form::select('filterBy',@config('constant.mockFilter'),null,['class'=>'selectpicker def_select filterBy','data-grade_id'=>$grade->id,'data-table_id'=>'table'.$grade->id.'_'.$school->id])}}
                                                            </div>
                                                        </th>
                                                    </tr>

                                                @endif
                                                <tr class="middle_hdng_rw">
                                                    <th colspan="8" align="center">{{$school->school_name}}</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        @empty
                                            No Record Found !
                                        @endforelse
                                    @empty
                                    @endforelse
                                @else
                                    @forelse($grades as $gkey => $grade)
                                        <table id='table{{@$grade->id}}' class="table-bordered table-striped table-condensed datatable cf" data-url='{{route('get-board-exam-data')}}' data-grade_id='{{@$grade->id}}' data-exam_board_id='{{@$examBoard->id}}'>
                                            @if($gkey == 0)
                                                <thead class="cf">
                                                <tr>
                                                    <th class="img_hd">{{__('formname.mock.image')}}</th>
                                                    <th>{{__('formname.mock.exam_name')}}</th>
                                                    <th>{{__('formname.mock.date')}}</th>
                                                    <th>{{__('formname.duration')}}</th>
                                                    <th>{{__('formname.mock.price')}}</th>
                                                    @if($isParent==true)
                                                        <th>{{__('formname.mock.action')}}</th>
                                                    @endif
                                                </tr>
                                                </thead>
                                            @endif
                                            <thead class="cf">
                                            @if($gkey != 0)
                                                <tr class="mid_height">
                                                    <th colspan="6"></th>
                                                </tr>
                                            @endif
                                            <tr class="middle_hdng_rw">
                                                <th colspan="6" align="center">{{$grade->title}}</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    @empty
                                    No Record Found !
                                    {{-- <table class="table-bordered table-striped table-condensed datatable cf">
                                        <tbody>
                                            <tr>
                                                No Record Found !
                                            </tr>
                                        </tbody>
                                    </table> --}}
                                    @endforelse
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('pageJs')
    <script>
        var isParent = '{{@$isParent}}';
    </script>
    <script src="{{ asset('backend/dist/default/assets/vendors/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{asset('backend/js/common.js')}}"></script>
    <script src="{{asset('newfrontend/js/mock/index.js')}}"></script>
@endsection
