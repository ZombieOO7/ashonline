@extends('admin.layouts.default')
@section('content')
@section('title', __('formname.tution_parent_list'))
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- END: Subheader -->
    <div class="m-content">
        @include('admin.includes.flashMessages')
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <div class="m-form__content">
                    <h5>{{__('formname.tution_parent_list')}}</h5>
                </div>
                <hr>
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
        
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="{{Route('tuition_parent_sync')}}"
                                    class="btn btn-success m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                    <span>
                                        <i class="la la-refresh"></i>
                                        <span>{{__('formname.sync')}}</span>
                                    </span>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="{{Route('tuition_parent_import')}}"
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
                <table class="table table-striped- table-bordered table-hover table-checkable for_wdth" id="tuition_parent_table"
                    data-type="" data-url="{{ route('tuition_parent_datatable') }}">
                    <thead>
                        <tr> 
                            <th>{{__('formname.parent.full_name')}}</th>
                            <th>{{__('formname.parent.email')}}</th>
                            <th>{{__('formname.parent.gender')}}</th>
                            <th>{{__('formname.parent.phone')}}</th>
                            <th>{{__('formname.created_at')}}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            
                            <th>
                                <input type="text" class="form-control form-control-sm tbl-filter-column" placeholder="{{__('formname.parent.full_name')}}">
                            </th>
                            <th>
                                <input type="text" class="form-control form-control-sm tbl-filter-column" placeholder="{{__('formname.parent.email')}}">
                            </th>
                            <th>
                                <input type="text" class="form-control form-control-sm tbl-filter-column" placeholder="{{__('formname.parent.gender')}}">
                            </th>
                            <th>
                                <input type="text" class="form-control form-control-sm tbl-filter-column" placeholder="{{__('formname.parent.phone')}}">
                            </th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="{{__('formname.created_at')}}"></th>    
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
        var url = "{{ route('tuition_parent_datatable') }}";
    </script>
    <script src="{{ asset('backend/js/tuition_parents/index.js') }}" type="text/javascript"></script>
@stop