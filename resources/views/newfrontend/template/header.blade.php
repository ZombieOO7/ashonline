<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title></title>
    <link
        href="https://fonts.googleapis.com/css?family=Poppins:400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap"
        rel="stylesheet">
</head>
<style type="text/css">

</style>

<body>
@php
    $faqs = getFooterFaqs();
@endphp
<table width="800px" cellpadding="0" cellspacing="0"
    style="font-family: 'Poppins', sans-serif !important;box-sizing:border-box;margin:0 auto;padding:0;width:800px;max-width: 800px;">
    <tbody>
        <tr>
            <td>
                <table width="100%" cellpadding="0" cellspacing="0"
                    style="background-color:#ffff;width: 100%;text-align: left;border-bottom:1px solid;">
                    <tbody>
                        <tr>
                            <td height="15px"></td>
                        </tr>
                        <tr>
                            <td><a href="{{route('home')}}"><img src="{{ asset('newfrontend/images/ashace_logo.png') }}" style="max-width: 150px;"></a></td>
                            <td><a style="font-size: 16px;color: #212121;font-weight: 500;text-decoration:none;position: relative;background-color: #fff;" href="{{route('home')}}">E-Papers</a></td>
                            <td><a style="font-size: 16px;color: #212121;font-weight: 500;text-decoration:none;position: relative;background-color: #fff;" href="{{route('e-mock')}}">E-Mock</a></td>
                            <td><a style="font-size: 16px;color: #212121;font-weight: 500;text-decoration:none;position: relative;background-color: #fff;" href="#">Practice</a></td>
                            <td><a style="font-size: 16px;color: #212121;font-weight: 500;text-decoration:none;position: relative;background-color: #fff;" href="{{route('resources/index', 'past-papers')}}">Resources</a></td>
                            <td><a style="font-size: 16px;color: #212121;font-weight: 500;text-decoration:none;position: relative;background-color: #fff;" href="{{route('contact-us')}}">Contact</a></td>
                        </tr>
                        <tr>
                            <td height="15px"></td>
                        </tr>
                        <tr>
                            <td height="15px"></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
