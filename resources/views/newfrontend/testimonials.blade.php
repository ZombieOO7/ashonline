@extends('newfrontend.layouts.default')
@section('title',@$cms->title)
@section('content')
<style>
    .tb_pgntn li a{
        border-radius:50% !important; 
    }
</style>
<div class="container mrgn_bt_40">
    <div class="row">
        <div class="col-md-10">
            <!--review card-->
            <div class="rated_card">
                <div class="prfl_ttl review_header">
                    <h3>Total Reviews {{@$total}}</h3>
                </div>
                <div class="review_body">
                    <div class="chart_rw star-rating-5 d-flex align-items-center">
                        <div class="checkbox_rw checkbox">
                            <input type="checkbox" class="checkbox chkbx" name='rate[]' value="5">
                            <label></label>
                        </div>
                        <div class="lable_rw"><span>Excellent</span></div>
                        <div class="progress_rw">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{@$fiveStar}}%" aria-valuenow="{{@$fiveStar}}"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="value_rw"><span>{{@$fiveStar}}%</span></div>
                    </div>
                    <div class="chart_rw star-rating-4 d-flex align-items-center">
                        <div class="checkbox_rw checkbox">
                            <input type="checkbox" class="checkbox chkbx" name='rate[]' value="4">
                            <label></label>
                        </div>
                        <div class="lable_rw"><span>Great</span></div>
                        <div class="progress_rw">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{@$fourStar}}%" aria-valuenow="{{@$fourStar}}"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="value_rw"><span>{{@$fourStar}}%</span></div>
                    </div>
                    <div class="chart_rw star-rating-3 d-flex align-items-center">
                        <div class="checkbox_rw checkbox">
                            <input type="checkbox" class="checkbox chkbx" name='rate[]' value="3">
                            <label></label>
                        </div>
                        <div class="lable_rw"><span>Average</span></div>
                        <div class="progress_rw">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{@$threeStar}}%" aria-valuenow="{{@$threeStar}}"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="value_rw"><span> <{{@$threeStar}}% </span> </div> 
                    </div> 
                    <div class="chart_rw star-rating-2 d-flex align-items-center">
                        <div class="checkbox_rw checkbox">
                            <input type="checkbox" class="checkbox chkbx" name='rate[]' value="2">
                                        <label></label>
                        </div>
                        <div class="lable_rw"><span>Poor</span></div>
                            <div class="progress_rw">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: {{@$twoStar}}%"
                                        aria-valuenow="{{@$twoStar}}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="value_rw"><span>
                                    <{{@$twoStar}}%</span> </div> </div> <div
                                        class="chart_rw star-rating-1 d-flex align-items-center">
                                        <div class="checkbox_rw checkbox">
                                            <input type="checkbox" class="checkbox chkbx" name='rate[]' value="1">
                                            <label></label>
                                        </div>
                                        <div class="lable_rw"><span>Bad</span></div>
                                        <div class="progress_rw">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: {{@$oneStar}}%"
                                                    aria-valuenow="{{@$oneStar}}" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="value_rw"><span>{{@$oneStar}}%</span></div>
                            </div>
                        </div>
                    </div>
                    <!-- review list-->
                    <table id="ratingTable" class="table">
                        <thead>
                            <tr>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    {{-- @forelse($ratings as $rating) --}}
                    {{-- <div class="review_list">
                        <div class="review_card">
                            <div class="header_list">
                                <a href="javascript:;" class="inner_header_list d-flex align-items-center">
                                    <div class="user_pictuer"><img src="{{@$rating->user->image_thumb}}"></div>
                                    <div class="user_info">
                                        <h4>{{@$rating->user->full_name}}</h4>
                                        <div class="num_of_revw">
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="star_time_list d-flex align-items-center justify-content-between">
                                <div class="fixedStar fixedStar_readonly" data-score="{{$rating->rating}}" readonly></div>
                                <div class="time_ls">{{@$rating->created_at_human_formate}}</div>
                            </div>
                            <div class="review_content_body">
                                <p>{{@$rating->msg}}</p>
                            </div>
                        </div>
                    </div> --}}
                {{-- @empty --}}
                {{-- @endforelse --}}
                <!--pagination-->
                {{-- <div class="tb_bt_actn mt-4">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="tb_pgntn">
                                <li><a class="page-link" href="#">&lt;</a></li>
                                <li><a class="page-link active" href="#">1</a></li>
                                <li><a class="page-link" href="#">2</a></li>
                                <li><a class="page-link" href="#">3</a></li>
                                <li><a class="page-link" href="#">&gt;</a></li>
                            </ul>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <!--close inner content-->
    @stop
    @section('pageJs')
    <script src="{{ asset('backend/dist/default/assets/vendors/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{asset('backend/js/common.js')}}"></script>
    <script>
        var ratings = [];
        url2 = "{{route('testimonials.datatable')}}";
            $(function() {
                $(document).find('.fixedStar_readonly').raty({
                    readOnly:  true,
                    path    :  '{{asset("newfrontend/images")}}',
                    starOff : 'star-off.svg',
                    starOn  : 'star-on.svg',
                    starHalf:   'star-half.svg',
                    start: $(document).find(this).attr('data-score')
                });
            });
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content') }
            });
            field_coloumns = [
                                {
                                    "data": "review",
                                    orderable: false,
                                    searchable: false
                                }
                            ];
            $('.chkbx').change(function(){
                ratings = [];
                $('.chkbx:checked').each(function(k,v){
                    ratings.push($(this).val());
                })
                table.draw();
            });

            table = $('#ratingTable').DataTable({
                stateSave: true,
                dom: 'trilp',
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": true,
                "bInfo": false,
                "ajax": {
                    url: url2,
                    type: "GET",
                    global: false,
                    data: function (d) {
                        d.rating = ratings;
                    },
                },
                "processing": true,
                "order": 0,
                "responsive": !0,
                "oLanguage": {
                    // "sProcessing": '<div class="text-center"><img src="' + base_url + '/public/images/loader.svg" width="40"></div>',
                    "sEmptyTable": "No Record Found",
                    "oPaginate": {
                        "sPrevious": "<",
                        "sNext": ">",
                    },
                },
                "lengthMenu": [10, 25, 50, 75, 100],
                "serverSide": true,
                "autoWidth": false,
                "searching": false,
                "orderCellsTop": true,
                "columns": field_coloumns,
                "ordering": false,
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': ['nosort']
                }],
                "aaSorting": [],
                "initComplete": function () {
                },
                "fnDrawCallback":function(){
                    $('#ratingTable_paginate ul').addClass("tb_pgntn");
                    if ( ! table.data().any() ) {
                        $('#ratingTable_paginate')[0].style.display = "none";
                        $('#ratingTable_length')[0].style.display = "none";
                    }
                    $('#ratingTable_processing')[0].style.display = "none";
                    $(document).find('.fixedStar_readonly').raty({
                        readOnly:  true,
                        path    :  '{{asset("newfrontend/images")}}',
                        starOff : 'star-off.svg',
                        starOn  : 'star-on.svg',
                        starHalf:   'star-half.svg',
                        start: $(document).find(this).attr('data-score')
                    });
                }
            });
    </script>
    @endsection