<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\User;
use App\Rules\CourseTimeAvailabilityRule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if (Auth::check()) {
      $courses = Course::with(['teacher', 'class', 'lessons'])->orderBy('created_at', 'desc')->paginate(8);
      return view('pages.course.index')
        ->with('courses', $courses);
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
    $teachers = User::teachers()->where('school_id', Auth::user()->school_id);
    // dd($teachers);

    if (!Auth::check()) {
      return redirect()->back();
    }
    return view('pages.course.add')
    ->with('teachers', $teachers)
    ->with('classes', $classes)
    ->with('schools', $schools);
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    if (!Auth::check()) {
      return redirect()->back();
    }


    $input = $request->all();

    $validator = Validator::make($request->all(), [
      'title' => 'required|string|min:3',
      'description' => 'string'
    ]);

    // validate inputs
    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator->errors())
        ->withInput($request->all());
    } else {
      try {
        // store
        $input['created_by'] = Auth::user()->id;
        $input['is_private'] = $request->is_private == 'true' ? true : false;
        $course = Course::create($input);

        // redirect
        toast('success', 'Process Successful!');
        return redirect()->back();
      } catch (\Throwable $th) {
        toast('error', 'Process failed!');
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

    $course = Course::with(['teacher', 'class', 'lessons'])->where([['school_id', Auth::user()->school_id], ['id', $id]])->first();

    if (isset($course)) {
      return view('pages.course.view')
        ->with('course', $course);
    } else {
      toast('error', 'Resource not found!');
      return redirect()->back();
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Course  $course
   * @return \Illuminate\Http\Response
   */
  public function edit(Course $course)
  {
    $classes = SchoolClass::all();
    $schools = School::all();

    if (Auth::user()) {
      return view('pages.course.edit')
        ->with('course', $course)
        ->with('classes', $classes)
        ->with('schools', $schools);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Course  $course
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Course $course)
  {
    if (!$course) {
      return redirect()->route('courses.index')->with('error', 'Resource not found.');
    }

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
      $course->title = $request->title ? $request->title : $course->title;
      $course->description = $request->description ? $request->description : $course->description;
      $course->school_id = $request->school_id ? $request->school_id : $course->school_id;
      $course->class_id = $request->class_id ? $request->class_id : $course->class_id;
      $course->is_private = isset($request->is_private) ? $request->is_private : $course->is_private;
      $course->save();

      // redirect
      toast('success', 'Update successful!');
      return redirect()->route('courses.show', $course)->with('course', $course);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Course  $course
   * @return \Illuminate\Http\Response
   */
  public function destroy(Course $course)
  {
    $course->delete();

    // redirect
    Session::flash('success', 'Resource deleted!');
    return redirect()->route('courses.index');
  }
}