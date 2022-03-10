@extends('admin.layouts.default')
@section('content')
@section('title', __('formname.result-grade.label'))
@php
$percentage = percentages();
@endphp
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- END: Subheader -->
    <div class="m-content">
        @include('admin.includes.flashMessages')
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <div class="m-form__content">
                    <h5>{{__('formname.result_type')}}</h5>
                </div>
                <!--begin: Datatable -->
                <form id='resultGrade'>
                    <table class="table m-table--head-bg-primary table-bordered table-hover table-checkable for_wdth">
                        <thead>
                            <tr>
                                <th colspan="3">{{__('formname.good_or_excellent')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="d-flex">
                                <td class="col-md-2">{{__('formname.excellent')}}</td>
                                <td class="col-md-2">
                                    {!! Form::select('excellent_min', $percentage, @$resultGrade->excellent_min ?? config('constant.excellent_min'),
                                    ['class' => 'form-control resultType', 'id'=>'excellent_min' ]) !!}
                                </td>
                                <td class="col-md-2">
                                    {!! Form::select('excellent_max', $percentage, @$resultGrade->excellent_max ?? config('constant.excellent_max'),
                                    ['class' => 'form-control resultType', 'id'=>'excellent_max' ]) !!}
                                </td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-md-2">{{__('formname.very_good')}}</td>
                                <td class="col-md-2">
                                    {!! Form::select('very_good_min', $percentage, @$resultGrade->very_good_min ?? config('constant.very_good_min'),
                                    ['class' => 'form-control resultType', 'id'=>'very_good_min' ]) !!}
                                </td>
                                <td class="col-md-2">
                                    {!! Form::select('very_good_max', $percentage, @$resultGrade->very_good_max ?? config('constant.very_good_max'),
                                    ['class' =>'form-control resultType', 'id'=>'very_good_max' ]) !!}
                                </td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-md-2">{{__('formname.good')}}</td>
                                <td class="col-md-2">
                                    {!! Form::select('good_min', $percentage, @$resultGrade->good_min ?? config('constant.good_min'),
                                    ['class' => 'form-control resultType', 'id'=>'good_min' ]) !!}
                                </td>
                                <td class="col-md-2">
                                    {!! Form::select('good_max', $percentage, @$resultGrade->good_max ?? config('constant.good_max'),
                                    ['class' => 'form-control resultType', 'id'=>'good_max' ]) !!}
                                </td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-md-2">{{__('formname.fair')}}</td>
                                <td class="col-md-2">
                                    {!! Form::select('fair_min', $percentage, @$resultGrade->fair_min ?? config('constant.fair_min'),
                                    ['class' => 'form-control resultType', 'id'=>'fair_min' ]) !!}
                                </td>
                                <td class="col-md-2">
                                    {!! Form::select('fair_max', $percentage, @$resultGrade->fair_max ?? config('constant.fair_max'),
                                    ['class' => 'form-control resultType', 'id'=>'fair_max' ]) !!}
                                </td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-md-2">{{__('formname.need_improvement')}}</td>
                                <td class="col-md-2">
                                    {!! Form::select('improve_min', $percentage, @$resultGrade->improve_min ?? config('constant.improve_min'),
                                    ['class' => 'form-control resultType', 'id'=>'improve_min' ]) !!}
                                </td>
                                <td class="col-md-2">
                                    {!! Form::select('improve_max', $percentage, @$resultGrade->improve_max ?? config('constant.improve_max'),
                                    ['class' => 'form-control resultType', 'id'=>'improve_max' ]) !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                    <input type="hidden" name="id" value="{{@$resultGrade->uuid}}" id="id">
                </form>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
@stop
@section('inc_script')
<script>
    var storeGradeUrl = "{{route('result-grade.store')}}";
</script>
<script src="{{ asset('backend/js/result-grade/index.js') }}" type="text/javascript"></script>
@stop