@extends('layouts.admin')

@section('title')
View User Role
@endsection



@section('content')

<!-- Start Content-->
@if (isset($role))
<div class="container-fluid">
  <div class="row page-title">
    <div class="col-sm-8 col-xl-6">
      <h4 class="mb-1 mt-0">
        Role: {{ $role->label }}
      </h4>
    </div>
    <div class="col-sm-4 col-xl-6 text-sm-right">
      <div class="btn-group ml-2 d-none d-sm-inline-block">
        <a href="{{ route('roles.edit', $role) }}" type="button" class="btn btn-soft-primary btn-sm"><i
            class="uil uil-edit mr-1"></i>Edit</a>
      </div>
      <div class="btn-group ml-2 d-none d-sm-inline-block">
        <a href="{{ route('role_permissions', $role) }}" type="button" class="btn btn-soft-success btn-sm"><i
            class="uil uil-lock mr-1"></i>Manage Permissions</a>
      </div>
      <div class="btn-group d-none d-sm-inline-block">
        <a href="{{ route('roles.destroy', $role) }}" type="button" class="btn btn-soft-danger btn-sm"><i
            class="uil uil-trash-alt mr-1"></i>Delete</a>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body p-0">
          <h6 class="card-title border-bottom p-3 mb-0 header-title">Overview</h6>
          <div class="row py-1">
            <div class="col-xl-3 col-sm-6">
              <!-- stat 1 -->
              <div class="media p-3">
                <i data-feather="users" class="align-self-center icon-dual icon-lg mr-4"></i>
                <div class="media-body">
                  <h4 class="mt-0 mb-0">
                    {{ $role->users ? count($role->users) : '0' }}
                  </h4>
                  <span class="text-muted font-size-13">Users</span>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6">
              <!-- stat 2 -->
              <div class="media p-3">
                <i data-feather="check-square" class="align-self-center icon-dual icon-lg mr-4"></i>
                <div class="media-body">
                  <h4 class="mt-0 mb-0">{{ $role->permissions ? count($role->permissions) : '0' }}</h4>
                  <span class="text-muted">Permissions</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- details-->
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          @if (isset($role->description))
          <h6 class="mt-0 header-title">Desription</h6>

          <div class="text-muted mt-3">
            {{ $role->description ? $role->description : '' }}
          </div>
          @endif

          @if (isset($role->permissions))
          <h6 class="mt-4 header-title">Permissions</h6>

          <div class="text-muted mt-3">
            <div class="row icons-list-demo">
              @foreach ($role->permissions as $p)
              <div class="col-xl-3 col-lg-4 col-sm-6" title="{{ $p->label }}">
                <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                {{ $p->label }}
              </div>
              @endforeach
            </div>
          </div>
          @endif
        </div>

      </div>
      <!-- end card -->
    </div>
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          <h6 class="mt-0 header-title">Recent Users</h6>

          <ul class="list-unstyled activity-widget">
            @if (isset($role->users))
              @foreach ($role->users as $index => $user)
                @if ($index < 5)
                <div class="media border-top pt-3">
                  <div class="text-center mr-3">
                    <div class="avatar-sm">
                        <span class="avatar-title rounded-circle bg-soft-info text-info">
                          {{ $user->name ? Str::substr(Str::ucfirst($user->name), 0, 1) : '' }}
                        </span>
                    </div>
                  </div>
                    <div class="media-body">
                      <h5 class="font-size-15 mt-2 mb-1">
                      <a href="{{ route('users.show', $user) }}" class="text-dark">
                          {{ $user->name ? $user->name : '' }}
                        </a>
                      </h5>
                    <h6 class="text-muted font-weight-normal mt-1 mb-3">{{ $user->email ? $user->email : '' }}</h6>
                    </div>
                    <div class="dropdown align-self-center float-right">
                        <a href="#" class="dropdown-toggle arrow-none text-muted" data-toggle="dropdown" aria-expanded="false">
                            <i class="uil uil-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(16px, 20px, 0px);">
                            <!-- item-->
                            <a href="{{ route('users.edit', $user) }}" class="dropdown-item"><i class="uil uil-edit-alt mr-2"></i>Edit</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item"><i class="uil uil-exit mr-2"></i>Remove from Role</a>
                            <div class="dropdown-divider"></div>
                            <!-- item-->
                            <a href="{{ route('users.destroy', $user) }}" class="dropdown-item text-danger"><i class="uil uil-trash mr-2"></i>Delete</a>
                        </div>
                    </div>
                </div>
                @endif
              @endforeach
            @endif
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- end row -->


</div> <!-- container-fluid -->
@endif


@endsection