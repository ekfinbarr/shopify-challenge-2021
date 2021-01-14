@extends('layouts.admin')

@section('title')
New Lesson
@endsection



@section('content')
<div class="row page-title">
  <div class="col-md-12">
    <nav aria-label="breadcrumb" class="float-right mt-1">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ trans('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('lessons.index') }}">{{ trans('Lessons') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ trans('New Lesson') }}</li>
      </ol>
    </nav>
    <h4 class="mb-1 mt-0">{{ trans('New Lesson') }}</h4>
  </div>
</div>

<div class="row">
  <!-- end col -->
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title mt-0 mb-1">{{ trans('Lesson form') }}</h4>
        <p class="sub-header">{{ trans('Fill in the form to add a new lesson') }}</p>

        <div class="row mg-2">
          <div class="col-12">
            <form action="{{ route('lessons.store') }}" method="post">
              @csrf

              {{-- <div class="form-group col-lg-8">
                <label for="sw-dots-userName">Name</label>
                <input type="text" name="label" class="form-control" id="sw-dots-userName" required
                  placeholder="Enter name of class...">
              </div> --}}






            {{-- <input type="hidden" value="{{ $timetable ? $timetable->id : '' }}" required name="timetable_id"> --}}

            <input type="hidden" value="{{ isset(Auth::user()->school) ? Auth::user()->school->id : '' }}" required name="school_id">

            <div class="row">

              <div class="form-group col-lg-10">
                <label for="sw-dots-first-name">Timetable</label>
                <select name="school_id" class="custom-select custom-select-md mb-2">
                  <option disabled>-- Select Timetable --</option>
                  @foreach ($timetables as $timetable)
                  <option value="{{ $timetable->id }}">{{ $timetable->title }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-lg-5">
                <div class="form-group">
                  <label class="control-label">Title</label>
                  <input class="form-control" value="{{ old('title') }}" placeholder="Lesson title" type="text" name="title" id="lesson-title"
                    required />
                  <div class="invalid-feedback">Please provide a valid title</div>
                </div>
              </div>

              <div class="col-lg-5">
                <div class="form-group">
                  <label class="control-label">Courses </label>
                  <select class="form-control custom-select" value="{{ old('course_id') }}" name="course_id" id="course_id">
                    @foreach ($courses as $course)
                      <option value="{{ $course->id }}" selected>{{ $course->code ? $course->title . ' ['.$course->code .'] ' : $course->title }}</option>
                    @endforeach
                  </select>
                  <div class="invalid-feedback">Please select a course</div>
                </div>
              </div>

              <div class="col-10">
                <div class="form-group">
                  <label class="control-label">Description</label>
                  <textarea class="form-control" value="{{ old('description') }}" placeholder="Lesson description" rows="3" required name="description"
                    id="lesson-description"></textarea>
                  <div class="invalid-feedback">Please provide a valid title</div>
                </div>
              </div>

              <div class="col-10">
                <div class="form-group">
                  <label class="control-label">Weekday</label>
                  <select class="form-control custom-select" value="{{ old('weekday') }}" name="weekday" id="weekday" required>
                    @if (config('weekdays'))
                    @foreach (config('weekdays') as $index => $weekday)
                    <option value="{{ Str::lower($weekday) }}" selected>{{ $weekday }}</option>
                    @endforeach
                    @endif
                  </select>
                  <div class="invalid-feedback">Please select a valid event category</div>
                </div>
              </div>

              <div class='col-lg-5 mb-lg-3'>
                <label for="">start time</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="validationTooltipUsernamePrepend">
                      <i class="fa fa-clock-o" aria-hidden="true"></i>
                    </span>
                  </div>
                  <input type="text" value="{{ old('start_time') }}" name="start_time" class="form-control" id="start_time_picker"
                    placeholder="Start time" required>
                </div>
                {{-- <input type='text' class="form-control" id='start_time_picker' /> --}}
              </div>

              <div class='col-lg-5 mb-lg-3'>
                <label for="">end time</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="validationTooltipUsernamePrepend">
                      <i class="fa fa-clock-o" aria-hidden="true"></i>
                    </span>
                  </div>
                  <input type="text" name="end_time" value="{{ old('end_time') }}" class="form-control" id="end_time_picker" placeholder="End time"
                    required>
                </div>
              </div>

              <script>
                $(function () {
                  $('#start_time_picker').datetimepicker({
                    format: 'LT'
                  });
                  $('#end_time_picker').datetimepicker({
                    format: 'LT'
                  });
                  $("#start_time_picker").on("dp.change", function (e) {
                    $('#end_time_picker').data("DateTimePicker").minDate(e.date);
                  });
                  $("#end_time_picker").on("dp.change", function (e) {
                    $('#start_time_picker').data("DateTimePicker").maxDate(e.date);
                  });
                });

                (function ($) {
                $(function () {
                  $('input.timepicker').timepicker();
                });
              })(jQuery);
              </script>

              @if (isset($classes) && Auth::user()->hasRole(['admin', 'super_admin']))
              <div class="col-lg-10">
                <div class="form-group">
                  <label class="control-label">Class</label>
                  <select class="form-control custom-select" value="{{ old('class_id') }}" name="class_id" id="class_id">
                    @foreach ($classes as $index => $class)
                    <option value="{{$class->id}}" selected>{{ $class->name }}</option>
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
                  <label class="control-label">Notifications </label>
                  <select class="form-control custom-select" value="{{ old('notifications') }}" name="notifications" id="event-category" required>
                    <option value="true" selected>Allow Notifications</option>
                    <option value="false">Keep everything silent</option>
                  </select>
                  <div class="invalid-feedback">Please select a mode of notifications</div>
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