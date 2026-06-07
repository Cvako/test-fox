@extends('frontend::page')

@section('content')

<!-- Container -->
<div class="container mt-3">

    <div id="notificationsContainer"></div>

    <div class="row">

        <div class="col-md-3 d-none d-md-block" id="menu-content">

            @include('frontend::inc.partials', ['type' => '1'])

        </div>

        <div class="col-md-9">

            @include('frontend::inc.partials', ['type' => '2'])

            @if (empty($station->image))
            @php $station->image='no_image.png'; @endphp
            @endif

            @if (!is_null($ad[1]))
            <div class="mb-3">{!! $ad[1] !!}</div>
            @endif

            @if (str_contains($station->stream_url, '.m3u8'))
            <video id='hls-example' poster="{{ $station->image }}" class="video-js vjs-default-skin d-none" width="400"
                height="300" controls>
                <source type="application/x-mpegURL" src="{{ $station->stream_url }}">
            </video>
            @endif

            <div class="container shadow-sm player rounded mb-3 p-0" id="player"
                data-stream-url="{{ $station->stream_url }}"
                data-thumb-url="{{ asset('images/stations/' . $station->image) }}" data-thumb="{{ $station->image }}"
                data-slug="{{ $station->slug }}" data-title="{{ $station->title }}"
                data-site-title="{{ $settings['site_title'] }}" data-cookie-prefix="{{ $settings['cookie_prefix'] }}">

                <div class="p-2">
                    <div class="row p-1 p-md-0">
                        <div class="col-5 col-md-2 order-1 pe-0"><img
                                src="{{ asset('images/stations/' . $station->image) }}" width="300" height="300"
                                alt="{{ $station->title }}" class="img-fluid station-image rounded"></div>
                        <div class="col-12 col-md-8 order-3 order-md-2 ps-md-2 my-auto pt-md-0 pt-2">

                            <div class="station-name my-auto">
                                <h1 class="mb-2 mb-md-1">{{ $h1_title }}</h1>

                                <button class="favorites">
                                    {!! custom_icon('heart') !!}
                                </button>

                                <a href="{{ asset('/random') }}">{!! custom_icon('random') !!}</a>

                                <div class="btn-group">
                                    <button type="button" class="btn p-0" data-toggle="dropdown"
                                        aria-label="@lang('general.share_on_social_media')" aria-expanded="false"
                                        data-boundary="viewport">
                                        {!! custom_icon('share') !!}
                                    </button>
                                    <div class="dropdown-menu">
                                        <button
                                            onclick="sm_share('https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}','Facebook','600','300');"
                                            class="facebook-box me-1">
                                            {!! custom_icon('facebook') !!}
                                        </button><button
                                            onclick="sm_share('http://twitter.com/share?text={{ str_replace("'", "\'", $station->title) }}&url={{ url()->current() }}','Twitter','600','450');"
                                            class="twitter-box me-1">
                                            {!! custom_icon('twitter') !!}
                                        </button><button
                                            onclick="sm_share('https://api.whatsapp.com/send?text={{ str_replace("'", "\'", $station->title) }} {{ url()->current() }}','WhatsApp','700','600');"
                                            class="whatsapp-box me-1">
                                            {!! custom_icon('whatsapp') !!}
                                        </button><button
                                            onclick="sm_share('https://t.me/share/url?url={{ url()->current() }}&text={{ str_replace("'", "\'", $station->title) }}','Telegram','600','450');"
                                            class="telegram-box">
                                            {!! custom_icon('telegram') !!}
                                        </button>
                                    </div>
                                </div>

                                <button class="report" data-bs-toggle="modal" data-bs-target="#MyModal">
                                    {!! custom_icon('report') !!}
                                </button>

                                <div class="station-data my-2 my-md-1 pb-0 pb-md-1">
                                    @foreach ($station->genres as $genre)
                                    <a href="{{ asset($settings['genre_base'] . '/' . $genre->slug) }}">{{ $genre->title
                                        }}</a>
                                    @if (!$loop->last)
                                    <span class="sep">›</span>
                                    @endif
                                    @endforeach @foreach ($station->languages as $language)
                                    <span class="sep">›</span> <a
                                        href="{{ asset($settings['language_base'] . '/' . $language->slug) }}">{{
                                        $language->title }}</a>
                                    @endforeach @foreach ($station->countries as $country)
                                    <span class="sep">›</span> <a
                                        href="{{ asset($settings['country_base'] . '/' . $country->slug) }}">{{
                                        $country->title }}</a>
                                    @endforeach
                                </div>

                                @if (!empty($station->description))
                                <span class="description">{!! $station->description !!}</span>
                                @endif

                            </div>
                        </div>

                        <div class="col-3 offset-1 offset-md-0 col-md-1 order-2 px-2 text-center order-md-3 my-auto">

                            <div id="play_1">
                                <div id="jplayer" class="jp-jplayer"></div>
                                <div id="jp_container_1" class="jp-audio">
                                    <div class="jp-type-single">
                                        <div class="jp-gui jp-interface">
                                            @if (str_contains($station->stream_url, '.m3u8'))
                                            <div class="jp-controls">
                                                <button class="m3-play" id="btnn" aria-label="@lang('general.play')">{!!
                                                    custom_icon('play') !!}</button>
                                                <button style="display: none;" class="m3-pause">{!! custom_icon('pause')
                                                    !!}</button>
                                            </div>
                                            @else
                                            <div class="jp-controls">
                                                <button class="jp-play" aria-label="@lang('general.play')">{!!
                                                    custom_icon('play') !!}</button>
                                                <button style="display: none;" class="jp-pause">{!! custom_icon('pause')
                                                    !!}</button>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mute-box my-1">
                                        <a class="jp-mute btn-mute" aria-label="Mute" role="button" tabindex="0">
                                            {!! custom_icon('mute') !!}</a>

                                        <a class="jp-unmute btn-unmute" aria-label="Unmute" role="button" tabindex="0">
                                            {!! custom_icon('unmute') !!}
                                        </a>
                                    </div>

                                    <div class="jp-time-holder">
                                        <div class="jp-current-time" role="timer">&nbsp;</div>
                                    </div>

                                    <div class="jp-volume-controls" id="volume-bar">
                                        <div class="jp-volume-bar mb-md-0">
                                            <div class="jp-volume-bar-value"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div
                            class="col-2 offset-1 offset-md-0 col-md-1 order-2 order-md-3 ps-0 ps-md-3 text-center my-auto">
                            <button class="rate_station bg-white border-0 w-100 mx-0 px-0" data-id="{{ $station->id }}"
                                data-action="up">
                                <i class="rounded d-block up-button shadow-sm p-1">
                                    {!! custom_icon('up_vote') !!}
                                </i>
                                <small class="d-block text-dark mb-2 mb-md-1" id="up">{{
                                    number_format($station->up_votes) }}</small>
                            </button>

                            <button class="rate_station bg-white border-0 w-100 mx-0 px-0" data-id="{{ $station->id }}"
                                data-action="down">
                                <i class="rounded d-block down-button shadow-sm p-1">
                                    {!! custom_icon('down_vote') !!}
                                </i>
                                <small class="text-dark" id="down">{{ number_format($station->down_votes) }}</small>
                            </button>

                        </div>

                    </div>
                </div>
            </div>
            @if (!empty($station->details))
            <div class="bg-white radio-details rounded p-3 mb-3">
                {!! $station->details !!}
            </div>
            @endif

            @if (count($comments) >= '1')
            <span class="section-title mb-3">@lang('general.comments')</span>

            @foreach ($comments as $comment)
            <div class="bg-white rounded p-2 user-reviews mb-3">

                <div class="review m-1">
                    <span class="name">{{ $comment->name }}</span>
                    <span class="comment">{{ $comment->comment }}</span>
                    <span class="date">{{ \Carbon\Carbon::parse($comment->created_at)->translatedFormat('F d, Y - H:i')
                        }}</span>
                </div>
            </div>
            @endforeach
            @endif

            <span class="section-title mb-3">@lang('general.add_comment')</span>

            <div class="bg-white rounded p-2 pb-1 user-reviews mb-3">

                <div class="comment-box m-1" id="comment-section" data-error="@lang('general.error')"
                    data-recaptcha-error="@lang('general.recaptcha_error')">

                    <form id="comment-form">

                        <input type="hidden" name="content_id" value="{{ $station->id }}">

                        <div class="mb-2">
                            <label for="name">@lang('general.name'): <span class="text-danger">*</span></label>
                            <input type="text" class="form-control mt-2" id="name" name="name">
                        </div>

                        <div class="mb-2">
                            <label for="comment">@lang('general.comment'): <span class="text-danger">*</span></label>
                            <textarea class="form-control mt-2" rows="4" id="comment" name="comment"
                                maxlength="1000"></textarea>
                        </div>

                        @if ($settings['enable_google_recaptcha'] == '1')
                        <div class="mb-2 py-1" id="recaptcha_comment"></div>
                        @endif

                    </form>

                    <button type="submit" class="btn comment-button text-white mb-1"
                        onclick="comment_form_send()">@lang('general.submit')</button>

                    <div id="comment_result"></div>

                </div>
            </div>

            @if (!is_null($ad[2]))
            <div class="mb-3">{!! $ad[2] !!}</div>
            @endif

            @if (count($similar_stations) >= '1')
            <span class="section-title text-white mb-3">@lang('general.similar_radio_stations')</span>

            <div class="row radio-channels">

                @foreach ($similar_stations as $similar)
                @if (empty($similar->image))
                @php $similar->image='no_image.png'; @endphp
                @endif

                <div class="col-md-2 col-4 mb-3"><a
                        href="{{ asset($settings['station_base'] . '/' . $similar->slug) }}"><img
                            src="{{ asset('images/pixel.png') }}"
                            data-src="{{ asset('images/stations/' . $similar->image) }}" width="300" height="300"
                            alt="{{ $similar->title }}" class="img-fluid lazy"></a></div>
                @endforeach

            </div>
            @endif

        </div>
    </div>

