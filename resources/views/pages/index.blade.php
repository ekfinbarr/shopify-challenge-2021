@extends('layouts.admin')

@section('title')
My Dashboard
@endsection



@section('content')

<!-- Start Content-->
<div class="container-fluid">

  <div class="row page-title">
    <div class="col-md-12">
      <nav aria-label="breadcrumb" class="float-right mt-1">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">{{ config('app.name') }}</a></li>
          <li class="breadcrumb-item"><a href="#">{{ trans('Dashboard') }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ trans('timetable') }}</li>
        </ol>
      </nav>
      <h4 class="mb-1 mt-0">@yield('title')</h4>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-xl-2 col-lg-3 col-6">
              <img src="assets/images/cal.png" class="mr-4 align-self-center img-fluid " alt="cal" />
            </div>
            <div class="col-xl-10 col-lg-9">
              <div class="mt-4 mt-lg-0">
                <h5 class="mt-0 mb-1 font-weight-bold">Welcome to Your Timetable</h5>
                <p class="text-muted mb-2">
                  The timetable shows the classes/lessons synced from all your linked timetables.
                  Click on lessons to see or edit the details. 
                  You can create new lessons or schedule by clicking on "Create New lesson" button or any cell available in calendar below.
                </p>

                <button class="btn btn-primary mt-2 mr-1" id="btn-new-event"><i class="uil-plus-circle"></i> 
                  Create New Lesson
                </button>
                <button class="btn btn-white mt-2"><i class="uil-sync"></i>
                  Link Timetables
                </button>
              </div>
            </div>
          </div>

        </div> <!-- end card body-->
      </div> <!-- end card -->
    </div>
    <!-- end col-12 -->
  </div> <!-- end row -->



  <div class="row">
    @if (Auth::user()->hasRole(['admin', 'super_admin']))
      <div class="col-md-6 col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body p-0">
                <div class="media p-3">
                    <div class="media-body">
                        <span class="text-muted text-uppercase font-size-12 font-weight-bold">
                          Schools
                        </span>
                        <h2 class="mb-0">{{ App\Models\School::all() ? count(App\Models\School::all()) : '' }}</h2>
                    </div>
                </div>
            </div>
        </div>
      </div> 
    @endif
    

    @if (isset(Auth::user()->school))
      <div class="col-md-6 col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body p-0">
                <div class="media p-3">
                    <div class="media-body">
                        <span class="text-muted text-uppercase font-size-12 font-weight-bold">
                          Classes
                        </span>
                        <h2 class="mb-0">{{ App\Models\SchoolClass::where('school_id', Auth::user()->school->id)->get() ? count(App\Models\SchoolClass::where('school_id', Auth::user()->school->id)->get()) : '' }}</h2>
                    </div>
                </div>
            </div>
        </div>
      </div>
    @endif

    @if (isset(Auth::user()->school))
      <div class="col-md-6 col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body p-0">
                <div class="media p-3">
                    <div class="media-body">
                        <span class="text-muted text-uppercase font-size-12 font-weight-bold">
                          Timetables
                        </span>
                        <h2 class="mb-0">{{ Auth::user()->hasRole(['admin','super_admin']) ? count(App\Models\Timetable::where('school_id', Auth::user()->school_id)->orWhere('created_by', Auth::user()->id)->get()) : count(App\Models\Timetable::where('school_id', Auth::user()->school_id)->get()) }}</h2>
                    </div>
                </div>
            </div>
        </div>
      </div>
    @endif
    

    @if (isset(Auth::user()->school))
      <div class="col-md-6 col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body p-0">
                <div class="media p-3">
                    <div class="media-body">
                        <span class="text-muted text-uppercase font-size-12 font-weight-bold">
                          Lessons
                        </span>
                        <h2 class="mb-0">
                          {{-- BREAKABLE --}}
                          {{ App\Models\School::with('lessons')->where('id', Auth::user()->school->id)->first()['lessons'] ? count(App\Models\School::with('lessons')->where('id', Auth::user()->school->id)->first()->lessons) : '' }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
      </div>
    @endif
    
  </div>


  {{-- <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div id="calendar"></div>
        </div> <!-- end card body-->
      </div> <!-- end card -->
    </div>
    <!-- end col-12 -->
  </div> <!-- end row --> --}}


  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="fc-toolbar fc-header-toolbar">
            <div class="fc-left">
              <div class="btn-group">
                {{-- <button type="button" class="fc-prev-button btn btn-primary">Prev</button>
                <button type="button" class="fc-next-button btn btn-primary">Next</button> --}}
              </div>
              <button type="button" class="fc-today-button btn btn-primary" disabled="">Today</button>
            </div>
            <div class="fc-center">
              <h2>Dec 13 – 19, 2020</h2>
            </div>
            <div class="fc-right">
              <div class="btn-group">
                {{-- <button type="button" class="fc-dayGridMonth-button btn btn-primary">Month</button>
                <button type="button" class="fc-timeGridWeek-button btn btn-primary active">Week</button>
                <button type="button" class="fc-timeGridDay-button btn btn-primary">Day</button> --}}
              </div>
            </div>
          </div>
          <div id="app">
            <example-component></example-component>
          </div>
        </div> <!-- end card body-->
      </div> <!-- end card -->
    </div>
    <!-- end col-12 -->
  </div> <!-- end row -->

  <!-- modals -->
  <!-- Add New Event MODAL -->
  <div class="modal fade" id="event-modal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header py-3 px-4 border-bottom-0 d-block">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h5 class="modal-title" id="modal-title">Event</h5>
        </div>
        <div class="modal-body p-4">
          <form class="needs-validation" name="event-form" id="form-event" novalidate>
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label class="control-label">Event Name</label>
                  <input class="form-control" placeholder="Insert Event Name" type="text" name="title" id="event-title"
                    required />
                  <div class="invalid-feedback">Please provide a valid event name</div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label class="control-label">Category</label>
                  <select class="form-control custom-select" name="category" id="event-category" required>
                    <option value="bg-danger" selected>Danger</option>
                    <option value="bg-success">Success</option>
                    <option value="bg-primary">Primary</option>
                    <option value="bg-info">Info</option>
                    <option value="bg-dark">Dark</option>
                    <option value="bg-warning">Warning</option>
                  </select>
                  <div class="invalid-feedback">Please select a valid event category</div>
                </div>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-6">
                <button type="button" class="btn btn-danger" id="btn-delete-event">Delete</button>
              </div>
              <div class="col-6 text-right">
                <button type="button" class="btn btn-light mr-1" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" id="btn-save-event">Save</button>
              </div>
            </div>
          </form>
        </div>
      </div> <!-- end modal-content-->
    </div> <!-- end modal dialog-->
  </div>
  <!-- end modal-->
</div> <!-- container-fluid -->
@endsection