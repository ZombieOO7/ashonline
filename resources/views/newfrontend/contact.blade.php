@extends('newfrontend.layouts.default')
@section('title','Contact Us')
@section('content')
<section class="contact_sc">
    <div class="container">
      <div class="row">
        <div class="col-md-7">
          <div class="row">
            <div class="col-md-12 in_ttl">
              <h3 class="df_h3">Contact Us</h3>
              <p class="df_pp">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo</p>
            </div>
            <div class="col-md-12">
              <form class="def_form">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Your Name">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Mobile Number">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Email Address">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <select class="selectpicker def_select" title="Select Subject">
                        <option>Subject1</option>
                        <option>Subject2</option>
                        <option>Subject3</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Your Message">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="capch_dv">
                        <label>ABCXDR</label>
                        <input type="text" class="form-control" placeholder="Enter Captcha">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <button type="submit" class="btn submit_btn">Submit</button>
                    </div>
                  </div>


                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@stop