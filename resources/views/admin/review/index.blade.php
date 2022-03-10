@extends('admin.layouts.default')
@section('content')
@section('inc_css')
<style>
    .star-rtng-dv .default img {
        width: 20px;
    }
</style>
@endsection
@section('title', __('formname.review.list'))
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- END: Subheader -->
    <div class="m-content">
        @include('admin.includes.flashMessages')
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <div class="m-form__content">
                    <h5>{{__('formname.review.list')}}</h5>
                </div>
                <hr>
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <select class="form-control" name="action" id='action' aria-invalid="false">
                                <option value="">{{__('formname.action')}}</option>
                                {{-- @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('review multiple delete')))
                                <option value="{{config('constant.delete')}}">{{__('formname.delete')}}</option>
                                @endif --}}
                                @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('review multiple active')))
                                <option value="{{config('constant.review_active')}}">{{__('formname.review.publish')}}
                                </option>
                                @endif
                                @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('review multiple inactive')))
                                <option value="{{config('constant.review_inactive')}}">
                                    {{__('formname.review.unpublish')}}</option>
                                @endif
                            </select>
                            <a href="javascript:;" class="btn btn-primary submit_btn" id='action_submit'
                                data-url="{{route('review_multi_delete')}}"
                                data-table_name="review_table" data-module_name="Review">{{__('formname.submit')}}</a>
                            <button class="btn btn-info" style='margin:0px 0px 0px 12px' id='clr_filter'
                                data-table_name="review_table">{{__('formname.clear_filter')}}</button>
                        </div>
                    </div>
            </div>
            <table class="table table-striped- table-bordered table-hover table-checkable for_wdth" id="review_table"
                data-type="" data-url="{{ route('review_datatable') }}">
                <thead>
                    <tr>
                        <th class="nosort">
                            <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                                <input type="checkbox" value="" id="trade_checkbox" class="m-checkable allCheckbox">
                                <span></span>
                            </label>
                        </th>
                        <th>{{__('formname.review.paper')}}</th>
                        <th>{{__('formname.mock_test_id')}}</th>
                        <th>{{__('formname.review.email')}}</th>
                        <th style="padding-right:80px;">{{__('formname.review.rate')}}</th>
                        <th>{{__('formname.review.description')}}</th>
                        <th>{{__('formname.created_at')}}</th>
                        <th>{{__('formname.status')}}</th>
                        <th>{{__('formname.action')}}</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td></td>
                        <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="{{__('formname.review.paper')}}"></th>
                        <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                            placeholder="{{__('formname.mock_test_id')}}"></th>
                        <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="{{__('formname.review.email')}}"></th>
                        <th></th>
                        <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="{{__('formname.review.description')}}"></th>
                        <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="Created At"></th>
                        <th class="slct-wdth">
                            <select class="statusFilter form-control form-control-sm tbl-filter-column">
                                @forelse (@$reviewStatusList as $key => $item)
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
<!-- Show Description Modal -->
<div class="modal fade def_mod dtails_mdl" id="DescModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content ">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <h3 class="mdl_ttl">{{__('formname.review.description')}}</h3>
                <p class="mrgn_tp_20 show_desc">

                </p>
                <button type="button" class="btn btn-success pull-right" data-dismiss="modal">{{__('formname.close')}}</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('inc_script')
<script>
var url = "{{ route('review_datatable') }}";
</script>
<script src="{{ asset('backend/js/review/index.js') }}" type="text/javascript"></script>
@stop