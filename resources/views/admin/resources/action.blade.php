{{-- Action bar for Resource --}}
@if(isset($item) && @$type == config('constant.col_action'))
        <a class="view" href="{{ route('resources.edit', [@$resType, @$item->uuid]) }}" title="{{__('formname.edit')}}"><i class="fas fa-pencil-alt"></i></a>
    
        <a class="delete" href="javascript:;" id="{{@$item->id}}" data-uuid="{{@$item->uuid}}" data-url="{{route('resources.destroy', [@$resType, @$item->uuid])}}" data-table_name="resources_table" data-module_name="{{ @$resType == 'blog' ? 'Blog' : 'Resource' }}" title="{{__('formname.delete')}}"><i class="fas fa-trash-alt"></i></a>
        @if((@$resType == 'guidance' || @$resType == 'blog') && @$item->paper_category_status == 1)
            <a class="active_inactive" href="javascript:;" data-status="{{(@$item->status) ? 0 : 1}}" id="{{@$item->id}}" data-url="{{ route('resources/change/status', @$resType) }}" data-table_name="resources_table" title="{{@$item->status_text}}">
                @if(@$item->status)
                    <i class="fas fa-toggle-on"></i>
                @else
                    <i class="fas fa-toggle-off"></i>
                @endif
            </a>
        @endif
@elseif(isset($item) && @$type == config('constant.col_checkbox'))
    <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
        <input type="checkbox" name="resources_checkbox[]" value="{{@$item->id}}" class="m-checkable checkbox">
        <span></span>
    </label>
@endif