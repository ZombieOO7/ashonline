@extends('admin.layouts.default')
@section('content')
@section('inc_css')
<style>
.hide {
    display:none;
}
.star-rtng-dv .default img {
    width: 20px;
}
</style>
@endsection
@section('title', __('formname.test_papers.list'))
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- END: Subheader -->
    <div class="m-content">
        @include('admin.includes.flashMessages')
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">
                <div class="m-form__content">
                    <h5>{{__('formname.test_papers.list')}}</h5>
                </div>
                <hr>
                <div class="m-form__content">
                    <div class="row justify-content-center">
                        <div class="col-md-7">
                        {{ Form::model(@$block, ['route' => ['paper_block_store', @$block->id], 'method' => 'PUT','id'=>'paper_block','class'=>'row align-items-center def-csm-form m-form m-form--fit m-form--label-align-right','files' => true,'autocomplete' => "off"]) }}
                        {{-- <div class="form-group m-form__group row"> --}}
                            {!! Form::label(__('formname.content').'', null,['class'=>'col-form-label
                            col-lg-12
                            col-sm-12']) !!}
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <div class="input-group">
                                    {!!Form::textarea('content',@$block->content,['class'=>'form-control
                                    m-input','id'=>'content','rows'=>2]) !!}
                                </div>
                                <span class="contentError">
                                    @if ($errors->has('content')) <p style="color:red;">
                                        {{ $errors->first('content') }}</p> @endif
                                </span>
                                <span class="m-form__help"></span>
                            </div>
                            {!! Form::hidden('title','Papers',['id'=>'title']) !!}
                            {!! Form::hidden('slug','papers',['id'=>'slug']) !!}
                            {!! Form::hidden('type',config('constant.block_types.papers'),['id'=>'slug']) !!}
                            {!! Form::hidden('id',@$block->id,['id'=>'id']) !!}
                        {{-- </div> --}}
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    {!! Form::submit(__('formname.submit'), ['class' => 'btn btn-success'] )
                                    !!}
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <hr>
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <select class="form-control" name="action" id='action' aria-invalid="false">
                                <option value="">{{__('formname.action')}}</option>
                                @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('paper multiple delete')))
                                <option value="{{config('constant.delete')}}">{{__('formname.delete')}}</option>
                                @endif
                                @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('paper category multiple active')))
                                <option value="{{config('constant.active')}}">{{__('formname.active')}}</option>
                                @endif
                                @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('paper multiple inactive')))
                                <option value="{{config('constant.inactive')}}">{{__('formname.inactive')}}</option>
                                @endif
                            </select>
                            <a href="javascript:;" class="btn btn-primary submit_btn" id='action_submit'
                                data-url="{{route('paper_multi_delete')}}"
                                data-table_name="paper_table" data-module_name="Paper">{{__('formname.submit')}}</a>
                            <button class="btn btn-info" style='margin:0px 0px 0px 12px' id='clr_filter'
                                data-table_name="paper_table">{{__('formname.clear_filter')}}</button>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('paper create')))
                            <li class="m-portlet__nav-item">
                                <a href="{{ route('paper_create')}}"
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
                <table class="table table-striped- table-bordered table-hover table-checkable for_wdth" id="paper_table"
                    data-type="" data-url="{{ route('paper_datatable') }}">
                    <thead>
                        <tr>
                            <th class="nosort">
                                <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                                    <input type="checkbox" value="" id="trade_checkbox" class="m-checkable allCheckbox">
                                    <span></span>
                                </label>
                            </th>
                            <th>{{__('formname.title')}}</th>
                            <th>{{__('formname.test_papers.category')}}</th>
                            <th>{{__('formname.test_papers.stage')}}</th>
                            <th>{{__('formname.test_papers.subject')}}</th>
                            <th>{{__('formname.test_papers.exam_type')}}</th>
                            <th>{{__('formname.test_papers.price')}}</th>
                            <th class="avg_rtng_wdth">{{__('formname.test_papers.avg_review')}}</th>
                            <th>{{__('formname.created_at')}}</th>
                            <th>{{__('formname.status')}}</th>
                            <th>{{__('formname.action')}}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td></td>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                    placeholder="{{__('formname.title')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="{{__('formname.test_papers.category')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="{{__('formname.test_papers.stage')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="{{__('formname.test_papers.subject')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="{{__('formname.test_papers.exam_type')}}"></th>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                    placeholder="{{__('formname.test_papers.price')}}"></th>
                            <td></td>
                            <th><input type="text" class="form-control form-control-sm tbl-filter-column"
                                placeholder="{{__('formname.created_at')}}"></th>
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

<?php /*Load script to footer section*/?>

@section('inc_script')
<script>
var paper_list_url = "{{ route('paper_datatable') }}";
</script>
<script src="{{ asset('backend/js/papers/index.js') }}" type="text/javascript"></script>
<script src="https://cdn.ckeditor.com/4.10.1/standard/ckeditor.js"></script>
<script>
    var fieldurl = '{{route("getColumns")}}';
    var paperId = '{{@$paper->id}}';
    var cartegoryId = '{{@$paper->category_id}}';
</script>
<script>
//deal with copying the ckeditor text into the actual textarea


$("#paper_block").validate({
    rules: {
        content:{
            required: true,
        }
    },
    errorPlacement: function (error, element) {
        if (element.attr("name") == "content")
            error.insertAfter(".contentError");
        else
            error.insertAfter(element);
    },
});
$(document).ready(function(){
    $.fn.raty.defaults.path = base_url + '/public/images';
    $(document).find('.default').raty({readOnly:  true});
});
// CKEDITOR.replace('content');
</script>
@stop