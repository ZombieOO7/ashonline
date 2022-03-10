
@extends('admin.layouts.default')
@section('content')
@section('title', __('formname.image_name.list'))
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- END: Subheader -->
    <div class="m-content">
        @include('admin.includes.flashMessages')
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <div class="m-form__content">
                    <h5>{{__('formname.image_name.list')}}</h5>
                </div>
                <hr>
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <select class="form-control" name="action" id='action' aria-invalid="false">
                                <option value="">{{__('formname.action_option')}}</option>
                                <option value="{{config('constant.delete')}}">{{__('formname.delete')}}</option>
                            </select>&nbsp;&nbsp;&nbsp;
                        <a href="javascript:;" style="margin-right: 16px"  class="btn btn-primary" id='action_submit'
                           data-url="{{route('image_multi_delete')}}"
                                data-table_name="image_table" data-module_name="Image">{{__('formname.submit')}}</a>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('subject create')))
                                <li class="m-portlet__nav-item">
                                    <a href="{{Route('image_create')}}"
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
                <table class="table table-striped- table-bordered table-hover table-checkable for_wdth"
                        data-url="{{ route('Image_datatable') }}" id="image_table">
                    <thead>
                    <tr>
                        <th class="nosort">
                            <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                                <input type="checkbox" value="" id="trade_checkbox" class="m-checkable allCheckbox">
                                <span></span>
                            </label>
                        </th>
                        <th>{{__('formname.image_name.path')}}</th>
                        <th>{{__('formname.action')}}</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
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
{{--    <script>--}}
{{--        var url = "{{ route('Image_datatable') }}";--}}
{{--    </script>--}}
    <script src="{{ asset('backend/js/Image/index.js') }}" type="text/javascript"></script>
@stop



