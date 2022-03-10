@extends('admin.layouts.default')
@section('content')
@section('title', __('formname.report-problem.title'))
<style>
    .hid_spn{
        display: none !important;
    }
</style>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- END: Subheader -->
    <div class="m-content">
        @include('admin.includes.flashMessages')
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <div class="m-form__content">
                    <h5>{{__('formname.report-problem.title')}}</h5>
                </div>
                <hr>
                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable for_wdth" id="report_problem_table" data-url="{{ route('report-problem.datatable') }}">
                    <thead>
                        <tr>
                            <th>{{__('formname.report-problem.child_id')}}</th>
                            <th>{{__('formname.report-problem.question')}}</th>
                            <th>{{__('formname.report-problem.description')}}</th>
                            <th>{{__('formname.report-problem.project_type')}}</th>
                            <th>{{__('formname.created_at')}}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                    placeholder="{{__('formname.report-problem.child_id')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                    placeholder="{{__('formname.report-problem.question')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                    placeholder="{{__('formname.report-problem.description')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                    placeholder="{{__('formname.report-problem.project_type')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                    placeholder="{{__('formname.subscribe.subscribed_at')}}"></th>
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
             <h3 class="mdl_ttl"></h3>
             <h3 class="mrgn_tp_20 show_sbjct">
                
             </h2>
             {{-- <h3 class="mdl_ttl">{{ __('formname.description') }}</h3> --}}
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
    var url = "{{ route('report-problem.datatable') }}";
    /** Show description modal */
    $(document).on('click','.shw-dsc',function(e) {
        $(document).find('.show_desc').html($(this).attr('data-description'));
        $(document).find('.show_sbjct').html($(this).attr('data-subject'));
    });
</script>
<script src="{{ asset('backend/js/report-problem/index.js') }}" type="text/javascript"></script>
@stop