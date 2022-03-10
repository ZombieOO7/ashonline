@include('newfrontend.template.header')
<tr>
    <tr>
    <td style="padding: 0 20px;">
        @php
        $content = str_replace('[USER_FULL_NAME]',@$user->full_name,$content);
        $link = "<a class='btn' role='button' href='".route('parent.email.verify',['token'=>@$token])."'>Verify</a>";
        $content = str_replace('[LINK]',@$link,$content);
        $content = str_replace('[EMAIL]',@$user->email,$content);
        $content = str_replace('[CONTENT]',@$link,@$content);
        @endphp
        {!! @$content !!}
    </td>
</tr>
@include('newfrontend.template.footer')
