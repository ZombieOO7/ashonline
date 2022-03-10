@extends('admin.layouts.default')
@php
$resType = ($type == 'blog') ? 'Blog' : 'Resource';
if($resType == 'Blog'){
    $title = __('admin/resorces.lists_title', ['type' => $resType]);
}
@endphp
@section('title', @$title)

@section('content')

<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        @include('admin.includes.flashMessages')
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">{{ @$title }}</h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                </div>
            </div>
            <div class="m-portlet__body width_big">
                <div class="m-form__content">
                    @if($type != 'emock-blog')
                    <form id="category_form" action="{{ route('resources/category/update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <div class="row">
                                    <input type="hidden" name="uuid" value="{{ @$category->uuid }}" >
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ __('admin/resorces.title').'*' }}</label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name', @$category->name) }}" maxlength="{{ config('constant.input_title_max_length') }}">
                                            @error('name') <p class="errors">{{ $errors->first('name') }} </p> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ __('admin/resorces.content').'*' }}</label>
                                            <textarea class="form-control" name="content" maxlength="{{ config('constant.input_desc_max_length') }}">{{ old('content', @$category->content) }}</textarea>
                                            @error('content') <p class="errors">{{ $errors->first('content') }} </p> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label></label>
                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    @endif
                    <div class="m-portlet__head" style="@if($type != 'emock-blog') border-top: 1px solid #ebedf2;@endif">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <select class="form-control" name="action" id='action' aria-invalid="false">
                                    <option value="">{{__('admin/table.action')}}</option>
                                    <option value="Delete">{{ __('admin/table.delete') }}</option>
                                    {{-- <option value="active">{{ __('admin/table.active') }}</option> --}}
                                    {{-- <option value="inactive">{{ __('admin/table.inactive') }}</option> --}}
                                </select>
                                <a href="javascript:;" class="btn btn-primary" style='margin:0px 0px 0px 12px' id='action_submit' data-url="{{ route('resources/bulk/action') }}" data-table_name="resources_table" data-module_name="{{ @$resType }}">Submit</a>
                                <button class="btn btn-info" style='margin:0px 0px 0px 12px' id='clr_filter_data'>{{ __('admin/table.clear_filter') }}</button>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="{{route('resources.create', $type)}}"
                                        class="btn btn-accent m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                        <span>
                                            <i class="la la-plus"></i>
                                            <span>{{__('formname.new_record')}}</span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--begin: Datatable -->
                <table class="table table-striped table-bordered table-hover table-checkable" id="resources_table" data-type="{{ $type }}">
                    <thead>
                        <tr>
                            <th class="nosort non-searchable">
                                <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                                    <input type="checkbox" value="" id="user_checkbox" class="m-checkable allCheckbox">
                                    <span></span>
                                </label>
                            </th>
                            <th>{{ __('admin/table.title') }}</th>
                            <th>{{ __('admin/table.question') }}</th>
                            <th>{{ __('admin/table.answer') }}</th>
                            <th>{{ __('admin/table.created_at') }}</th>
                            <th>{{__('admin/table.action')}}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column" placeholder="{{ __('admin/table.title') }}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column" placeholder="{{ __('admin/table.question') }}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column" placeholder="{{ __('admin/table.answer') }}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column" placeholder="{{ __('admin/table.created_at') }}"></th>
                            <th></th>
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
    $('#clr_filter_data').on('click',function(){
        $('#resources_table').find('input:text, input:password, select')
        .each(function () {
            $(this).val('');
        });
        var columns = $('#resources_table').DataTable().columns();
        columns.every(function(i) {
            var column = this;
            column.search('');
            // column.search('').draw();
        });
        $('#resources_table').DataTable().clear().draw();
        $('#action').val('');
    });
</script>
<script src="{{ asset('backend/js/resources/index.js') }}" type="text/javascript"></script>
@stop
