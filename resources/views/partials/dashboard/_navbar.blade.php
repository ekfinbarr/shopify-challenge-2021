<div class="navbar navbar-expand flex-column flex-md-row navbar-custom">
  <div class="container-fluid">
      <!-- LOGO -->
    <a href="{{ route('home') }}" class="navbar-brand mr-0 mr-md-2 logo">
          <span class="logo-lg">
              {{-- <img src="assets/images/logo.png" alt="" height="24" /> --}}
              <i data-feather="camera"></i>
              <span class="d-inline h5 ml-1 text-logo">{{ config('app.name') }}</span>
          </span>
          <span class="logo-sm">
              <img src="{{ asset('assets/images/logo.png') }}" alt="" height="24">
          </span>
      </a>

      <ul class="navbar-nav bd-navbar-nav flex-row list-unstyled menu-left mb-0">
          <li class="">
              <button class="button-menu-mobile open-left disable-btn">
                  <i data-feather="menu" class="menu-icon"></i>
                  <i data-feather="x" class="close-icon"></i>
              </button>
          </li>
      </ul>

      <ul class="navbar-nav flex-row ml-auto d-flex list-unstyled topnav-menu float-right mb-0">
          <li class="d-none d-sm-block">
              <div class="app-search">
              <form action="{{ route("media.index") }}">
                @csrf
                @method("GET")
                  <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search...">
                    <span data-feather="search"></span>
                  </div>
                </form>
              </div>
          </li>

          @if(count(config('panel.available_languages', [])) > 1)
          <li class="dropdown d-none d-lg-block" data-toggle="tooltip" data-placement="left" title="Change language">
              <a class="nav-link dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button"
                  aria-haspopup="false" aria-expanded="false">
                  <i data-feather="globe"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                  <!-- item-->
                  @foreach(config('panel.available_languages') as $langLocale => $langName)
                      <a class="dropdown-item" href="{{ url()->current() }}?change_language={{ $langLocale }}" class="dropdown-item notify-item">{{ strtoupper($langLocale) }} ({{ $langName }})</a>
                  @endforeach
              </div>
          </li>
          @endif


          <li class="dropdown notification-list align-self-center profile-dropdown">
              <a class="nav-link dropdown-toggle nav-user mr-0" data-toggle="dropdown" href="#" role="button"
                  aria-haspopup="false" aria-expanded="false">
                  <div class="media user-profile ">
                      <img src="assets/images/users/avatar-7.jpg" alt="user-image" class="rounded-circle align-self-center" />
                      <div class="media-body text-left">
                          <h6 class="pro-user-name ml-2 my-0">
                              <span>Shreyu N</span>
                              <span class="pro-user-desc text-muted d-block mt-1">Administrator </span>
                          </h6>
                      </div>
                      <span data-feather="chevron-down" class="ml-2 align-self-center"></span>
                  </div>
              </a>
              <div class="dropdown-menu profile-dropdown-items dropdown-menu-right">
                  <a href="pages-profile.html" class="dropdown-item notify-item">
                      <i data-feather="user" class="icon-dual icon-xs mr-2"></i>
                      <span>My Account</span>
                  </a>

                  <a href="javascript:void(0);" class="dropdown-item notify-item">
                      <i data-feather="settings" class="icon-dual icon-xs mr-2"></i>
                      <span>Settings</span>
                  </a>

                  <a href="javascript:void(0);" class="dropdown-item notify-item">
                      <i data-feather="help-circle" class="icon-dual icon-xs mr-2"></i>
                      <span>Support</span>
                  </a>

                  <a href="pages-lock-screen.html" class="dropdown-item notify-item">
                      <i data-feather="lock" class="icon-dual icon-xs mr-2"></i>
                      <span>Lock Screen</span>
                  </a>

                  <div class="dropdown-divider"></div>

                  <a href="javascript:void(0);" class="dropdown-item notify-item">
                      <i data-feather="log-out" class="icon-dual icon-xs mr-2"></i>
                      <span>Logout</span>
                  </a>
              </div>
          </li>
      </ul>
  </div>

</div>