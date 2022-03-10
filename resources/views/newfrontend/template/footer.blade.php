            <tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0"
                        style="width: 100%;font-family: 'Poppins', sans-serif !important;">
                        <tbody>
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0"
                                        style="background: #000;width: 100%;text-align: center;">
                                        <tbody>
                                            <tr>
                                                <td style="height: 20px;"></td>
                                            </tr>
                                            <tr>
                                                <td style="height: 20px;"></td>
                                            </tr>
                                            <tr>
                                                <td><a href="{{route('home')}}"><img src="{{ asset('newfrontend/images/ftr_logo.png') }}" style="max-width: 150px;"></a></td>
                                                <td><a style="font-size: 16px;color: #fff;font-weight: 500;text-decoration:none;position: relative;background-color: #000;" href="{{route('home')}}">E-Papers</a></td>
                                                <td><a style="font-size: 16px;color: #fff;font-weight: 500;text-decoration:none;position: relative;background-color: #000;" href="{{route('e-mock')}}">E-Mock</a></td>
                                                <td><a style="font-size: 16px;color: #fff;font-weight: 500;text-decoration:none;position: relative;background-color: #000;" href="#">Practice</a></td>
                                                <td><a style="font-size: 16px;color: #fff;font-weight: 500;text-decoration:none;position: relative;background-color: #000;" href="{{route('resources/index', 'past-papers')}}">Resources</a></td>
                                                <td><a style="font-size: 16px;color: #fff;font-weight: 500;text-decoration:none;position: relative;background-color: #000;" href="{{route('contact-us')}}">Contact</a></td>
                                            </tr>
                                            <tr>
                                                <td style="height: 20px;"></td>
                                            </tr>
                                            <tr>
                                                <td style="height: 20px;"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0"
                                        style="background-color: #000;width: 100%;font-family: 'Poppins', sans-serif !important;">
                                        <tr>
                                            <td style="height: 10px;"></td>
                                        </tr>
                                        <tr>
                                            <td
                                                style="font-family: 'Poppins', sans-serif !important;font-weight: 500;font-size: 10px;color: #ffffff;text-align: center;">
                                                © {{ date('Y') }} All right reserved. {{config('app.name')}}</td>
                                        </tr>
                                        <tr>
                                            <td style="height: 10px;"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
