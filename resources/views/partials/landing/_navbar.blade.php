<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('home') }}">
      <i class="fas fa-image mr-1"></i>
      {{ config('app.name') }}
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link nav-link-1 active" aria-current="page" href="{{ route('media.index') }}">Photos</a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link nav-link-2" href="videos.html">Videos</a>
        </li> --}}
        <li class="nav-item">
          <a class="nav-link nav-link-1" href="{{ route('about') }}">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-link-1" href="{{ route('contact') }}">Contact</a>
        </li>
        @if (Auth::check())
        <li class="nav-item">
          <a class="nav-link nav-link-1" href="{{ route('dashboard', ["path" => "dashboard"]) }}">{{ trans('Dashboard') }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-link-1" href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link nav-link-1" href="{{ route('login') }}">Login</a>
        </li>
        @endif
      </ul>
    </div>
  </div>
</nav>