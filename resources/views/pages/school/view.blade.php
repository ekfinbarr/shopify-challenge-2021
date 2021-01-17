@extends('layouts.admin')

@section('title')
View Timetable
@endsection



@section('content')

<!-- Start Content-->
@if (isset($school))
<div class="container-fluid">
  <div class="row page-title">
    <div class="col-sm-8 col-xl-6">
      <h4 class="mb-1 mt-0">
        School: {{ $school->name }}
      </h4>
    </div>

    @if (Auth::user()->hasRole(['admin']))
    <div class="col-sm-4 col-xl-6 text-sm-right">
      <div class="btn-group ml-2 d-none d-sm-inline-block">
        <a href="{{ route('schools.edit', $school) }}" type="button" class="btn btn-soft-primary btn-sm"><i
            class="uil uil-edit mr-1"></i>Edit</a>
      </div>
      <div class="btn-group d-none d-sm-inline-block">
        <a href="{{ route('schools.destroy', $school) }}" type="button" class="btn btn-soft-danger btn-sm"><i
            class="uil uil-trash-alt mr-1"></i>Delete</a>
      </div>
    </div>
    @endif

  </div>

  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body p-0">
          <h6 class="card-title border-bottom p-3 mb-0 header-title">Overview</h6>
          <div class="row py-1">
            <div class="col-xl-3 col-sm-6">
              <!-- stat 1 -->
              <div class="media p-3">
                <i data-feather="grid" class="align-self-center icon-dual icon-lg mr-4"></i>
                <div class="media-body">
                  <h4 class="mt-0 mb-0">
                    {{ $school->classes ? count($school->classes) : '0' }}
                  </h4>
                  <span class="text-muted font-size-13">{{ count($school->classes) <= 1 ? 'Class' : 'Classes' }}</span>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6">
              <!-- stat 2 -->
              <div class="media p-3">
                <i data-feather="calendar" class="align-self-center icon-dual icon-lg mr-4"></i>
                <div class="media-body">
                  <h4 class="mt-0 mb-0">{{ $school->timetables ? count($school->timetables) : '0' }}</h4>
                  <span class="text-muted">{{ count($school->timetables) <= 1 ? 'Timetable' : 'Timetables' }}</span>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6">
              <!-- stat 2 -->
              <div class="media p-3">
                <i data-feather="list" class="align-self-center icon-dual icon-lg mr-4"></i>
                <div class="media-body">
                  <h4 class="mt-0 mb-0">{{ $school->lessons ? count($school->lessons) : '0' }}</h4>
                  <span class="text-muted">{{ count($school->lessons) <= 1 ? 'Lesson' : 'Lessons' }}</span>
                </div>
              </div>
            </div>
            @if (Auth::user()->hasRole(['admin']))
            <div class="col-xl-3 col-sm-6">
              <!-- stat 2 -->
              <div class="media p-3">
                <i data-feather="users" class="align-self-center icon-dual icon-lg mr-4"></i>
                <div class="media-body">
                  <h4 class="mt-0 mb-0">{{ $school->users ? count($school->users) : '0' }}</h4>
                  <span class="text-muted">{{ count($school->users) <= 1 ? 'User' : 'Users' }}</span>
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- details-->
  <div class="row">
    <div class="col-xl-8">
      <div class="card">
        <div class="card-body">
          <h6 class="mt-0 header-title">About School</h6>

          <div class="text-muted mt-3">
            <p>
              {{ $school->description ? $school->description : '' }}
            </p>

            {{-- <div class="row">
              <div class="col-lg-3 col-md-6">
                <div class="mt-4">
                  <p class="mb-2"><i class="uil-calender text-danger"></i> Start Date</p>
                  <h5 class="font-size-16">15 July, 2019</h5>
                </div>
              </div>
              <div class="col-lg-3 col-md-6">
                <div class="mt-4">
                  <p class="mb-2"><i class="uil-calendar-slash text-danger"></i> Due Date</p>
                  <h5 class="font-size-16">15 July, 2019</h5>
                </div>
              </div>
              <div class="col-lg-3 col-md-6">
                <div class="mt-4">
                  <p class="mb-2"><i class="uil-dollar-alt text-danger"></i> Budget</p>
                  <h5 class="font-size-16">$1325</h5>
                </div>
              </div>

              <div class="col-lg-3 col-md-6">
                <div class="mt-4">
                  <p class="mb-2"><i class="uil-user text-danger"></i> Owner</p>
                  <h5 class="font-size-16">Rick Perry</h5>
                </div>
              </div>
            </div> --}}

          </div>

        </div>
      </div>
      <!-- end card -->
    </div>
    <div class="col-xl-4">
      <div class="card">
        <div class="card-body">
          <h6 class="mt-0 header-title">Classes</h6>

          <ul class="list-unstyled activity-widget">
            @if (isset($school->classes))

            @endif
            @foreach ($school->classes as $index => $class)
            @if ($index < 5) <li class="activity-list">
              <div class="media">
                <div class="text-center mr-3">
                  <div class="avatar-sm">
                    <span
                      class="avatar-title rounded-circle bg-soft-primary text-primary">{{ Str::substr($class->label, 0, 1) }}</span>
                  </div>
                  {{-- <p class="text-muted font-size-13 mb-0">Jan</p> --}}
                </div>
                <div class="media-body overflow-hidden">
                  <h5 class="font-size-15 mt-2 mb-1">
                    <a href="{{ route('classes.show', $class) }}"
                      class="text-dark">{{ $class->label ? $class->label : '' }}</a>
                  </h5>
                  <p class="text-muted font-size-13 text-truncate mb-0">
                    {{ $school->description ? Str::limit($school->description, 50, '...') : '' }}
                  </p>
                </div>
              </div>
              </li>
              @endif
              @endforeach
          </ul>
          {{-- <div class="text-center">
            <a href="{{ route('schools.show', $school) }}" class="btn btn-sm border btn-white">
          <i data-feather="loader" class="icon-dual icon-xs mr-2"></i>
          Load more
          </a>
        </div> --}}
      </div>
    </div>
  </div>
</div>
<!-- end row -->

</div> <!-- container-fluid -->
@endif


@endsection