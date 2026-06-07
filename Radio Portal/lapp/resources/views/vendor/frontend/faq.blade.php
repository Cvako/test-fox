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

                <h1 class="section-title mb-3">{{ $h1_title }}</h1>

                <div class="accordion faqs" id="accordionExample">

                    @foreach ($faqs as $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-heading{{ $faq->id }}">
                                <button class="accordion-button @if (!$loop->first) collapsed @endif"
                                    type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapse{{ $faq->id }}"
                                    aria-expanded="@if ($loop->first) true @else false @endif"
                                    aria-controls="panelsStayOpen-collapse{{ $faq->id }}">
                                    {{ $faq->title }}
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapse{{ $faq->id }}"
                                class="accordion-collapse collapse @if ($loop->first) show @endif"
                                aria-labelledby="panelsStayOpen-heading{{ $faq->id }}"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {!! $faq->details !!}
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>


            </div>

        </div>

    </div>
    <!-- /Container -->
@endsection
