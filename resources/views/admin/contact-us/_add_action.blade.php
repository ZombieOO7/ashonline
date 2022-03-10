@if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('contact us edit')))
{{-- <a class=" view" href="{{ URL::signedRoute('contact_us_edit',['id'=>$contact->id]) }}" title="Edit Contact Us"><i
        class="fas fa-pencil-alt"></i></a> --}}
@endif
@if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('contact us delete')))
<a class=" delete" href="javascript:;" id="{{@$contact->id}}"  data-table_name="contact_us_table"
    data-url="{{route('contact_us_delete')}}" title="Delete Contact Us" data-module_name="inquiry"><i class="fas fa-trash-alt"></i>
</a>
@endif