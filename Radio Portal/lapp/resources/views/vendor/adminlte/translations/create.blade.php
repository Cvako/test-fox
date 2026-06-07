@extends('adminlte::page')

@section('content_header', __('admin.create_translation'))

@section('content')

@include('adminlte::inc.messages')

<div class="card p-2">
    <div class="m-1">

        {!! Form::open(['action' => 'App\Http\Controllers\TranslationController@store', 'method' => 'POST']) !!}
       
        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('language', __('admin.language')." <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('language', '', ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.language')])}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('code', __('admin.language_code')." <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('code', '', ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.language_code')])}}
            </div>
        </div>
        
       <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('locale_code', __('admin.og_locale_tag')." <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('locale_code', '', ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.og_locale_tag')])}}
            </div>
        </div>
    
        {{ Form::submit(__('admin.submit'), ['class' => 'btn button-green']) }}
        {!! Form::close() !!}

    </div>
</div>

@stop