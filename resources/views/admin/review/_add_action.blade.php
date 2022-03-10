    @if((\Auth::guard('admin')->user()->hasRole('superadmin')||\Auth::guard('admin')->user()->can('review active inactive')))
    <select class="form-control published_unpublished" id="{{@$review->id}}" data-url="{{ route('review_active_inactive', [@$review->id]) }}" data-table_name="review_table">
        <option value="">{{__('formname.select_action')}}</option>
        <option value="{{config('constant.review_active')}}" {{(@$review->status == config('constant.review_active_value'))?'selected':''}}>{{__('formname.review.publish')}}</option>
        <option value="{{config('constant.review_inactive')}}" {{(@$review->status == config('constant.review_inactive_value'))?'selected':''}}>{{__('formname.review.unpublish')}}</option>
    </select>
    @endif