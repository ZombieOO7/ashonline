{{-- @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('page edit'))) --}}
@if(@$cms->type == 2)
@php $route = 'subject-cms.edit'; @endphp
@elseif(@$cms->type ==3)
@php $route = 'school-cms.edit'; @endphp
@else
@php $route = 'cms_edit'; @endphp
@endif
<a class=" view" href="{{ URL::signedRoute($route,['id'=>@$cms->id]) }}" title="Edit Page"><i
        class="fas fa-pencil-alt"></i></a>
{{-- @endif --}}
{{-- @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('page delete'))) --}}
<a class=" delete" href="javascript:;" id="{{@$cms->id}}" data-table_name="cms_table"
    data-url="{{route('cms_delete')}}" data-module_name="{{ @$cms->type == 2 ? 'Subject' : 'School' }}" title="Delete Page"><i class="fas fa-trash-alt"></i>
</a>
{{-- @endif --}}