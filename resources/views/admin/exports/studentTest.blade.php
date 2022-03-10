<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if(@$reportType==1)
        <table>
            <thead>
                <tr>
                    <th>{{__('formname.student.student_no')}}</th>
                    <th>{{__('formname.mock.exam_name')}}</th>
                    <th>{{__('formname.student.start_date')}}</th>
                    <th>{{__('formname.student.end_date')}}</th>
                    <th>{{__('formname.student.ip_address')}}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reportData as $studentTest)
                    <tr>
                        <td>{{@$studentTest->student->student_no}}</td>
                        <td>{{@$studentTest->mockTest->title}}</td>
                        <td>{{@$studentTest->start_date_text}}</td>
                        <td>{{@$studentTest->end_date_text}}</td>
                        <td>{{@$studentTest->ip_address}}</td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    @elseif(@$reportType==2)
        <table>
            <thead>
                <tr>
                    <th>{{__('formname.student.student_no')}}</th>
                    <th>{{__('formname.student.full_name')}}</th>
                    <th>{{__('formname.student.email')}}</th>
                    <th>{{__('formname.student.school_year')}}</th>
                    <th>{{__('formname.student.preferred_exam_board')}}</th>
                    <th>{{__('formname.student.parent_name')}}</th>
                    <th>{{__('formname.student.created_at')}}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reportData as $student)
                <tr>
                    <td>{{@$student->student_no}}</td>
                    <td>{{@$student->full_name}}</td>
                    <td>{{@$student->email}}</td>
                    <td>{{@$student->school_year}}</td>
                    <td>{{@$student->examBoard->title}}</td>
                    <td>{{@$student->parents->full_name}}</td>
                    <td>{{@$student->created_at}}</td>
                </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    @elseif(@$reportType==3 || @$reportType==4)
        <table>
            <thead>
                <tr>
                    <th>{{__('formname.orders.order_no')}}</th>
                    <th>{{__('formname.orders.invoice_number')}}</th>
                    {{-- <td>
                        <b>{{__('formname.orders.mock_detail')}}</b>
                        <table>
                            <tr>
                                <td><b>{{__('formname.orders.mock_paper')}}</b></td>
                                <td><b>{{__('formname.orders.mock_price')}}</b></td>
                            </tr>
                        </table>
                    </td> --}}
                    <th>{{__('formname.parent.full_name')}}</th>
                    <th>{{__('formname.orders.amount')}}</th>
                    <th>{{__('formname.orders.discount')}}</th>
                    <th>{{__('formname.orders.created_at')}}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reportData as $order)
                <tr>
                    <td>{{@$order->order_no}}</td>
                    <td>{{@$order->invoice_no}}</td>
                    {{-- <td>
                        <table>
                            @forelse(@$order->items as $item)
                                <tr>
                                    <td>{{@$item->mockTest->title}}</td>
                                    <td>{{@$item->price}}</td>
                                </tr>
                            @empty
                            @endforelse
                        </table>
                    </td> --}}
                    <td>{{@$order->parent->full_name}}</td>
                    <td>{{@$order->amount_text}}</td>
                    <td>{{@$order->discount_text}}</td>
                    <td>{{@$order->created_at}}</td>
                </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    @endif
</body>
</html>
@php
// exit;
@endphp