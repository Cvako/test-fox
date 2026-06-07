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

            <h1 class="section-title mb-3">{{ $section_title }}</h1>

            @if($rows->isEmpty())
            <div class="col-12">
                <h6 class="alert alert-no-record">@lang('general.no_record_found')</h6>
            </div>
            @endif

            <div class="row radio-channels">
                @php $previous = null; @endphp
                @foreach ($rows as $genre)
                @php
                $firstletter = substr($genre->title, 0, 1);
                if($previous !== $firstletter)
                echo "<div class=\"col-md-12 col-12 mb-3 letter\">$firstletter</div>";
                $previous = $firstletter;
                @endphp
                <div class="col-md-4 col-6 mb-3"><a href="{{ asset($section_base.'/'.$genre->slug) }}" class="text-white">{{ $genre->title }}</a></div>

                @endforeach

            </div>

        </div>
    </div>

</div>
<!-- /Container -->

@endsection