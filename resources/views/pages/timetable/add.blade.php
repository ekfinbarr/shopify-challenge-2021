@extends('layouts.admin')

@section('title')
All Timetables
@endsection



@section('content')
<div class="row page-title">
  <div class="col-md-12">
    <nav aria-label="breadcrumb" class="float-right mt-1">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ trans('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('timetables.index') }}">{{ trans('Timetable') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ trans('New Timetable') }}</li>
      </ol>
    </nav>
    <h4 class="mb-1 mt-0">{{ trans('New Timetable') }}</h4>
  </div>
</div>

<div class="row">
  <!-- end col -->
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title mt-0 mb-1">{{ trans('Timetable form') }}</h4>
        <p class="sub-header">{{ trans('Fill in the form to create a new timetable') }}</p>

        <div class="row mg-2">
          <div class="col-12">
            <form action="{{ route('timetables.store') }}" method="post">
              @csrf
              <div class="form-group col-lg-8">
                <label for="sw-dots-userName">Title</label>
                <input type="text" name="title" class="form-control" id="sw-dots-userName" required
                  placeholder="Enter title for timetable...">
              </div>

              <div class="form-group col-lg-8">
                <label for="sw-dots-userName">Description</label>
                <textarea name="description" class="form-control" rows="2" id="example-textarea" required></textarea>
              </div>

              @if (Auth::user()->hasRole(['admin']))
                <div class="form-group col-lg-6">
                  <label for="sw-dots-first-name">School</label>
                  <select name="school_id" class="custom-select custom-select-lg mb-2">
                    <option disabled>-- Select School --</option>
                    @foreach ($schools as $school)
                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                    @endforeach
                  </select>
                </div> 
                
              <div class="form-group col-lg-6">
                <label for="sw-dots-last-name">Class</label>
                <select name="class_id" class="custom-select custom-select-lg mb-2">
                  <option disabled>-- Select Class --</option>
                  @foreach ($classes as $class)
                  <option value="{{ $class->id }}">{{ $class->label }}</option>
                  @endforeach
                </select>
              </div>
              @endif

              <div class="form-group col-lg-6">
                <label for="sw-dots-last-name">Type</label>
                <select name="is_private" class="custom-select custom-select-lg mb-2" required>
                  <option disabled>-- Select timetable type --</option>
                  @if (Auth::user()->hasRole(['admin']))
                  <option value="false">Public timetable</option>
                  @endif
                  <option value="true">Private timetable</option>
                </select>
              </div>

              <hr class="mt-5 mb-3">

              <div class="form-group mt-2 mb-10">
                <div class="custom-control custom-radio mb-2">
                  <button type="submit" class="btn btn-primary">Submit</button>
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
  <style>
    .sw-toolbar-bottom {
      visibility: hidden;
    }
  </style>
</div>

@endsection