@extends('layouts.admin')

@section('title')
All Timetables
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
        <a href="{{ route('timetables.create') }}" type="button" class="btn btn-danger mr-4 mb-3  mb-sm-0">
          <i class="uil-plus mr-1"></i>
          Create Timetable
        </a>
        {{-- <div class="btn-group mb-3 mb-sm-0">
          <button type="button" class="btn btn-primary">All</button>
        </div>
        <div class="btn-group ml-1">
          <button type="button" class="btn btn-white">Ongoing</button>
          <button type="button" class="btn btn-white">Finished</button>
        </div>
        <div class="btn-group ml-2 d-none d-sm-inline-block">
          <button type="button" class="btn btn-primary btn-sm"><i class="uil uil-apps"></i></button>
        </div>
        <div class="btn-group d-none d-sm-inline-block">
          <button type="button" class="btn btn-white btn-sm"><i class="uil uil-align-left-justify"></i></button>
        </div> --}}
      </div>
    </div>
  </div>

  <div class="row">

    @if (isset($timetables))
      @foreach ($timetables as $timetable)
        <div class="col-xl-4 col-lg-6">
          <div class="card">
            <div class="card-body">
              <div class="badge {{ $timetable->is_active ? 'badge-warning' : 'badge-success' }} float-right">Active</div>
              <p class="{{ $timetable->is_private ? 'text-warning' : 'text-success' }} text-uppercase font-size-12 mb-2">{{ $timetable->is_private ? 'Private' : 'Public' }}</p>
              <h5>
              <a href="{{ route('timetables.show', $timetable) }}" class="text-dark">{{ $timetable->title ? $timetable->title : '' }}</a>
              </h5>
              <p class="text-muted mb-1">
                {{ $timetable->description ? Str::limit($timetable->description, 160, '...') : '' }}
              </p>
            </div>
            <div class="card-body border-top">
              <div class="row align-items-center">
                <div class="col-sm-auto">
                  <ul class="list-inline mb-0">
                    <li class="list-inline-item pr-2">
                      <a href="#" class="text-muted d-inline-block" data-toggle="tooltip" data-placement="top" title=""
                        data-original-title="Date Created">
                        <i class="uil uil-calender mr-1"></i>
                        {{ $timetable->created_at ? $timetable->created_at->diffForHumans() : '' }}
                      </a>
                    </li>
                    <li class="list-inline-item pr-2">
                      <a href="#" class="text-muted d-inline-block" data-toggle="tooltip" data-placement="top" title=""
                        data-original-title="Lesson Events">
                        <i class="uil uil-bars mr-1"></i> {{ $timetable->lessons ? count($timetable->lessons) : '0' }}
                      </a>
                    </li>
                  </ul>
                </div>
                {{-- <div class="col offset-sm-1">
                  <div class="progress mt-4 mt-sm-0" style="height: 5px;" data-toggle="tooltip" data-placement="top"
                    title="" data-original-title="100% completed">
                    <div class="progress-bar {{ $timetable->is_private ? 'bg-warning' : 'bg-success' }}" role="progressbar" style="width: 100%;" aria-valuenow="100"
                      aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div> --}}
              </div>
            </div>
          </div>
          <!-- end card -->
        </div> 
      @endforeach
    @endif
    
  </div>
  <!-- end row -->

  <div class="row mb-3 mt-2">
    <div class="col-12">
      <div class="text-center">
        <a href="javascript:void(0);" class="btn btn-white">
          <i data-feather="loader" class="icon-dual icon-xs mr-2"></i>
          Load more
        </a>
      </div>
    </div> <!-- end col-->
  </div>
  <!-- end row -->

</div> <!-- container-fluid -->

@endsection