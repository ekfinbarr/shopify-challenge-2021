@extends('layouts.admin')

@section('title')
View Timetable
@endsection



@section('content')


{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script> --}}

{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"> --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css"> --}}
<script src="{{ asset('assets/libs/moment/moment.min.js') }}"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

<!-- Start Content-->
@if (isset($timetable))
<div class="container-fluid">
  <div class="row page-title">
    <div class="col-sm-8 col-xl-8">
      <h4 class="mb-1 mt-0">
        Timetable: {{ $timetable->title }}
        <div
          class="badge {{ $timetable->is_private ? 'badge-warning' : 'badge-success' }} font-size-13 font-weight-normal">
          {{ $timetable->is_private ? 'Private' : 'Public' }}</div>
        @if (isset($timetable->school))
        <div class="badge badge-soft-primary font-size-13 font-weight-normal" title="{{ $timetable->school->name }}">
          {{ Str::limit($timetable->school->name, 50, '...') }}</div>
        @endif
      </h4>
    </div>

    @if ($timetable->created_by == Auth::user()->id || Auth::user()->hasRole(['admin', 'super_admin']))
        <div class="col-sm-4 col-xl-4 text-sm-right">
          <div class="btn-group ml-2 d-none d-sm-inline-block">
            <a href="{{ route('timetables.edit', $timetable) }}" type="button" class="btn btn-soft-primary btn-sm"><i
                class="uil uil-edit mr-1"></i>Edit</a>
          </div>
          @if (!$timetable->locked)
          <div class="btn-group ml-2 d-none d-sm-inline-block">
            <a href="{{ route('timetables.edit', $timetable) }}" type="button" class="btn btn-soft-warning btn-sm"><i
                class="uil uil-lock mr-1"></i>Lock</a>
          </div>
              
          @endif
          <div class="btn-group d-none d-sm-inline-block">
            <a href="{{ route('timetables.destroy', $timetable) }}" type="button" class="btn btn-soft-danger btn-sm"><i
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
                  <h4 class="mt-0 mb-0">{{ isset($timetable->class) ? $timetable->class->label : 'None' }}</h4>
                  <span class="text-muted font-size-13">Class</span>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6">
              <!-- stat 2 -->
              <div class="media p-3">
                <i data-feather="check-square" class="align-self-center icon-dual icon-lg mr-4"></i>
                <div class="media-body">
                  <h4 class="mt-0 mb-0">{{ isset($timetable->lessons) ? count($timetable->lessons) : '0' }}</h4>
                  <span class="text-muted">Lessons</span>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6">
              <!-- stat 3 -->
              <div class="media p-3">
                <i data-feather="clock" class="align-self-center icon-dual icon-lg mr-4"></i>
                <div class="media-body">
                  <h4 class="mt-0 mb-0">
                    {{ isset($timetable->updated_at) ? $timetable->updated_at->diffForHumans() : '' }}</h4>
                  <span class="text-muted">Last Update</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row page-title align-items-center">
            <div class="col-md-12 col-xl-12 text-md-right">
              <div class="mt-4 mb-2 mt-md-0">
                <button type="button" class="btn btn-danger mr-4 mb-3  mb-sm-0" data-toggle="modal"
                  data-target="#event-modal" {{ $timetable->locked ? 'disabled' : '' }}>
                  <i class="uil-plus mr-1"></i>
                  Add Lesson
                </button>
              </div>
            </div>
          </div>


          <div class="timetable"></div>
          <style>
            .timetable .time-entry {
              display: inline-block;
              padding: 6px 12px;
              margin-bottom: 0;
              font-size: 20px;
              font-weight: normal;
              line-height: 1.42857143;
              text-align: center;
              white-space: nowrap;
              vertical-align: middle;
              -ms-touch-action: manipulation;
              touch-action: manipulation;
              cursor: pointer;
              -webkit-user-select: none;
              -moz-user-select: none;
              -ms-user-select: none;
              user-select: none;
              background-image: none;
              border: 1px solid #5369f8;
              border-radius: 0px;
              background-color: rgba(83, 105, 248, .2);
              color: #5369f8;
            }

            .timetable .time-entry:hover {
              background-color: rgba(83, 105, 248, .2);
              color: #5369f8;
            }
          </style>


          <script>
            var t_table = new Timetable();
            moment().format();


            t_table.setScope(1, 23); //0 - 23

            t_table.usingTwelveHour = true;

            function setWeekdays(t_table, weekdays = []) {
              if (t_table) {
                t_table.addLocations(weekdays);
              }
            }


            function getWeekdays() {
              // Weekday factory
              <?php 
              $weekdays = config('weekdays');
              $js_array = json_encode($weekdays);
              echo "var weekdays = ".$js_array. ";\n"; 
              ?>
                let days = [];
              if (weekdays) {
                if (typeof (weekdays) === 'array' || 'object') {
                  for (let i = 1; i < 8; i++) {
                    days.push(weekdays[i]);
                  }
                }
              }
              return days ? days : [];
            }

            function getLessons() {
              <?php 
              $lessons = $timetable -> lessons;
              $js_array = json_encode($lessons);
              echo "var tt_lessons = ".$js_array. ";\n"; 
              ?>

              return tt_lessons ? tt_lessons : [];
            }

            function generateCalendar(t_table, weekdays) {
              if (weekdays) {
                // Set weekday dates
                const last_monday = moment().weekday(Date.now).format('YYYY-MM-DD') == moment().day("Monday").format('YYYY-MM-DD') ? moment().weekday(Date.now) : moment().day("Monday");
                const start_week_date = last_monday.format('YYYY-MM-DD');

                let calendar = {};
                let count = 0;
                if (weekdays) {
                  weekdays.forEach(day => {
                    calendar[day] = count > 0 ? last_monday.add(count, 'd').format('YYYY-MM-DD') : last_monday.format('YYYY-MM-DD');
                    count = + 1;
                  });
                }

                // add calendar as t_table property
                if (!t_table.hasOwnProperty('calendar')) {
                  try {
                    t_table.calendar = calendar;
                  } catch (error) {
                    console.log("CALENDAR : " + error);
                  }

                }
              }
            }

            function formatDate(time, period, weekday) {
              if (time && weekday) {
                let date = t_table.calendar[weekday.replace(/\b[a-z]/g, (x) => x.toUpperCase())] ? t_table.calendar[weekday.replace(/\b[a-z]/g, (x) => x.toUpperCase())] : '';
                date = date + ' ' + time;
                // console.log("PERIOD :: ", date);
                return date;
              }
              return null;
            }

            function addLesson(t_table, lesson) {
              if (t_table && lesson) {
                const { title, description, weekday, start_time, end_time, start_period, end_period } = lesson;
                console.log("LESSON TIME :: ", formatDate(end_time, end_period, weekday))
                t_table.addEvent(title, weekday.replace(/\b[a-z]/g, (x) => x.toUpperCase()), new Date(formatDate(start_time, start_period, weekday)), new Date(formatDate(end_time, end_period, weekday)), {
                  onClick: function (event) {
                    loadPreviewModal(lesson);
                    localStorage.setItem("lesson", JSON.stringify(lesson));
                    setTimeout(() => {
                      $('#view_lesson_modal').modal('show');
                    }, 100);
                    // window.alert('You clicked on the ' + title + ' event in ' + event.location + '. This is an example of a click handler');
                  }
                });
              }
            }

            function loadPreviewModal(lesson) {
              let modal_lesson_header = document.getElementById('modal_lesson_header');
              let modal_lesson_title = document.getElementById('modal_lesson_title');
              let modal_lesson_description = document.getElementById('modal_lesson_description');
              let modal_lesson_start_time = document.getElementById('modal_lesson_start_time');
              let modal_lesson_weekday = document.getElementById('modal_lesson_weekday');
              let modal_lesson_end_time = document.getElementById('modal_lesson_end_time');
              let modal_lesson_teacher = document.getElementById('modal_lesson_teacher');
              // subscription input fields
              let modal_lesson_id_field = document.getElementById('modal_lesson_id_field');
              let modal_school_id_field = document.getElementById('modal_school_id_field');

              if(!lesson && typeof(lesson) !== 'object') return;

              modal_lesson_title.innerText = lesson.title ? lesson.title : '';
              modal_lesson_header.innerText = lesson.title ? lesson.title : '';
              modal_lesson_description.innerText = lesson.description ? lesson.description : '';
              modal_lesson_start_time.innerText = lesson.start_time ? lesson.start_time + ' ' + lesson.start_period : '';
              modal_lesson_weekday.innerText = lesson.weekday ? lesson.weekday.toUpperCase() : '';
              modal_lesson_end_time.innerText = lesson.end_time ? lesson.end_time + ' ' + lesson.end_period : '';
              modal_lesson_teacher.innerText = lesson.teacher ? lesson.teacher.name : '';

              modal_lesson_id_field.value = lesson.id ? lesson.id : '';
              <?php echo "let timetable_id = ". $timetable->id . "; \n"; ?>
              modal_timetable_id_field.value = timetable_id ? timetable_id : '';
              }

            // set weekdays
            setWeekdays(t_table, getWeekdays());

            // generate week calendar
            generateCalendar(t_table, getWeekdays());


            // Get lessons
            let all_lessons = getLessons();
            console.log("TABLE ", all_lessons);

            // Add Lessons
            all_lessons.forEach(l => {
              console.log(l)
              try {
                addLesson(t_table, l);
              } catch (error) {
                console.log("Error Adding Lesson: ", t_table);
              }
            })

            t_table.addEvent('Sightseeing', 'Monday', new Date(2015, 7, 17, 9, 00), new Date(2015, 7, 17, 11, 30), { url: '#' });
            t_table.addEvent('Lasergaming', 'Tuesday', new Date(2015, 7, 17, 17, 45), new Date(2015, 7, 17, 19, 30), { class: 'vip-only', data: { maxPlayers: 14, gameType: 'Capture the flag' } });
            var renderer = new Timetable.Renderer(t_table);
            renderer.draw('.timetable');
          </script>
        </div> <!-- end card body-->
      </div> <!-- end card -->
    </div>
    <!-- end col-12 -->
  </div> <!-- end row -->


  <!-- details-->
  <div class="row">
    <div class="col-xl-8">
      <div class="card">
        <div class="card-body">
          <h6 class="mt-0 header-title">About Timetable</h6>

          <div class="text-muted mt-3">
            <p>
              {{ $timetable->description ? $timetable->description : '' }}
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



          {{-- TIMELINE VIEWER --}}
          <div class="tab-pane fade active show mt-4" id="pills-activity" role="tabpanel"
            aria-labelledby="pills-activity-tab">

            @if(isset($activity)) 
            <h5 class="mt-3">{{ $activity['date']}}</h5>
            <div class="left-timeline mt-3 mb-3 pl-4">
              <ul class="list-unstyled events mb-0">
                @foreach($activity['lessons'] as $index => $lesson)
                <li class="event-list">
                  <div class="pb-4">
                    <div class="media">
                      <div class="event-date text-center mr-4">
                        <div class="bg-soft-primary p-1 rounded text-primary font-size-14">
                        {{ $lesson->start_time ? $lesson->start_time . ' ' . $lesson->start_period . ' - ' . $lesson->end_time . ' ' . $lesson->end_period : '' }}
                        </div>
                      </div>
                      <div class="media-body">
                        <h6 class="font-size-15 mt-0 mb-1">
                        {{ $lesson->title ? $lesson->title : '' }}
                        </h6>
                        <p class="text-muted font-size-14">
                        {{ $lesson->description ? Str::limit($lesson->description, 65, '...') : '' }}
                        </p>
                      </div>
                    </div>
                  </div>
                </li>
                @endforeach
              </ul>
            </div>
            @endif

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

            @if (isset($timetable->lessons))
            @foreach ($timetable->lessons as $lesson)
            <li class="activity-list">
              <div class="media">
                <div class="text-center mr-3">
                  <div class="avatar-sm">
                    <span
                      class="avatar-title rounded-circle bg-soft-primary text-primary">{{ Str::substr($lesson->title, 0, 1) }}</span>
                  </div>
                  {{-- <p class="text-muted font-size-13 mb-0">Jan</p> --}}
                </div>
                <div class="media-body overflow-hidden">
                  <h5 class="font-size-15 mt-2 mb-1">
                    <a href="#" class="text-dark">{{ $lesson->title ? $lesson->title : '' }}</a>
                  </h5>
                  <p class="text-muted font-size-13 text-truncate mb-0">
                    {{ $lesson->description ? Str::limit($lesson->description, 60, '...') : '' }}
                  </p>
                </div>
              </div>

            </li>
            @endforeach
            @endif
          </ul>
          <div class="text-center">
            <a href="javascript:void(0);" class="btn btn-sm border btn-white">
              <i data-feather="loader" class="icon-dual icon-xs mr-2"></i>
              Load more
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end row -->


  <!-- modals -->
  <!-- Add New Lesson MODAL -->
  <div class="modal fade" id="event-modal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header py-3 px-4 border-bottom-0 d-block">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h5 class="modal-title" id="modal-title">New Lesson</h5>
        </div>
        <div class="modal-body p-4">
          <form class="needs-validation" action="{{ route('lessons.store') }}" method="POST">
            @csrf
            @method('POST')

            <input type="hidden" value="{{ $timetable ? $timetable->id : '' }}" required name="timetable_id">

            <input type="hidden" value="{{ isset($school) ? $school->id : '' }}" required name="school_id">

            <div class="row">

              <div class="col-12">
                <div class="form-group">
                  <label class="control-label">Title</label>
                  <input class="form-control" value="{{ old('title') }}" placeholder="Lesson title" type="text" name="title" id="lesson-title"
                    required />
                  <div class="invalid-feedback">Please provide a valid title</div>
                </div>
              </div>

              <div class="col-12">
                <div class="form-group">
                  <label class="control-label">Description</label>
                  <textarea class="form-control" value="{{ old('description') }}" placeholder="Lesson description" rows="3" required name="description"
                    id="lesson-description"></textarea>
                  <div class="invalid-feedback">Please provide a valid title</div>
                </div>
              </div>

              <div class="col-12">
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

              <div class='col-lg-6 mb-lg-3'>
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

              <div class='col-lg-6 mb-lg-3'>
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
              <div class="col-12">
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


              <div class="col-lg-6">
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

              <div class="col-lg-6">
                <div class="form-group">
                  <label class="control-label">Notifications </label>
                  <select class="form-control custom-select" value="{{ old('notifications') }}" name="notifications" id="event-category" required>
                    <option value="true" selected>Allow Notifications</option>
                    <option value="false">Keep everything silent</option>
                  </select>
                  <div class="invalid-feedback">Please select a mode of notifications</div>
                </div>
              </div>

            </div>
            <div class="row mt-2">
              <div class="col-12 text-right">
                <button type="button" class="btn btn-light btn-lg mr-1" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success btn-lg" id="btn-save-event">Save</button>
              </div>
            </div>
          </form>
        </div>
      </div> <!-- end modal-content-->
    </div> <!-- end modal dialog-->
  </div>
  <!-- end modal-->

  <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
  <!-- end modal -->
</div> <!-- container-fluid -->
@endif


@endsection