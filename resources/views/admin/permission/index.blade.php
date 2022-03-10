@extends('admin.layouts.default')
@section('content')

@section('title', __('formname.permissions_list'))

<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        @include('admin.includes.flashMessages')
        <div class="m-portlet m-portlet--mobile">

            <div class="m-portlet__body">
                <div class="m-form__content">
                    <h5>{{__('formname.permissions_list')}}</h5>
                </div>
                <hr>
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <select class="form-control" name="action" id='action' aria-invalid="false">
                                <option value="">{{__('formname.action')}}</option>
                                @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('permission multiple delete')))
                                <option value="delete">{{__('formname.delete')}}</option>
                                @endif
                            </select>
                            <a href="javascript:;" class="btn btn-primary submit_btn"id='action_submit' data-url="{{route('permission_multi_delete')}}" data-table_name="permission_table">{{__('formname.submit')}}</a>
                                 <button class="btn btn-info" style='margin:0px 0px 0px 12px' id='clr_filter'
                                data-table_name="permission_table">{{__('formname.clear_filter')}}</button>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
<<<<<<< HEAD
                            @if((\Auth::guard('admin')->user()->can('permission create')))
=======
                            @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('permission create')))
>>>>>>> M1
                            <li class="m-portlet__nav-item">
                                <a href="{{Route('permission_create')}}"
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
                <table class="table table-striped- table-bordered table-hover table-checkable" id="permission_table">
                    <thead>
                        <tr>
                            <th class="nosort">
                                <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                                    <input type="checkbox" value="" id="permission_checkbox" class="m-checkable allCheckbox">
                                    <span></span>
                                </label>
                            </th>
                            <th>{{__('formname.id')}}</th>
                            <th>{{__('formname.permissions')}}</th>
                            <th>{{__('formname.action')}}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td></td>
                            <th>{{__('formname.id')}}</th>
                            <th>{{__('formname.permissions')}}</th>
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
var permission_list_url = "{{ route('permission_datatable') }}";
</script>
<script src="{{ asset('backend/js/permission/index.js') }}" type="text/javascript"></script>
@stop