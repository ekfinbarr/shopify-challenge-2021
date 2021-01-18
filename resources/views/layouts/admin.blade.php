<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name') }} - @yield('title')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
  <meta content="Coderthemes" name="author" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <!-- App favicon -->
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

  <!-- plugins -->
  <link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />

  <!-- plugin css -->
  <link href="{{ asset('assets/libs/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/libs/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/libs/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/libs/datatables/select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" /> 


  <link rel="stylesheet" href="{{ asset('assets/css/timetablejs.css') }}">

  <link rel="stylesheet" href="{{ asset('assets/libs/smartwizard/smart_wizard.min.css') }}" type="text/css" />
  <link rel="stylesheet" href="{{ asset('assets/libs/smartwizard/smart_wizard_theme_arrows.min.css') }}"
    type="text/css" />
  <link rel="stylesheet" href="{{ asset('assets/libs/smartwizard/smart_wizard_theme_circles.min.css') }}"
    type="text/css" />
  <link rel="stylesheet" href="{{ asset('assets/libs/smartwizard/smart_wizard_theme_dots.min.css') }}"
    type="text/css" />

  <!-- App css -->
  <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/css/bootstrap-datetimepicker-standalone.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>


  <script src="{{ asset('assets/js/timetable.js') }}"></script>
  <script src="{{ asset('css/dataTables.bootstrap4.min.css') }}"></script>

  <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css"> 
  @yield('styles')
</head>

<body>
  <!-- Begin page -->
  <div id="wrapper">

    <!-- Topbar Start -->
    @include('partials.dashboard._navbar')
    <!-- end Topbar -->

    <!-- ========== Left Sidebar Start ========== -->
    @include('partials.dashboard._sidebar')
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
      <div class="content">
        @if(session('message'))
        <div class="row mb-2 mt-3">
          <div class="col-lg-12">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              {{ session('message') }}
            </div>
          </div>
        </div>
        @endif
        @if(session('success'))
        <div class="row mb-2 mt-3">
          <div class="col-lg-12">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              {{ session('success') }}
            </div>
          </div>
        </div>
        @endif
        @if(session('error'))
        <div class="row mb-2 mt-3">
          <div class="col-lg-12">
            <div class="alert alert-danger  alert-dismissible fade show" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              {{ session('error') }}
            </div>
          </div>
        </div>
        @endif

        <script>
          $(".alert").alert();
        </script>
        @if($errors->count() > 0)
        <div class="alert alert-danger mt-3">
          <ul class="list-unstyled">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        @yield("content")

      </div>
      <!-- content -->



      <!-- Footer Start -->
      @include('partials.dashboard._footer')
      <!-- end Footer -->

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->



  </div>
  <!-- END wrapper -->

  <!-- Right bar overlay-->
  <div class="rightbar-overlay"></div>

  <!-- Vendor js -->
  <script src="{{ asset('assets/js/vendor.min.js') }}"></script>



  <!-- optional plugins -->
  <script src="{{ asset('assets/libs/moment/moment.min.js') }}"></script>

  <!-- page js -->
  <script src="{{ asset('assets/js/pages/dashboard.init.js') }}"></script>

  <!-- App js -->
  <script src="{{ asset('assets/js/app.min.js') }}"></script>

  <!-- Calendar init -->
  <script src="{{ asset('assets/js/pages/calendar.init.js') }}"></script>
  {{-- <script src="{{ mix('js/app.js') }}"></script> --}}

  <script src="{{ asset('assets/libs/smartwizard/jquery.smartWizard.min.js') }}"></script>

  <script src="{{ asset('assets/js/pages/form-wizard.init.js') }}"></script>

  <script src="{{ asset('assets/js/pages/form-wizard.init.js') }}"></script>
  
  <script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
  <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>

  
  <!-- datatable js -->
  <script src="{{ asset('assets/libs/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/libs/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('assets/libs/datatables/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('assets/libs/datatables/responsive.bootstrap4.min.js') }}"></script>
  
  <script src="{{ asset('assets/libs/datatables/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('assets/libs/datatables/buttons.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('assets/libs/datatables/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('assets/libs/datatables/buttons.flash.min.js') }}"></script>
  <script src="{{ asset('assets/libs/datatables/buttons.print.min.js') }}"></script>

  <script src="{{ asset('assets/libs/datatables/dataTables.keyTable.min.js') }}"></script>
  <script src="{{ asset('assets/libs/datatables/dataTables.select.min.js') }}"></script>

  <!-- Datatables init -->
  <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
  
  <script src="{{ asset('assets/js/pages/email-inbox.init.js') }}"></script>

  {{-- <script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script> --}}
  <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
  {!! Toastr::message() !!}


  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-confirmation/1.0.5/bootstrap-confirmation.min.js"></script>
  
  @yield('scripts')
</body>

</html>