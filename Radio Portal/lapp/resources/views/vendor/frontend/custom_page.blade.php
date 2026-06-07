@extends('frontend::page')

@section('content')

<!-- Container -->
<div class="container mt-3">

    <div class="row">

        <div class="col-md-3 d-none d-md-block" id="menu-content">

            @include('frontend::inc.partials', ['type' => '1'])

        </div>

        <div class="col-md-9 mb-3">

            @include('frontend::inc.partials', ['type' => '2'])

            <div class="bg-white page-details rounded p-3">

                <h1 class="section-title text-dark">{{ $h1_title }}</h1>
                {!! $page->content !!}

            </div>

        </div>

    </div>

</div>
<!-- /Container -->

@endsection