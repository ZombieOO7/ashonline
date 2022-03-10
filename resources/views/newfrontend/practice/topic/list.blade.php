@extends('newfrontend.layouts.default')
@section('title', __('frontend.practice'))
@section('content')
@php
$parentData = parentData();
$parent = @$parentData[0];
$isParent = @$parentData[1];
@endphp
@php
    $routeArray = [
    [
		'title' => __('frontend.practice'),
		'route' => route('practice'),
	],
    [
		'title' => __('frontend.practice_by_topic'),
		'route' => route('topic-list',['subject'=>'maths']),
	],
    [
		'title' => @$subjectData->title,
		'route' => route('topic-list',['subject'=>@$subjectData->slug]),
	],
];
@endphp
@include('newfrontend.includes.breadcrumbs',$routeArray)
    <section class="mock_papers">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="df_h3 mdl_tilte mt-1 mb-3">{{@$subjectData->title}}</h3>
                </div>
                <div class="col-md-12">
                    <div class="row justify-content-center">
                        <div class="col-xl-11">
                            <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                                @if($isParent== true)
                                    @forelse(@$parent->childs as $key => $child)
                                        <li class="nav-item">
                                            <a class="nav-link e-mck-btn e-mck-btn-child @if($studentId==$child->id)active @endif" href="{{route('topic-list',['subject'=>$subject,'studentId'=>@$child->uuid])}}">
                                                <span class="pbwa_ic pbwa_ic01" style="background: url('{{@$child->image_thumb}}') !important;background-size: 50px !important;border-radius: 25px;"></span>
                                                {{@$child->full_name}}
                                            </a>
                                        </li>
                                    @empty
                                    @endforelse
                                @endif
                            </ul>
                            <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tab   list">
                                <li class="nav-item">
                                    <a class="nav-link e-mck-btn e-mck-btn-v2 @if(@$subjectData->slug=='maths')active @endif" id="maths-tab"
                                        href="{{route('topic-list',['slug'=>'maths'])}}"  aria-controls="maths" aria-selected="true">
                                        <span class="pbwa_ic pbwa_ic01"></span>
                                        {{__('frontend.maths_lbl')}}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link e-mck-btn e-mck-btn-v2 @if(@$subjectData->slug=='english')active @endif" id="english-t-tab"
                                        href="{{route('topic-list',['slug'=>'english'])}}"  aria-controls="english-t" aria-selected="false">
                                        <span class="pbwa_ic pbwa_ic02"></span>
                                        {{__('frontend.english_lbl')}}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link e-mck-btn e-mck-btn-v2 @if(@$subjectData->slug=='vr') active @endif" id="verbal-t-tab"
                                        href="{{route('topic-list',['slug'=>'vr'])}}"  aria-controls="verbal-t" aria-selected="false">
                                        <span class="pbwa_ic pbwa_ic03"></span>
                                        {{__('frontend.verbal_lbl')}}
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content  mt-5 mb-5" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="maths" role="tabpanel"
                                    aria-labelledby="maths-tab">

                                    <div class="rspnsv_table rspnsv_table_allinfo">
                                        <table
                                            class="table-bordered table-striped table-condensed cf v-align-bottom sm_txt_tbl">
                                            <thead class="cf">
                                                <tr>
                                                    <th class="wt_80_p">{{ __('frontend.topic_name') }}</th>
                                                    <th>{{ __('frontend.best_score') }}</th>
                                                    <th>{{ __('frontend.practice_test') }}</th>
                                                </tr>
                                                <!-- <tr class="middle_hdng_rw"><th colspan="6" align="center">Mock Exams</th></tr> -->
                                            </thead>
                                            <tbody>
                                                @php $i=1; @endphp
                                                @forelse($topicList as $key => $topic)
                                                    <tr>
                                                        <td data-title="{{ __('frontend.topic_name') }}">{{$i}} {{@$topic->title}}</td>
                                                        <td data-title="{{ __('frontend.best_score') }}">
                                                            {{-- {!! @$topic->result !!} --}}
                                                            @if(@$topic->result != null)
                                                            <img src="{{asset('newfrontend/images/snglstr.png')}}" alt="" width="30px" class="str_img"> 
                                                                {{@$topic->result->obtained_marks.'/'.@$topic->result->total_marks}}
                                                            @endif
                                                        </td>
                                                        <td data-title="{{ __('frontend.practice_test') }}"><a href="{{route('practice-by-topic',['uuid'=>@$topic->uuid])}}"
                                                            class="add_to_cart btn_flwr @if($isParent== true)unread_tr @endif">{{__('frontend.start')}}</a></td>
                                                    </tr>
                                                @php $i++; @endphp
                                                @empty
                                                <tr>
                                                    <td colspan="3">{{__('frontend.record_not_found')}}</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
        var base_url = "{{ url('/') }}";
        $(function() {
            $(document).find('.fixedStar_readonly').raty({
                readOnly: true,
                path: base_url + '/public/frontend/images',
                starOff: 'star-off.svg',
                starOn: 'star-on.svg',
                start: $(document).find(this).attr('data-score')
            });
        });

    </script>
@endsection
