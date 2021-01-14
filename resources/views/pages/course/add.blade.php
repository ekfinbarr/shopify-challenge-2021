@extends('layouts.admin')

@section('title')
New Course
@endsection



@section('content')
<div class="row page-title">
  <div class="col-md-12">
    <nav aria-label="breadcrumb" class="float-right mt-1">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ trans('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">{{ trans('Courses') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ trans('New Course') }}</li>
      </ol>
    </nav>
    <h4 class="mb-1 mt-0">{{ trans('New Course') }}</h4>
  </div>
</div>

<div class="row">
  <!-- end col -->
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title mt-0 mb-1">{{ trans('Course form') }}</h4>
        <p class="sub-header">{{ trans('Fill in the form to add a new course') }}</p>

        <div class="row mg-2">
          <div class="col-12">
            <form action="{{ route('courses.store') }}" method="post">
              @csrf

              {{-- <div class="form-group col-lg-8">
                <label for="sw-dots-userName">Name</label>
                <input type="text" name="label" class="form-control" id="sw-dots-userName" required
                  placeholder="Enter name of class...">
              </div> --}}






            {{-- <input type="hidden" value="{{ $timetable ? $timetable->id : '' }}" required name="timetable_id"> --}}

            <input type="hidden" value="{{ isset(Auth::user()->school) ? Auth::user()->school->id : '' }}" required name="school_id">

            <div class="row">

              <div class="col-lg-6">
                <div class="form-group">
                  <label class="control-label">Title</label>
                  <input class="form-control" value="{{ old('title') }}" placeholder="Course title" type="text" name="title" id="course-title"
                    required />
                  <div class="invalid-feedback">Please provide a valid title</div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="control-label">Code</label>
                  <input class="form-control" value="{{ old('code') }}" placeholder="Course Code" type="text" name="code" id="code" />
                  <div class="invalid-feedback">Please provide a valid code</div>
                </div>
              </div>

              <div class="col-10">
                <div class="form-group">
                  <label class="control-label">Description</label>
                  <textarea class="form-control" value="{{ old('description') }}" placeholder="Course description" rows="3" name="description"
                    id="course-description"></textarea>
                  <div class="invalid-feedback">Please provide a valid title</div>
                </div>
              </div>

              
              @if (isset($classes) && Auth::user()->hasRole(['admin', 'super_admin']))

              <div class="form-group col-lg-10">
                <label for="sw-dots-first-name">Teacher</label>
                <select name="teacher_id" class="custom-select custom-select-md mb-2">
                  <option disabled>-- Select Teacher --</option>
                  @foreach ($teachers as $teacher)
                  <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-lg-10">
                <div class="form-group">
                  <label class="control-label">Class</label>
                  <select class="form-control custom-select" value="{{ old('class_id') }}" name="class_id" id="class_id">
                    @foreach ($classes as $index => $class)
                    <option value="{{$class->id}}" selected>{{ $class->label }}</option>
                    @endforeach
                  </select>
                  <div class="invalid-feedback">Please select a class</div>
                </div>
              </div>
              @endif


              <div class="col-lg-5">
                <div class="form-group">
                  <label class="control-label">Type </label>
                  <select class="form-control custom-select" value="{{ old('is_private') }}" name="is_private" id="privacy" required>
                    <option value="true" selected>Private</option>
                    @if(Auth::user()->hasRole(['admin', 'super_admin']))
                      <option value="false">Public</option>
                    @endif
                  </select>
                  <div class="invalid-feedback">Please select type</div>
                </div>
              </div>

              <div class="col-lg-5">
                <div class="form-group">
                  <label class="control-label">Credit Unit</label>
                  <input class="form-control" value="{{ old('credit_unit') }}" placeholder="Credit Unit" type="number" min="0" name="credit_unit" id="credit_unit"/>
                  <div class="invalid-feedback">Please provide a valid value for credit unit</div>
                </div>
              </div>



              <hr class="mt-5 mb-3">

              <div class="col-lg-12 mb-lg-5 mt-2">
                <div class="form-group mt-2 mb-10">
                  <div class="custom-control custom-radio mb-2">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </div>
              </div>

            </form>

          </div> <!-- end col -->
          
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