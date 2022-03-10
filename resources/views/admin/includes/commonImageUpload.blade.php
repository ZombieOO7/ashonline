<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <ul class="nav nav-tabs">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                role="tab" aria-controls="nav-home" aria-selected="true">{{__('formname.upload_image')}}</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                role="tab" aria-controls="nav-profile" aria-selected="false">{{__(__('formname.media_lib'))}}</a>
                        </div>
                    </nav>
                </ul>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.test-assessment.image') .'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                {!!Form::file('test_image',['id'=>'imgInput','class'=>'form-control m-input','accept' => 'image/*'])!!}
                                <input type="hidden" name="stored_img_name" id="stored_img_id" value="{{@$user->profile_pic}}">
                                @if ($errors->has('test_image')) <p class='errors' style="color:red;">
                                    {{ $errors->first('test_image') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <table class="table table-striped- table-bordered table-hover for_wdth" id="image_module_table"
                            data-type="" data-url="{{ route('test-assessment.images_datatable') }}">
                            <thead>
                                <tr>
                                    <th>
                                    </th>
                                    <th>{{__('formname.image_name.path')}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="SaveImageMedia" data-module_name="Image">{{__('formname.save')}}</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal"> {{__('formname.close')}} </button>
            </div>
        </div>
    </div>
</div>
