@extends('admin.layouts.default')
@section('content')

@section('title',  __('general.school.school'))

<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        @include('admin.includes.flashMessages')
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">{{ __('general.school.school')}}</h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                </div>
            </div>
            <div class="m-portlet__body width_big">
                <div class="m-form__content">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <select class="form-control" name="action" id='action' aria-invalid="false">
                                    <option value="">{{trans('users.action')}}</option>
                                    <option value="{{config('constant.delete')}}">{{trans('users.delete')}}</option>
                                    <option value="{{config('constant.active')}}">{{trans('users.active')}}</option>
                                    <option value="{{config('constant.inactive')}}">{{trans('users.inactive')}}</option>
                                </select>
                                <a href="javascript:;" class="btn btn-primary" style='margin:0px 0px 0px 12px' id='action_submit' data-url="{{route('schools/bulk/action')}}" data-table_name="schools_table" data-module_name="School">{{trans('users.submit')}}</a>
                                <button class="btn btn-info" style='margin:0px 0px 0px 12px' id='clr_filter'>@lang('general.clear_filter')</button>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="{{Route('schools.create')}}"
                                        class="btn btn-accent m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                        <span>
                                            <i class="la la-plus"></i>
                                            <span>{{trans('New Record')}}</span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable" id="schools_table" data-url="{{ route('admin/schools/datatable') }}">
                    <thead>
                        <tr>
                            <th class="nosort">
                                <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                                    <input type="checkbox" value="" id="user_checkbox" class="m-checkable allCheckbox">
                                    <span></span>
                                </label>
                            </th>
                            <th>{{trans('users.school_name')}}</th>
                            <th>{{trans('users.exam_board')}}</th>
                            <th>{{__('formname.status')}}</th>
                            <th>{{__('formname.created_at')}}</th>
                            <th>{{trans('users.action')}}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column" placeholder="{{trans('users.school_name')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column" placeholder="{{trans('users.exam_board')}}"></th>
                            <th><select class="statusFilter form-control form-control-sm tbl-filter-column">
                                @forelse (properStatusList() as $key => $item)
                                    <option value="{{$key}}">{{$item}}</option>
                                @empty
                                @endforelse
                            </select>
                            </th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column" placeholder="{{__('formname.created_at')}}"></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>

@stop

<?php /*Load script to footer section*/?>

@section('inc_script')
<script src="{{ asset('backend/js/schools/index.js') }}" type="text/javascript"></script>
@stop
