    <a class=" view" href="{{ URL::signedRoute('mock-test.edit',['uuid'=>@$mockTest->uuid]) }}" title="{{__('formname.edit')}}">
        <i class="fas fa-pencil-alt"></i>
    </a>
    <a class="delete" href="javascript:;" data-module_name="Mock Exam" id="{{@$mockTest->uuid}}" data-table_name="mock_test_table" data-url="{{route('mock-test.delete')}}" data-module="mock exam" title="{{__('formname.delete')}}">
        <i class="fas fa-trash-alt"></i>
    </a>
    @if(@$mockTest->status=='1')
        <a class=" active_inactive" href="javascript:;" id="{{@$mockTest->uuid}}" data-uuid="{{@$mockTest->uuid}}" data-url="{{ route('mock-test.active_inactive', [@$mockTest->id]) }}" data-module="mock exam" data-table_name="mock_test_table" title="Active">
            <i class="fas fa-toggle-on"></i>
        </a>
    @else
        <a class=" active_inactive" href="javascript:;" id="{{@$mockTest->uuid}}" data-uuid="{{@$mockTest->uuid}}" data-url="{{ route('mock-test.active_inactive', [@$mockTest->id]) }}" data-module="mock exam" data-table_name="mock_test_table" title="Inactive">
            <i class="fas fa-toggle-off"></i>
        </a>
    @endif
    <a class="view" href="{{ URL::signedRoute('mock-test.detail',['uuid'=>@$mockTest->uuid]) }}"  title="Preview">
        <i class="fas fa-eye"></i>
    </a>
    <a class="copy" href="{{ URL::signedRoute('mock-test.copy',['uuid'=>@$mockTest->uuid]) }}"  title="Copy Mock Exam">
        <i class="fas fa-copy"></i>
    </a>