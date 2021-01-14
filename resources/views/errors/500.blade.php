<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<!-- Mirrored from shreyu.coderthemes.com/pages-404.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 05 Nov 2020 23:28:27 GMT -->

<head>
  <meta charset="utf-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Timetable') }} - @yield('title')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
  <meta content="Coderthemes" name="author" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />


  <!-- App favicon -->
  <link rel="shortcut icon" href="assets/images/favicon.ico">

  <!-- App css -->
  <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

</head>

<body class="authentication-bg">

  <div class="account-pages my-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-4 col-lg-5 col-8">
          <div class="text-center">

            <div>
              <img src="{{ asset('assets/images/server-down.png') }}" alt="" class="img-fluid" />
            </div>
          </div>

        </div>
      </div>

      <div class="row">
        <div class="col-12 text-center">
          <h3 class="mt-3">Opps, something went wrong</h3>
          <p class="text-muted mb-5">Server Error 500. We apoligise and are fixing the problem.<br /> Please try again
            at a later stage.</p>

          <a href="{{ route('home') }}" class="btn btn-lg btn-primary mt-4">Take me back to Home</a>
        </div>
      </div>
    </div>
    <!-- end container -->
  </div>
  <!-- end account-pages -->

  <!-- Vendor js -->

  <!-- App js -->
  <script src="{{ asset('assets/js/app.min.js') }}"></script>

  <script src="{{ mix('js/app.js') }}"></script>

</body>

<!-- Mirrored from shreyu.coderthemes.com/pages-404.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 05 Nov 2020 23:28:29 GMT -->

</html>