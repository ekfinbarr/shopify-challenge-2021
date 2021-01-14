@extends('layouts.admin')

@section('title')
Update Role Permissions
@endsection



@section('content')
<div class="row page-title">
  <div class="col-md-12">
    <nav aria-label="breadcrumb" class="float-right mt-1">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ trans('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">{{ trans('Roles') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ trans('Update Role Permissions') }}</li>
      </ol>
    </nav>
    <h4 class="mb-1 mt-0">{{ trans('Update Role Permissions') }}</h4>
  </div>
</div>

<div class="row">
  <!-- end col -->
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title mt-0 mb-1">{{ trans('Role Permissions Form') }}</h4>
        {{-- <p class="sub-header">{{ trans('Fill in the form to update user role') }}</p> --}}

        @if (isset($permissions))
        <div class="row mg-2">
          <div class="col-12">
            <form action="{{ route('assign_role_permission', $role) }}" method="post">
              @csrf
              @method('POST')
            <input type="hidden" name="role_id" value="{{ $role->id }}">
              <div class="form-group mt-5">
                <div class="custom-control custom-radio mb-2">
                  <button type="submit" class="btn btn-primary">Submit Update</button>
                </div>
              </div>

              <hr class="mb-5">

                @foreach ($permissions as $p)
                <div class="mt-3 col-lg-3">
                  <div class="custom-control custom-checkbox mb-2 col-3">
                  <input type="checkbox" class="custom-control-input" name="permissions[]" value="{{ $p->id }}" id="{{ 'permission-'.$p->id }}" {{ $role->hasPermission($p->name) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="{{ 'permission-'.$p->id }}">
                      {{ $p->label ? $p->label : ''}}
                    </label>
                  </div> 
                </div>
                @endforeach
              <hr class="mt-5 mb-3">

              <div class="form-group mt-2 mb-10">
                <div class="custom-control custom-radio mb-2">
                  <button type="submit" class="btn btn-primary">Submit Update</button>
                </div>
              </div>

            </form>

          </div> <!-- end col -->
        </div> <!-- end row -->
            
        @endif


      </div>
    </div>
    <!-- end card -->
  </div>
</div>

@endsection