{!! Form::hidden("questionSubjectId",@$subjectId,['id'=>@$questionSubjectId]) !!}
<table class="table table-striped- table-bordered table-hover table-checkable for_wdth" id="question_table">
    <thead>
        <tr>
            {{-- <th class="nosort">
                <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                    <input type="checkbox" value="" id="trade_checkbox" class="m-checkable allCheckbox">
                    <span></span>
                </label>
            </th> --}}
            <th>{{__('formname.question.question')}}</th>
            <th>{{__('formname.question.')}}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($questions as $key => $question)
        <tr>
            <td class="nosort">
                <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                    <input type="checkbox" name="trade_checkbox[]" value="{{@$question->id}}" class="m-checkable trade_checkbox checkbox">
                    <span></span>
                </label>
            </td>
            <td>{{@$question->question_title}}</td>
            <td>{{@$question->type}}</td>
        </tr>
        @empty
        @endforelse
    </tbody>
</table>