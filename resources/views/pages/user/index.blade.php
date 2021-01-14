@extends('layouts.admin')

@section('title')
Users
@endsection



@section('content')

<!-- Start Content-->
<div class="container-fluid">
  <div class="row page-title align-items-center">
    <div class="col-md-3 col-xl-6">
      <h4 class="mb-1 mt-0">@yield('title')</h4>
    </div>
    {{-- <div class="col-md-9 col-xl-6 text-md-right">
      <div class="mt-4 mt-md-0">
        <a href="{{ route('roles.create') }}" type="button" class="btn btn-danger mr-4 mb-3  mb-sm-0">
          <i class="uil-plus mr-1"></i>
          Add Role
        </a>
      </div>
    </div> --}}
  </div>

  <div class="row">
    @if (isset($users))
        <div class="col-xl-12 col-lg-12">
          <div class="card">
            <div class="card-body p-3">
              <table id="users_table" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Date verified</th>
                        <th>Roles</th>
                        <th>Class</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                  @foreach ($users as $user)
                    <tr>
                    <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                          @if (isset($user->email_verified_at))
                            {{ $user->email_verified_at }}
                          @endif
                        </td>
                        <td>
                          @if (isset($user->roles))
                            @foreach ($user->roles as $role)
                              <span class="badge badge-soft-primary p-1">{{ $role->label }}</span>
                            @endforeach
                          @endif
                        </td>
                        <td>
                          {{ $user->class ? $user->class->label : '' }}
                        </td>
                        <td>
                          <div class="btn-group dropdown">
                            <button class="btn btn-primary">Manage</button>
                            <button id="my-dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fa fa-caret-down" aria-hidden="true"></i>
                              <span class="sr-only">Toggle dropdown</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="my-dropdown">
                            <a class="dropdown-item active" href="{{ route('users.show', $user) }}">View</a>
                            <a class="dropdown-item active" href="{{ route('users.show', $user) . '#roles' }}">Manage Role</a>
                            <a class="dropdown-item active" href="{{ route('users.destroy', $user) }}">Delete</a>
                            </div>
                          </div>
                        </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              <script>
                $(document).ready(function() {
                    $('#users_table').DataTable();
                } );
              </script>
            </div>
        </div>
          <!-- end card -->
        </div> 
    @endif
    
  </div>
  <!-- end row -->

  {{-- <div class="row mb-3 mt-2">
    <div class="col-12">
      <div class="text-center">
        <a href="javascript:void(0);" class="btn btn-white">
          <i data-feather="loader" class="icon-dual icon-xs mr-2"></i>
          Load more
        </a>
      </div>
    </div> <!-- end col-->
  </div> --}}
  <!-- end row -->

</div> <!-- container-fluid -->

@endsection