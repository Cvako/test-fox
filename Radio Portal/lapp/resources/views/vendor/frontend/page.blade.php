<!DOCTYPE html>
<html lang="{{ $settings['site_language'] }}">

<head>
    @include('frontend::inc.head')
</head>

<body class="site-bg-{{ $settings['theme'] }}">

    @include('frontend::inc.header')

    @yield('content')

    @include('frontend::inc.footer')

</body>

</html>
