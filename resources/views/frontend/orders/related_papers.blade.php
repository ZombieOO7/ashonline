@forelse (@$relatedProducts as $item)
    <div class="col-lg-12 related_product">
        <div class="d-flex justify-content-between related_title">
            @if ($loop->first)
                <h4>{{ __('frontend.papers.related_papers')}}</h4>
            @endif
            <div class="sbct_ttle">
                @if(@$item['papers']->count() > 0)
                <h5>{{ @$item['title']}}</h5>
                    <a href="{{ route('paper.detail',['slug' => @$item['slug']]) }}" class="view_all">{{ __('frontend.papers.view_all') }}</a>
                @endif
            </div>
        </div>
        <!-- PAPERS LIST STARTS HERE -->
        @include('frontend.papers.list',['papers' => @$item['papers']])
        <!-- PAPERS LIST ENDS HERE -->
    </div>
@empty
    <div class="col-lg-12 related_product">
        <h4>{{ __('frontend.papers.no_related_papers_available') }}</h4>    
    </div>
@endforelse