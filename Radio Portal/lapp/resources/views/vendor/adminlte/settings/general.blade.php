@extends('adminlte::page')

@section('content')

@section('content_header', __('admin.general_settings'))

@include('adminlte::inc.messages')

<div class="card p-2">
    <div class="m-1">

        {!! Form::open(['url' => url(env('ADMIN_URL').'/general_settings'), 'method' => 'POST', 'files' => true]) !!}

        <span class="section-title mb-3">
            <i class="fas fa-sliders-h mr-1"></i> @lang('admin.general_settings')
        </span>
        
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="languages">@lang('admin.site_language')</label>
                {!! Form::select('site_language', $languages, $settings['site_language'], ['class' => 'form-control selectpicker', 'data-live-search' => 'true', 'id' => 'site_language' ]) !!}
            </div>
            
            <div class="col-md-3">
                <label for="languages">@lang('admin.theme')</label>
                {!! Form::select('theme', $themes, $settings['theme'], ['class' => 'form-control selectpicker', 'data-live-search' => 'true', 'id' => 'theme' ]) !!}
            </div>

            <div class="col-md-3">
                {{Form::label('meta_theme_color', __('admin.meta_theme_color'), [], false)}}
                {{Form::text('meta_theme_color', $settings['meta_theme_color'], ['class' => 'form-control my-colorpicker2', 'placeholder' => __('admin.meta_theme_color')])}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('site_title', __('admin.site_title') . " <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('site_title', $settings['site_title'], ['class' => 'form-control', 'required' => 'required', 'maxlength' => 255, 'placeholder' => __('admin.site_title')])}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('site_description', __('admin.site_description') . " <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::textarea('site_description', $settings['site_description'], ['class' => 'form-control', 'required' => 'required', 'maxlength' => 255, 'rows' => '5', 'placeholder' => __('admin.site_description')])}}
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('admin_email', __('admin.admin_email') . " <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('admin_email', $settings['admin_email'], ['class' => 'form-control', 'required' => 'required', 'maxlength' => 255, 'placeholder' => __('admin.admin_email')])}}
            </div>
        </div>
        
        
        <div class="row mb-3">
            <div class="col-md-3">
                {{Form::label('twitter_account', __('admin.twitter_account'), [], false)}}
                {{Form::text('twitter_account', $settings['twitter_account'], ['class' => 'form-control', 'placeholder' => __('admin.twitter_account')])}}
            </div>
            <div class="col-md-3">
                {{Form::label('facebook_page', __('admin.facebook_page'), [], false)}}
                {{Form::text('facebook_page', $settings['facebook_page'], ['class' => 'form-control', 'placeholder' => __('admin.facebook_page')])}}
            </div>
            <div class="col-md-3">
                {{Form::label('telegram_page', __('admin.telegram_page'), [], false)}}
                {{Form::text('telegram_page', $settings['telegram_page'], ['class' => 'form-control', 'placeholder' => __('admin.telegram_page')])}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('cronjob_url', __('admin.cronjob_url') . " <a href=\"".asset(env('ADMIN_URL').'/general_settings')."?cronjob_code\"><sup class=\"text-dark\"><u>".__('admin.generate_new_link')."</u></sup></a>", [], false)}}
                {{Form::text('cronjob_url', asset('/cronjob'.'/'.$settings['cronjob_code']), ['class' => 'form-control', 'readonly' => 'true'])}}
            
          <div class="callout callout-dark mt-3 mb-0 py-2 pl-2">
