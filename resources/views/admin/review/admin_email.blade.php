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
                        {{__('formname.feedback')}}</td>
                </tr>
                <tr>
                    <td
                        style="font-family: 'Poppins', sans-serif !important;font-weight: 400;font-size: 20px;color: #616161;">
                        {{__('formname.review_content')}}</td>
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
                                {{-- <tr><td style="text-align: center;font-family: 'Poppins', sans-serif !important;font-weight: 400;font-size: 14px;color: #616161;"><p>Please click below on the Download to download the paper(s) ordered. The papers are for your personal and private use only.</p></td></tr> --}}
                                {{-- <tr><td style="text-align: center;font-family: 'Poppins', sans-serif !important;font-weight: 500;font-size: 13px;color: #212121;border: 1px solid #e5e5e5;padding: 8px;border-radius: 5px;">The password to open the papers is your email id : <a href="#" style="text-decoration: none;color: #2196f3;">cashutosh@gmail.com</a></td></tr> --}}
                                <tr>
                                    <td height="15px"></td>
                                </tr>
                                <tr>
                                    <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600;font-size: 16px;color: #000000;padding-bottom: 10px;">
                                        {{-- Fullname : <span style="text-decoration: none;">{{ @$billing_address->full_name }}</span> --}}
                                        {!! @$content !!}
                                    </td>
                                </tr>
                                {{-- <tr>
                                    <td
                                        style="font-family: 'Poppins', sans-serif !important;font-weight: 600;font-size: 16px;color: #000000;border-bottom: 1px solid #e5e5e5;padding-bottom: 10px;">
                                        Email : <span style="text-decoration: none;color: #2196f3;">{{ @$billing_address->email }}</span>
                                    </td>
                                </tr> --}}
                                <tr>
                                    <td height="15px"></td>
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
                                                        {{__('formname.papers')}}</th>
                                                    <th
                                                        style="background-color: #f5f5f5;font-family: 'Poppins', sans-serif !important;font-weight: 700;font-size: 13px;color: #2196f3;padding: 10px 15px;text-align: left;">
                                                        {{__('formname.review.rate')}}</th>
                                                    <th
                                                        style="background-color: #f5f5f5;font-family: 'Poppins', sans-serif !important;font-weight: 700;font-size: 13px;color: #2196f3;padding: 10px 15px;text-align: right;border-top-right-radius: 6px;border-bottom-right-radius: 6px;">
                                                        {{__('formname.review.description')}}</th>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 10px 15px;"></th>
                                                    <th style="padding: 10px 15px;"></th>
                                                    <th style="padding: 10px 15px;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($review as $rate)
                                                <tr>
                                                    <td
                                                        style="font-family: 'Poppins', sans-serif !important;padding: 10px 15px;text-align: left;border: 1px solid #e5e5e5;border-right: none;border-top-left-radius: 6px;border-bottom-left-radius: 6px;">
                                                        <p
                                                            style="font-family: 'Poppins', sans-serif !important;font-weight: 600;font-size: 14px;color: #000000;margin-top: 0;margin-bottom: 5px;">
                                                            {{ @$rate->paper->title }}</p>
                                                    </td>
                                                    <td
                                                        style="font-family: 'Poppins', sans-serif !important;padding: 10px 15px;text-align: left;border: 1px solid #e5e5e5;border-right: none;border-left: none;">
                                                        <p
                                                            style="font-family: 'Poppins', sans-serif !important;font-weight: 500;font-size: 14px;color: #424242;margin-top: 0;margin-bottom: 5px;">
                                                            <img src="{{asset('frontend/images/templates/'.@$rate->rate.'_star.png')}}">
                                                        </p>
                                                    </td>
                                                    <td
                                                        style="font-family: 'Poppins', sans-serif !important;padding: 10px 15px;text-align: right;border: 1px solid #e5e5e5;border-left: none;border-top-right-radius: 6px;border-bottom-right-radius: 6px;">
                                                        <p
                                                            style="font-family: 'Poppins', sans-serif !important;font-weight: 500;font-size: 14px;color: #424242;margin-top: 0;margin-bottom: 5px;">
                                                            {{ truncate(@$rate->content,50) }}</p>
                                                    </td>
                                                </tr>
                                                @empty
                                                @endforelse
                                            </tbody>
                                        </table>
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