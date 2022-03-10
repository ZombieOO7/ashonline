@forelse ($relatedProducts as $board)
    <div class="col-md-12 mrgn_bt_20">
        <h3 class="more_text">{{__('frontend.mock.related_papers')}}</h3>
        <div class="rspnsv_table">
            <table class="table-bordered table-striped table-condensed cf">
                <thead class="cf">
                <tr>
                    <th class="img_hd">{{__('formname.mock.image')}}</th>
                    <th>{{__('formname.mock.exam_name')}}</th>
                    <th>{{__('formname.mock.date')}}</th>
                    <th>{{__('formname.mock.time')}}</th>
                    <th>{{__('formname.mock.price')}}</th>
                    <th>{{__('formname.mock.action')}}</th>
                </tr>
                <tr class="middle_hdng_rw">
                    <th colspan="6" align="center">{{@$board->title}}</th>
                </tr>
                </thead>
                <tbody>
                @forelse(@$board['mockExams'] as $mkey => $mockTest)
                    <tr>
                        <td data-title="Images">
                            <a href="{{ route('mock-detail', @$mockTest->uuid ) }}">
                                <img
                                    src="{{@$mockTest->image_path }}"
                                    class="mx-wd-95" width="100px" height="100px">
                            </a>
                        </td>
                        <td data-title="Exam Name">
                            <a href="{{ route('mock-detail', @$mockTest->uuid ) }}">{{ @$mockTest->title }}</a>
                        </td>
                        <td data-title="Date">
                            {{@$mockTest->proper_start_date_and_end_date }}
                        </td>
                        <td data-title="Time">
                            {{ @$mockTest->mockTestSubjectTime->proper_time }}
                        </td>
                        <td data-title="Price">{{config('constant.default_currency_symbol')}}
                            {{@$mockTest->price}}</td>
                        <td data-title="Action" class="min-wd-140"><a href="javascript:;"
                                                                      data-url="{{route('emock-add-to-cart')}}"
                                                                      data-mock_id="{{ @$mockTest->id }}"
                                                                      class="add_to_cart addToCart">{{__('formname.mock.add_to_cart')}}</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">{{__('formname.not_found')}}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@empty
@endforelse
@forelse ($relatedPapers as $relatedPaper)
    <div class="col-md-12 mrgn_bt_20">
        @if ($loop->first)
            <h4>{{ __('frontend.papers.related_papers')}}</h4>
        @endif
        <div class="rspnsv_table">
            <table class="table-bordered table-striped table-condensed cf">
                <thead class="cf">
                <tr>
                    <th class="img_hd">{{__('formname.mock.image')}}</th>
                    <th>{{__('frontend.cart.product_name')}}</th>
                    <th>{{__('formname.test_papers.exam_type')}}</th>
                    <th>{{__('formname.mock.price')}}</th>
                    <th>{{__('formname.mock.action')}}</th>
                </tr>
                @if(@$relatedPaper['papers']->count() > 0)
                    <tr class="middle_hdng_rw">
                        <th colspan="6" align="center">
                            <a href="{{ route('paper.detail',['slug' => @$relatedPaper['slug']]) }}" class="view_all">
                                {{@$relatedPaper['title']}}
                            </a>
                        </th>
                    </tr>
                @endif
                </thead>
                <tbody>
                @forelse (@$relatedPaper['papers'] as $key => $paper)
                    <tr>
                        <td data-title="Images">
                            <img src="{{@$paper->thumb_path }}" class="mx-wd-95" width="100px" height="100px"
                                 alt="{{ @$paper->title }}" title="{{ Str::limit(@$paper->title, 30) }}">
                        </td>
                        <td data-title="Exam Name">
                            <a href="{{ route('paper-details',['category' => @$paper->category->slug, 'slug' => @$paper->slug]) }}">{{ @$paper->title }}</a>
                        </td>
                        <td data-title="Date">
                            {{@$paper->examType->title }}
                        </td>
                        <td data-title="Price">
                            {{ @$paper->price_text }}
                        </td>
                        <td data-title="Action" class="min-wd-140"><a href="javascript:;"
                                                                      data-url="{{route('emock-add-to-cart')}}"
                                                                      data-paper_id="{{ @$paper->id }}"
                                                                      class="add_to_cart addToCart">{{__('formname.mock.add_to_cart')}}</a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">{{__('formname.not_found')}}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@empty
@endforelse
