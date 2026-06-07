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

                <div class="bg-white rounded p-3 pb-2">


                    <div id="contact-form-section" data-error="@lang('general.error')" data-recaptcha-error="@lang('general.recaptcha_error')">

                        <form id="contact-form">

                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label for="name" class="form-label">@lang('general.name') <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label for="email" class="form-label">@lang('general.email') <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label for="subject" class="form-label">@lang('general.subject') <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="subject" name="subject" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label for="message" class="form-label">@lang('general.message') <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                                </div>
                            </div>

                            @if ($settings['enable_google_recaptcha'] == '1')
                                <div class="g-recaptcha mb-2 py-1"
                                    data-sitekey="{{ $settings['google_recaptcha_site_key'] }}"></div>
                            @endif

                        </form>

                        <div id="contact-form-result"></div>

                        <button type="submit" class="btn text-white submit-button mb-2"
                            onclick="contact_form()">@lang('general.submit')</button>

                    </div>

                </div>

            </div>

        </div>

    </div>
    <!-- /Container -->
@endsection
