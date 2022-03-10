@extends('admin.layouts.default')
@section('content')

@section('title', trans('formname.user_list'))

<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        @include('admin.includes.flashMessages')
        <div class="m-portlet m-portlet--mobile">

            <div class="m-portlet__body">
                <div class="m-form__content">
                    <h5>{{trans('formname.user_list')}}</h5>
                </div>
                <hr>
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <select class="form-control" name="action" id='action' aria-invalid="false">
                                <option value="">{{trans('formname.action')}}</option>
                                @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('user multiple delete')))
                                <option value="{{config('constant.delete')}}">{{trans('formname.delete')}}</option>
                                @endif
                                @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('user multiple active')))
                                <option value="{{config('constant.active')}}">{{trans('formname.active')}}</option>
                                @endif
                                @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('user multiple inactive')))
                                <option value="{{config('constant.inactive')}}">{{trans('formname.inactive')}}</option>
                                @endif
                            </select>
                            <a href="javascript:;" class="btn btn-primary submit_btn"id='action_submit' data-url="{{route('user_multi_delete')}}" data-table_name="user_table">{{trans('formname.submit')}}</a>
                                <button class="btn btn-info" style='margin:0px 0px 0px 12px' id='clr_filter'
                                data-table_name="user_table">{{trans('formname.clear_filter')}}</button>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="{{Route('user_export')}}"
                                    class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air"
                                    title="Export To Excel">
                                    <span>
                                        <i class="fa fa-file-excel"></i>
                                        <span>{{__('formname.export')}}</span>
                                    </span>
                                </a>
                            </li>
                            @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('user create')))
                            <li class="m-portlet__nav-item">
                                <a href="{{Route('user_create')}}"
                                    class="btn btn-accent m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                    <span>
                                        <i class="la la-plus"></i>
                                        <span>{{trans('formname.new_record')}}</span>
                                    </span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>

                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable" id="user_table">
                    <thead>
                        <tr>
                            <th class="nosort">
                                <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                                    <input type="checkbox" value="" id="user_checkbox" class="m-checkable allCheckbox">
                                    <span></span>
                                </label>
                            </th>
                            <th>{{trans('formname.id')}}</th>
                            <th>{{trans('formname.first_name')}}</th>
                            <th>{{trans('formname.last_name')}}</th>
                            <th>{{trans('formname.email')}}</th>
                            <th>{{trans('formname.status')}}</th>
                            <th>{{trans('formname.action')}}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td></td>
                            <th>{{trans('formname.id')}}</th>
                            <th>{{trans('formname.first_name')}}</th>
                            <th>{{trans('formname.last_name')}}</th>
                            <th>{{trans('formname.email')}}</th>
                              <th>
                                <select  class="form-control form-control-sm tbl-filter-column">
                                    @forelse ($statusList as $key => $item)
                                        <option value="{{$key}}">{{$item}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </th>
                            <td></td>
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
<script>
var user_list_url = "{{ route('user_datatable') }}";
</script>
<script src="{{ asset('backend/js/user/index.js') }}" type="text/javascript"></script>
@stop