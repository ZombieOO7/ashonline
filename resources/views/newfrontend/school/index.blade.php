@extends('newfrontend.layouts.default')
@section('title','Home')
@section('content')
<section class="wehelp_sc">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-left">
				<h3 class="df_h3">Top Schools We Cover</h3>
				<p class="df_pp m-0">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod
					tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud
					exerci tation </p>
            </div>
            <div class="col-md-12">
                <div class="rspnsv_table scrollble-table">
                    <table id='school_table' class="table-bordered table-striped table-condensed datatable cf">
                        <thead class="cf">
                            <tr>
                                <th class="img_hd">{{__('formname.mock.image')}}</th>
                                <th>{{__('frontend.school.name')}}</th>
                                <th>{{__('frontend.school.style')}}</th>
                                <th>{{__('frontend.school.description')}}</th>
                                <th>{{__('formname.mock.action')}}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section('pageJs')
<script>
    var url = '{{route("school-datatable")}}';
</script>
<script src="{{ asset('backend/dist/default/assets/vendors/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{asset('backend/js/common.js')}}"></script>
<script src="{{asset('newfrontend/js/school/index.js')}}"></script>
@endsection