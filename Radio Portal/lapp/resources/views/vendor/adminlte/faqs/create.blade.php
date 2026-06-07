@extends('adminlte::page')

@section('content_header', __('admin.create_faq'))

@section('content')

@include('adminlte::inc.messages')

<div class="card p-2">
    <div class="m-1">

        {!! Form::open(['action' => 'App\Http\Controllers\FAQController@store', 'method' => 'POST']) !!}
       
        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('title', __('admin.title')." <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::text('title', '', ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('admin.title')])}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                {{Form::label('details', __('admin.details')." <span class=\"text-danger\">*</span>", [], false)}}
                {{Form::textarea('details', '', ['class' => 'textarea textarea-style', 'required' => 'required', 'placeholder' => __('admin.details')])}}
            </div>
        </div>
        
        {{ Form::submit(__('admin.submit'), ['class' => 'btn button-green']) }}
        {!! Form::close() !!}

    </div>
</div>

@stop
