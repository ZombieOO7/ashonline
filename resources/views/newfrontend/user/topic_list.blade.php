@extends('newfrontend.layouts.default')
@section('title', __('frontend.practice_by_topic'))
@section('content')
    @php
    $parentData = parentData();
    $parent = @$parentData[0];
    $isParent = @$parentData[1];
    @endphp
    <div class="container mrgn_bt_40">
        <div class="row">
            @include('newfrontend.user.leftbar')
            <div class="col-md-9">
                <div class="form_box">
                    <h3>{{ __('frontend.practice_by_topic') }}</h3>
                    <div class="pdng_box">
                        <div class="row">
                            <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                                @if ($isParent == true)
                                    @forelse(@$parent->childs as $key => $child)
                                        <li class="nav-item">
                                            <a class="nav-link e-mck-btn e-mck-btn-child @if (@$studentId==$child->id) active @endif"
                                                href="{{ route('parent.practice-by-topic', ['studentId' => @$child->uuid]) }}">
                                                <span class="pbwa_ic pbwa_ic01"
                                                    style="background: url('{{ @$child->image_thumb }}') !important;background-size: 50px !important;border-radius: 25px;"></span>
                                                {{ @$child->full_name }}
                                            </a>
                                        </li>
                                    @empty
                                @endforelse
                                @endif
                            </ul>
                            @forelse($subjects as $subject)
                                <div class="col-md-12">
                                    <h4 class="tbl_ttl">{{ __('formname.subj_papers', ['subject' => @$subject->title]) }}</h4>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <div class="rspnsv_table rspnsv_table_allinfo">
                                        <table class="table-bordered table-striped table-condensed cf">
                                            <thead class="cf">
                                                <tr>
                                                    <th width="33%">{{ __('frontend.topic_name') }}</th>
                                                    <th width="33%">{{ __('frontend.best_score') }}</th>
                                                    <th width="33%">{{ __('frontend.practice_test') }}</th>
                                                </tr>
                                                <!-- <tr class="middle_hdng_rw"><th colspan="6" align="center">Mock Exams</th></tr> -->
                                            </thead>
                                            <tbody>
                                                @php $i=1; @endphp
                                                @forelse($subject->topicList as $key => $topic)
                                                    @php
                                                    $result = @$topic->studentTestResult($studentId);
                                                    @endphp
                                                    <tr>
                                                        <td width="33%" data-title="{{ __('frontend.topic_name') }}">{{$i}} {{@$topic->title}}</td>
                                                        <td width="33%" data-title="{{ __('frontend.best_score') }}">
                                                            @if(@$result->overall_result != null)
                                                            <img src="{{asset('newfrontend/images/snglstr.png')}}" alt="" width="30px" class="str_img"> 
                                                                {{@$result->overall_result.'/100'}}
                                                            @else
                                                                - 
                                                            @endif
                                                        </td>
                                                        <td width="33%" data-title="{{ __('frontend.practice_test') }}"><a href="{{route('practice-by-topic',['subject'=>@$subjectData->slug,'slug'=>@$topic->slug])}}"
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
                                @empty
                                @endforelse
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('pageJs')
@stop
