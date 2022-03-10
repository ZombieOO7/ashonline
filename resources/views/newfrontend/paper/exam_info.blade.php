@extends('newfrontend.layouts.default')
@section('title', 'Mock Exam')
@section('pageCss')
@endsection
@section('content')
@php
    $user = Auth::guard('student')->user();
    $routeArray = [
    [
		'title' => __('frontend.my_profile'),
		'route' => route('student-profile'),
	],
    [
		'title' => 'My Mocks',
		'route' => route('student-mocks'),
	],
    [
		'title' => @$mockTest->title,
		'route' => route('mock-info',@$mockTest->uuid),
	],
];
@endphp
@include('newfrontend.includes.breadcrumbs',$routeArray)
    <div class="container mrgn_bt_40">
        <div class="row">
            <div class="col-md-12 prfl_ttl">
                @if(@$mockTest->school_id != null)
                <h3>{{@$mockTest->school->school_name}}</h3>
                @endif
            </div>
            <div class="col-md-12">
                <div class="brdr_bbx">
                    <div class="d_bl_bbx purched_details">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="d-md-flex align-items-center">
                                    <a href="#"><img src="{{@$mockTest->image_path }}" class="img-fluid" style="width:150px;height:150px;"></a>
                                    <a href="#">
                                        <p class="mdl_txt"> {{@$mockTest->title}}</p>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <p class="mdl_txt">{{@$mockTest->proper_start_date_and_end_date}}</p>
                            </div>
                            <div class="col-md-2">
                                <p class="mdl_txt">{{@$mockTest->examBoard->title}}</p>
                            </div>
                            <div class="col-md-2">
                                <p class="mdl_txt">{{@$mockTest->total_paper_time}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="inf_bx_wpdng">
                        <h4>{{__('formname.mock_instruction')}}</h4>
                        <div class="unset-list">
                            {!! @$mockTest->description !!}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="inf_bx_wpdng">
                        <div class="rspnsv_table rspnsv_table_scrlb">
                            <table class="table-bordered table-striped table-condensed cf moc_tbl wt_brdrd">
                                <thead class="cf">
                                    <tr>
                                        <th>Paper Name</th>
                                        <th>Time</th>
                                        <th width="30%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($mockTest->papers as $paper)
                                        <tr class="cf">
                                            <td><span class="p-4">{{@$paper->name}}</span></td>
                                            <td><span class="p-4">{{@$paper->time}}</span></td>
                                            @if($paper->testPaper2 != null)
                                                {{-- @if(@$paper->testPaper2->status == 1 || @$paper->testPaper2->status == 3) --}}
                                                    <td>
                                                        <a role="button" class="drk_blue_btn text-white" href="#"> Completed</a>
                                                    </td>
                                                {{-- @else
                                                    <td>
                                                        <a role="button" class="drk_blue_btn text-white disabled" href="#"> Inprogress</a>
                                                    </td>
                                                @endif --}}
                                            @else
                                                <td>
                                                    <span class="p-4">
                                                        <a role="button" class="drk_blue_btn text-white @if($inprgExam > 0) disabled @endif" href="{{ route('mock-paper-info',['uuid'=>@$paper->uuid]) }}">Start</a>
                                                    </span>
                                                </td>
                                            @endif
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-12">
                <form action="" id='m_form_1'>
                    <div class="brdr_bbx brdr_bbx_v2">
                        <h4>Please provide your coﬁrmation for the below points to start your mock exam :</h4>
                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet</p>
                        <ul class="chcklist">
                            <li>
                                <div class="checkbox agreeckbx">
                                    <input type="checkbox" class="dt-checkboxes" id="ckb_1" name="agree">
                                    <label for="ckb_1">I have read all the above Instructions</label>
                                </div>
                            </li>
                            <span class="agreeError"></span>
                        </ul>
                        <a role="button" class="drk_blue_btn" href="{{ route('mock-exam',[@$mockTest->uuid]) }}">Start Now</a>
                    </div>
                </form>
            </div> --}}
        </div>
    </div>
@stop
@section('pageJs')
<script>
    $('#m_form_1').validate({
        rules:{
            agree:{
                required:true
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == 'agree'){
                error.insertAfter('.agreeError');
            }
        }
    })
    $('#m_form_1').on('submit',function(event){
        event.preventDefault();
        if($('#m_form_1').valid()){
            var url = $('.drk_blue_btn').attr('href');
            window.location.href = url;
        }
    })
</script>
@stop