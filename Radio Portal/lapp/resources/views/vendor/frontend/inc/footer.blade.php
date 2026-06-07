@if (!is_null($ad[7]))<div class="container text-center mb-3">{!! $ad[7] !!}</div>@endif

<div class="footer-container site-color-{{ $settings['theme'] }}">
    <footer class="page-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mx-auto">
                    <img src="{{ asset('/images/logo.png') }}" class="footer-logo mb-1" alt="{{$settings['site_title']}}">
                    <span class="d-block mt-2">{{$settings['site_description']}}</span>
                    <div class="clearfix mb-1"></div>
                    @if (!empty($settings['twitter_account']))<a href="https://twitter.com/{{$settings['twitter_account']}}" aria-label="Twitter" target="_blank">{!! custom_icon('twitter-footer') !!}</a>@endif
                    @if (!empty($settings['facebook_page']))<a href="{{$settings['facebook_page']}}" aria-label="Facebook" target="_blank">{!! custom_icon('facebook-footer') !!}</a>@endif
                    @if (!empty($settings['telegram_page']))<a href="{{$settings['telegram_page']}}" aria-label="Telegram" target="_blank">{!! custom_icon('telegram-footer') !!}</a>@endif
                </div>
                <div class="clearfix w-100 d-md-none">&nbsp;</div>
                <div class="col-md-3 col-4">
                    <span class="section-head">@lang('general.pages')</span><br><br>
                    <ul class="list-unstyled">
                        @foreach ($footer_array['pages'] as $country)
                        <li><a href="{{ asset($settings['page_base'].'/'.$country[1]) }}">{{$country[0]}}</a></li>
                        @endforeach
                        <li><a href="{{ asset($settings['contact_slug']) }}">@lang('general.contact')</a></li>
                        @if($settings['enable_faq'] == '1')<li><a href="{{ asset($settings['faq_slug']) }}">@lang('general.faq')</a></li>@endif
                        @if($settings['radio_submission'] == '1')<li><a href="{{ asset($settings['submission_slug']) }}">@lang('general.submit_radio')</a></li>@endif
                    </ul>
                </div>
                <div class="col-md-3 col-4">
                    <span class="section-head">@lang('general.genres')</span><br><br>
                    <ul class="list-unstyled">
                        @foreach ($footer_array['genres'] as $genre)
                        <li><a href="{{ asset($settings['genre_base'].'/'.$genre[1]) }}">{{$genre[0]}}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-3 col-4">
                    <span class="section-head mt-3 mb-4">@lang('general.countries')</span><br><br>
                    <ul class="list-unstyled">
                        @foreach ($footer_array['countries'] as $country)
                        <li><a href="{{ asset($settings['country_base'].'/'.$country[1]) }}">{{$country[0]}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright text-center py-2 site-copyright-{{ $settings['theme'] }}">© {{date('Y')}} @lang('general.copyright_notice') - <a href="{{ asset('') }}"> {{$settings['site_title']}}</a></div>
    </footer>
</div>

@if ($settings['show_cookie_bar'] == '1')
<!-- Cookie Alert -->
<div class="alert text-center cookiealert py-2" role="alert">
    @lang('general.cookies_note')
    <button type="button" class="btn btn-sm acceptcookies" aria-label="Close">
        @lang('general.accept_cookies')
    </button>
</div>
<!-- /Cookie Alert -->
@endif

<!-- Scripts -->
<script src="{{ asset('assets/js/scripts.js') }}?1.2"></script>

<!-- Bootstrap Bundle -->
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}?1.2"></script>

<!-- Bootstrap -->
<script src="{{ asset('assets/js/bootstrap.min.js') }}?1.2"></script>

<!-- jQuery UI -->
<script defer async src="{{ asset('assets/js/jquery-ui.min.js') }}?1.2"></script>

@stack('assets_footer')

{!! $settings['before_body_end_tag'] !!}