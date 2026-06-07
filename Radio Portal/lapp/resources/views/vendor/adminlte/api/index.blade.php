@extends('adminlte::page')

@section('content_header', __('admin.api'))

@section('content')

@include('adminlte::inc.messages')

<div class="row">
    <div id="notificationsContainer"></div>

    <div class="col-12">
        <div class="callout callout-dark">
            <p><i class="fas fa-info-circle"></i> @lang('admin.api_warning')</p>
        </div>
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover text-nowrap m-0" id="table" data-delete-prompt-title="@lang('admin.oops')" data-delete-prompt-body="@lang('admin.delete_prompt')" data-yes="@lang('admin.yes')" data-cancel="@lang('admin.cancel')">
                    <thead>
                        <tr>
                            <th class="col-11">@lang('admin.title')</th>
                            <th class="col-1">@lang('admin.stations')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($countries as $country)
                        <tr>
                            <td><a href="{{ asset(env('ADMIN_URL').'/api/'.$country['iso_3166_1']) }}" class="text-dark"><u>{{ $country['name'] }}</u></a></td>
                            <td>{{ $country['stationcount'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>

@stop