</div>
<!-- /Container -->

<!-- Report Form -->

<div class="modal align-middle" id="MyModal">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">@lang('general.report_a_problem')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="icon-close"></i>
                </button>
            </div>

            <div class="modal-body submission-box pt-1 pb-1" id="report-submission-section"
                data-station-id="{{ $station->id }}" data-error="@lang('general.error')"
                data-recaptcha-error="@lang('general.recaptcha_error')">

                <form id="report-submission-form">

                    <div class="mt-3">
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="@lang('general.email')" required>
                    </div>

                    <div class="mt-3">
                        <select title="@lang('general.select_a_reason')" id="reason" name="reason" class="form-select">
                            <option selected="selected" disabled="disabled">@lang('general.select_a_reason')</option>
                            @foreach ($report_reasons as $key => $reason)
                            <option value="{{ $key }}">{{ $reason }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if ($settings['enable_google_recaptcha'] == '1')
                    <div class=" mt-3" id="recaptcha_report"></div>
                    @endif

                    <div id="report-submission-result" class="mb-3"></div>

                    <div class="modal-footer pt-0 pe-0">
                        <button type="button" class="btn submit-button m-0"
                            onclick="report_submission_form()">@lang('general.submit')</button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<!-- /Report Form -->

@if ($settings['enable_google_recaptcha'] == '1')
<script>
    var onloadCallback = function() {
            grecaptcha.render('recaptcha_report', {
                'sitekey' : '{{ $settings['google_recaptcha_site_key'] }}'
            });
            grecaptcha.render('recaptcha_comment', {
                'sitekey' : '{{ $settings['google_recaptcha_site_key'] }}'
            });
        };
</script>
@endif

@endsection