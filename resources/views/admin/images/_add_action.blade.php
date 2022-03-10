{{--@if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('stage edit')))--}}
{{--    <a class=" view" href="{{ URL::signedRoute('image_edit',['id'=>@$image->uuid]) }}" title="{{__('formname.edit')}}">--}}
{{--        <i class="fas fa-pencil-alt"></i>--}}
{{--    </a>--}}

    @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('stage delete')))
        <a class="delete" href="javascript:;" id="{{@$image->id}}" data-module_name="Image" data-table_name="image_table" data-url="{{route('image_delete')}}" title="{{__('formname.delete')}}">
            <i class="fas fa-trash-alt"></i>
        </a>
    @endif
{{--@endif--}}
