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
                        <img src="{{ asset('assets/images/maintenance.svg') }}" alt="" class="img-fluid" />
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-12 text-center">
                <h4 class="mt-5">We are currently performing maintenance</h4>
                    <p class="text-muted">We're making the system more awesome. <br/> We'll be back shortly.</p>
            </div>
        </div>

        <!-- <div class="row pt-5">
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar-sm rounded-circle bg-soft-primary mr-4">
                                <i class="uil-presentation-lines-alt font-size-20 avatar-title text-primary"></i>
                            </div>
                            <div class="media-body">
                                <h5 class="font-size-16  mt-0">Why is the Site Down?</h5>
                                <p class="text-muted mb-0">If several languages coalesce, the grammar of the resulting language is more simple.</p>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar-sm rounded-circle bg-soft-primary mr-4">
                                <i class="uil-clock-eight font-size-20 avatar-title text-primary"></i>
                            </div>
                            <div class="media-body">
                                <h5 class="font-size-16  mt-0">What is the Downtime?</h5>
                                <p class="text-muted mb-0">Everyone realizes why a new common language would be desirable one could refuse.</p>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar-sm rounded-circle bg-soft-primary mr-4">
                                <i class="uil-envelope font-size-20 avatar-title text-primary"></i>
                            </div>
                            <div class="media-body">
                                <h5 class="font-size-16  mt-0">Do you need Support?</h5>
                                <p class="text-muted mb-0">You need to be sure there isn't anything embar.. <a href="mailto:#" class="text-muted font-weight-semibold">no-reply@domain.com</a></p>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div> -->
        <!-- end row -->
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