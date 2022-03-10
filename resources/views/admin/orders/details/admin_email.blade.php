@include('frontend.template.header')
<tr>
    <td>
        <table width="100%" cellpadding="0" cellspacing="0"
            style="background-color:#ebeff2;width: 100%;text-align: center;font-family: 'Poppins', sans-serif !important;">
            <tbody>
                <tr>
                    <td height="15px"></td>
                </tr>
                <tr>
                    <td
                        style="font-family: 'Poppins', sans-serif !important;font-weight: bold;font-size: 38px;color: #000;">
                        {{__('formname.thank_you')}}</td>
                </tr>
                <tr>
                    <td
                        style="font-family: 'Poppins', sans-serif !important;font-weight: 400;font-size: 20px;color: #616161;">
                        {{__('formname.paper_purchase')}}</td>
                </tr>
                <tr>
                    <td height="15px"></td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>
<tr>
    <td height="15px"></td>
</tr>
<tr>
    <td>
        <table width="100%" cellpadding="0" cellspacing="0"
            style="width: 100%;font-family: 'Poppins', sans-serif !important;background-color: #ffffff;">
            <tbody>
                <tr>
                    <td width="30px"></td>
                    <td width="740px">
                        <table width="100%" cellpadding="0" cellspacing="0"
                            style="width: 100%;font-family: 'Poppins', sans-serif !important;">
                            <tbody>
                                <tr>
                                    <td
                                        style="text-align: center;font-family: 'Poppins', sans-serif !important;font-weight: 400;font-size: 14px;color: #616161;">
                                        {!!@$content!!}
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="text-align: center;font-family: 'Poppins', sans-serif !important;font-weight: 500;font-size: 13px;color: #212121;border: 1px solid #e5e5e5;padding: 8px;border-radius: 5px;">
                                        {{__('formname.password_content')}} : <a href="javascript:;"
                                            style="text-decoration: none;color: #2196f3;">{{@$order->biilingAddress->email}}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="15px"></td>
                                </tr>
                                <tr>
                                    <td
                                        style="font-family: 'Poppins', sans-serif !important;font-weight: 600;font-size: 16px;color: #000000;border-bottom: 1px solid #e5e5e5;padding-bottom: 10px;">
                                        {{__('formname.order_id')}} : <span style="text-decoration: none;color: #2196f3;">{{@$order->order_no}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="15px"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="100%" cellpadding="0" cellspacing="0"
                                            style="width: 100%;font-family: 'Poppins', sans-serif !important;">
                                            <tbody>
                                                <tr>
                                                    <td width="130px">
                                                        <span style="font-family: 'Poppins', sans-serif !important;font-weight: 500;font-size: 12px;color: #616161;">Date</span>
                                                        <p style="font-family: 'Poppins', sans-serif !important;font-weight: 600;font-size: 16px;color: #000;margin-top: 5px;margin-bottom: 0;">
                                                            {{@date('d M ,Y',strtotime($order->created_at))}}
                                                        </p>
                                                    </td>
                                                    <td width="510px" style="border-left:1px solid #e5e5e5;padding-left: 10px;">
                                                        <span style="font-family: 'Poppins', sans-serif !important;font-weight: 500;font-size: 12px;color: #616161;">{{__('formname.total_amount')}}</span>
                                                        <p style="font-family: 'Poppins', sans-serif !important;font-weight: 600;font-size: 16px;color: #000;margin-top: 5px;margin-bottom: 0;">
                                                            {{config('constant.default_currency_symbol').$order->amount_format_text}}
                                                        </p>
                                                    </td>
                                                    <td width="160">
                                                        <span
                                                            style="font-family: 'Poppins', sans-serif !important;font-weight: 500;font-size: 12px;color: #616161;">{{__('formname.payment.method')}}</span>
                                                        <p
                                                            style="font-family: 'Poppins', sans-serif !important;font-weight: 600;font-size: 16px;color: #000;margin-top: 5px;margin-bottom:0;">
                                                            {{@$order->payment_text}}</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="15px"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="100%" cellpadding="0" cellspacing="0"
                                            style="width: 100%;font-family: 'Poppins', sans-serif !important;">
                                            <thead>
                                                <tr>
                                                    <th style="background-color: #f5f5f5;font-family: 'Poppins', sans-serif !important;font-weight: 700;font-size: 13px;color: #2196f3;padding: 10px 15px;text-align: left;border-top-left-radius: 6px;border-bottom-left-radius: 6px;">
                                                        {{__('formname.papers')}}</th>
                                                    <th style="background-color: #f5f5f5;font-family: 'Poppins', sans-serif !important;font-weight: 700;font-size: 13px;color: #2196f3;padding: 10px 15px;text-align: left;">
                                                    </th>
                                                    <th style="background-color: #f5f5f5;font-family: 'Poppins', sans-serif !important;font-weight: 700;font-size: 13px;color: #2196f3;padding: 10px 15px;text-align: right;border-top-right-radius: 6px;border-bottom-right-radius: 6px;">
                                                        {{__('formname.download_now')}}</th>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 10px 15px;"></th>
                                                    <th style="padding: 10px 15px;"></th>
                                                    <th style="padding: 10px 15px;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse(@$order->items as $key => $item)
                                                <tr>
                                                    <td
                                                        style="font-family: 'Poppins', sans-serif !important;padding: 10px 15px;text-align: left;border: 1px solid #e5e5e5;border-right: none;border-top-left-radius: 6px;border-bottom-left-radius: 6px;">
                                                        <img src={{ @$item->paper->thumb_path}} alt="{{ @$item->paper->title }}" title="{{ @$item->paper->title }}"></td>
                                                    <td
                                                        style="font-family: 'Poppins', sans-serif !important;padding: 10px 15px;text-align: left;border: 1px solid #e5e5e5;border-right: none;border-left: none;">
                                                        <p
                                                            style="font-family: 'Poppins', sans-serif !important;font-weight: 600;font-size: 14px;color: #000000;margin-top: 0;margin-bottom: 5px;">
                                                            {{@$item->paper->title}}</p>
                                                        <p
                                                            style="font-family: 'Poppins', sans-serif !important;font-weight: 500;font-size: 14px;color: #424242;margin-top: 0;margin-bottom: 5px;">
                                                            {{@$item->item_price_text}}</p>
                                                    </td>
                                                    <td style="font-family: 'Poppins', sans-serif !important;padding: 10px 15px;text-align: right;border: 1px solid #e5e5e5;border-left: none;border-top-right-radius: 6px;border-bottom-right-radius: 6px;">
                                                        <a href="{{route('download',[@$item->order->uuid,@$item->paper->slug,@$item->paper->version->uuid])}}" style="text-decoration: none;font-family: 'Poppins', sans-serif !important;font-weight: 500;font-size: 13px;color: #000;">
                                                            <img src={{ asset("frontend/images/templates/downld_icn.png") }} style="vertical-align: middle;margin-top: -4px;margin-right: 5px;">{{__('formname.download_now')}}</a>
                                                    </td>
                                                </tr>
                                                @empty
                                                @endforelse

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3" height="10px"></td>
                                                </tr>
                                                @if(@$order->discount > 0)
                                                @php
                                                $total = config('constant.default_currency_symbol').($order->amount - $order->discount);
                                                @endphp
                                                <tr>
                                                    <td
                                                        style="font-family: 'Poppins', sans-serif !important;font-weight:500;padding: 10px 15px;text-align: left;color: #000;font-size: 13px;">
                                                        {{__('formname.sub_total')}}</td>
                                                    <td
                                                        style="font-family: 'Poppins', sans-serif !important;font-weight:500;padding: 10px 15px;text-align: left;color: #000;font-size: 13px;">
                                                    </td>
                                                    <td
                                                        style="font-family: 'Poppins', sans-serif !important;font-weight:500;padding: 10px 15px;text-align: right;color: #000;font-size: 13px;">
                                                        {{@$order->amount_format_text}}</td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="font-family: 'Poppins', sans-serif !important;font-weight:500;padding: 10px 15px;text-align: left;color: #000;font-size: 13px;">
                                                        {{__('formname.orders.discount')}}</td>
                                                    <td
                                                        style="font-family: 'Poppins', sans-serif !important;font-weight:500;padding: 10px 15px;text-align: left;color: #000;font-size: 13px;">
                                                    </td>
                                                    <td
                                                        style="font-family: 'Poppins', sans-serif !important;font-weight:500;padding: 10px 15px;text-align: right;color: #000;font-size: 13px;">
                                                        {{@$order->discount_text}}</td>
                                                </tr>
                                                @else
                                                @php
                                                $total = config('constant.default_currency_symbol').@$order->amount_format_text;
                                                @endphp
                                                @endif
                                                <tr>
                                                    <td colspan="3" height="10px"></td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="font-family: 'Poppins', sans-serif !important;font-weight:600;padding: 15px 15px;text-align: left;color: #000;font-size: 18px;background-color: #f5f5f5;">
                                                        {{__('formname.total_amount')}}</td>
                                                    <td
                                                        style="font-family: 'Poppins', sans-serif !important;font-weight:600;padding: 15px 15px;text-align: left;color: #000;font-size: 18px;background-color: #f5f5f5;">
                                                    </td>
                                                    <td
                                                        style="font-family: 'Poppins', sans-serif !important;font-weight:600;padding: 15px 15px;text-align: right;color: #1a237e;font-size: 18px;background-color: #f5f5f5;">
                                                        {{@$total}}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="20px"></td>
                                </tr>
                                <tr>
                                    <td
                                        style="font-family: 'Poppins', sans-serif !important;font-weight: 600;font-size: 18px;color: #000000;">
                                        {{__('formname.customer_info')}}</td>
                                </tr>
                                <tr>
                                    <td height="15px"></td>
                                </tr>
                                <tr>
                                    <td
                                        style="font-family: 'Poppins', sans-serif !important;font-weight: 500;font-size: 16px;color: #000000;">
                                        {{__('formname.billing_address')}} :</td>
                                </tr>
                                <tr>
                                    <td height="15px"></td>
                                </tr>
                                <tr>
                                    <td
                                        style="font-family: 'Poppins', sans-serif !important;font-weight: 400;font-size: 14px;color: #424242;">
                                        <p
                                            style="font-family: 'Poppins', sans-serif !important;font-weight: 400;font-size: 14px;color: #424242;margin: 5px 0;">
                                            {{@$order->biilingAddress->fullname}}</p>
                                        <p
                                            style="font-family: 'Poppins', sans-serif !important;font-weight: 400;font-size: 14px;color: #424242;margin: 5px 0;">
                                            {{ @$order->biilingAddress->address1 }}</p>
                                        <p
                                            style="font-family: 'Poppins', sans-serif !important;font-weight: 400;font-size: 14px;color: #424242;margin: 5px 0;">
                                            {{ @$order->biilingAddress->address2 }}</p>
                                        <p
                                            style="font-family: 'Poppins', sans-serif !important;font-weight: 400;font-size: 14px;color: #424242;margin: 5px 0;">
                                            {{ @$order->biilingAddress->city }}, {{ @$order->biilingAddress->state }}, {{@$order->biilingAddress->postal_code}}</p>
                                        <p
                                            style="font-family: 'Poppins', sans-serif !important;font-weight: 400;font-size: 14px;color: #424242;margin: 5px 0;">
                                            {{ @$order->biilingAddress->country }}</p>
                                        <p
                                            style="font-family: 'Poppins', sans-serif !important;font-weight: 400;font-size: 14px;color: #424242;margin: 5px 0;">
                                            T: {{ @$order->biilingAddress->phone }} </p>
                                        {{-- <p
                                            style="font-family: 'Poppins', sans-serif !important;font-weight: 400;font-size: 14px;color: #424242;margin: 5px 0;">
                                            VAT: 215144561654</p> --}}
                                    </td>
                                </tr>
                                <tr>
                                    <td height="15px"></td>
                                </tr>
                                @php
                                    $faqs = getFooterFaqs();
                                @endphp
                                @include('frontend.template.faq',['faqs' => @$faqs])
                            </tbody>
                        </table>
                    </td>
                    <td width="30px"></td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>
@include('frontend.template.footer')
