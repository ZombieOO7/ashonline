@extends('admin.layouts.default')
@section('content')
@section('title', __('formname.parent_list'))
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- END: Subheader -->
    <div class="m-content">
        @include('admin.includes.flashMessages')
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <div class="m-form__content">
                    <h5>{{__('formname.parent_list')}}</h5>
                </div>
                <hr>
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <div class="m-portlet__head-title">
                                <select class="form-control" name="action" id='action' aria-invalid="false">
                                    <option value="">{{trans('users.action')}}</option>
                                    <option value="{{config('constant.delete')}}">{{trans('users.delete')}}</option>
                                    <option value="{{config('constant.active')}}">{{trans('users.active')}}</option>
                                    <option value="{{config('constant.inactive')}}">{{trans('users.inactive')}}</option>
                                </select>
                                <a href="javascript:;" class="btn btn-primary" style='margin:0px 0px 0px 12px' id='action_submit' data-url="{{route('bulk_action')}}" data-table_name="parent_table" data-module_name="Parent">{{trans('users.submit')}}</a>
                                <button class="btn btn-info" style='margin:0px 0px 0px 12px' id='clr_filter' data-table_name="parent_table">@lang('general.clear_filter')</button>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="{{ route('parent_create')}}"
                                    class="btn btn-accent m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                    <span>
                                        <i class="la la-plus"></i>
                                        <span>{{__('formname.new_record')}}</span>
                                    </span>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="{{Route('parent_import')}}"
                                    class="btn btn-info m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                    <span>
                                        <i class="la la-plus"></i>
                                        <span>{{__('formname.import_record')}}</span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable for_wdth" id="parent_table"
                    data-type="" data-url="{{ route('parent_datatable') }}">
                    <thead>
                        <tr>
                            <th class="nosort">
                                <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                                    <input type="checkbox" value="" id="user_checkbox" class="m-checkable allCheckbox">
                                    <span></span>
                                </label>
                            </th>
                            <th>{{__('formname.parent.full_name')}}</th>
                            <th>{{__('formname.parent.email')}}</th>
                            {{-- <th>{{__('formname.parent.gender')}}</th> --}}
                            <th>{{__('formname.parent.is_tution_parent')}}</th>
                            <th>{{__('formname.created_at')}}</th>
                            <th>{{__('formname.status')}}</th>
                            <th>{{__('formname.action')}}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>
                                <input type="text" class="form-control form-control-sm tbl-filter-column" placeholder="{{__('formname.parent.full_name')}}">
                            </th>
                            <th>
                                <input type="text" class="form-control form-control-sm tbl-filter-column" placeholder="{{__('formname.parent.email')}}">
                            </th>
                            {{-- <th>
                                <input type="text" class="form-control form-control-sm tbl-filter-column" placeholder="{{__('formname.parent.gender')}}">
                            </th> --}}
                            <th class="slct-wdth">
                                <select class="isTuitionParentFilter form-control form-control-sm tbl-filter-column">
                                    <option value="">Select</option>
                                    <option value={{config('constant.yes')}}>{{__('Yes')}}</option>
                                <option value={{config('constant.no')}}>{{__('No')}}</option>
                                </select>
                            </th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="{{__('formname.created_at')}}"></th>
                            <th class="slct-wdth">
                                <select class="statusFilter form-control form-control-sm tbl-filter-column">
                                    @forelse (properStatusList2() as $key => $item)
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
@section('inc_script')
    <script>
        var url = "{{ route('parent_datatable') }}";
    </script>
    <script src="{{ asset('backend/js/parents/index.js') }}" type="text/javascript"></script>
@stop
