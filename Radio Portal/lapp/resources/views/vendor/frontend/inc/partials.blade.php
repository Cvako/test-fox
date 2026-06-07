@if($type == '1')

<div class="shadow-sm p-3 rounded mb-3 site-color-{{ $settings['theme'] }}">

    <span class="filter-title">@lang('general.genres')</span>

    <ul class="list-unstyled genre-list mt-2 mb-0">
        @foreach ($left_array['genres'] as $genre)
        <li><a href="{{ asset($settings['genre_base'].'/'.$genre[1]) }}">{{$genre[0]}} ({{$genre[2]}})</a></li>
        @endforeach
        <li class="mt-2"><a href="{{ asset($settings['browse_genres_base']) }}" class="text-decoration-underline fw-bold">@lang('general.browse_genres')</a></li>
    </ul>

</div>

<div class="shadow-sm p-3 rounded mb-3 site-color-{{ $settings['theme'] }}">

    <span class="filter-title">@lang('general.countries')</span>

    <ul class="list-unstyled genre-list mt-2 mb-0">
        @foreach ($left_array['countries'] as $country)
        <li><a href="{{ asset($settings['country_base'].'/'.$country[1]) }}">{{$country[0]}} ({{$country[2]}})</a></li>
        @endforeach
        <li class="mt-2"><a href="{{ asset($settings['browse_countries_base']) }}" class="text-decoration-underline fw-bold">@lang('general.browse_countries')</a></li>
    </ul>

</div>

<div class="shadow-sm p-3 rounded mb-3 site-color-{{ $settings['theme'] }}">

    <span class="filter-title">@lang('general.languages')</span>

    <ul class="list-unstyled genre-list mt-2 mb-0">
        @foreach ($left_array['languages'] as $language)
        <li><a href="{{ asset($settings['language_base'].'/'.$language[1]) }}">{{$language[0]}} ({{$language[2]}})</a></li>
        @endforeach
        <li class="mt-2"><a href="{{ asset($settings['browse_languages_base']) }}" class="text-decoration-underline fw-bold">@lang('general.browse_languages')</a></li>
    </ul>

</div>

@endif

@if($type == '2')

@if (!is_null($ad[3]))<div class="mb-3">{!! $ad[3] !!}</div>@endif

<form method="post" action="{{ asset('/search') }}" class="d-flex shadow-sm p-2 bg-white rounded mb-3">
    {{ csrf_field() }}
    <input class="form-control search-form me-2 ps-1" id="search-form" name="term" type="search" placeholder="@lang('general.search_radio_stations')" aria-label="@lang('general.search_radio_stations')">
    <button class="btn search-btn" type="submit" aria-label="@lang('general.search_radio_stations')">{!! custom_icon('search') !!}</button>
</form>

@endif

@if($type == '3')
@if(count($index_array['genres']) != '0')

@if (!is_null($ad[5]))<div class="mb-3">{!! $ad[5] !!}</div>@endif
<h2 class="section-title mb-3 mt-2">@lang('general.browse_by_genre')</h2>

<div class="row">

    @foreach ($index_array['genres'] as $home_genre)

    @if(empty($home_genre[2]))
    @php $home_genre[2]='no_image.png'; @endphp
    @endif

    <div class="col-md-4 col-6 mb-3">
        <div class="position-relative">
            <a href="{{ asset($settings['genre_base'].'/'.$home_genre[1]) }}">
                <img src="{{ asset('images/genres/'.$home_genre[2]) }}" width="516" height="258" alt="{{ $home_genre[0] }}" class="img-fluid rounded">
                <span class="genre-image d-block mt-1">{{ $home_genre[0] }}</span>
            </a>
        </div>
    </div>

    @endforeach

</div>
@endif

@endif
