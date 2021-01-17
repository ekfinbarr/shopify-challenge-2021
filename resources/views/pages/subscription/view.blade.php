@extends('layouts.admin')

@section('title')
View Lesson
@endsection



@section('content')

<!-- Start Content-->
@if (isset($lesson))
<div class="container-fluid">
  <div class="row page-title">
    <div class="col-sm-8 col-xl-6">
      <h4 class="mb-1 mt-0">
        Lesson: {{ $lesson->title }}
      </h4>
    </div>

    @if (Auth::user()->hasRole(['admin']))
    <div class="col-sm-4 col-xl-6 text-sm-right">
      <div class="btn-group ml-2 d-none d-sm-inline-block">
        <a href="{{ route('lessons.edit', $lesson) }}" type="button" class="btn btn-soft-primary btn-sm"><i
            class="uil uil-edit mr-1"></i>Edit</a>
      </div>
      <div class="btn-group d-none d-sm-inline-block">
        <a href="{{ route('lessons.destroy', $lesson) }}" type="button" class="btn btn-soft-danger btn-sm"><i
            class="uil uil-trash-alt mr-1"></i>Delete</a>
      </div>
    </div>
    @endif

  </div>
  
  <!-- details-->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h6 class="mt-0 header-title">About Lesson</h6>

          <div class="text-muted mt-3">
            <p>
              {{ $lesson->description ? $lesson->description : '' }}
            </p>


            <div class="row">
              <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="mt-4">
                  <p class="mb-2"><i class="uil-calender text-danger font-size-20"></i> Start Time</p>
                  <h5 class="font-size-16">{{ $lesson->weekday ? Str::ucfirst($lesson->weekday) : '' }}</h5>
                </div>
              </div>
              <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="mt-4">
                  <p class="mb-2"><i class="uil-book-open text-danger font-size-20"></i> Course</p>
                  <h5 class="font-size-16">{{ $lesson->course ? Str::ucfirst($lesson->course->title) : '' }}</h5>
                </div>
              </div>
              <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="mt-4">
                  <p class="mb-2"><i class="uil-stopwatch text-danger font-size-20"></i> Starting</p>
                  <h5 class="font-size-16">{{ $lesson->start_time ? $lesson->start_time . ' ' . $lesson->start_period : '' }}</h5>
                </div>
              </div>
              <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="mt-4">
                  <p class="mb-2"><i class="uil-stopwatch-slash text-danger font-size-20"></i> Ending</p>
                  <h5 class="font-size-16">{{ $lesson->end_time ? $lesson->end_time . ' ' . $lesson->end_period : '' }}</h5>
                </div>
              </div>
              <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="mt-4">
                  <p class="mb-2"><i class="uil-arrows-shrink-h text-danger font-size-20"></i> Duration</p>
                  <h5 class="font-size-16">{{ $lesson->difference <= 1 ? $lesson->difference . ' min' : $lesson->difference . ' mins' }}</h5>
                </div>
              </div>

              <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="mt-4">
                  <p class="mb-2"><i class="uil-user text-danger"></i> Teacher</p>
                  <h5 class="font-size-16">{{ $lesson->teacher ? $lesson->teacher->name : '' }}</h5>
                </div>
              </div>
            </div>

          </div>

        </div>
      </div>
      <!-- end card -->
    </div>
  </div>
</div>
<!-- end row -->

</div> <!-- container-fluid -->
@endif


@endsection