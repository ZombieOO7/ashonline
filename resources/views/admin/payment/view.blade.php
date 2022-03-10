@extends('admin.layouts.default')
@section('inc_css')
@section('content')
@section('title', __('formname.payment.detail'))
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
                              {{ __('formname.payment.detail') }}
                           </h3>
                        </div>
                     </div>
                     <div class="m-portlet__head-tools">
                        <a href="{{route('payment_index')}}"
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
                  @include('admin.payment.details.order_header')
                     
                  <!-- BILLING, SHIPPING & PAYMENT INFORMATION -->
                  @include('admin.payment.details.billing_info')   
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@stop
