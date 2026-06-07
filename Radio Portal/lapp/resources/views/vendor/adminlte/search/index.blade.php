@extends('adminlte::page')

@section('content_header', __('admin.search_results'))

@section('content')

@include('adminlte::inc.messages')

@if($stations->isNotEmpty() || $genres->isNotEmpty() || $countries->isNotEmpty() || $languages->isNotEmpty() || $pages->isNotEmpty())

<ul class="nav nav-tabs" id="myTab" role="tablist">

    @php $active='0' @endphp

    <!-- Stations Nav -->
    @if($stations->isNotEmpty())
    <li class="nav-item">
        <a class="nav-link text-dark{{ $active == '0' ? ' active' : '' }}" id="stations-tab" data-toggle="tab" href="#stations" role="tab" aria-controls="stations" aria-selected="false">@if($stations->isNotEmpty())<b>@lang('admin.stations')</b> ({{count($stations)}})@endif</a>
    </li>
    @php $active='1' @endphp
    @endif
    <!-- /Stations Nav -->

    <!-- Genres Nav -->
    @if($genres->isNotEmpty())
    <li class="nav-item">
        <a class="nav-link text-dark{{ $active == '0' ? ' active' : '' }}" id="genres-tab" data-toggle="tab" href="#genres" role="tab" aria-controls="genres" aria-selected="false">@if($genres->isNotEmpty())<b>@lang('admin.genres')</b> ({{count($genres)}})@endif</a>
    </li>
    @php $active='1' @endphp
    @endif
    <!-- /Genres Nav -->

    <!-- Countries Nav -->
    @if($countries->isNotEmpty())
    <li class="nav-item">
        <a class="nav-link text-dark{{ $active == '0' ? ' active' : '' }}" id="countries-tab" data-toggle="tab" href="#countries" role="tab" aria-controls="countries" aria-selected="false">@if($countries->isNotEmpty())<b>Countries</b> ({{count($countries)}})@endif</a>
    </li>
    @php $active='1' @endphp
    @endif
    <!-- /Countries Nav -->

    <!-- Languages Nav -->
    @if($languages->isNotEmpty())
    <li class="nav-item">
        <a class="nav-link text-dark{{ $active == '0' ? ' active' : '' }}" id="languages-tab" data-toggle="tab" href="#languages" role="tab" aria-controls="languages" aria-selected="false">@if($languages->isNotEmpty())<b>@lang('admin.languages')</b> ({{count($languages)}})@endif</a>
    </li>
    @php $active='1' @endphp
    @endif
    <!-- /Languages Nav -->
    
    <!-- Pages Nav -->
    @if($pages->isNotEmpty())
    <li class="nav-item">
        <a class="nav-link text-dark{{ $active == '0' ? ' active' : '' }}" id="pages-tab" data-toggle="tab" href="#pages" role="tab" aria-controls="pages" aria-selected="false">@if($pages->isNotEmpty())<b>@lang('admin.pages')</b> ({{count($pages)}})@endif</a>
    </li>
    @php $active='1' @endphp
    @endif
    <!-- /Pages Nav -->

</ul>

