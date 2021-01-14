@extends('layouts.admin')

@section('title')
All Roles
@endsection



@section('content')

<!-- Start Content-->
<div class="container-fluid">
  <div class="row page-title align-items-center">
    <div class="col-md-3 col-xl-6">
      <h4 class="mb-1 mt-0">@yield('title')</h4>
    </div>
    <div class="col-md-9 col-xl-6 text-md-right">
      <div class="mt-4 mt-md-0">
        <a href="{{ route('roles.create') }}" type="button" class="btn btn-danger mr-4 mb-3  mb-sm-0">
          <i class="uil-plus mr-1"></i>
          Add Role
        </a>
      </div>
    </div>
  </div>

  <div class="row">
    @if (isset($roles))
      @foreach ($roles as $role)
        <div class="col-xl-4 col-lg-6">
          <div class="card">
            <div class="card-body p-3">
                <div class="media">
                    <div class="media-body">
                        <h5 class="mt-1 mb-0">
                          <a href="{{ route('roles.show', $role) }}">
                            {{ $role->label ? Str::ucfirst(Str::limit($role->label, 70, '...')) : '' }}
                          </a>
                        </h5>
                        {{-- <p class="text-muted">Designer | Creative | Thinker</p> --}}
                    </div>
                </div>
                <div class="row mt-2 border-top pt-2">
                    <div class="col">
                        <div class="media">
                            <div class="media-body">
                            <h5 class="mt-2 pt-1 mb-0 font-size-16">{{ $role->permissions ? count($role->permissions) : 0 }}</h5>
                                <h6 class="font-weight-normal mt-0">Permissions</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="media">
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye icon-dual align-self-center mr-2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg> --}}
                            <div class="media-body">
                                <h5 class="mt-2 pt-1 mb-0 font-size-16">{{ $role->users ? count($role->users): 0 }}</h5>
                                <h6 class="font-weight-normal mt-0">Users</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3 text-center">
                    <div class="col">
                      <a href="{{ route('roles.show', $role) }}" type="button" class="btn btn-primary btn-sm btn-block mr-1">
                        View
                      </a>
                    </div>
                    @if (Auth::check())
                      @if (Auth::user()->hasRole('admin'))
                        <div class="col">
                          <a href="{{ route('roles.edit', $role) }}" type="button" class="btn btn-white btn-sm btn-block">Edit</a>
                        </div> 
                      @endif 
                    @endif
                </div>
            </div>
        </div>
          <!-- end card -->
        </div> 
      @endforeach
    @endif
    
  </div>
  <!-- end row -->

  <div class="row mb-3 mt-2">
    <div class="col-12">
      <div class="text-center">
        <a href="javascript:void(0);" class="btn btn-white">
          <i data-feather="loader" class="icon-dual icon-xs mr-2"></i>
          Load more
        </a>
      </div>
    </div> <!-- end col-->
  </div>
  <!-- end row -->

</div> <!-- container-fluid -->

@endsection