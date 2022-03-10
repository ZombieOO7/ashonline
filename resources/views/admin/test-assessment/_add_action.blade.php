    <a class=" view" href="{{ URL::signedRoute('test-assessment.edit',['uuid'=>@$testAssessment->uuid]) }}" title="{{__('formname.edit')}}">
        <i class="fas fa-pencil-alt"></i>
    </a>
    <a class="delete" href="javascript:;" data-module_name="Test Assesment" id="{{@$testAssessment->uuid}}" data-table_name="test_assessment_table" data-url="{{route('test-assessment.delete')}}" data-module="Test Assesment" title="{{__('formname.delete')}}">
        <i class="fas fa-trash-alt"></i>
    </a>
    @if(@$testAssessment->status=='1')
        <a class=" active_inactive" href="javascript:;" id="{{@$testAssessment->uuid}}" data-uuid="{{@$testAssessment->uuid}}" data-url="{{ route('test-assessment.active_inactive', [@$testAssessment->id]) }}" data-module="Test Assesment" data-table_name="test_assessment_table" title="Active">
            <i class="fas fa-toggle-on"></i>
        </a>
    @else
        <a class=" active_inactive" href="javascript:;" id="{{@$testAssessment->uuid}}" data-uuid="{{@$testAssessment->uuid}}" data-url="{{ route('test-assessment.active_inactive', [@$testAssessment->id]) }}" data-module="Test Assesment" data-table_name="test_assessment_table" title="Inactive">
            <i class="fas fa-toggle-off"></i>
        </a>
    @endif
    <a class="view" href="{{ URL::signedRoute('test-assessment.detail',['uuid'=>@$testAssessment->uuid]) }}"  title="Preview">
        <i class="fas fa-eye"></i>
    </a>
    <a class="copy" href="{{ URL::signedRoute('test-assessment.copy',['uuid'=>@$testAssessment->uuid]) }}"  title="Copy Test Assessment">
        <i class="fas fa-copy"></i>
    </a>