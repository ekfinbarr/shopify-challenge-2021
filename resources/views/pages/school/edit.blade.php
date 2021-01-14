@extends('layouts.admin')

@section('title')
Edit School
@endsection



@section('content')
<div class="row page-title">
  <div class="col-md-12">
    <nav aria-label="breadcrumb" class="float-right mt-1">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ trans('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('schools.index') }}">{{ trans('Schools') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ trans('Edit School') }}</li>
      </ol>
    </nav>
    <h4 class="mb-1 mt-0">{{ trans('Edit School') }}</h4>
  </div>
</div>

<div class="row">
  <!-- end col -->
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title mt-0 mb-1">{{ trans('School update form') }}</h4>
        {{-- <p class="sub-header">{{ trans('Fill in the form to add a new school') }}</p> --}}

        <div class="row mg-2">
          <div class="col-12">
            <form action="{{ route('schools.update', $school) }}" method="post">
              @csrf
              @method('PUT')

              <div class="form-group col-lg-8">
                <label for="sw-dots-userName">Name</label>
              <input type="text" name="name" value="{{ $school->name }}" class="form-control" id="sw-dots-userName" required
                  placeholder="Enter name of school...">
              </div>

              <div class="form-group col-lg-8">
                <label for="sw-dots-userName">Description</label>
                <textarea name="description" class="form-control" rows="4" id="example-textarea" required>{{ $school->description }}</textarea>
              </div>

              <div class="form-group col-lg-8">
                <label for="sw-dots-userName">Address</label>
              <textarea name="address" class="form-control" rows="2" required>{{ $school->address }} </textarea>
              </div>


              <div class="form-group col-lg-8">
                <label for="sw-dots-userName">Email</label>
                <input type="email" name="email" value="{{ $school->email }}" class="form-control" id="sw-dots-userName" placeholder="Enter name of school...">
              </div>

              <div class="form-group col-lg-6">
                <label for="sw-dots-first-name">Country</label>
                <select name="school_id" class="custom-select custom-select-lg mb-2">
                  <option disabled>-- Select Country --</option>
                  @foreach ($countries as $country)
                    <option value="{{ $country }}">{{ $country }}</option>
                  @endforeach
                </select>
              </div>


              <hr class="mt-5 mb-3">

              <div class="form-group mt-2 mb-10">
                <div class="custom-control custom-radio mb-2">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </div>

            </form>

          </div> <!-- end col -->
          
          @if (session('success'))
            <div class="col-12">
              <div class="text-center">
                <div class="mb-3">
                  <i class="uil uil-check-square text-success h2"></i>
                </div>
                <h3>Thank you !</h3>

                <p class="w-75 mb-2 mx-auto text-muted">Quisque nec turpis at urna dictum luctus. Suspendisse
                  convallis dignissim eros at volutpat. In egestas mattis dui. Aliquam
                  mattis dictum aliquet.</p>

                <div class="mb-3">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="sm-dots-customCheck">
                    <label class="custom-control-label" for="sm-dots-customCheck">I agree with the Terms and
                      Conditions</label>
                  </div>
                </div>
              </div>
            </div> <!-- end col -->
          @endif
        </div> <!-- end row -->


      </div>
    </div>
    <!-- end card -->
  </div>
  <!-- end col -->
</div>

@endsection