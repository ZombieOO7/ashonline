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
                        Student Report</td>
                </tr>
                <tr>
                    {{-- <td
                        style="font-family: 'Poppins', sans-serif !important;font-weight: 400;font-size: 20px;color: #616161;">
                        {{__('formname.paper_purchase')}}</td> --}}
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
                                        {!! @$content !!}
                                    </td>
                                </tr>
                                {{-- <tr>
                                    <td
                                        style="text-align: center;font-family: 'Poppins', sans-serif !important;font-weight: 500;font-size: 13px;color: #212121;border: 1px solid #e5e5e5;padding: 8px;border-radius: 5px;">
                                        {{__('formname.password_content')}} : <a href="javascript:;"
                                            style="text-decoration: none;color: #2196f3;">{{@$orderItem->order->biilingAddress->email}}</a>
                                    </td>
                                </tr> --}}
                                <tr>
                                    <td height="15px"></td>
                                </tr>
                                <tr>
                                    <td
                                        style="font-family: 'Poppins', sans-serif !important;font-weight: 600;font-size: 16px;color: #000000;border-bottom: 1px solid #e5e5e5;padding-bottom: 10px;">
                                        Date : <span
                                            style="text-decoration: none;color: #2196f3;">{{@$studentTest->created_at_user_readable}}</span>
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
                                                        <span
                                                            style="font-family: 'Poppins', sans-serif !important;font-weight: 500;font-size: 12px;color: #616161;">Date</span>
                                                        <p
                                                            style="font-family: 'Poppins', sans-serif !important;font-weight: 600;font-size: 16px;color: #000;margin-top: 5px;margin-bottom: 0;">
                                                            {{@$studentTest->created_at_user_readable}}
                                                        </p>
                                                    </td>

                                                    {{-- <td width="510px"
                                                        style="border-left:1px solid #e5e5e5;padding-left: 10px;">
                                                        <span
                                                            style="font-family: 'Poppins', sans-serif !important;font-weight: 500;font-size: 12px;color: #616161;">{{__('formname.total_amount')}}</span>
                                                        <p
                                                            style="font-family: 'Poppins', sans-serif !important;font-weight: 600;font-size: 16px;color: #000;margin-top: 5px;margin-bottom: 0;">
                                                            {{@$orderItem->order->amount_format_text}}
                                                        </p>
                                                    </td> --}}
                                                    {{-- <td width="160">
                                                        <span
                                                            style="font-family: 'Poppins', sans-serif !important;font-weight: 500;font-size: 12px;color: #616161;">{{__('formname.payment.method')}}</span>
                                                        <p
                                                            style="font-family: 'Poppins', sans-serif !important;font-weight: 600;font-size: 16px;color: #000;margin-top: 5px;margin-bottom:0;">
                                                            {{@$orderItem->order->payment_text}}</p>
                                                    </td> --}}
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
                                                    <th
                                                        style="background-color: #f5f5f5;font-family: 'Poppins', sans-serif !important;font-weight: 700;font-size: 13px;color: #2196f3;padding: 10px 15px;text-align: left;border-top-left-radius: 6px;border-bottom-left-radius: 6px;">
                                                        Mock Exam</th>
                                                    <th
                                                        style="background-color: #f5f5f5;font-family: 'Poppins', sans-serif !important;font-weight: 700;font-size: 13px;color: #2196f3;padding: 10px 15px;text-align: left;">
                                                    </th>
                                                    <th
                                                        style="background-color: #f5f5f5;font-family: 'Poppins', sans-serif !important;font-weight: 700;font-size: 13px;color: #2196f3;padding: 10px 15px;text-align: right;border-top-right-radius: 6px;border-bottom-right-radius: 6px;">
                                                        {{__('formname.download_now')}}</th>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 10px 15px;"></th>
                                                    <th style="padding: 10px 15px;"></th>
                                                    <th style="padding: 10px 15px;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td
                                                        style="font-family: 'Poppins', sans-serif !important;padding: 10px 15px;text-align: left;border: 1px solid #e5e5e5;border-right: none;border-top-left-radius: 6px;border-bottom-left-radius: 6px;">
                                                        <img src={{ @$mockTest->image_path}} alt="{{ @$mockTest->title }}" title="{{ @$mockTest->title }}" width="200px" height="200px"></td>
                                                    <td
                                                        style="font-family: 'Poppins', sans-serif !important;padding: 10px 15px;text-align: left;border: 1px solid #e5e5e5;border-right: none;border-left: none;">
                                                        <p
                                                            style="font-family: 'Poppins', sans-serif !important;font-weight: 500;font-size: 14px;color: #424242;margin-top: 0;margin-bottom: 5px;">
                                                            {{@$mockTest->title}}</p>
                                                    </td>
                                                    <td
                                                        style="font-family: 'Poppins', sans-serif !important;padding: 10px 15px;text-align: right;border: 1px solid #e5e5e5;border-left: none;border-top-right-radius: 6px;border-bottom-right-radius: 6px;">
                                                        <a href="{{route('download-child-report',['uuid'=>@$studentTest->uuid])}}"  target="_blank"
                                                            style="text-decoration: none;font-family: 'Poppins', sans-serif !important;font-weight: 500;font-size: 13px;color: #000;"><img
                                                                src={{ asset("frontend/images/templates/downld_icn.png") }}
                                                                style="vertical-align: middle;margin-top: -4px;margin-right: 5px;">{{__('formname.download_now')}}</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                            </tfoot>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="20px"></td>
                                </tr>
                                <tr>
                                    <td height="15px"></td>
                                </tr>
                                @php
                                    $faqs = getFooterFaqs();
                                @endphp
                                @include('frontend.template.faq',['faqs'=>@$faqs])
                            </tbody>
                        </table>
                    </td>
                    <td width="30px"></td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>
@php
// exit;
@endphp
@include('frontend.template.footer')