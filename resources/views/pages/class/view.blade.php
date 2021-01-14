@extends('layouts.admin')

@section('title')
View Class
@endsection



@section('content')

<!-- Start Content-->
@if (isset($class))
<div class="container-fluid">
  <div class="row page-title">
    <div class="col-sm-8 col-xl-6">
      <h4 class="mb-1 mt-0">
        Class: {{ $class->label }}
      </h4>
    </div>
    <div class="col-sm-4 col-xl-6 text-sm-right">
      <div class="btn-group ml-2 d-none d-sm-inline-block">
      <a href="{{ route('classes.edit', $class) }}" type="button" class="btn btn-soft-primary btn-sm"><i class="uil uil-edit mr-1"></i>Edit</a>
      </div>
      <div class="btn-group ml-2 d-none d-sm-inline-block">
      <a href="{{ isset($class->timetable) ? route('timetables.show', $class->timetable) : route('timetables.create') }}" type="button" class="btn btn-soft-success btn-sm">
        <i class="uil uil-calender mr-1"></i>
        {{ isset($class->timetable) ? 'Manage Timetable' : 'Add Timetable' }}
      </a>
      </div>
      <div class="btn-group d-none d-sm-inline-block">
      <a href="{{ route('classes.destroy', $class) }}" type="button" class="btn btn-soft-danger btn-sm"><i class="uil uil-trash-alt mr-1"></i>Delete</a>
      </div>
    </div>
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
                    {{ $class->users ? count($class->users) : '0' }}
                  </h4>
                  <span class="text-muted font-size-13">Members</span>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6">
              <!-- stat 2 -->
              <div class="media p-3">
                <i data-feather="check-square" class="align-self-center icon-dual icon-lg mr-4"></i>
                <div class="media-body">
                  <h4 class="mt-0 mb-0">{{ $class->lessons ? count($class->lessons) : '0' }}</h4>
                  <span class="text-muted">Lessons</span>
                </div>
              </div>
            </div>
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
          <h6 class="mt-0 header-title">Timetable</h6>

          <div class="text-muted mt-3">
            <div id="app">
              <example-component></example-component>
            </div>
          </div>

        </div>
      </div>
      <!-- end card -->
    </div>
    <div class="col-xl-4">
      <div class="card">
        <div class="card-body">
          <h6 class="mt-0 header-title">Lessons</h6>

          <ul class="list-unstyled activity-widget">
            @if (isset($class->lessons))
              @foreach ($class->lessons as $lesson)
                <li class="activity-list">
                  <div class="media">
                    <div class="text-center mr-3">
                      <div class="avatar-sm">
                        <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                          {{ Str::upper(Str::substr($lesson->title, 0, 1)) }}
                        </span>
                      </div>
                      {{-- <p class="text-muted font-size-13 mb-0">Jan</p> --}}
                    </div>
                    <div class="media-body overflow-hidden">
                      <h5 class="font-size-15 mt-2 mb-1"><a href="#" class="text-dark">{{ $lesson->title ? $lesson->title : '' }}</a></h5>
                      <p class="text-muted font-size-13 text-truncate mb-0">
                        {{ $lesson->title ? Str::limit($lesson->title, 50, '...') : '' }}
                      </p>
                    </div>
                  </div>

                </li>  
              @endforeach
            @endif
            
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- end row -->

</div> <!-- container-fluid -->    
@endif


@endsection