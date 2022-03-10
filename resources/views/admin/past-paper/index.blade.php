@extends('admin.layouts.default')
@section('content')
@section('title', __('formname.past-paper.label'))
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- END: Subheader -->
    <div class="m-content">
        @include('admin.includes.flashMessages')
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <div class="m-form__content">
                    <h5>{{__('formname.past-paper.list')}}</h5>
                </div>
                <hr>
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <select class="form-control" name="action" id='action' aria-invalid="false">
                                <option value="">{{__('formname.action')}}</option>
                                @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('past paper delete')))
                                <option value="{{config('constant.delete')}}">{{__('formname.delete')}}</option>
                                @endif
                                @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('past paper active')))
                                <option value="{{config('constant.active')}}">{{__('formname.active')}}</option>
                                @endif
                                @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('past paper inactive')))
                                <option value="{{config('constant.inactive')}}">{{__('formname.inactive')}}</option>
                                @endif
                            </select>
                            <a href="javascript:;" class="btn btn-primary submit_btn" id='action_submit'
                                data-url="{{route('past-paper.multi_delete')}}"
                                data-table_name="past_paper_table" data-module_name="Past Paper">{{__('formname.submit')}}</a>
                            <button class="btn btn-info" style='margin:0px 0px 0px 12px' id='clr_filter'
                                data-table_name="past_paper_table">{{__('formname.clear_filter')}}</button>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            {{-- @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('subject create'))) --}}
                            <li class="m-portlet__nav-item">
                                <a href="{{Route('past-paper.create')}}"
                                    class="btn btn-accent m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                    <span>
                                        <i class="la la-plus"></i>
                                        <span>{{__('formname.new_record')}}</span>
                                    </span>
                                </a>
                            </li>
                            {{-- @endif --}}
                        </ul>
                    </div>
                </div>
                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable for_wdth" id="past_paper_table"
                    data-type="" data-url="{{ route('past-paper.datatable') }}">
                    <thead>
                        <tr>
                            <th class="nosort">
                                <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                                    <input type="checkbox" value="" id="trade_checkbox" class="m-checkable allCheckbox">
                                    <span></span>
                                </label>
                            </th>
                            <th>{{__('formname.past-paper.name')}}</th>
                            <th>{{__('formname.subject')}}</th>
                            <th>{{__('formname.school_year')}}</th>
                            <th>{{__('formname.month')}}</th>
                            <th>{{__('formname.year')}}</th>
                            <th>{{__('formname.created_at')}}</th>
                            <th>{{__('formname.status')}}</th>
                            <th>{{__('formname.action')}}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td></td>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                    placeholder="{{__('formname.past-paper.name')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                    placeholder="{{__('formname.subject')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                    placeholder="{{__('formname.school_year')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                    placeholder="{{__('formname.month')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                    placeholder="{{__('formname.year')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="{{__('formname.created_at')}}"></th>
                            <th class="slct-wdth">
                                <select class="statusFilter form-control form-control-sm tbl-filter-column">
                                    @forelse (@$statusList as $key => $item)
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
var url = "{{ route('past-paper.datatable') }}";
</script>
<script src="{{ asset('backend/js/past-paper/index.js') }}" type="text/javascript"></script>
@stop