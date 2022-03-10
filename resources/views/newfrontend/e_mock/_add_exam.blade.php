<div>{{ @$mockTest->title }}</div>
<a href="{{ route('mock-detail', @$mockTest->uuid ) }}" class="text-primary">
    {{__('formname.view_detail')}}
</a>