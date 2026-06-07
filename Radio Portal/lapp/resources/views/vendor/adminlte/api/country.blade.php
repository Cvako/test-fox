@extends('adminlte::page')

@section('content_header', __('admin.stations'))

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
                            <th class="col-1">@lang('admin.image')</th>
                            <th class="col-8">@lang('admin.station')</th>
                            <th class="col-1">@lang('admin.codec')</th>
                            <th class="col-1">@lang('admin.added')</th>
                            <th class="col-1"><i class="fas fa-align-justify"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $extensions = ['pls', 'm3u']; @endphp
                        @foreach ($stations as $station)
                        @php $api_query = DB::table('stations')->where('stream_url', $station['url'])->first(); @endphp
                        @php $extension = pathinfo($station['url'], PATHINFO_EXTENSION); @endphp
                        <tr>
                            <td>@if($station['favicon'])<a href="{{ asset(env('ADMIN_URL').'/api/station/'.$station['stationuuid']) }}"><img src="{{ $station['favicon'] }}" class="img-fluid"> @else @lang('admin.no_image') @endif</a></td>
                            <td><a href="{{ asset(env('ADMIN_URL').'/api/station/'.$station['stationuuid']) }}" class="text-dark"><u>{{ $station['name'] }}</u></a> @if (in_array($extension, $extensions))<br><span class="badge badge-warning">@lang('admin.unsupported_format')</span>@endif</td>
                            <td>{{ $station['codec'] }}</td>
                            <td> @if (!$api_query == null) <span class="text-success">@lang('admin.yes')</span> @else <span class="text-muted">@lang('admin.no')</span> @endif</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn p-0" data-toggle="dropdown" aria-expanded="false" data-boundary="viewport">
                                        <i class="fas fa-align-justify"></i>
                                    </button>
                                    <div class="dropdown-menu mr-3">
                                        <a class="dropdown-item" href="{{ $station['url'] }}" target="_blank"><i class="fas fa-play mr-1"></i> @lang('admin.listen')</a>
                                        <a class="dropdown-item" href="{{ asset(env('ADMIN_URL').'/api/station/'.$station['stationuuid']) }}"><i class="fas fa-plus mr-1"></i> @lang('admin.submit')</a>
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

{{ $paginator->onEachSide(1)->links() }}

@stop