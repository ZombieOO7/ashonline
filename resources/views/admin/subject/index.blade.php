@extends('admin.layouts.default')
@section('content')
@section('title', __('formname.subjects.list'))
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- END: Subheader -->
    <div class="m-content">
        @include('admin.includes.flashMessages')
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <div class="m-form__content">
                    <h5>{{__('formname.subjects.list')}}</h5>
                </div>
                <hr>
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <select class="form-control" name="action" id='action' aria-invalid="false">
                                <option value="">{{__('formname.action')}}</option>
                                @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('subject multiple delete')))
                                <option value="{{config('constant.delete')}}">{{__('formname.delete')}}</option>
                                @endif
                            </select>
                            <a href="javascript:;" class="btn btn-primary submit_btn" id='action_submit'
                                data-url="{{route('subject_multi_delete')}}"
                                data-table_name="subject_table" data-module_name="subject">{{__('formname.submit')}}</a>
                            <button class="btn btn-info" style='margin:0px 0px 0px 12px' id='clr_filter'
                                data-table_name="subject_table">{{__('formname.clear_filter')}}</button>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('subject create')))
                            <li class="m-portlet__nav-item">
                                <a href="{{Route('subject_create')}}"
                                    class="btn btn-accent m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                    <span>
                                        <i class="la la-plus"></i>
                                        <span>{{__('formname.new_record')}}</span>
                                    </span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable for_wdth" id="subject_table"
                    data-type="" data-url="{{ route('subject_datatable') }}">
                    <thead>
                        <tr>
                            <th class="nosort">
                                <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                                    <input type="checkbox" value="" id="trade_checkbox" class="m-checkable allCheckbox">
                                    <span></span>
                                </label>
                            </th>
                            {{-- <th>{{__('formname.subjects.id')}}</th> --}}
                            <th>{{__('formname.subjects.no')}}</th>
                            <th>{{__('formname.subjects.title')}}</th>
                            <th>{{__('formname.created_at')}}</th>
                            <th>{{__('formname.action')}}</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td></td>
                            {{-- <td><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="Id"></td> --}}
                            <td><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="No"></td>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                    placeholder="{{__('formname.subjects.title')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="{{__('formname.created_at')}}"></th>
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
var subject_list_url = "{{ route('subject_datatable') }}";
var site_url = '{{url('/')}}';
</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('backend/js/subject/index.js') }}" type="text/javascript"></script>
@stop