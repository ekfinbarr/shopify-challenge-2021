@extends('layouts.admin')

@section('title')
New User Role
@endsection



@section('content')
<div class="row page-title">
  <div class="col-md-12">
    <nav aria-label="breadcrumb" class="float-right mt-1">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ trans('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">{{ trans('Roles') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ trans('New User Role') }}</li>
      </ol>
    </nav>
    <h4 class="mb-1 mt-0">{{ trans('New User Role') }}</h4>
  </div>
</div>

<div class="row">
  <!-- end col -->
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title mt-0 mb-1">{{ trans('User Role form') }}</h4>
        <p class="sub-header">{{ trans('Fill in the form to add a new user role') }}</p>

        <div class="row mg-2">
          <div class="col-12">
            <form action="{{ route('roles.store') }}" method="post">
              @csrf
              <div class="form-group col-lg-8">
                <label for="sw-dots-userName">Name</label>
                <input type="text" name="label" class="form-control" id="name" required
                  placeholder="Enter name of role...">
              </div>

              <div class="form-group col-lg-8">
                <label for="sw-dots-userName">Description</label>
                <textarea name="description" rows="2" class="form-control" id="description" placeholder="Description..."></textarea>
              </div>

              <hr class="mt-5 mb-3">

              <div class="form-group mt-2 mb-10">
                <div class="custom-control custom-radio mb-2">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>

            </form>

          </div> <!-- end col -->
        </div> <!-- end row -->


      </div>
    </div>
    <!-- end card -->
  </div>
</div>

@endsection