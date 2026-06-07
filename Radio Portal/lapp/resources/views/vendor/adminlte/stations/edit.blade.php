@extends('adminlte::page')

@section('content_header', __('admin.edit_station'))

@section('content')

@include('adminlte::inc.messages')

<div class="card p-2">
    <div class="m-1">

        {!! Form::open(['action' => ['App\Http\Controllers\StationController@update', $row->id], 'method' => 'PUT', 'files' => true]) !!}

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('title', __('admin.title')." <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('title', $row->title, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.title')])}}
            </div>
        </div>
           
        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('slug', __('admin.slug'))}}
                {{Form::text('slug', $row->slug, ['class' => 'form-control', 'placeholder' => __('admin.slug')])}}
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('description', __('admin.description'))}}
                {{Form::textarea('description', $row->description, ['class' => 'form-control', 'rows' => '5', 'placeholder' => __('admin.description')])}}
                 <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%station_title%</a><a href="#">%genres%</a><a href="#">%countries%</a><a href="#">%languages%</a><a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('details', __('admin.details'))}}
                {{Form::textarea('details', $row->details, ['class' => 'textarea textarea-style', 'id' => 'details', 'placeholder' => __('admin.details')])}}
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('stream_url', "Stream URL <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('stream_url', $row->stream_url, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Stream URL'])}}
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-12">
            <label for="genres">@lang('admin.genres') <span class="text-danger">*</span></label>
            {!! Form::select('genres[]', $genres, old('genres') ? old('genres') : $row->genres->pluck('id')->toArray(), ['class' => 'form-control selectpicker', 'required' => 'required', 'multiple' => 'multiple', 'data-live-search' => 'true', 'id' => 'genres' ]) !!}
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-12">
            <label for="countries">@lang('admin.countries')</label>
            {!! Form::select('countries[]', $countries, old('countries') ? old('countries') : $row->countries->pluck('id')->toArray(), ['class' => 'form-control selectpicker', 'multiple' => 'multiple', 'data-live-search' => 'true', 'id' => 'countries' ]) !!}
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-12">
            <label for="languages">@lang('admin.languages')</label>
            {!! Form::select('languages[]', $languages, old('languages') ? old('languages') : $row->languages->pluck('id')->toArray(), ['class' => 'form-control selectpicker', 'multiple' => 'multiple', 'data-live-search' => 'true', 'id' => 'languages' ]) !!}
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-3">
                <label>@lang('admin.image')</label>
                <div class="custom-file">
                    {{Form::label('image', __('admin.choose_image'), ['class' => 'custom-file-label'])}}
                    {{Form::file('image', ['class' => 'custom-file-input', 'id' => 'browse-image'])}}
                </div>
            </div>
        </div>

        <div class="row mb-3">
            
            <div class="col-md-4">
                {{Form::label('page_views', __('admin.page_views')." <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('page_views', $row->page_views, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.page_views')])}}
            </div>
            
            <div class="col-md-4">
                {{Form::label('up_votes', __('admin.up_votes')." <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('up_votes', $row->up_votes, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.up_votes')])}}
            </div>
            
            <div class="col-md-4">
                {{Form::label('down_votes', __('admin.down_votes')." <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('down_votes', $row->down_votes, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.down_votes')])}}
            </div>
            
        </div>

        <div class="row mb-3">

            <div class="col-md-3">
                <div class="icheck-wetasphalt">
                    {{Form::checkbox('status', null, $row->status, ['id' => 'status'])}}
                    {{Form::label('status', __('admin.active'))}}
                </div>
            </div>
            
         <div class="col-md-3">
                <div class="icheck-wetasphalt">
                    {{Form::checkbox('home_page', null, $row->home_page, ['id' => 'home_page'])}}
                    {{Form::label('home_page', __('admin.home_page'))}}
                </div>
            </div>            

        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label class="section-head">@lang('admin.seo_settings')</label>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('custom_title', __('admin.custom_meta_title'))}}
                {{Form::text('custom_title', $row->custom_title, ['class' => 'form-control', 'placeholder' => __('admin.custom_meta_title')])}}
                    <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%station_title%</a><a href="#">%genres%</a><a href="#">%countries%</a><a href="#">%languages%</a><a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('custom_description', __('admin.custom_meta_description'))}}
                {{Form::textarea('custom_description', $row->custom_description, ['class' => 'form-control', 'rows' => '5', 'placeholder' => __('admin.custom_meta_description')])}}
                 <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%station_title%</a><a href="#">%genres%</a><a href="#">%countries%</a><a href="#">%languages%</a><a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
           </div>
        </div>
       
        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('custom_h1', __('admin.custom_h1_title'))}}
                {{Form::text('custom_h1', $row->custom_h1, ['class' => 'form-control', 'placeholder' => __('admin.custom_h1_title')])}}
                    <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%station_title%</a><a href="#">%genres%</a><a href="#">%countries%</a><a href="#">%languages%</a><a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>
        
        {{ Form::submit(__('admin.submit'), ['class' => 'btn button-green']) }}
        {!! Form::close() !!}

    </div>
</div>

@stop
