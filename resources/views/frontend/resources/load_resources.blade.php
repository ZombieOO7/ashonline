@forelse ($resources as $key => $item)
    <tr>
        <td data-title="{{__('formname.sno')}}.">{{ $key + $resources->firstItem() }}</td>
        <td data-title="{{__('formname.exam_paper')}}">{{ $item->title }}</td>
        <td data-title="{{__('formname.question_paper')}}"><a href="{{ route('resource/download/file',[$item->uuid, 'question']) }}"><span class="ash-download"></span>{{__('formname.download_now')}}</a></td>
        <td data-title="{{__('formname.detail_ans')}}"><a href="{{ route('resource/download/file',[$item->uuid, 'answer']) }}"><span class="ash-chat"></span>{{__('formname.answer')}}</a></td>
    </tr>
@empty

@endforelse
<tr class="pagination"><td colspan="4">
<input type="hidden" value="{{ count($resources) ? @$resources->lastPage() : '' }}" id="total_pages">
{{ count($resources) ? $resources->links() : '' }}
</td></tr>