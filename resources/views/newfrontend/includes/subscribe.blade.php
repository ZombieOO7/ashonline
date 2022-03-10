@php 
$subscription = getSubscribeSection();
@endphp
<div class="subscibe_sc">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h4>{!! @$subscription->title !!}</h4>
          <p>{{@$subscription->content}}</p> 
        </div>
        <div class="col-md-6 newsletter">
          <form id="subscribeForm">
            <div class="input-group">
              <input type="email" name='subscribe_email' class="form-control" placeholder="{{ __('frontend.email_address') }}" id="subscriber_email">
              <span class="input-group-btn">
                <button class="btn newsletter-subscribe" type="button" data-url="{{ route('subscribe') }}">Subscribe</button>
              </span>
            </div>
            <span class="subscribeError"></span>
          </form>
        </div>
      </div>
    </div>
  </div>
