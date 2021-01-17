<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name') }} - @yield('title')</title>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/templatemo-style.css') }}">

  <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
  @yield('styles')
  
</head>

<body>
  <!-- Page Loader -->
  <div id="loader-wrapper">
    <div id="loader"></div>

    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>

  </div>

  {{-- NAVBAR --}}
  @include('partials.landing._navbar')


  @yield('content')


  {{-- FOOTER --}}
  @include('partials.landing._footer')

  <script src="{{ asset('js/plugins.js') }}"></script>
  <script>
    $(window).on("load", function () {
      $('body').addClass('loaded');
    });
  </script>

  <script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
  <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
  {!! Toastr::message() !!}


  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-confirmation/1.0.5/bootstrap-confirmation.min.js"></script>

  @yield('scripts')
</body>

</html>