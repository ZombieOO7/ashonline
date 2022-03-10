@if(is_file(@$paperCategory->thumb_path))
<img id="blah" src="{{ isset(@$paperCategory)? url(@$paperCategory->thumb_path):'' }}" alt="" height="50px;" width="50px;" />
@else
<img id="blah" src="{{ asset('images/default.png') }}" alt="" height="50px;" width="50px;" />
@endif