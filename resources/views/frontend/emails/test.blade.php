<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- m_-2245936519748174671custom-checkbox-input -->
    
    <style>
       html, body {
            height: 100%;
            }

            .page {
            width: 100%;
            min-height: 100%;
            position: relative;
            }

            .custom-checkbox {
            position: absolute;
            left: 50%;
            top: 50%;
            }

            .custom-checkbox-input {
            display: none;
            }

            .custom-checkbox-text {
            padding: 1rem;
            background-color: #aaa;
            color: #555;
            cursor: pointer;
            user-select: none;
            }

            .custom-checkbox-input:checked ~ .custom-checkbox-text {
            background-color: red;
            color: white;
            }
        

    </style>
</head>
<body>
    <form method="Post" action="{{route('get-feedback')}}">
        @csrf
        <table border="1">
            <tr>
                <th>{{__('fromname.paper_title')}}</th>
                <th>{{__('fromname.review.rate')}}</th>
                <th>{{__('fromname.review.review')}}</th>
            </tr>
            
            <tr>
                <td>{{__('formname.paper_set',['no'=>1])}}</td>
                <td><input type="text" name="paper[0][rate]"></td>
                <td>
                 <input type="text" name="paper[0][review]">
                </td>
            </tr>
            <tr>
                <td>{{__('formname.paper_set',['no'=>2])}}</td>
                <td><input type="text" name="paper[1][rate]"></td>
                <td>
                 <input type="text" name="paper[1][review]">
                </td>
            </tr>
            <tr>
                <td>{{__('formname.paper_set',['no'=>3])}}</td>
                <td><input type="text" name="paper[2][rate]"></td>
                <td>
                 <input type="text" name="paper[2][review]">
                </td>
            </tr>
            <tr>
                <td>{{__('formname.paper_set',['no'=>4])}}</td>
                <td><input type="text" name="paper[4][rate]"></td>
                <td>
                 <input type="text" name="paper[4][review]">
                </td>
            </tr>
            <tr>
                <td>{{__('formname.paper_set',['no'=>5])}}</td>
                <td><input type="text" name="paper[5][rate]"></td>
                <td>
                 <input type="text" name="paper[5][review]">
                </td>
            </tr>

        </table>
        <input type="submit" name="share" value="share your review">
    </form>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
    var base_url = "{{url('/')}}";
</script>
<script src="https://webcluesstaging.com/ashace_paper_html/js/bootstrap.min.js"></script>
<!-- <script src="https://webcluesstaging.com/ashace_paper_html/js/jquery.raty.js"></script> -->
<script src="https://webcluesstaging.com/ashace_paper_html/js/dev.js"></script>
</html>