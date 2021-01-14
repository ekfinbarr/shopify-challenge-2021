@extends('layouts.admin')

@section('title')
{{ trans('All Courses') }}
@endsection



@section('content')

<!-- Start Content-->
<div class="container-fluid">
  <div class="row page-title align-items-center">
    <div class="col-md-3 col-xl-6">
      <h4 class="mb-1 mt-0">@yield('title')</h4>
    </div>
    @if (Auth::check() && Auth::user()->hasRole(['admin', 'super_admin']))
    <div class="col-md-9 col-xl-6 text-md-right">
      <div class="mt-4 mt-md-0">
        <a href="{{ route('courses.create') }}" type="button" class="btn btn-danger mr-4 mb-3  mb-sm-0">
          <i class="uil-plus mr-1"></i>
          {{ trans('Add New Course') }}
        </a>
      </div>
    </div>
    @endif
  </div>

  <div class="row">
    @if (isset($courses))
    <div class="col-xl-12 col-lg-12">
      <div class="card">
        <div class="card-body p-3">
          <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
              <tr>
                <th>#</th>
                <th>Title</th>
                <th>Class</th>
                <th>Credit Unit</th>
                <th>Department</th>
                <th>Teacher</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($courses as $index => $course)
              <tr>
                <th scope="row">{{ $index + 1 }}</th>
                <td>{{ $course->title ? Str::limit($course->title, 70, '...') : '' }}</td>
                <td>{{ $course->class ? Str::limit($course->class->label, 70, '...') : '' }}</td>
                <td>{{ $course->credit_unit ? $course->credit_unit : '' }}</td>
                <td>{{ $course->department ? $course->department->label : '' }}</td>
                <td>{{ $course->teacher ? $course->teacher->name : '' }}</td>
                <td>
                  @if ($course->is_private)
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
                  <div class="btn-group dropdown">
                    <button class="btn btn-primary">Options</button>
                    <button id="my-dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-caret-down" aria-hidden="true"></i>
                      <span class="sr-only">Toggle dropdown</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="my-dropdown">
                      <a class="dropdown-item" href="{{ route('courses.show', $course) }}">View</a>
                      <a class="dropdown-item"
                        href="{{ $course->timetable ? route('timetables.show', $course->timetable) : '#' }}">View
                        Timetable</a>
                      @if (Auth::check() && Auth::user()->hasRole(['admin', 'super_admin']))
                      <a class="dropdown-item" href="{{ route('courses.edit', $course) }}">Edit</a>
                      <a class="dropdown-item" href="{{ route('courses.destroy', $course) }}">Delete</a>
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