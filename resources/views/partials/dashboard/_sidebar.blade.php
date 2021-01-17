<div class="left-side-menu">
  <div class="media user-profile mt-2 mb-2">
    {{-- <img src="assets/images/users/avatar-7.jpg" class="avatar-sm rounded-circle mr-2" alt="Shreyu" />
      <img src="assets/images/users/avatar-7.jpg" class="avatar-xs rounded-circle mr-2" alt="Shreyu" /> --}}

    <div class="media-body">
      <h6 class="pro-user-name mt-0 mb-0">
        {{ Auth::check() ? Auth::user()->name : '' }}
      </h6>
      {{-- <span class="pro-user-desc">Administrator</span> --}}
    </div>
    <div class="dropdown align-self-center profile-dropdown-menu">
      <a class="dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
        aria-expanded="false">
        <span data-feather="chevron-down"></span>
      </a>
      <div class="dropdown-menu profile-dropdown">
        <a href="{{ route('users.show', Auth::user()) }}" class="dropdown-item notify-item">
          <i data-feather="user" class="icon-dual icon-xs mr-2"></i>
          <span>{{ trans('My Account') }}</span>
        </a>

        <a href="{{ route('users.show', Auth::user()) }}" class="dropdown-item notify-item">
          <i data-feather="settings" class="icon-dual icon-xs mr-2"></i>
          <span>{{ trans('Settings') }}</span>
        </a>

        {{-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                  <i data-feather="help-circle" class="icon-dual icon-xs mr-2"></i>
                  <span>Support</span>
              </a> --}}

        {{-- <a href="pages-lock-screen.html" class="dropdown-item notify-item">
                  <i data-feather="lock" class="icon-dual icon-xs mr-2"></i>
                  <span>Lock Screen</span>
              </a> --}}

        <div class="dropdown-divider"></div>

        <a href="{{ route('logout') }}" class="dropdown-item notify-item" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
          <i data-feather="log-out" class="icon-dual icon-xs mr-2"></i>
          <span>{{ __('Logout') }}</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
      </div>
    </div>
  </div>
  <div class="sidebar-content">
    <!--- Sidemenu -->
    <div id="sidebar-menu" class="slimscroll-menu">
      <ul class="metismenu" id="menu-bar">
        <li class="menu-title">{{ trans('Navigation') }}</li>

        <li>
          <a href="{{ route('dashboard') }}">
            <i data-feather="home"></i>
            {{-- <span class="badge badge-success float-right">1</span> --}}
            <span> {{ trans('Dashboard') }} </span>
          </a>
        </li>

        @if (Auth::user()->hasRole(['admin']))
        <li>
          <a href="{{ route('media.index') }}">
            <i data-feather="award"></i>
            <span> {{ trans('Earnings') }} </span>
          </a>
        </li>
        @endif

        <li>
          <a href="{{ route('media.index') }}">
            <i data-feather="aperture"></i>
            <span> {{ trans('Content Manager') }} </span>
          </a>
        </li>

        @if (Auth::user()->hasRole(['admin']))
        <li>
          <a href="{{ route('categories.index') }}" title="Manage Media Categories">
            <i data-feather="menu"></i>
            <span> {{ trans('Categories') }} </span>
          </a>
        </li>
        <li>
          <a href="{{ route('tags.index') }}" title="Manage Media Tags">
            <i data-feather="tag"></i>
            <span> {{ trans('Tags') }} </span>
          </a>
        </li>
        <li>
          <a href="{{ route('media_formats.index') }}" title="Manage Media Formats">
            <i data-feather="tag"></i>
            <span> {{ trans('Media Formats') }} </span>
          </a>
        </li>
        <li>
          <a href="{{ route('media_types.index') }}" title="Manage Media Types">
            <i data-feather="tag"></i>
            <span> {{ trans('Media Types') }} </span>
          </a>
        </li>
        <li>
          <a href="{{ route('roles.index') }}" title="Manage user roles and permissions">
            <i data-feather="lock"></i>
            <span> {{ trans('Roles/Permissions') }} </span>
          </a>
        </li>

        <li>
          <a href="{{ route('users.index') }}" title="Manage users and accounts">
            <i data-feather="users"></i>
            <span> {{ trans('User Manager') }} </span>
          </a>
        </li>
        @endif

        @if (!Auth::user()->hasRole(['admin']))
        <li>
          <a href="{{ route('users.show', Auth::user()) }}" title="Manage Profile">
            <i data-feather="user"></i>
            <span> {{ trans('Profile') }} </span>
          </a>
        </li>
        @endif

        <li>
          <a href="{{ route('notifications.index') }}">
            <i data-feather="bell"></i>
            @if (Auth::check() && Auth::user()->unreadNotifications())
            <span class="badge badge-primary float-right">
              {{ count(Auth::user()->notifications->where('read_at', '')) }}
            </span>
            @endif
            <span> {{ trans('Notifications') }} </span>
          </a>
        </li>

        {{-- <li>
                  <a href="javascript: void(0);">
                      <i data-feather="briefcase"></i>
                      <span> Projects </span>
                      <span class="menu-arrow"></span>
                  </a>

                  <ul class="nav-second-level" aria-expanded="false">
                      <li>
                          <a href="project-list.html">List</a>
                      </li>
                      <li>
                          <a href="project-detail.html">Detail</a>
                      </li>
                  </ul>
              </li>
              <li>
                  <a href="javascript: void(0);">
                      <i data-feather="bookmark"></i>
                      <span> Tasks </span>
                      <span class="menu-arrow"></span>
                  </a>

                  <ul class="nav-second-level" aria-expanded="false">
                      <li>
                          <a href="task-list.html">List</a>
                      </li>
                      <li>
                          <a href="task-board.html">Kanban Board</a>
                      </li>
                  </ul>
              </li> --}}
      </ul>
    </div>
    <!-- End Sidebar -->

    <div class="clearfix"></div>
  </div>
  <!-- Sidebar -left -->

</div>