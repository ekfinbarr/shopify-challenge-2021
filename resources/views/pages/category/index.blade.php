@extends('layouts.admin')

@section('title')
{{ trans('All Category') }}
@endsection



@section('content')

<!-- Start Content-->
<div class="container-fluid">
  <div class="row page-title align-items-center">
    <div class="col-md-3 col-xl-6">
      <h4 class="mb-1 mt-0">@yield('title')</h4>
    </div>
    @if (Auth::check() && Auth::user()->hasRole(['admin']))
    <div class="col-md-9 col-xl-6 text-md-right">
      <div class="mt-4 mt-md-0">
        <a href="{{ route('lessons.create') }}" type="button" class="btn btn-danger mr-4 mb-3  mb-sm-0">
          <i class="uil-plus mr-1"></i>
          {{ trans('Add Lesson') }}
        </a>
      </div>
    </div>
    @endif
  </div>

  <div class="row">
    @if (isset($lessons))
    <div class="col-xl-12 col-lg-12">
      <div class="card">
        <div class="card-body p-3">
          <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
              <tr>
                <th>#</th>
                <th>Title</th>
                <th>Course</th>
                <th>Class</th>
                <th>Weekday</th>
                <th>Start time</th>
                <th>End time</th>
                <th>Teacher</th>
                <th>Availability</th>
                <th>Notifications</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($lessons as $index => $lesson)
              <tr>
                <th scope="row">{{ $index + 1 }}</th>
                <td>{{ $lesson->title ? Str::limit($lesson->title, 70, '...') : '' }}</td>
                <td>{{ $lesson->course ? Str::limit($lesson->course->title, 70, '...') : '' }}</td>
                <td>{{ $lesson->class ? Str::limit($lesson->class->label, 70, '...') : '' }}</td>
                <td>{{ $lesson->weekday ? $lesson->weekday : '' }}</td>
                <td>{{ $lesson->start_time ? $lesson->start_time . $lesson->start_period : '' }}</td>
                <td>{{ $lesson->end_time ? $lesson->end_time . $lesson->end_period : '' }}</td>
                <td>{{ $lesson->teacher ? $lesson->teacher->name : '' }}</td>
                <td>
                  @if ($lesson->is_private)
                  <span class="badge badge-soft-danger p-1">
                    {{ trans('private') }}
                  </span>
                  @else
                  <span class="badge badge-soft-primary p-1">
                    {{ trans('public') }}
                  </span>
                  @endif  
                </td>
                <td>
                  @if ($lesson->notifications)
                  <span class="badge badge-soft-primary p-1">
                      {{ trans('enabled') }}
                  </span>
                  @else
                  <span class="badge badge-soft-danger p-1">
                      {{ trans('disabled') }}
                  </span>
                  @endif
                </td>
                <td>
                @if ($lesson->is_valid)
                <span class="badge badge-soft-primary p-1">
                  {{ trans('Active') }}
                </span>
                @else
                <span class="badge badge-soft-danger p-1">
                  {{ trans('Disabled') }}
                </span>
                @endif
                </td>
                <td>
                  <div class="btn-group dropdown">
                    <button class="btn btn-primary">Options</button>
                    <button id="my-dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-caret-down" aria-hidden="true"></i>
                      <span class="sr-only">Toggle dropdown</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="my-dropdown">
                      <a class="dropdown-item" href="{{ route('lessons.show', $lesson) }}">View</a>
                      <a class="dropdown-item"
                        href="{{ $lesson->timetable ? route('timetables.show', $lesson->timetable) : '#' }}">View
                        Timetable</a>
                      @if (Auth::check() && Auth::user()->hasRole(['admin']))
                      <a class="dropdown-item" href="{{ route('lessons.edit', $lesson) }}">Edit</a>
                      <a class="dropdown-item" href="{{ route('lessons.destroy', $lesson) }}">Delete</a>
                      @endif
                    </div>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <script>
            $(document).ready(function () {
              // $('#datatable-buttons').DataTable();
            });
          </script>
        </div>
      </div>
      <!-- end card -->
    </div>
    @endif

  </div>
  <!-- end row -->

</div> <!-- container-fluid -->

@endsection