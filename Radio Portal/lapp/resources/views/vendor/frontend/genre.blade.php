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

            <h1 class="section-title mb-3">{{ $h1_title }}</h1>

            @if($stations->isEmpty())
            <div class="col-12">
                <h6 class="alert alert-no-record">@lang('general.no_record_found')</h6>
            </div>
            @endif

            <div class="row radio-channels">

                @foreach ($stations as $station)

                @if(empty($station->image))
                @php $station->image='no_image.png'; @endphp
                @endif

                <div class="col-md-2 col-4 mb-3"><a href="{{ asset($settings['station_base'].'/'.$station->slug) }}"><img src="{{ asset('images/pixel.png') }}" data-src="{{ asset('images/stations/'.$station->image) }}" width="300" height="300" alt="{{ $station->title }}" class="img-fluid lazy"></a></div>

                @endforeach

            </div>

            <!-- Pagination -->
            <div class="d-flex">
                <div class="site-pagination-{{ $settings['theme'] }} mx-auto">
                    {{ $stations->onEachSide(0)->links() }}
                </div>
            </div>
            <!-- /Pagination -->

        </div>
    </div>

</div>
<!-- /Container -->

@endsection