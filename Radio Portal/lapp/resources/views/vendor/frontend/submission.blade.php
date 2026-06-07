@extends('frontend::page')

@section('content')
    @push('assets_head')
        <!-- bootstrap-select -->
        <link href="{{ asset('assets/css/bootstrap-select.min.css') }}" rel="stylesheet">
    @endpush

    @push('assets_footer')
        <!-- bootstrap-select -->
        <script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
    @endpush

    <!-- Container -->
    <div class="container mt-3">

        <div class="row">

            <div class="col-md-3 d-none d-md-block" id="menu-content">

                @include('frontend::inc.partials', ['type' => '1'])

            </div>

            <div class="col-md-9 mb-3">

                @include('frontend::inc.partials', ['type' => '2'])

                <h1 class="section-title mb-3">{{ $h1_title }}</h1>

                <div class="bg-white rounded p-3 pb-2">

                    <div id="submission-section" data-error="@lang('general.error')" data-recaptcha-error="@lang('general.recaptcha_error')">

                        <form id="submission-form" enctype="multipart/form-data">

                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label for="name" class="form-label">@lang('general.name'): <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label for="email" class="form-label">@lang('general.email'): <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label for="title" class="form-label">@lang('general.title'): <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label for="stream_url" class="form-label">@lang('general.stream_url'): <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="stream_url" name="stream_url" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label for="image" class="form-label">@lang('general.image'): <span
                                            class="text-danger">*</span></label>
                                    <input type="file" accept="image/*" class="form-control mb-1" id="image"
                                        name="image">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label for="description" class="form-label">@lang('general.description'): <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" rows="3" id="description" name="description"></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label for="details" class="form-label">@lang('general.detailed_description'):</label>
                                    <textarea class="form-control" rows="5" id="details" name="details"></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="genres" class="form-label">@lang('admin.genres') <span
                                            class="text-danger">*</span></label>
                                    {!! Form::select('genres[]', $genres, old('genres'), [
                                        'class' => 'form-control selectpicker',
                                        'data-max-options' => '3',
                                        'required' => 'required',
                                        'multiple' => 'multiple',
                                        'data-live-search' => 'true',
                                        'id' => 'genres',
                                    ]) !!}
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="countries" class="form-label">@lang('admin.countries')</label>
                                    {!! Form::select('countries[]', $countries, old('countries'), [
                                        'class' => 'form-control selectpicker',
                                        'data-max-options' => '3',
                                        'multiple' => 'multiple',
                                        'data-live-search' => 'true',
                                        'id' => 'countries',
                                    ]) !!}
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <label for="languages" class="form-label">@lang('admin.languages')</label>
                                    {!! Form::select('languages[]', $languages, old('languages'), [
                                        'class' => 'form-control selectpicker',
                                        'data-max-options' => '3',
                                        'multiple' => 'multiple',
                                        'data-live-search' => 'true',
                                        'id' => 'languages',
                                    ]) !!}
                                </div>
                            </div>

                            @if ($settings['enable_google_recaptcha'] == '1')
                                <div class="g-recaptcha mb-2 py-1"
                                    data-sitekey="{{ $settings['google_recaptcha_site_key'] }}"></div>
                            @endif

                        </form>

                        <button type="submit" class="btn text-white comment-button mb-2"
                            onclick="submission_form_control()">@lang('general.submit')</button>

                        <div id="submission-result"></div>

                    </div>

                </div>

            </div>

        </div>

    </div>
    <!-- /Container -->
@endsection
