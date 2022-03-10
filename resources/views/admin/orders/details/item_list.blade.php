@php
$orderItems = @$order->papers;
// dd($orderItems);
@endphp
<div class="form-group m-form__group row row_div">
    <div class="col-lg-12">
        @if(count($orderItems) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>{{__('formname.item.name')}}</th>
                    <th>{{__('formname.test_papers.price')}}</th>
                    <th width='100px;'>{{__('formname.test_papers.versions')}}</th>
                    <th>{{__('formname.item.download')}}</th>
                    <th>{{__('formname.action')}}</th>
                </tr>
            </thead>
            <tbody>
                @forelse(@$orderItems as $key => $item)
                <tr>
                    <td>
                        <span data-toggle="tooltip" data-html="true" title="{{ @$item->paper->title }}">
                            {{ @$item->paper->title }}
                        </span>
                    </td>
                    <td>
                        @if(@$item->price != null)
                        {{ config('constant.default_currency_symbol').number_format((float)@$item->price, 2, '.', '') }}
                        @else
                        {{ config('constant.default_currency_symbol').number_format((float)@$item->paper->price, 2, '.', '') }}
                        @endif
                    </td>
                    <td>
                        <select class="form-control" id="version_id{{ $key }}" name='version_id'>
                            @forelse($item->paperVersion as $version)
                            <option value="{{@$version->uuid}}">
                                {{ @$version->version}}</option>
                            @empty
                            <option value="">1</option>
                            @endforelse
                        </select>
                    </td>
                    <td>
                        <a class="view version-download" href="javascript:void(0)"
                            data-order-uuid="{{ @$item->order->uuid }}" data-paper-slug="{{ @$item->paper->slug }}"
                            data-url="{{ route('version_download') }}" data-key="{{ $key }}" title="Download">
                            <i class="fas fa-download"></i>
                        </a>
                    </td>
                    <td>
                        <a class="view version-send-mail" href="javascript:void(0)"
                            data-order-id="{{ @$item->order->id }}" data-paper-id="{{ @$item->paper->id }}"
                            data-url="{{ route('send_mail') }}" data-key="{{ $key }}" title="Send Mail">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </td>
                </tr>
                @empty
                @endforelse
            </tbody>
        </table>
        @endif
        @if($order->mockTests)
            <table class="table">
                <thead>
                    <tr>
                        <th>Mock Exam</th>
                        <th>{{__('formname.test_papers.price')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(@$order->mockTests as $key => $mockTest)
                    <tr>
                        <td>
                            <span data-toggle="tooltip" data-html="true" title="{{ @$mockTest->mockTest->title }}">
                                {{  @$mockTest->mockTest->title }}
                            </span>
                        </td>
                        <td>
                            {{ config('constant.default_currency_symbol').number_format((float)@$mockTest->price, 2, '.', '') }}
                        </td>
                    </tr>
                    @empty
                    @endforelse
        @endif
                    @if(@$order->discount != 0)
                        <tr>
                            <td>
                                <b>{{__('formname.orders.discount')}}</b>
                            </td>
                            <td>
                                {{ config('constant.default_currency_symbol').number_format((float)@$order->discount, 2, '.', '') }}
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td>
                            <b>{{ __('formname.orders.total') }} </b>
                        </td>
                        <td>
                            {{ config('constant.default_currency_symbol').number_format((float)@$order->total_amount, 2, '.', '') }}
                        </td>
                    </tr>
                </tbody>
        </table>
    </div>
</div>