@extends('adminlte::page')

@section('content_header', __('admin.create_station'))

@section('content')

@include('adminlte::inc.messages')

<div class="card p-2">
    <div class="m-1">

        {!! Form::open(['action' => 'App\Http\Controllers\StationController@store', 'method' => 'POST', 'files' => true]) !!}

        @if($station[0]['favicon'])
        <input type="hidden" name="image" value="{{$station[0]['favicon']}}" />
        @endif
        <input type="hidden" name="api" value="1" />

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('title', __('admin.title')." <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('title', $station[0]['name'], ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.title')])}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('slug', __('admin.slug'))}}
                {{Form::text('slug', '', ['class' => 'form-control', 'placeholder' => __('admin.slug')])}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('description', __('admin.description'))}}
                {{Form::textarea('description', '', ['class' => 'form-control', 'rows' => '5', 'placeholder' => __('admin.description')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%station_title%</a><a href="#">%genres%</a><a href="#">%countries%</a><a href="#">%languages%</a><a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('details', __('admin.details'))}}
                {{Form::textarea('details', '', ['class' => 'textarea textarea-style', 'placeholder' => __('admin.details')])}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('stream_url', __('admin.stream_url')." <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('stream_url', $station[0]['url'], ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.stream_url')])}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label for="genres">@lang('admin.genres') <span class="text-danger">*</span></label>
                {!! Form::select('genres[]', $genres, old('genres'), ['class' => 'form-control selectpicker', 'required' => 'required', 'multiple' => 'multiple', 'data-live-search' => 'true', 'id' => 'genres' ]) !!}
            </div>
        </div>
    
<div class="row mb-3">
    <div class="col-md-12">
        <label for="countries">@lang('admin.countries')</label>
        <select name="countries[]" class="form-control selectpicker" multiple="multiple" data-live-search="true" id="countries">
            @foreach($countries as $country)
                <option value="{{ $country->id }}" {{ $country->title == ucfirst($station[0]['country']) ? 'selected' : '' }}>
                    {{ $country->title }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <label for="languages">@lang('admin.languages')</label>
        <select name="languages[]" class="form-control selectpicker" multiple="multiple" data-live-search="true" id="languages">
            @foreach($languages as $language)
                <option value="{{ $language->id }}" {{ $language->title == ucfirst($station[0]['language']) ? 'selected' : '' }}>
                    {{ $language->title }}
                </option>
            @endforeach
        </select>
    </div>
</div>

  @if($station[0]['favicon'])
           <div class="row mb-3">
            <div class="col-md-1 mb-md-0 mb-3">
                <img src="{{ $station[0]['favicon'] }}" class="img-fluid">
            </div>
            <div class="col-md-3 my-auto">
                <div class="custom-file">
                    {{Form::label('different_image', __('admin.choose_image'), ['class' => 'custom-file-label'])}}
                    {{Form::file('different_image', ['class' => 'custom-file-input'])}}
                </div>
            </div>
        </div>
        @else
        <div class="row mb-3">
            <div class="col-md-3">
                <label>@lang('admin.image')</label>
                <div class="custom-file">
                    {{Form::label('image', __('admin.choose_image'), ['class' => 'custom-file-label'])}}
                    {{Form::file('image', ['class' => 'custom-file-input', 'id' => 'browse-image'])}}
                </div>
            </div>
        </div>
        @endif
        
        <div class="row mb-3">

            <div class="col-md-4">
                {{Form::label('page_views', __('admin.page_views')." <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('page_views', '0', ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.page_views')])}}
            </div>

            <div class="col-md-4">
                {{Form::label('up_votes', __('admin.up_votes')." <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('up_votes', '0', ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.up_votes')])}}
            </div>

            <div class="col-md-4">
                {{Form::label('down_votes', __('admin.down_votes')." <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('down_votes', '0', ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.down_votes')])}}
            </div>

        </div>

        <div class="row mb-3">

            <div class="col-md-3">
                <div class="icheck-wetasphalt">
                    {{Form::checkbox('status', null, true, ['id' => 'status'])}}
                    {{Form::label('status', __('admin.active'))}}
                </div>
            </div>

            <div class="col-md-3">
                <div class="icheck-wetasphalt">
                    {{Form::checkbox('home_page', null, false, ['id' => 'home_page'])}}
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
                {{Form::text('custom_title', '', ['class' => 'form-control', 'placeholder' => __('admin.custom_meta_title')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%station_title%</a><a href="#">%genres%</a><a href="#">%countries%</a><a href="#">%languages%</a><a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('custom_description', __('admin.custom_meta_description'))}}
                {{Form::textarea('custom_description', '', ['class' => 'form-control', 'rows' => '5', 'placeholder' => __('admin.custom_meta_description')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%station_title%</a><a href="#">%genres%</a><a href="#">%countries%</a><a href="#">%languages%</a><a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('custom_h1', __('admin.custom_h1_title'))}}
                {{Form::text('custom_h1', '', ['class' => 'form-control', 'placeholder' => __('admin.custom_h1_title')])}}
                <div class="shortcodes mt-1"><b>@lang('admin.supported_shortcodes'):</b> <a href="#">%station_title%</a><a href="#">%genres%</a><a href="#">%countries%</a><a href="#">%languages%</a><a href="#">%site_title%</a><a href="#">%sep%</a><a href="#">%year%</a><a href="#">%month%</a><a href="#">%day%</a><a href="#">%month_text%</a><a href="#">%day_text%</a></div>
            </div>
        </div>

        {{ Form::submit(__('admin.submit'), ['class' => 'btn button-green']) }}
        {!! Form::close() !!}

    </div>
</div>

@stop