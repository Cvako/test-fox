@extends('frontend::page')

@section('content')

<!-- Container -->
<div class="container mt-3">

    <div class="row">

        <div class="col-md-3 d-none d-md-block" id="menu-content">

            @include('frontend::inc.partials', ['type' => '1'])

        </div>

        <div class="col-md-9">

            @include('frontend::inc.partials', ['type' => '2'])

            <h1 class="section-title text-white mb-3">{{ $h1_title }}</h1>
            <div class="row radio-channels"></div>
			
			  <script>
        var ked = Cookies.get('{{ $settings['cookie_prefix'].'_favorites' }}');
        var i = 0;
if ( ked != undefined && ked != '' ) {
            ked_values = ked.split('|');

            $.each(ked_values, function(imagee) {
                    values = ked_values[i].split(',');

 if (values.length > 1) {

                        $(".radio-channels").prepend('<div class="col-md-2 col-4 mb-3"><a href="/{{ $settings['station_base'] }}/' + values[0] + '"><img src="/images/pixel.png" data-src="/images/stations/' + values[1] + '" width="300" height="300" alt="" class="img-fluid lazy"></a></div>');
 }
                        i++;

            });
} else {
                $(".radio-channels").prepend('<div class="col-md-12 col-12 text-white mb-3">@lang('general.no_favorites').</div>');


            }
            </script>

        </div>

    </div>

</div>
<!-- /Container -->

@endsection
