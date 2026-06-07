<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
{!!
\MetaTag::setPath()
->setDefault(['robots' => 'follow', 'canonical' => url()->full()])
->setDefault(['og_site_name' => $settings['site_title']])
->render()
!!}
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
<link href="{{ asset('assets/css/jquery-ui.min.css') }}?1.2" rel="stylesheet">

<!-- Bootstrap -->
<link href="{{ asset('assets/css/bootstrap.min.css') }}?1.2" rel="stylesheet">

<!-- Main CSS -->
<link href="{{ asset('assets/css/app.css') }}?1.2" rel="stylesheet">

<!-- Jquery -->
<script src="{{ asset('assets/js/jquery-3.6.1.min.js') }}?1.2"></script>

<!-- Video.js -->
<script src="{{ asset('assets/js/video.js') }}?1.2"></script>

<!-- Jplayer -->
<script src="{{ asset('assets/js/jquery.jplayer.min.js') }}?1.2"></script>

<!-- js-cookie -->
<script src="{{ asset('assets/js/js.cookie.min.js') }}?1.2"></script>

<!-- Other JS -->
<script src="{{ asset('assets/js/other.js') }}?1.2"></script>

<!-- Lazy Load -->
<script src="{{ asset('assets/js/jquery.lazy.min.js') }}?1.2"></script>

<!-- notificationManager -->
<script src="{{ asset('assets/js/notificationManager.js') }}?1.2"></script>

@stack('assets_head')

@if ($settings['enable_google_recaptcha'] == '1')
<!-- Google reCAPTCHA -->
@if(Request::url() == asset($settings['contact_slug']) || Request::url() == asset($settings['submission_slug']))
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@else
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
@endif
@endif

@if(!empty($settings['meta_theme_color']))
<meta name="theme-color" content="{{ $settings['meta_theme_color'] }}">
@endisset

@if ($settings['enable_pwa'] == '1')
<script type="module">
   import 'https://cdn.jsdelivr.net/npm/@pwabuilder/pwaupdate';
   const el = document.createElement('pwa-update');
   document.body.appendChild(el);
</script>

<link rel="manifest" href="{{ asset('manifest.json') }}" />
@endif

{!! $settings['before_head_tag'] !!}