@extends('adminlte::page')

@section('content')

@section('content_header', __('admin.seo_settings'))

@include('adminlte::inc.messages')

<div class="card p-2">
    <div class="m-1">

        {!! Form::open(['url' => url(env('ADMIN_URL').'/seo_settings'), 'method' => 'POST', 'files' => true]) !!}

        <span class="section-title mb-3">
            <i class="fas fa-code mr-1"></i> @lang('admin.home_page')
        </span>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('home_page_title_format', __('admin.custom_meta_title'), [], false)}}
                {{Form::text('home_page_title_format', $settings['home_page_title_format'], ['class' => 'form-control', 'placeholder' => __('admin.custom_meta_title')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('home_page_description_format', __('admin.custom_meta_description'))}}
                {{Form::textarea('home_page_description_format', $settings['home_page_description_format'], ['class' => 'form-control', 'rows' => '5', 'placeholder' => __('admin.custom_meta_description')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('home_page_h1_format', __('admin.h1_tag'), [], false)}}
                {{Form::text('home_page_h1_format', $settings['home_page_h1_format'], ['class' => 'form-control', 'placeholder' => __('admin.title')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <span class="section-title mb-3">
            <i class="fas fa-code mr-1"></i> @lang('admin.station_pages')
        </span>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('station_base', __('admin.base') . " <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('station_base', $settings['station_base'], ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.base')])}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('station_title_format', __('admin.custom_meta_title'), [], false)}}
                {{Form::text('station_title_format', $settings['station_title_format'], ['class' => 'form-control', 'placeholder' => __('admin.custom_meta_title')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%station_title%</a><a href="#">%genres%</a><a href="#">%countries%</a><a href="#">%languages%</a><a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('station_description_format', __('admin.custom_meta_description'))}}
                {{Form::textarea('station_description_format', $settings['station_description_format'], ['class' => 'form-control', 'rows' => '5', 'placeholder' => __('admin.custom_meta_description')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%station_title%</a><a href="#">%genres%</a><a href="#">%countries%</a><a href="#">%languages%</a><a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('custom_station_description', __('admin.custom_station_description'))}}
                {{Form::textarea('custom_station_description', $settings['custom_station_description'], ['class' => 'form-control', 'rows' => '5', 'placeholder' => __('admin.custom_station_description')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%station_title%</a><a href="#">%genres%</a><a href="#">%countries%</a><a href="#">%languages%</a><a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('station_h1_format', __('admin.h1_tag'), [], false)}}
                {{Form::text('station_h1_format', $settings['station_h1_format'], ['class' => 'form-control', 'placeholder' => __('admin.h1_tag')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%station_title%</a><a href="#">%genres%</a><a href="#">%countries%</a><a href="#">%languages%</a><a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <span class="section-title mb-3">
            <i class="fas fa-code mr-1"></i> @lang('admin.genre_pages')
        </span>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('genre_base', __('admin.base') . " <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('genre_base', $settings['genre_base'], ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.base')])}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('genres_title_format', __('admin.custom_meta_title'), [], false)}}
                {{Form::text('genres_title_format', $settings['genres_title_format'], ['class' => 'form-control', 'placeholder' => __('admin.custom_meta_title')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%genre_title%</a><a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('genres_description_format', __('admin.custom_meta_description'))}}
                {{Form::textarea('genres_description_format', $settings['genres_description_format'], ['class' => 'form-control', 'rows' => '5', 'placeholder' => __('admin.custom_meta_description')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%genre_title%</a><a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('genres_h1_format', __('admin.h1_tag'), [], false)}}
                {{Form::text('genres_h1_format', $settings['genres_h1_format'], ['class' => 'form-control', 'placeholder' => __('admin.h1_tag')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%genre_title%</a><a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <span class="section-title mb-3">
            <i class="fas fa-code mr-1"></i> @lang('admin.country_pages')
        </span>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('country_base', __('admin.base') . " <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('country_base', $settings['country_base'], ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.base')])}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('countries_title_format', __('admin.custom_meta_title'), [], false)}}
                {{Form::text('countries_title_format', $settings['countries_title_format'], ['class' => 'form-control', 'placeholder' => __('admin.custom_meta_title')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%country_title%</a><a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('countries_description_format', __('admin.custom_meta_description'))}}
                {{Form::textarea('countries_description_format', $settings['countries_description_format'], ['class' => 'form-control', 'rows' => '5', 'placeholder' => __('admin.custom_meta_description')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%country_title%</a><a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('countries_h1_format', __('admin.h1_tag'), [], false)}}
                {{Form::text('countries_h1_format', $settings['countries_h1_format'], ['class' => 'form-control', 'placeholder' => __('admin.h1_tag')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%country_title%</a><a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <span class="section-title mb-3">
            <i class="fas fa-code mr-1"></i> @lang('admin.language_pages')
        </span>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('language_base', __('admin.base') . " <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('language_base', $settings['language_base'], ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.base')])}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('languages_title_format', __('admin.custom_meta_title'), [], false)}}
                {{Form::text('languages_title_format', $settings['languages_title_format'], ['class' => 'form-control', 'placeholder' => __('admin.custom_meta_title')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%language_title%</a><a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('languages_description_format', __('admin.custom_meta_description'))}}
                {{Form::textarea('languages_description_format', $settings['languages_description_format'], ['class' => 'form-control', 'rows' => '5', 'placeholder' => __('admin.custom_meta_description')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%language_title%</a><a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('languages_h1_format', __('admin.h1_tag'), [], false)}}
                {{Form::text('languages_h1_format', $settings['languages_h1_format'], ['class' => 'form-control', 'placeholder' => __('admin.h1_tag')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%language_title%</a><a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <span class="section-title mb-3">
            <i class="fas fa-code mr-1"></i> @lang('admin.pages')
        </span>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('page_base', __('admin.base') . " <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('page_base', $settings['page_base'], ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.base')])}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('page_title_format', __('admin.custom_meta_title'), [], false)}}
                {{Form::text('page_title_format', $settings['page_title_format'], ['class' => 'form-control', 'placeholder' => __('admin.custom_meta_title')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%page_title%</a><a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('page_description_format', __('admin.custom_meta_description'))}}
                {{Form::textarea('page_description_format', $settings['page_description_format'], ['class' => 'form-control', 'rows' => '5', 'placeholder' => __('admin.custom_meta_description')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%page_title%</a><a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('page_h1_format', __('admin.h1_tag'), [], false)}}
                {{Form::text('page_h1_format', $settings['page_h1_format'], ['class' => 'form-control', 'placeholder' => __('admin.h1_tag')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%page_title%</a><a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <span class="section-title mb-3">
            <i class="fas fa-code mr-1"></i> @lang('admin.browse_genres_page')
        </span>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('browse_genres_base', __('admin.base') . " <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('browse_genres_base', $settings['browse_genres_base'], ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.base')])}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('browse_genres_title', __('admin.custom_meta_title'), [], false)}}
                {{Form::text('browse_genres_title', $settings['browse_genres_title'], ['class' => 'form-control', 'placeholder' => __('admin.custom_meta_title')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('browse_genres_description', __('admin.custom_meta_description'))}}
                {{Form::textarea('browse_genres_description', $settings['browse_genres_description'], ['class' => 'form-control', 'rows' => '5', 'placeholder' => __('admin.custom_meta_description')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('browse_genres_h1_title', __('admin.h1_tag'), [], false)}}
                {{Form::text('browse_genres_h1_title', $settings['browse_genres_h1_title'], ['class' => 'form-control', 'placeholder' => __('admin.h1_tag')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <span class="section-title mb-3">
            <i class="fas fa-code mr-1"></i> @lang('admin.browse_countries_page')
        </span>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('browse_countries_base', __('admin.base') . " <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('browse_countries_base', $settings['browse_countries_base'], ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.base')])}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('browse_countries_title', __('admin.custom_meta_title'), [], false)}}
                {{Form::text('browse_countries_title', $settings['browse_countries_title'], ['class' => 'form-control', 'placeholder' => __('admin.custom_meta_title')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('browse_countries_description', __('admin.custom_meta_description'))}}
                {{Form::textarea('browse_countries_description', $settings['browse_countries_description'], ['class' => 'form-control', 'rows' => '5', 'placeholder' => __('admin.custom_meta_description')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('browse_countries_h1_title', __('admin.h1_tag'), [], false)}}
                {{Form::text('browse_countries_h1_title', $settings['browse_countries_h1_title'], ['class' => 'form-control', 'placeholder' => __('admin.h1_tag')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <span class="section-title mb-3">
            <i class="fas fa-code mr-1"></i> @lang('admin.browse_languages_page')
        </span>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('browse_languages_base', __('admin.base') . " <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('browse_languages_base', $settings['browse_languages_base'], ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.base')])}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('browse_languages_title', __('admin.custom_meta_title'), [], false)}}
                {{Form::text('browse_languages_title', $settings['browse_languages_title'], ['class' => 'form-control', 'placeholder' => __('admin.custom_meta_title')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('browse_languages_description', __('admin.custom_meta_description'))}}
                {{Form::textarea('browse_languages_description', $settings['browse_languages_description'], ['class' => 'form-control', 'rows' => '5', 'placeholder' => __('admin.custom_meta_description')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('browse_languges_h1_title', __('admin.h1_tag'), [], false)}}
                {{Form::text('browse_languges_h1_title', $settings['browse_languges_h1_title'], ['class' => 'form-control', 'placeholder' => __('admin.h1_tag')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <span class="section-title mb-3">
            <i class="fas fa-code mr-1"></i> @lang('admin.faq_page')
        </span>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('faq_slug', __('admin.base') . " <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('faq_slug', $settings['faq_slug'], ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.base')])}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('faq_title', __('admin.custom_meta_title'), [], false)}}
                {{Form::text('faq_title', $settings['faq_title'], ['class' => 'form-control', 'placeholder' => __('admin.custom_meta_title')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('faq_description', __('admin.custom_meta_description'))}}
                {{Form::textarea('faq_description', $settings['faq_description'], ['class' => 'form-control', 'rows' => '5', 'placeholder' => __('admin.custom_meta_description')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('faq_h1_title', __('admin.h1_tag'), [], false)}}
                {{Form::text('faq_h1_title', $settings['faq_h1_title'], ['class' => 'form-control', 'placeholder' => __('admin.title')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>
        
        <span class="section-title mb-3">
            <i class="fas fa-code mr-1"></i> @lang('admin.contact_page')
        </span>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('contact_slug', __('admin.base') . " <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('contact_slug', $settings['contact_slug'], ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.base')])}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('contact_title', __('admin.custom_meta_title'), [], false)}}
                {{Form::text('contact_title', $settings['contact_title'], ['class' => 'form-control', 'placeholder' => __('admin.custom_meta_title')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('contact_description', __('admin.custom_meta_description'))}}
                {{Form::textarea('contact_description', $settings['contact_description'], ['class' => 'form-control', 'rows' => '5', 'placeholder' => __('admin.custom_meta_description')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('contact_h1_title', __('admin.h1_tag'), [], false)}}
                {{Form::text('contact_h1_title', $settings['contact_h1_title'], ['class' => 'form-control', 'placeholder' => __('admin.title')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>
        
        <span class="section-title mb-3">
            <i class="fas fa-code mr-1"></i> @lang('admin.submission_page')
        </span>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('submission_slug', __('admin.base') . " <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('submission_slug', $settings['submission_slug'], ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.base')])}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('submission_title', __('admin.custom_meta_title'), [], false)}}
                {{Form::text('submission_title', $settings['submission_title'], ['class' => 'form-control', 'placeholder' => __('admin.custom_meta_title')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('submission_description', __('admin.custom_meta_description'))}}
                {{Form::textarea('submission_description', $settings['submission_description'], ['class' => 'form-control', 'rows' => '5', 'placeholder' => __('admin.custom_meta_description')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('submission_h1_title', __('admin.h1_tag'), [], false)}}
                {{Form::text('submission_h1_title', $settings['submission_h1_title'], ['class' => 'form-control', 'placeholder' => __('admin.title')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>
        
        <span class="section-title mb-3">
            <i class="fas fa-code mr-1"></i> @lang('admin.history_page')
        </span>

        <div class="row mb-3">
            <div class="col-md-12">
                <div class="icheck-wetasphalt">
                    {{Form::checkbox('no_index_history', null, $settings['no_index_history'], ['id' => 'no_index_history'])}}
                    {{Form::label('no_index_history', __('admin.no_index'))}}
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('history_base', __('admin.base') . " <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('history_base', $settings['history_base'], ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.base')])}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('listen_history_title', __('admin.custom_meta_title'), [], false)}}
                {{Form::text('listen_history_title', $settings['listen_history_title'], ['class' => 'form-control', 'placeholder' => __('admin.custom_meta_title')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('listen_history_description', __('admin.custom_meta_description'))}}
                {{Form::textarea('listen_history_description', $settings['listen_history_description'], ['class' => 'form-control', 'rows' => '5', 'placeholder' => __('admin.custom_meta_description')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('listen_history_h1_title', __('admin.h1_tag'), [], false)}}
                {{Form::text('listen_history_h1_title', $settings['listen_history_h1_title'], ['class' => 'form-control', 'placeholder' => __('admin.title')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <span class="section-title mb-3">
            <i class="fas fa-code mr-1"></i> @lang('admin.favorites_page')
        </span>

        <div class="row mb-3">
            <div class="col-md-12">
                <div class="icheck-wetasphalt">
                    {{Form::checkbox('no_index_favorites', null, $settings['no_index_favorites'], ['id' => 'no_index_favorites'])}}
                    {{Form::label('no_index_favorites', __('admin.no_index'))}}
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('favorites_base', __('admin.base') . " <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('favorites_base', $settings['favorites_base'], ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.base')])}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('favorites_title', __('admin.custom_meta_title'), [], false)}}
                {{Form::text('favorites_title', $settings['favorites_title'], ['class' => 'form-control', 'placeholder' => __('admin.custom_meta_title')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('favorites_description', __('admin.custom_meta_description'))}}
                {{Form::textarea('favorites_description', $settings['favorites_description'], ['class' => 'form-control', 'rows' => '5', 'placeholder' => __('admin.custom_meta_description')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('favorites_h1_title', __('admin.h1_tag'), [], false)}}
                {{Form::text('favorites_h1_title', $settings['favorites_h1_title'], ['class' => 'form-control', 'placeholder' => __('admin.title')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        {{ Form::submit(__('admin.submit'), ['class' => 'btn button-green']) }}
        {!! Form::close() !!}

    </div>
</div>

@stop
