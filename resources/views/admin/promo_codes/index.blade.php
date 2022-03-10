@extends('admin.layouts.default')
@section('content')
@section('title', __('formname.promo_codes.list'))
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- END: Subheader -->
    <div class="m-content">
        @include('admin.includes.flashMessages')
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <div class="m-form__content">
                    <h5>{{__('formname.promo_codes.list')}}</h5>
                </div>
                <hr>
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <button class="btn btn-info" style='margin:0px 0px 0px 0' id='clr_filter'
                                data-table_name="stage_table">{{__('formname.clear_filter')}}</button>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('subject create')))
                            <li class="m-portlet__nav-item">
                                <a href="{{Route('promo_code_create')}}"
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
                <table class="table table-striped- table-bordered table-hover table-checkable for_wdth" id="promo_code_table"
                    data-type="" data-url="{{ route('promo_code_datatable') }}">
                    <thead>
                        <tr>
                            <th>{{__('formname.promo_codes.code')}}</th>
                            <th>{{__('formname.promo_codes.amount_1')}}</th>
                            <th>{{__('formname.promo_codes.discount_1')}}</th>
                            <th>{{__('formname.promo_codes.amount_2')}}</th>
                            <th>{{__('formname.promo_codes.discount_2')}}</th>
                            <th>{{__('formname.promo_codes.start_date')}}</th>
                            <th>{{__('formname.promo_codes.end_date')}}</th>
                            <th>{{__('formname.created_at')}}</th>
                            <th>{{__('formname.status')}}</th>
                            <th>{{__('formname.action')}}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="Code"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="Amount 1"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="Discount 1"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="Amount 2"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="Discount 2"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="Start Date"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="End Date"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="Created At"></th>
                            <th class="slct-wdth">
                                <select class="statusFilter form-control form-control-sm tbl-filter-column">
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
@section('inc_script')
<script>
var url = "{{ route('promo_code_datatable') }}";
</script>
<script src="{{ asset('backend/js/promo_codes/index.js') }}" type="text/javascript"></script>
@stop
