@extends('newfrontend.layouts.default')
@section('title',__('frontend.parentAddress.label'))
@section('content')
<!--inner content-->
<div class="container mrgn_bt_40">
    <div class="row">
        @include('newfrontend.user.leftbar')
        <div class="col-md-9">
            <div class="form_box">
                <h3>{{__('frontend.parentAddress.label')}}</h3>
                <div class="row">
                    <div class="col-md-12">
                        @forelse (@$addresses as $value)
                                <div class="defult_blng_adress">
                                    <a href="#" class="default_btn"> @if(@$value->default == 1) {{__('frontend.parentAddress.default')}} @endif </a>
                                    <p>{{(isset($value->address)&&$value->address!=null)?$value->address.', ':''}}
                                        {{(isset($value->address2)&&$value->address2!=null)?$value->address2.', ':'' }}<br>
                                        {{(isset($value->city)&&$value->city!=null)?$value->city.', ':''}}
                                        {{(isset($value->state)&&$value->state!=null)?$value->state.'-':''}}
                                        {{(isset($value->postal_code)&&$value->postal_code!=null)?$value->postal_code:''}}</p>
                                    <a href="{{route('edit-address',['uuid'=>@$value->uuid])}}" class="" id="">
                                        {{__('frontend.edit_lbl')}}
                                    </a>
                                    <a href="javascript:void(0)" class="text-danger delete" data-url="{{route('delete-address',['id'=>$value->uuid])}}">
                                        {{__('frontend.delete_lbl')}}
                                    </a>
                                </div>
                        @empty
                            <div class="col-sm-6 col-lg-3 mb-4">
                                {{__('frontend.record_not_found')}}
                            </div>
                        @endforelse
                        <a href="{{route('create-address')}}" class="" id="">{{__('frontend.parentAddress.add')}}</a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade def_modal lgn_modal" id="deleteAddress" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                    <h3>{{__('frontend.sure')}}</h3>
                    <p class="mrgn_bt_40">{{__('frontend.delete_warning')}}</p>
                    <a role="button" class="btn submit_btn d_inline" data-url="" id='deleteLink'>{{__('frontend.delete_lbl')}}
                        <div class="lds-ring" style="display:none;">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </a>
                    <button type="button" class="btn gr_btn d_inline" data-dismiss="modal">{{__('frontend.cancel')}}</button>
            </div>

        </div>
    </div>
</div>
<!--close inner content-->
@stop
@section('pageJs')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{asset('newfrontend/js/parent/address.js')}}"></script>
@stop