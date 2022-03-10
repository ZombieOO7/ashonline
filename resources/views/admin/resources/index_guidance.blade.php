@extends('admin.layouts.default')

@php
$resType = ($type == 'blog' || $type == 'emock-blog') ? 'Blog' : 'Resource';
$title = __('admin/resorces.lists_title', ['type' => @$resType]);
@endphp
@section('title', $title)

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
                    @if($category->slug == 'guidance')
                    <form id="category_form" action="{{ route('resources/category/update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
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
                                            <input type="submit" class="btn btn-success" value="Submit">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    @endif
                    <div class="m-portlet__head" @if($type != "blog") style="border-top: 1px solid #ebedf2;" @endif>
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <select class="form-control" name="action" id='action' aria-invalid="false">
                                    <option value="">{{__('admin/table.action')}}</option>
                                    <option value="{{config('constant.delete')}}">{{ __('admin/table.delete') }}</option>
                                    <option value="{{config('constant.active')}}">{{ __('admin/table.active') }}</option>
                                    <option value="{{config('constant.inactive')}}">{{ __('admin/table.inactive') }}</option>
                                </select>
                                <a href="javascript:;" class="btn btn-primary" style='margin:0px 0px 0px 12px' id='action_submit' data-url="{{ route('resources/guidance/bulk/action', @$category->slug) }}" data-table_name="resources_table" data-module_name="{{ @$resType }}">Submit</a>
                                <button class="btn btn-info" style='margin:0px 0px 0px 12px' id='clr_filter'>{{ __('admin/table.clear_filter') }}</button>
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
                <table class="table table-striped table-bordered table-hover table-checkable" id="resources_table" data-type="{{ @$type }}">
                    <thead>
                        <tr>
                            <th class="nosort non-searchable">
                                <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                                    <input type="checkbox" value="" id="user_checkbox" class="m-checkable allCheckbox">
                                    <span></span>
                                </label>
                            </th>
                            @if($resType == 'Blog')
                            {{-- <th>{{__('formname.subjects.id')}}</th> --}}
                            <th>{{__('formname.subjects.no')}}</th>
                            @endif
                            <th>{{ __('admin/table.title') }}</th>
                            <th>{{ __('admin/table.slug') }}</th>
                            @if($type == 'emock-blog')
                                <th>{{ __('admin/table.grade_id') }}</th>
                            @else
                                <th>{{ __('admin/table.category') }}</th>
                            @endif
                            <th>{{ __('admin/table.featured_img') }}</th>
                            <th>{{ __('admin/table.created_at') }}</th>
                            <th>{{ __('admin/table.status') }}</th>
                            <th>{{ __('admin/table.action') }}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            @if($resType == 'Blog')
                            {{-- <td><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="Id"></td> --}}
                            <td><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="No"></td>
                            @endif
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column" placeholder="{{ __('admin/table.title') }}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column" placeholder="{{ __('admin/table.slug') }}"></th>
                            @if($type == 'emock-blog')
                                <th><input type="text" class="form-control form-control-sm tbl-filter-column" placeholder="{{ __('admin/table.grade_id') }}"></th>
                            @else
                                <th><input type="text" class="form-control form-control-sm tbl-filter-column" placeholder="{{ __('admin/table.category') }}"></th>
                            @endif
                            <th></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column" placeholder="{{ __('admin/table.created_at') }}"></th>
                            <th class="slct-wdth">
                                <select class="statusFilter form-control form-control-sm tbl-filter-column">
                                    @forelse (statusList() as $key => $item)
                                    <option value="{{$key}}">{{$item}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </th>
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
    var site_url = '{{url('/')}}';
</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@if($resType == 'Blog')
    <script src="{{ asset('backend/js/resources/index_blog.js') }}" type="text/javascript"></script>
@else 
    <script src="{{ asset('backend/js/resources/index_guidance.js') }}" type="text/javascript"></script>
@endif
@stop
