<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\School;
use App\Models\SchoolClass;
// use App\Rules\isCourseInRequest;
use App\Rules\LessonTimeAvailabilityRule;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class LessonController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if (Auth::check()) {
      $lessons = Lesson::with(['teacher', 'class', 'timetable'])->orderBy('created_at', 'desc')->paginate(8);
      return view('pages.lesson.index')
        ->with('lessons', $lessons);
    } else {
      return view('auth.login')->with('error', 'Authentication Failed!');
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    if (!Auth::check()) {
      return redirect()->back();
    }

    $classes = SchoolClass::where('school_id', Auth::user()->school_id)->get();
    $schools = Auth::user()->schools;
    $timetables = Auth::user()->timetables;
    $courses = Course::where('school_id', Auth::user()->school_id)->get();

    if (!Auth::check()) {
      return redirect()->back();
    }
    return view('pages.lesson.add')
    ->with('classes', $classes)
    ->with('timetables', $timetables)
    ->with('courses', $courses)
    ->with('schools', $schools);
  }


  private function getTimePeriod($time)
  {
    if ($time) {
      $h = explode(':', $time)[0];
      $m = explode(' ', explode(':', $time)[1])[0];
      $p = explode(' ', explode(':', $time)[1])[1];
      return [
        'h' => $h,
        'm' => $m,
        'p' => $p
      ];
    } else {
      return null;
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    if (!Auth::check() || !isset($request->timetable_id)) {
      return redirect()->back();
    }


    $input = $request->all();

    // dd($this->getTimePeriod($request->start_time));
    $validator = Validator::make($request->all(), [
      'title' => 'string|min:3|nullable',
      'description' => 'string|nullable',
      // 'title' => new isCourseInRequest,
      // 'description' => new isCourseInRequest,
      'weekday' => 'required|string|min:3',
      // 'start_time' => 'required|string|min:3|date_format:' . config('panel.lesson_time_format'),
      // 'end_time' => 'required|string|min:3|date_format:' . config('panel.lesson_time_format'),
      'timetable_id' => 'required|min:1',
      'start_time' => new LessonTimeAvailabilityRule,
      'end_time' => new LessonTimeAvailabilityRule
    ]);

    // validate inputs
    if ($validator->fails()) {
      Session::flash('error', 'Kindly validate your inputs!');
      return redirect()->back()
        ->withErrors($validator->errors())
        ->withInput($request->all());
    } else {
      try {
        // get time period
        $start_period = $this->getTimePeriod($request->start_time);
        $end_period = $this->getTimePeriod($request->end_time);

        // validate time difference
        $time_diff = Carbon::parse($start_period['h'] . ':' . $start_period['m'] . ':00')->floatDiffInMinutes($start_period['h'] . ':' . $start_period['m'] . ':00');
        // dd($time_diff);
        // if(intval($time_diff, 10) < 1 /**  || (intval($time_diff, 10) < 1 && (trim($start_period['p']) === trim($end_period['p']))) */) {
        //   Session::flash('error', 'Invalid time difference specified for lesson duration!');
        //   return redirect()->back()->withInput($request->all());
        // }

        // if course is selected, replace course title and description with request fields
        if(isset($request->course_id)) {
          $course = Course::where('id', $request->course_id)->first();
          if($course) {
            $input['title'] = $course->title;
            $input['description'] = $course->description; 
          }
        }

        // store
        $input['created_by'] = Auth::user()->id;
        $input['start_time'] = isset($start_period['h']) ? $start_period['h'] . ':' . $start_period['m'] : '';
        $input['end_time'] = isset($end_period['h']) ? $end_period['h'] . ':' . $end_period['m'] : '';
        $input['is_private'] = $request->is_private == 'true' ? true : false;
        $input['notifications'] = $request->notifications == 'true' ? true : false;
        $input['start_period'] = isset($start_period['p']) ? $start_period['p'] : '';
        $input['end_period'] = isset($end_period['p']) ? $end_period['p'] : '';
        $lesson = Lesson::create($input);

        // redirect
        toast('success', 'Process Successful!');
        return redirect()->back();
      } catch (\Throwable $th) {
        Session::flash('error', 'Process failed!');
        return back()->withErrors($th->getMessage());
      }
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Category  $consult
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    if (!Auth::check()) {
      return redirect()->back();
    }

    $lesson = Lesson::with(['teacher', 'class', 'timetable'])->where([['created_by', Auth::user()->id], ['id', $id]])->first();

    if (isset($lesson)) {
      return view('pages.lesson.view')
        ->with('lesson', $lesson);
    } else {
      toast('error', 'Resource not found!');
      return redirect()->back();
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Lesson  $lesson
   * @return \Illuminate\Http\Response
   */
  public function edit(Lesson $lesson)
  {
    $classes = SchoolClass::all();
    $schools = School::all();
    $courses = Course::where('school_id', Auth::user()->school_id)->get();

    if (Auth::user()) {
      return view('pages.lesson.edit')
        ->with('lesson', $lesson)
        ->with('classes', $classes)
        ->with('courses', $courses)
        ->with('schools', $schools);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Lesson  $lesson
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Lesson $lesson)
  {
    if (!$lesson) {
      return redirect()->route('lessons.index')->with('error', 'Resource not found.');
    }

    // $request->is_private = $request->is_private === 'true' ? 1 : 0;

    $input = $request->input();

    $validator = Validator::make($request->all(), [
      'title' => 'required|string|min:3',
      'description' => 'required|string|min:3'
    ]);


    // validate inputs
    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator->errors())
        ->withInput($request->all());
    } else {
      $request['is_private'] = $request->is_private == 'true' || true ? true : false;
      $lesson->title = $request->title ? $request->title : $lesson->title;
      $lesson->description = $request->description ? $request->description : $lesson->description;
      $lesson->school_id = $request->school_id ? $request->school_id : $lesson->school_id;
      $lesson->class_id = $request->class_id ? $request->class_id : $lesson->class_id;
      $lesson->is_private = isset($request->is_private) ? $request->is_private : $lesson->is_private;
      $lesson->save();

      // redirect
      toast('success', 'Update successful!');
      return redirect()->route('lessons.show', $lesson)->with('lesson', $lesson);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Lesson  $lesson
   * @return \Illuminate\Http\Response
   */
  public function destroy(Lesson $lesson)
  {
    $lesson->delete();

    // redirect
    Session::flash('success', 'Resource deleted!');
    return redirect()->route('lessons.index');
  }
}
