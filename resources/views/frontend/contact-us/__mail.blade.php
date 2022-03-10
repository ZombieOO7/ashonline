@include('frontend.template.header')
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
                                <tr><td style="text-align: left;font-family: 'Poppins', sans-serif !important;font-weight: 400;font-size: 14px;color: #616161;"><p><b>Hi {{ @$adminFullName }},</b></p></td></tr>
                                <tr>
                                    <td>
                                        <table width="100%" cellpadding="0" cellspacing="0"
                                            style="width: 100%;font-family: 'Poppins', sans-serif !important;">
                                            <thead>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td
                                                        style="font-family: 'Poppins', sans-serif !important;padding: 10px 15px;text-align: left;border: 1px solid #e5e5e5;border-top-left-radius: 6px;border-bottom-left-radius: 6px;">
                                                        {!! @$content !!}
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3" height="10px"></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="15px"></td>
                                </tr>
                                @php
                                $faqs = getFooterFaqs();
                                @endphp
                                @include('frontend.template.faq',['faqs' => $faqs])
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
