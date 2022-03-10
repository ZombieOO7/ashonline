<div class="col-md-12 mrgn_tp_30 mrgn_bt_20 hide_on_search" >
    <div class="listing_select">
        <label class="lstng_lbl">{{ __('frontend.papers.filter_by') }} :</label>
        @if($detail->type == 1)
          <div class="df-select" >
              <select class="selectpicker filter" id="exam_type_id" data-category-id="{{ @$detail->id }}" data-url="{{ route('paper.filter') }} ">
                  {{-- <option value="all" selected>All Exam Types</option> --}}
                  <optgroup label="Exam Types" data-group="1" >
                    @foreach (@$examTypes as $type)
                      <option value="{{ $type->id }}">{{ $type->title }}</option>
                    @endforeach
                  </optgroup>
                  <optgroup label="Age" data-group="2">
                    @foreach (@$ages as $age)
                      <option value="{{ $age->id }}">{{ $age->title }}</option>
                    @endforeach
                  </optgroup>
              </select>
          </div>
          <div class="df-select">
              {!! Form::select('subject_id', @$subjects,null,['class' => 'selectpicker filter','data-url' => route('paper.filter'),'data-category-id' => @$detail->id,'id' => 'subject_id']); !!}
          </div>
        @else
          <div class="df-select">
            {!! Form::select('stage_id', @$stages,null,['class' => 'selectpicker filter','title' => 'All Levels','data-url' => route('paper.filter'),'data-category-id' => @$detail->id,'id' => 'stage_id']); !!}
          </div>
        @endif
    </div>
</div>
