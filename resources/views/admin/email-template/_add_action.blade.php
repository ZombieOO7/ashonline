@if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('email template edit')))
    <a class=" view" href="{{ URL::signedRoute('email_template_edit',['id'=>@$emailTemplate->uuid]) }}" title="{{__('formname.edit')}}">
        <i class="fas fa-pencil-alt"></i>
    </a>
@endif