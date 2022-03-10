<div class="main_brdcrmb">
	<div class="container">
        <div class="row">
            <div class="col-md-12 frtp_ttl">
                <nav class="bradcrumb_pr" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb_v2">
                        <li class="breadcrumb-item">
                            <a href="{{route('firstpage')}}">{{__('frontend.home')}}</a>
                        </li>
                        @forelse($routeArray as $key => $routeData)
                            <li class="breadcrumb-item">
                                <a href="{{@$routeData['route']}}">{{@$routeData['title']}}</a>
                            </li>
                        @empty
                        @endforelse
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>