<p><i class="fas fa-info-circle"></i> <b>@lang('admin.sample_curl_command'):</b> curl --silent {{ asset('/cronjob'.'/'.$settings['cronjob_code']) }} >/dev/null 2>&1</p>
</div>
          
            </div>
        </div>

        <span class="section-title mb-3">
            <i class="fas fa-sliders-h mr-1"></i> @lang('admin.image_settings')
        </span>

        <div class="row mb-3">
            <div class="col-md-4">
                <label>@lang('admin.site_logo') <sup><span class="right badge size-sup">600x148</span></sup></label>
                <div class="custom-file custom-file-logo">
                    {{Form::label('logo', __('admin.choose_image'), ['class' => 'custom-file-label'])}}
                    {{Form::file('logo', ['class' => 'custom-file-input', 'id' => 'browse-logo'])}}
            </div>
            <a href="{{ asset('/images/logo.png') }}?r={{Str::random(40)}}" data-toggle="lightbox" class="preview d-table mt-1">@lang('admin.preview')</a>
            </div>
            <div class="col-md-4">
                <label>@lang('admin.favicon') <sup><span class="right badge size-sup">192x192</span></sup></label>
                <div class="custom-file custom-file-favicon">
                    {{Form::label('favicon', __('admin.choose_image'), ['class' => 'custom-file-label'])}}
                    {{Form::file('favicon', ['class' => 'custom-file-input', 'id' => 'browse-favicon'])}}
                </div>
            <a href="{{ asset('/images/favicon.png') }}?r={{Str::random(40)}}" data-toggle="lightbox" class="preview d-table mt-1">@lang('admin.preview')</a>
            </div>
            <div class="col-md-4">
                <label>@lang('admin.default_share_image') <sup><span class="right badge size-sup">600x315</span></sup></label>
                <div class="custom-file custom-file-share">
                    {{Form::label('share', __('admin.choose_image'), ['class' => 'custom-file-label'])}}
                    {{Form::file('share', ['class' => 'custom-file-input', 'id' => 'browse-share'])}}
                </div>
                <a href="{{ asset('/images/default_share_image.png') }}?r={{Str::random(40)}}" data-toggle="lightbox" class="preview d-table mt-1">@lang('admin.preview')</a>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label>@lang('admin.default_station_image') <sup><span class="right badge size-sup">300x300</span></sup></label>
                <div class="custom-file custom-file-station">
                    {{Form::label('station', __('admin.choose_image'), ['class' => 'custom-file-label'])}}
                    {{Form::file('station', ['class' => 'custom-file-input', 'id' => 'browse-station'])}}
                </div>
                <a href="{{ asset('/images/stations/no_image.png') }}?r={{Str::random(40)}}" data-toggle="lightbox" class="preview d-table mt-1">@lang('admin.preview')</a>
            </div>
            <div class="col-md-4">
                <label>@lang('admin.default_genre_image') <sup><span class="right badge size-sup">516x258</span></sup></label>
                <div class="custom-file custom-file-genre">
                    {{Form::label('genre', __('admin.choose_image'), ['class' => 'custom-file-label'])}}
                    {{Form::file('genre', ['class' => 'custom-file-input', 'id' => 'browse-genre'])}}
                </div>
                <a href="{{ asset('/images/genres/no_image.png') }}?r={{Str::random(40)}}" data-toggle="lightbox" class="preview d-table mt-1">@lang('admin.preview')</a>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <div class="icheck-wetasphalt">
                    {{Form::checkbox('save_as_webp', null, $settings['save_as_webp'], ['id' => 'save_as_webp'])}}
                    {{Form::label('save_as_webp', __('admin.save_as_webp'))}}
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                {{Form::label('image_quality', __('admin.image_quality') . " <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('image_quality', $settings['image_quality'], ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.image_quality')])}}
            </div>
        </div>

        <span class="section-title mb-3">
            <i class="fas fa-sliders-h mr-1"></i> @lang('admin.google_recaptcha')
        </span>

        <div class="row mb-3">
            <div class="col-md-4">
                <div class="icheck-wetasphalt">
                    {{Form::checkbox('enable_google_recaptcha', null, $settings['enable_google_recaptcha'], ['id' => 'enable_google_recaptcha'])}}
                    {{Form::label('enable_google_recaptcha', __('admin.enable_google_recaptcha'))}}
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('google_recaptcha_site_key', __('admin.google_recaptcha_site_key'), [], false)}}
                {{Form::text('google_recaptcha_site_key', $settings['google_recaptcha_site_key'], ['class' => 'form-control', 'placeholder' => __('admin.google_recaptcha_site_key')])}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('google_recaptcha_secret_key', __('admin.google_recaptcha_secret_key'), [], false)}}
                {{Form::text('google_recaptcha_secret_key', $settings['google_recaptcha_secret_key'], ['class' => 'form-control', 'placeholder' => __('admin.google_recaptcha_secret_key')])}}
            </div>
        </div>

        <span class="section-title mb-3">
            <i class="fas fa-sliders-h mr-1"></i> @lang('admin.html_codes')
        </span>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('before_head_tag', __('admin.before_head_tag'), [], false)}}
                {{Form::textarea('before_head_tag', $settings['before_head_tag'], ['class' => 'form-control', 'rows' => '4', 'placeholder' => __('admin.before_head_tag')])}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('after_head_tag', __('admin.after_head_tag'), [], false)}}
                {{Form::textarea('after_head_tag', $settings['after_head_tag'], ['class' => 'form-control', 'rows' => '4', 'placeholder' => __('admin.after_head_tag')])}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('before_body_end_tag', __('admin.before_body_end_tag'), [], false)}}
                {{Form::textarea('before_body_end_tag', $settings['before_body_end_tag'], ['class' => 'form-control', 'rows' => '4', 'placeholder' => __('admin.before_body_end_tag')])}}
            </div>
        </div>

        <span class="section-title mb-3">
            <i class="fas fa-sliders-h mr-1"></i> @lang('admin.other_settings')
        </span>

        <div class="row mb-3">
            <div class="col-md-3">
                <label for="languages">@lang('admin.api_source')</label>
                {!! Form::select('api_source', $api_sources, $settings['api_source'], ['class' => 'form-control selectpicker', 'data-live-search' => 'true', 'id' => 'api_source' ]) !!}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <div class="icheck-wetasphalt">
                    {{Form::checkbox('show_cookie_bar', null, $settings['show_cookie_bar'], ['id' => 'show_cookie_bar'])}}
                    {{Form::label('show_cookie_bar', __('admin.show_cookie_bar'))}}
                </div>
            </div>

            <div class="col-md-3">
                <div class="icheck-wetasphalt">
                    {{Form::checkbox('enable_faq', null, $settings['enable_faq'], ['id' => 'enable_faq'])}}
                    {{Form::label('enable_faq', __('admin.enable_faq'))}}
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="icheck-wetasphalt">
                    {{Form::checkbox('radio_submission', null, $settings['radio_submission'], ['id' => 'radio_submission'])}}
                    {{Form::label('radio_submission', __('admin.radio_submission'))}}
                </div>
            </div>
        </div>

        <div class="row mb-3">

            <div class="col-md-3">
                {{Form::label('genres_on_home_page', __('admin.genres_on_home_page'), [], false)}}
                {{Form::select('genres_on_home_page', array('1' => __('admin.above_featured_stations'), '2' => __('admin.under_featured_stations')), $settings['genres_on_home_page'], ['class' => 'form-control', 'id' => 'genres_on_home_page'])}}
            </div>

            <div class="col-md-3">
                {{Form::label('records_per_page', __('admin.records_per_page') . " <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('records_per_page', $settings['records_per_page'], ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.records_per_page')])}}
            </div>

            <div class="col-md-3">
                {{Form::label('sitemap_records_per_page', __('admin.sitemap_records_per_page') . " <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('sitemap_records_per_page', $settings['sitemap_records_per_page'], ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.sitemap_records_per_page')])}}
            </div>

            <div class="col-md-3">
                {{Form::label('cookie_prefix', __('admin.cookie_prefix') . " <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('cookie_prefix', $settings['cookie_prefix'], ['class' => 'form-control', 'required' => 'required', 'maxlength' => 15, 'placeholder' => __('admin.cookie_prefix')])}}
            </div>

        </div>

        {{ Form::submit(__('admin.submit'), ['class' => 'btn button-green']) }}
        {!! Form::close() !!}

    </div>
</div>


@stop
