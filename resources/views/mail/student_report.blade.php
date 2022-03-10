<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{--<meta http-equiv="X-UA-Compatible" content="ie=edge">--}}
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Report</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        .page-break {
            page-break-after: always;
        }
        body, html{
            margin: 0 auto;
            padding: 0;
            width: 100%;
            font-family: 'Poppins', sans-serif;
            position: relative;
        }
        table{
            border-collapse:collapse;
            border-spacing: 0;
            font-size: 13px;
            color: #212121;
        }
        td{line-height: 20px;}
        th, td {vertical-align: top;text-align: left;}
    </style>
</head>
<body style="background-color: #ffffff; font-family: 'Poppins', sans-serif; font-size: 14px; color: #757575; margin: 0 auto;padding: 0; width: 100%;">
<table style="width: 100%" border="0" cellpadding="0" cellspacing="0">
    <tbody>
    {{--first-table--}}
    <tr>
        <td>
            <table style="width: 100%;background-color: #ffffff; border: 1px solid #e0e0e0; max-width: 100%" align="left" border="0" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Student No.</th>
                        <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Name</th>
                        <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Attempt</th>
                        <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Exam Name</th>
                        <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Exam ID</th>
                        <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">1012</td>
                        <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">Tasha Ewing</td>
                        <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">0</td>
                        <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">Mock Test Topics</td>
                        <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">40</td>
                        <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">07th December 2020</td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
    {{--space-table--}}
    <tr><td height="20px"></td></tr>

    {{--second table--}}
    <tr>
        <td>
            <table style="width: 100%;background-color: #ffffff; border: 1px solid #e0e0e0; max-width: 100%" align="left" border="0" cellpadding="10" cellspacing="0">
                <thead>
                <tr>
                    <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Questions</th>
                    <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Attempted</th>
                    <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Correctly Answered</th>
                    <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Unanswered</th>
                    <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Marks</th>
                    <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Overall Result</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">4</td>
                    <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">4</td>
                    <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">1</td>
                    <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">0</td>
                    <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #2296f3 !important;text-align: left !important;border: 1px solid #e0e0e0;">1 out of 76</td>
                    <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #2296f3 !important;text-align: left !important;border: 1px solid #e0e0e0;">1.32%</td>
                </tr>
                <tr>
                    <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 15px !important;color: #000 !important;text-align: left !important;vertical-align: middle;">
                        <img src="{{asset('images/mlt_str.png')}}" alt="" style="vertical-align: middle;padding-right: 15px">
                        Your Ranking
                    </td>
                    <td colspan="5" style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 15px !important;color: #000 !important;text-align: left !important;vertical-align: middle;">1 out of 1</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    {{--space-table--}}
    <tr><td height="30px"></td></tr>

    {{--question analysis--}}
    <tr>
        <td>
            <table style="width: 100%;background-color: #ffffff;max-width: 100%" align="left" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                      <tr>
                          <td style="font-family: 'Poppins', sans-serif !important;font-weight: 700 !important;font-size: 16px !important;color: #000 !important;text-align: left !important;">Question Analysis</td>
                      </tr>
                      <tr><td height="15px"></td></tr>
                      <tr>
                          <td style="font-family: 'Poppins', sans-serif !important;font-weight: 400 !important;font-size: 14px !important;color: #949494 !important;text-align: left !important;">
                              Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi
                              enim ad minim
                          </td>
                      </tr>
                      <tr><td height="25px"></td></tr>
                      <tr>
                          <td style="font-family: 'Poppins', sans-serif !important;font-weight: 700 !important;font-size: 16px !important;color: #000 !important;text-align: left !important;">Maths</td>
                      </tr>
                      <tr><td height="20px"></td></tr>
                      <tr>
                          <td>
                              <span style="display:inline-block;font-size: 15px;color: #fff;font-weight: 600;background-color: #4CAF50;margin-right: 1px;;padding: 10px 15px;text-align: center;">1</span>
                              <span style="display:inline-block;font-size: 15px;color: #fff;font-weight: 600;background-color: #FF9800;margin-right: 1px;;padding: 10px 15px;text-align: center;">2</span>
                              <span style="display:inline-block;font-size: 15px;color: #fff;font-weight: 600;background-color: #F44336;margin-right: 1px;;padding: 10px 15px;text-align: center;">3</span>
                              <span style="display:inline-block;font-size: 15px;color: #fff;font-weight: 600;background-color: #F44336;margin-right: 1px;;padding: 10px 15px;text-align: center;">4</span>
                          </td>
                      </tr>
                      <tr><td height="30px"></td></tr>
                </tbody>
            </table>
        </td>
    </tr>
    {{--Answer analysis--}}
    <tr>
        <td>
            <table style="width: 100%;background-color: #ffffff;max-width: 100%" align="left" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <td style="font-family: 'Poppins', sans-serif !important;font-weight: 700 !important;font-size: 16px !important;color: #000 !important;text-align: left !important;">Answers</td>
                </tr>
                <tr><td height="15px"></td></tr>
                <tr>
                    <td style="font-family: 'Poppins', sans-serif !important;font-weight: 400 !important;font-size: 14px !important;color: #949494 !important;text-align: left !important;">
                        Want to check the answers for the questions you didn't attempt and the wrong answered ones?
                    </td>
                </tr>
                <tr><td height="25px"></td></tr>
                <tr>
                    <td>
                        <table style="width: 100%;background-color: #ffffff; border: 1px solid #e0e0e0; max-width: 100%" align="left" border="0" cellpadding="10" cellspacing="0">
                            <thead>
                            <tr>
                                <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Q No.</th>
                                <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Questions</th>
                                <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Topic</th>
                                <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Your Answer</th>
                                <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Correct Answer</th>
                                <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Result</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">1</td>
                                <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">2+2 = ?</td>
                                <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">irure repellendus esse deleniti do accusantium ob</td>
                                <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">4</td>
                                <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">4</td>
                                <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;"><img src="{{asset('images/ys_ic.png')}}"></td>
                            </tr>
                            <tr>
                                <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">2</td>
                                <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">Jacob starts from the number 472 and counts in steps of
                                    10. He reached 552. How many steps did he take?</td>
                                <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">numbers</td>
                                <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">70</td>
                                <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">8</td>
                                <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;"><img src="{{asset('images/wrng_ic.png')}}"></td>
                            </tr>
                            <tr>
                                <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">3</td>
                                <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">There is a 16 x 42 grid. How many more dots are needed
                                    to make it a 18 x 42 diagram ? </td>
                                <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">numbers</td>
                                <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">84</td>
                                <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">42</td>
                                <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;"><img src="{{asset('images/wrng_ic.png')}}"></td>
                            </tr>
                            </tbody>
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