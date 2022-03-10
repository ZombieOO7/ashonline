@if(@$parent->is_tuition_parent == config('constant.is_tution_parent')[0])
    {{@config('constant.is_tution_parent')[0]}}
@else
    {{@config('constant.is_tution_parent')[1]}}
@endif