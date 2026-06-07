@extends('frontend::page')

@section('content')

<!-- Container -->
<div class="container mt-3">

    <div class="row">

        <div class="col-md-3 d-none d-md-block" id="menu-content">

            @include('frontend::inc.partials', ['type' => '1'])

        </div>

        <div class="col-md-9">

            @include('frontend::inc.partials', ['type' => '2'])
            
            @if ($settings['genres_on_home_page'] == '1')
            <!-- Genres -->
            @include('frontend::inc.partials', ['type' => '3'])
            <!-- /Genres -->
            @endif

            @if (!is_null($ad[4]))<div class="mb-3">{!! $ad[4] !!}</div>@endif

            <h1 class="section-title mb-3">{{ $h1_title }}</h1>

            @if(count($index_array['stations']) == '0')
            <div class="col-12">
                <h6 class="alert alert-no-record">@lang('general.no_record_found')</h6>
            </div>
            @endif
            
            @if(count($index_array['stations']) != '0')
                <div class="row radio-channels">

               @foreach ($index_array['stations'] as $station)

                @if(empty($station[2]))
                @php $station[2]='no_image.png'; @endphp
                @endif

                <div class="col-md-2 col-4 mb-3"><a href="{{ asset($settings['station_base'].'/'.$station[1]) }}"><img src="{{ asset('images/pixel.png') }}" data-src="{{ asset('images/stations/'.$station[2]) }}" width="300" height="300" alt="{{ $station[0] }}" class="img-fluid lazy"></a></div>

                @endforeach

            </div>
            @endif

            @if ($settings['genres_on_home_page'] == '2')
            <!-- Genres -->
            @include('frontend::inc.partials', ['type' => '3'])
            <!-- /Genres -->
            @endif

        </div>
    </div>

</div>
<!-- /Container -->

@endsection