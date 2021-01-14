@extends('layouts.admin')

@section('title')
All Classes
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
        <a href="{{ route('classes.create') }}" type="button" class="btn btn-danger mr-4 mb-3  mb-sm-0">
          <i class="uil-plus mr-1"></i>
          Add Class
        </a>
      </div>
    </div>
  </div>

  <div class="row">
    @if (isset($classes))
    <div class="col-xl-12 col-lg-12">
      <div class="card">
        <div class="card-body p-3">
          <table id="school_classes_table" class="table table-striped table-bordered" style="width:100%">
            <thead>
              <tr>
                <th> # </th>
                <th>Name</th>
                <th>Lessons</th>
                <th>Members</th>
                <th>Membership Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($classes as $index => $class)
              <tr>
                <th scope="row">{{ $index + 1 }}</th>
                <td>{{ $class->label ? Str::limit($class->label, 70, '...') : '' }}</td>
                <td>{{ count($class->lessons) }}</td>
                <td>{{ count($class->users) }}</td>
                <td>
                  @if (Auth::user()->classMember($class->id))
                  <span class="badge badge-soft-success p-1">Joined</span>
                  @else
                  <span class="badge badge-soft-primary p-1">Not joined</span>
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
                      <a class="dropdown-item active" href="{{ route('classes.show', $class) }}">View</a>
                      <a class="dropdown-item active"
                        href="{{ $class->timetable ? route('timetables.show', $class->timetable) : '#' }}">View
                        Timetable</a>
                      @if (Auth::check() && Auth::user()->hasRole(['admin', 'super_admin']))
                      <a class="dropdown-item active" href="{{ route('classes.destroy', $class) }}">Delete</a>
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
              $('#school_classes_table').DataTable();
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