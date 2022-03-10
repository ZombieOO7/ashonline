@extends('admin.layouts.default')
@section('inc_css')
@section('content')
@section('title', __('formname.orders.detail'))
<div class="m-grid__item m-grid__item--fluid m-wrapper">
   <div class="m-content">
      <div class="row">
         <div class="col-lg-12">
            @include('admin.includes.flashMessages')
            <!--begin::Portlet-->
            <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile"
               id="main_portlet">
               <div class="m-portlet__head">
                  <div class="m-portlet__head-wrapper">
                     <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                           <h3 class="m-portlet__head-text">
                              {{ __('formname.orders.detail') }}
                           </h3>
                        </div>
                     </div>
                     <div class="m-portlet__head-tools">
                        <a href="{{route('order_index')}}"
                           class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                        <span>
                        <i class="la la-arrow-left"></i>
                        <span>{{ __("formname.back") }}</span>
                        </span>
                        </a>
                     </div>
                  </div>
               </div>
               <div class="m-portlet__body">

                  <!-- ORDER NUMBER & ORDER STATUS -->
                  @include('admin.orders.details.order_header')
                     
                  <!-- BILLING, SHIPPING & PAYMENT INFORMATION -->
                  @include('admin.orders.details.billing_info')   

                  <!-- ORDERED ITEMS LIST -->
                  @include('admin.orders.details.item_list')
                     
                  <!-- SUB TOTAL, SHIPPING CHARGES & DISCOUNT -->
                  {{--@include('admin.orders.details.charges')   --}}

               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@stop
@section('inc_script')
<script src="{{ asset('backend/js/orders/index.js') }}" type="text/javascript"></script>
@stop