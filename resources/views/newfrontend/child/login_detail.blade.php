@include('newfrontend.template.header')
<tr>
    <tr>
    <td style="padding: 0 20px;">
        @php
        $content = str_replace('[USER_NAME]',@$user->email,$content);
        $content = str_replace('[PASSWORD]',@$password,$content);
        $content = str_replace('[CHILD_ID]',@$email,$content);
        @endphp
        {!! @$content !!}
    </td>
</tr>
@include('newfrontend.template.footer')