<div class="tab-content" id="myTabContent">

    @php $active='0' @endphp

    <!-- Stations Tab -->
    @if($stations->isNotEmpty())
    <div class="tab-pane{{ $active == '0' ? ' show active' : '' }}" id="stations" role="tabpanel" aria-labelledby="stations-tab">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover text-nowrap m-0" id="table" data-delete-prompt-title="@lang('admin.oops')" data-delete-prompt-body="@lang('admin.delete_prompt')" data-yes="@lang('admin.yes')" data-cancel="@lang('admin.cancel')">
                            <thead>
                                <tr>
                                    <th class="col-1">@lang('admin.id')</th>
                                    <th class="col-10">@lang('admin.title')</th>
                                    <th class="col-1"><i class="fas fa-align-justify"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stations as $row)
                                <tr>
                                    <td>{{$row->id}}</td>
                                    <td>{{$row->title}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn p-0" data-toggle="dropdown" aria-expanded="false" data-boundary="viewport">
                                                <i class="fas fa-align-justify"></i>
                                            </button>
                                            <div class="dropdown-menu mr-3">
                                                <a class="dropdown-item" href="{{ asset($settings['station_base']) }}/{{ $row->slug }}" target="_blank"><i class="fas fa-external-link-alt mr-1"></i> @lang('admin.browse')</a>
                                                <a class="dropdown-item" href="{{ route('stations.edit', $row->id) }}"><i class="fas fa-edit mr-1"></i> @lang('admin.edit')</a>
                                                <div class="dropdown-divider"></div>
                                                <form id="delete_from_{{$row->id}}_stations" method="POST" action="{{ action('App\Http\Controllers\StationController@destroy', $row['id']) }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <a href="javascript:void(0);" data-id="{{ $row->id }}_stations" class="dropdown-item _delete_data" role="button"><i class="fas fa-ban mr-1"></i> @lang('admin.delete')</a>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php $active='1' @endphp
    @endif
    <!-- /Stations Tab -->

    <!-- Genres Tab -->
    @if($genres->isNotEmpty())
    <div class="tab-pane{{ $active == '0' ? ' show active' : '' }}" id="genres" role="tabpanel" aria-labelledby="genres-tab">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover text-nowrap m-0" id="table" data-delete-prompt-title="Oops..." data-delete-prompt-body="Are you sure you want to delete it?" data-yes="Yes" data-cancel="Cancel">
                            <thead>
                                <tr>
                                    <th class="col-1">@lang('admin.id')</th>
                                    <th class="col-10">@lang('admin.title')</th>
                                    <th class="col-1"><i class="fas fa-align-justify"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($genres as $row)
                                <tr>
                                    <td>{{$row->id}}</td>
                                    <td>{{$row->title}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn p-0" data-toggle="dropdown" aria-expanded="false" data-boundary="viewport">
                                                <i class="fas fa-align-justify"></i>
                                            </button>
                                            <div class="dropdown-menu mr-3">
                                                <a class="dropdown-item" href="{{ asset($settings['genre_base']) }}/{{ $row->slug }}" target="_blank"><i class="fas fa-external-link-alt mr-1"></i> @lang('admin.browse')</a>
                                                <a class="dropdown-item" href="{{ route('genres.edit', $row->id) }}"><i class="fas fa-edit mr-1"></i> @lang('admin.edit')</a>
                                                <div class="dropdown-divider"></div>
                                                <form id="delete_from_{{$row->id}}_genres" method="POST" action="{{ action('App\Http\Controllers\GenreController@destroy', $row['id']) }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <a href="javascript:void(0);" data-id="{{ $row->id }}_genres" class="dropdown-item _delete_data" role="button"><i class="fas fa-ban mr-1"></i> @lang('admin.delete')</a>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php $active='1' @endphp
    @endif
    <!-- /Genres Tab -->
    
    <!-- Countries Tab -->
    @if($countries->isNotEmpty())
    <div class="tab-pane{{ $active == '0' ? ' show active' : '' }}" id="countries" role="tabpanel" aria-labelledby="countries-tab">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover text-nowrap m-0" id="table" data-delete-prompt-title="Oops..." data-delete-prompt-body="Are you sure you want to delete it?" data-yes="Yes" data-cancel="Cancel">
                            <thead>
                                <tr>
                                    <th class="col-1">@lang('admin.id')</th>
                                    <th class="col-10">@lang('admin.title')</th>
                                    <th class="col-1"><i class="fas fa-align-justify"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($countries as $row)
                                <tr>
                                    <td>{{$row->id}}</td>
                                    <td>{{$row->title}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn p-0" data-toggle="dropdown" aria-expanded="false" data-boundary="viewport">
                                                <i class="fas fa-align-justify"></i>
                                            </button>
                                            <div class="dropdown-menu mr-3">
                                                <a class="dropdown-item" href="{{ asset($settings['country_base']) }}/{{ $row->slug }}" target="_blank"><i class="fas fa-external-link-alt mr-1"></i> @lang('admin.browse')</a>
                                                <a class="dropdown-item" href="{{ route('countries.edit', $row->id) }}"><i class="fas fa-edit mr-1"></i> @lang('admin.edit')</a>
                                                <div class="dropdown-divider"></div>
                                                <form id="delete_from_{{$row->id}}_countries" method="POST" action="{{ action('App\Http\Controllers\CountryController@destroy', $row['id']) }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <a href="javascript:void(0);" data-id="{{ $row->id }}_countries" class="dropdown-item _delete_data" role="button"><i class="fas fa-ban mr-1"></i> @lang('admin.delete')</a>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php $active='1' @endphp
    @endif
    <!-- /Countries Tab -->

    <!-- Languages Tab -->
    @if($languages->isNotEmpty())
    <div class="tab-pane{{ $active == '0' ? ' show active' : '' }}" id="languages" role="tabpanel" aria-labelledby="languages-tab">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover text-nowrap m-0" id="table" data-delete-prompt-title="Oops..." data-delete-prompt-body="Are you sure you want to delete it?" data-yes="Yes" data-cancel="Cancel">
                            <thead>
                                <tr>
                                    <th class="col-1">@lang('admin.id')</th>
                                    <th class="col-10">@lang('admin.title')</th>
                                    <th class="col-1"><i class="fas fa-align-justify"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($languages as $row)
                                <tr>
                                    <td>{{$row->id}}</td>
                                    <td>{{$row->title}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn p-0" data-toggle="dropdown" aria-expanded="false" data-boundary="viewport">
                                                <i class="fas fa-align-justify"></i>
                                            </button>
                                            <div class="dropdown-menu mr-3">
                                                <a class="dropdown-item" href="{{ asset($settings['language_base']) }}/{{ $row->slug }}" target="_blank"><i class="fas fa-external-link-alt mr-1"></i> @lang('admin.browse')</a>
                                                <a class="dropdown-item" href="{{ route('languages.edit', $row->id) }}"><i class="fas fa-edit mr-1"></i> @lang('admin.edit')</a>
                                                <div class="dropdown-divider"></div>
                                                <form id="delete_from_{{$row->id}}_languages" method="POST" action="{{ action('App\Http\Controllers\LanguageController@destroy', $row['id']) }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <a href="javascript:void(0);" data-id="{{ $row->id }}_languages" class="dropdown-item _delete_data" role="button"><i class="fas fa-ban mr-1"></i> @lang('admin.delete')</a>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php $active='1' @endphp
    @endif
    <!-- /Languages Tab -->
    
    <!-- Pages Tab -->
    @if($pages->isNotEmpty())
    <div class="tab-pane{{ $active == '0' ? ' show active' : '' }}" id="pages" role="tabpanel" aria-labelledby="pages-tab">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover text-nowrap m-0" id="table" data-delete-prompt-title="Oops..." data-delete-prompt-body="Are you sure you want to delete it?" data-yes="Yes" data-cancel="Cancel">
                            <thead>
                                <tr>
                                    <th class="col-1">@lang('admin.id')</th>
                                    <th class="col-10">@lang('admin.title')</th>
                                    <th class="col-1"><i class="fas fa-align-justify"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pages as $row)
                                <tr>
                                    <td>{{$row->id}}</td>
                                    <td>{{$row->title}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn p-0" data-toggle="dropdown" aria-expanded="false" data-boundary="viewport">
                                                <i class="fas fa-align-justify"></i>
                                            </button>
                                            <div class="dropdown-menu mr-3">
                                                <a class="dropdown-item" href="{{ asset($settings['page_base']) }}/{{ $row->slug }}" target="_blank"><i class="fas fa-external-link-alt mr-1"></i> @lang('admin.browse')</a>
                                                <a class="dropdown-item" href="{{ route('pages.edit', $row->id)}}"><i class="fas fa-edit mr-1"></i> @lang('admin.edit')</a>
                                                <div class="dropdown-divider"></div>
                                                <form id="delete_from_{{$row->id}}_pages" method="POST" action="{{action('App\Http\Controllers\PageController@destroy', $row['id'])}}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <a href="javascript:void(0);" data-id="{{$row->id}}_pages" class="dropdown-item _delete_data" role="button"><i class="fas fa-ban mr-1"></i> @lang('admin.delete')</a>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php $active='1' @endphp
    @endif
    <!-- /Pages Tab -->

    @endif

    @if($stations->isEmpty() && $genres->isEmpty() && $countries->isEmpty() && $languages->isEmpty() && $pages->isEmpty())
    <p class="alert alert-warning-custom">@lang('admin.no_search_result')</p>
    @endif

    @stop
