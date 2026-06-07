{!! $settings['after_head_tag'] !!}

  <div class="container-fluid top-menu px-0 site-color-{{ $settings['theme'] }}">
  <div class="container">
  <div class="row">
     
  <div class="col-6">
      <a href="{{ asset('/') }}"><img src="{{ asset('/images/logo.png') }}" alt="{{ $settings['site_title'] }}" class="logo"></a>
  </div>
  <div class="col-6 d-flex justify-content-end align-items-center">
 <a href="{{ asset($settings['history_base']) }}" aria-label="@lang('general.listen_history')">{!! custom_icon('history') !!}</a>
 <a href="{{ asset($settings['favorites_base']) }}" aria-label="@lang('general.favorites')">{!! custom_icon('favorite') !!}</a>
 <button type="button" class="d-inline-block d-md-none" aria-label="@lang('general.menu')">{!! custom_icon('menu') !!}</button>
 </div>
</div>

</div>
</div>

<script>
$('#menu-opener').on('click', function(){
    if ($('#menu-content').hasClass("d-none")) {
    $('#menu-content').addClass('d-block');
    $('#menu-content').removeClass('d-none');
    } else {
    $('#menu-content').addClass('d-none');
    $('#menu-content').removeClass('d-block');
 }
});
</script>

@if (!is_null($ad[6]))<div class="container text-center my-3">{!! $ad[6] !!}</div>@endif