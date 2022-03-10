<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="{{ @getWebSettings()->meta_description != null ? @getWebSettings()->meta_description  : "Welcome to AshACE Papers" }}">
    <meta name="keywords" content="{{ @getWebSettings()->meta_keywords != null ? @getWebSettings()->meta_keywords : 'AshACE Papers' }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{__('formname.report.title')}}</title>
    <style>
        .text-left{
            text-align:left;
        }
        .text-center{
            text-align:center;
        }
    </style>
</head>
<body>
    <table class="table table-responsive table-striped-table-bordered table-hover table-checkable for_wdth" id="order_report_table">
        <tr>
            <th><b>{{__('formname.report.pack')}}</b></th>
            <th><b>{{__('formname.report.price')}}</b></th>
            <th><b>{{__('formname.report.no_of_paper_sold')}}</b></th>
            <th><b>{{__('formname.orders.amount')}}</b></th>
        </tr>
        @forelse($items as $paper)
            <tr>
                <td>{{@$paper->title}}</td>
                <td>{{@$paper->price_text}}</td>
                <td>{{@$paper->order_items_count}}</td>
                <td>{{@config('constant.default_currency_symbol').@$paper->totalSoldPaperAmount}}</td>
            </tr>
        @empty
        @endforelse
    </table>
</body>
</html>